/**
 * ==========================================================
 *  ENTROPY ANALYZER — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo encargado del análisis matemático y visualización
 *  gráfica de la entropía generada por los headers y tokens
 *  utilizados en el Protocolo RHC (Randomized Header Channel).
 * 
 *  Este módulo funciona como un subsistema especializado,
 *  independiente del core del protocolo, y provee herramientas
 *  para:
 *     - Cálculo de entropía basada en frecuencia simbólica
 *     - Generación de gráficas dinámicas mediante Chart.js
 *     - Exportación de dichas gráficas en formato PNG Base64
 *     - Control del modo de análisis (headers, tokens o ambos)
 *     - Integración con módulos externos como el visor de
 *       respaldo (Entropy Viewer Fallback)
 *
 *  El análisis de entropía permite medir la calidad aleatoria
 *  y la resistencia predictiva de los tokens y encabezados
 *  generados dinámicamente por el Protocolo RHC (Randomized Header Channel)
 *  NIVEL ADAPTATIVO DINÁMICO
 *
 *  @file        public_html/js/entropy_analyzer.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Proporcionar mediciones de entropía y generar
 *               representaciones visuales para auditoría
 *               interna, depuración y pruebas de seguridad.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

    // -----------------------------------------------------------------------------
    // Modo global de análisis del sistema de entropía.
    // -----------------------------------------------------------------------------
    // Esta constante determina qué elementos deben ser analizados y visualizados
    // durante los procesos de análisis de entropía:
    //
    //   - "Tokens"       → Analiza únicamente los tokens generados. (Valor por defecto)
    //   - "Headers"      → Analiza exclusivamente los encabezados definidos.
    //   - "Todos"        → Analiza headers y tokens de forma separada y muestra ambos.
    //   - "TodosUnidos"  → Analiza headers y tokens como un conjunto único,
    //                      combinándolos con el formato: header + ":" + token.
    //
    // El modo de operación se define de manera programática.
    // El valor elegido en esta constante afecta directamente la salida del análisis
    // visual y los cálculos realizados durante la evaluación de la entropía.
    // -----------------------------------------------------------------------------
    // Modo recomendado para inspección completa: "Todos".
    // Valor por defecto operativo: "Tokens".
    // -----------------------------------------------------------------------------
    const modoAnalisis = "Todos";

    // -----------------------------------------------------------------------------
    // Modo global de animación para la visualización del análisis de entropía.
    // -----------------------------------------------------------------------------
    // Esta constante define el efecto de transición utilizado para mostrar los
    // resultados calculados y la gráfica generada por el sistema. El valor elegido
    // determina la combinación de movimientos y efectos visuales aplicados durante
    // la consulta de la informacion.
    //
    // Modos disponibles:
    //   - "SLIDE"       → Deslizamiento horizontal únicamente.
    //   - "SLIDE-FADE"  → Deslizamiento combinado con efecto de desvanecimiento.
    //
    // Su propósito es establecer, de manera programática, el estilo de transición
    // que debe usarse en cada actualización visual.
    // -----------------------------------------------------------------------------
    // Valor recomendado para una transición más fluida: "SLIDE-FADE".
    // Valor por defecto operativo: "SLIDE-FADE".
    // -----------------------------------------------------------------------------
    const modoAnimacion = "SLIDE-FADE";

    // -----------------------------------------------------------------------------
    // URL de respaldo para la visualización del análisis de entropía
    // -----------------------------------------------------------------------------
    // Esta constante define la ruta hacia un módulo independiente de análisis
    // de entropía y visualización gráfica. Este módulo puede recibir el pool de
    // headers y tokens generado por el sistema actual y mostrar los mismos resultados
    // con una interfaz dedicada y optimizada.
    //
    // Propósito principal:
    //   - Servir como respaldo en caso de que el módulo integrado falle.
    //   - Permitir abrir la gráfica en una ventana o módulo independiente.
    //   - Mantener la experiencia del usuario sin interrumpir el análisis.
    //
    // Uso en el sistema:
    //   - Botón principal → muestra el análisis y gráfica en la interfaz actual.
    //   - Botón secundario → envía los datos a este módulo usando la URL definida
    //     en ENTROPY_VIEWER_FALLBACK_URL.
    //
    // Valor por defecto apunta a: './entropy/entropy_viewer.php'
    // -----------------------------------------------------------------------------
    const ENTROPY_VIEWER_FALLBACK_URL = './entropy/entropy_viewer.php';


	function calcularEntropia(cadena) {
		if (!cadena || cadena.length === 0) return 0;

		const freq = {};
		for (let c of cadena) freq[c] = (freq[c] || 0) + 1;

		const len = cadena.length;
		let entropy = 0;

		for (let c in freq) {
			const p = freq[c] / len;
			entropy -= p * Math.log2(p);
		}

		return parseFloat(entropy.toFixed(3));
	}

	function generarGraficaPNG(headersTokens, modo = "tokens", callback) {

		// Cargar Chart.js y chartjs-plugin-annotation si aún no están cargados
		function cargarChart(cb) {
			if (window.Chart && window.ChartAnnotation) return cb();

			const s1 = document.createElement("script");
			s1.src = "https://cdn.jsdelivr.net/npm/chart.js";
			s1.onload = () => {
				const s2 = document.createElement("script");
				s2.src = "https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@latest";
				s2.onload = cb;
				document.head.appendChild(s2);
			};
			document.head.appendChild(s1);
		}

		cargarChart(() => {
			// Crear canvas temporal
			const canvas = document.createElement("canvas");
			canvas.width = 1200;   // ancho fijo para buena resolución - 1200
			canvas.height = 600;   // alto fijo - 600
			document.body.appendChild(canvas);

			// Preparar datos
			const labels = [];
			const values = [];
			const colors = [];
			const labelColors = [];

			for (let [header, token] of Object.entries(headersTokens)) {

				if (modo === "TodosUnidos") {

					// Analizar header + token como UNA sola cadena
					let cadena = header + ":" + token;
					let entropia = calcularEntropia(cadena);

					// Etiqueta como array para salto de línea
					let cadenaEtiqueta = [header + " (H)", token + " (T)"];
					labels.push(cadenaEtiqueta);
					values.push(entropia);

					if (entropia >= 3.5) colors.push('#23c552');
					else if (entropia >= 1.5) colors.push('#f5b942');
					else colors.push('#d43838');

				} else if (modo === "Todos") {

					// ---- HEADER ----
					let entropiaH = calcularEntropia(header);
					labels.push(header + " (H)");
					values.push(entropiaH);

					if (entropiaH >= 3.5) colors.push('#23c552');
					else if (entropiaH >= 1.5) colors.push('#f5b942');
					else colors.push('#d43838');

					// ---- TOKEN ----
					let entropiaT = calcularEntropia(token);
					labels.push(token + " (T)");
					values.push(entropiaT);

					if (entropiaT >= 3.5) colors.push('#23c552');
					else if (entropiaT >= 1.5) colors.push('#f5b942');
					else colors.push('#d43838');

				} else if (modo === "Headers") {

					let entropia = calcularEntropia(header);
					labels.push(header + " (H)");
					values.push(entropia);

					if (entropia >= 3.5) colors.push('#23c552');
					else if (entropia >= 1.5) colors.push('#f5b942');
					else colors.push('#d43838');

				} else { // Tokens

					let entropia = calcularEntropia(token);
					labels.push(token + " (T)");
					values.push(entropia);

					if (entropia >= 3.5) colors.push('#23c552');
					else if (entropia >= 1.5) colors.push('#f5b942');
					else colors.push('#d43838');

				}
			}

			// --------------------------------------------------------
			// ENTROPÍA TOTAL (solo en modo "Todos")
			// --------------------------------------------------------
			if (modo === "Todos") {
				let concatenado = "";

				for (let [header, token] of Object.entries(headersTokens)) {
					concatenado += header + token;
				}

				let entropiaTotal = calcularEntropia(concatenado);

				labels.push("ENTROPÍA TOTAL");
				values.push(entropiaTotal);

				if (entropiaTotal >= 3.5) colors.push('#23c552');
				else if (entropiaTotal >= 1.5) colors.push('#f5b942');
				else colors.push('#d43838');
			}

			const legendPlugin = {
				id: 'customLegend',
				afterDraw: (chart) => {
					const {ctx, chartArea: {left, bottom, right}} = chart;
					const colors = ['#23c552', '#f5b942', '#d43838'];
					const labels = [
						'Alta seguridad (≥ 3.5 bits/char)',
						'Media (1.5–3.4 bits/char)',
						'Baja (≤ 1.4 bits/char)'
					];

					ctx.save();
					ctx.font = '14px sans-serif';
					ctx.textBaseline = 'top';

					let x = left;
					let y = bottom + 90; // un poco debajo del eje X

					labels.forEach((text, i) => {
						// dibujar cuadro de color
						ctx.fillStyle = colors[i];
						ctx.fillRect(x, y, 16, 16);

						// dibujar texto
						ctx.fillStyle = '#aaa';
						ctx.fillText(text, x + 20, y);

						x += ctx.measureText(text).width + 40; // separación entre elementos
					});

					ctx.restore();
				}
			};

			// Crear gráfica
			const chart = new Chart(canvas, {
				type: 'bar',
				data: {
					labels,
					datasets: [{
						label: 'Entropía (bits/char)',
						data: values,
						borderRadius: 8,
						backgroundColor: colors
					}]
				},
				options: {
					layout: {
							padding: {
								top: 0,
								bottom: 30,
								left: 0,
								right: 0
							}
						},
					responsive: true,
					plugins: {
						legend: { display: true },
						title: {
							display: true,
							text: 'Comparativa de entropía - RHC Protocol',
							color: '#f0f0f0',
							font: { size: 16 }
						},
						annotation: {
							annotations: {
								secureLine: {
									type: 'line',
									yMin: 3.5,
									yMax: 3.5,
									borderColor: '#00c4ff',
									borderWidth: 2,
									borderDash: [6, 6],
									label: {
										enabled: true,
										content: 'Zona segura ≥ 3.5 bits/char',
										position: 'end',
										backgroundColor: 'rgba(0,196,255,0.2)',
										color: '#00c4ff'
									}
								}
							}
						},
						tooltip: { mode: 'index' },
					},
					scales: {
						y: {
							beginAtZero: true,
							max: 4.0,
							ticks: { color: '#ccc' },
							grid: { color: '#333' }
						},
						x: {
							ticks: { color: '#ccc', autoSkip: false },
							grid: { color: '#333' }
						}
					}
				},
				plugins: [legendPlugin]
			});

			// Esperamos 200ms para asegurar render
			setTimeout(() => {
				const img = canvas.toDataURL("image/png");
				chart.destroy();
				canvas.remove();
				callback(img);
			}, 200);
		});
	}
