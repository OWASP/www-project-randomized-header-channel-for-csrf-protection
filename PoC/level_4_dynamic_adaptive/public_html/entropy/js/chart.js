/**
 * ==========================================================
 *  CHART MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo responsable del renderizado visual del nivel de
 *  entropía mediante barras de colores con Chart.js.
 *
 *  Características:
 *    • Colores dinámicos según nivel de seguridad
 *    • Línea de referencia para zona segura (≥ 3.5 bits/char)
 *    • Destrucción automática del gráfico previo
 *    • Integración directa con analyzer.js
 *
 *  Este módulo transforma los datos de entropía en una gráfica
 *  comparativa clara para auditorías y visualización técnica.
 *
 *  @file        public_html/entropy/js/chart.js
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Graficar los niveles de entropía de los tokens ingresados.
 *
 *  @module      Frontend\EntropyChart
 *  @category    Security Visualization / Chart Rendering
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	let chart;
	function renderChart(results) {
		const ctx = document.getElementById('entropyChart');
		if (chart) chart.destroy();

		const labels = results.map(r => r.label);
		const values = results.map(r => r.value);
		const colors = values.map(v => {
			if (v >= 3.5) return '#23c552';
			if (v >= 1.5) return '#f5b942';
			return '#d43838';
		});

		chart = new Chart(ctx, {
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
					tooltip: { mode: 'index' }
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
			}
		});
	}
