/**
 * ==========================================================
 *  UI CONTROLS MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Funciones de interfaz, validaciones y mensajes visuales.
 *  Gestiona dinámicamente los elementos del DOM, botones,
 *  alertas y retroalimentación visual al usuario.
 * 
 *  @file        public_html/js/ui_controls.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Controlar la capa visual e interacción UI del sistema.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Cargar en tabla los encabezados y token's
	function cargarTablaHeaderTokens() {
		// Limpia la tabla (dejando solo encabezados de columna)
		const tabla = document.getElementById('headerstokensTable');
		tabla.innerHTML = '<tr><th>Header</th><th>Token</th></tr>';

		// Genera las filas dinámicamente desde poolHT
		Object.entries(poolHT).forEach(([header, token]) => {
			// Verifica si el header está en la lista de válidos
			const esValido = headersDefinidos.includes(header);
			// Crea la fila con estilo condicional
			tabla.innerHTML += `
				<tr>
					<td class="${esValido ? 'green' : 'gray'}">${header}</td>
					<td class="token-cell ${esValido ? 'green' : ''}">${token}</td>
				</tr>`;
		});


		// --------------------------------------------------------------------
		// Agregar filas en blanco para los encabezados que falten del conjunto total
		// --------------------------------------------------------------------
		const todosLosHeaders = [...headersDefinidos, ...headersDecoys];
		const headersFaltantes = todosLosHeaders.filter(h => !Object.keys(poolHT).includes(h));
		headersFaltantes.forEach(header => {
			const esValido = headersDefinidos.includes(header);
			tabla.innerHTML += `
				<tr class="missing-row">
					<td>—</td>
					<td>—</td>
				</tr>`;
		});
	}

	// Mensajes de error de Productos
	function mostrarErrorProductos(mensaje) {
		const errorDiv = document.getElementById('errorProductosMsg');
		errorDiv.style.visibility = "visible";
		errorDiv.textContent = mensaje;
	}
	
	function limpiarErrorProductos() {
		const errorDiv = document.getElementById('errorProductosMsg');
		errorDiv.style.visibility = "hidden";
		errorDiv.textContent = "";
	}

	// Mensajes de error del Servidor
	function mostrarErrorServidor(mensaje) {
		const errorDiv = document.getElementById('errorServidorMsg');
		errorDiv.style.visibility = "visible";
		errorDiv.textContent = mensaje;
	}
	
	function limpiarErrorServidor() {
		const errorDiv = document.getElementById('errorServidorMsg');
		errorDiv.style.visibility = "hidden";
		errorDiv.textContent = "";
	}

	// Limpieza y llenado de campos
	function limpiarCampos() {
		document.getElementById('productKey').value = "";
		document.getElementById('productDesc').value = "";
		document.getElementById('productPrice').value = "";
	}

	function llenarCampos(data) {
		document.getElementById('productKey').value = data.clave || "";
		document.getElementById('productDesc').value = data.descripcion || "";
		document.getElementById('productPrice').value = data.precio || "";
	}

	// Detectar Enter sobre botones
	document.querySelectorAll("button").forEach(btn => {
		btn.addEventListener("keydown", e => {
			if (e.key === "Enter") btn.classList.add("presionado");
		});
		btn.addEventListener("keyup", e => {
			if (e.key === "Enter") btn.classList.remove("presionado");
		});
	});

	// Asignamos un listener al evento 'change' de forma segura
	document.getElementById('tokenLengthMode')?.addEventListener('change', function() {
		regenerarPoolHT();
	});


	/**
	 * Abre Entropy Viewer en una nueva ventana usando POST (por defecto) o GET
	 * @param {Object} data - Objeto a enviar como JSON
	 * @param {string} metodo - "POST" o "GET" (por defecto "POST")
	 */
	function abrirEntropyViewer(data, metodo="POST") {
		// Convertimos el objeto a una cadena JSON
		const jsonData = JSON.stringify(data);

		if (metodo === "GET") { // --- Método GET ---
			// Codificamos la cadena JSON para que sea segura para usarla en una URL (GET)
			const encodedData = encodeURIComponent(jsonData);
			// Abrimos una nueva ventana con GET y enviamos los datos
			window.open(`${ENTROPY_VIEWER_FALLBACK_URL}?data=${encodedData}`, '_blank');
		} else { // --- Método POST ---
			// Creamos un formulario temporal
			const form = document.createElement('form');
			form.method = 'POST';
			form.action = ENTROPY_VIEWER_FALLBACK_URL;
			form.target = '_blank'; // Abrir en ventana nueva

			// Creamos un input oculto con los datos
			const input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'data';
			input.value = jsonData;

			// Agregamos input al formulario
			form.appendChild(input);
			// Lo agregamos al body y enviamos
			document.body.appendChild(form);
			form.submit();
			// Lo eliminamos del DOM para no ensuciar la página
			document.body.removeChild(form);
		}
	}

	// Abrir Entropy Viewer para poolHT
	document.getElementById('openEntropy')?.addEventListener('click', () => {
		abrirEntropyViewer(poolHT);
	});


	// ==========================================
	// SISTEMA DE HISTORIAL DE PETICIONES RHC
	// ==========================================

	// Límite de renglones a mostrar
	let limiteHistorial = 5;

	// Contenedor en memoria
	let historialPeticiones = [];

	// Contador global de peticiones
	let contadorPeticiones = 0;

	// Función para registrar una petición
	function registrarPeticion(estado, datos) {
		return new Promise(resolve => {
			contadorPeticiones++;
			const fecha = new Date().toLocaleString();
			const descripcion = "Petición del Protocolo RHC (Randomized Header Channel)";

			// Generar la gráfica con los tokens usados (columna1.poolHT)
			generarGraficaPNG(datos.columna1.poolHT, modoAnalisis, (imgBase64) => {

				const registro = {
					numero: contadorPeticiones,
					fecha,
					descripcion,
					estado,
					columna1: datos.columna1,
					columna2: datos.columna2,
					graficaBase64: imgBase64 // ← NUEVO
				};

				// Insertar al inicio
				historialPeticiones.unshift(registro);

				// Si nos pasamos del límite, eliminar el más viejo
				if (historialPeticiones.length > limiteHistorial) {
					historialPeticiones.pop();
				}

				// Actualizar la tabla visual
				renderHistorial();
				// Se resuelve la promesa
				resolve();
			});
		});
	}

	// Renderizar la tabla dentro del HTML
	function renderHistorial() {

		const tabla = document.getElementById("tablaHistorialRHC");
		if (!tabla) return;

		tabla.innerHTML = "";

		historialPeticiones.forEach((item) => {

			const idExpandible = `datos_${item.numero}`;

			// ----------------------------------------------------------------
			// 🔹 GENERAR FILAS DINÁMICAS DE COLUMNA 1 (poolHT)
			// ----------------------------------------------------------------
			let filasColumna1 = "";
			if (item.columna1?.poolHT) {
				Object.entries(item.columna1.poolHT).forEach(([header, token]) => {
					const esValido = headersDefinidos.includes(header);
					filasColumna1 += `
						<tr>
							<td class="${esValido ? 'green' : 'gray'}">${header}</td>
							<td class="token-cell ${esValido ? 'green' : 'gray'}">${token}</td>
						</tr>
					`;
				});
			}

			const todosLosHeaders = [...headersDefinidos, ...headersDecoys];
			const headersFaltantes = todosLosHeaders.filter(h => !Object.keys(item.columna1?.poolHT || {}).includes(h));

			headersFaltantes.forEach(header => {
				filasColumna1 += `
					<tr class="missing-row">
						<td>—</td>
						<td>—</td>
					</tr>
				`;
			});


			// ----------------------------------------------------------------
			// 🔹 GENERAR FILAS DINÁMICAS DE COLUMNA 2 (headers devueltos)
			// ----------------------------------------------------------------
			let filasColumna2 = "";
			const headersResp = item.columna2?.headers || {};
			const mensajeColumna2 = item.columna2?.mensaje || "";

			Object.entries(headersResp).forEach(([header, token]) => {
				const esValido = headersDefinidos.includes(header);
				filasColumna2 += `
					<tr>
						<td class="${esValido ? 'green' : 'red'}">${header}</td>
						<td class="token-cell ${esValido ? 'green' : 'red'}">${token}</td>
					</tr>
				`;
			});


			// Fila principal
			const fila = `
				<tr class="history-row ${item.estado === 'error' ? 'red' : 'green'} toggle-row" data-id="${idExpandible}">
					<td class="historial-num">${item.numero}</td>
					<td class="historial-fecha">${item.fecha}</td>
					<td class="historial-desc">${item.descripcion}</td>
					<td class="celda-toggle">▼</td>
				</tr>
			`;

			// Fila secundaria con datos expandibles
			const filaDatos = `
			<tr>
				<td colspan="4" style="padding:0;">
					<div id="${idExpandible}" class="datos-expandibles">

	<div class="pantalla-contenedor">

		<!-- DATOS -->
		<!-- Contenedor de los datos dentro de la fila expandible -->
		<div class="pantalla-datos">


							<div class="tables-wrapper">
								<!-- Tabla de Hisotrial Headers y Tokens -->
								<div class="table-box">
									<h3 class="tableTitle">Headers y Tokens - Utilizados</h3>

									<div class="legend">
										<span><span class="legend-circle green-circle"></span> Válidos</span>
										<span><span class="legend-circle gray-circle"></span> Señuelo (decoys)</span>
										<!-- Slide Entropy Viewer -->
										<span id="openGrafica_${item.numero}" class="slideEntropyTable" title="Ver Gráfica">📊</span>
										<!-- Abrir Entropy Viewer -->
										<span class="openEntropyTable" data-id="${idExpandible}" title="Abrir Entropy Viewer">📊</span>
									</div>

									<table>
										<tr><th>Header</th><th>Token</th></tr>
										${filasColumna1}
									</table>
								</div>

								<!-- Tabla de Hisotrial Respuesta de Servidor -->
								<div class="table-box">
									<h3 class="tableTitle">Respuesta del Servidor</h3>

									<div class="legend">
										<span><span class="legend-circle green-circle"></span> Válidos</span>
										<span><span class="legend-circle red-circle"></span> No Reconocidos</span>
									</div>

									<table>
										<tr><th>Header</th><th>Token</th></tr>
										${filasColumna2}
									</table>

									<div class="errorServidorRequest"
										style="visibility:${mensajeColumna2 ? 'visible' : 'hidden'};">
										${mensajeColumna2}
									</div>

								</div>
							</div>


		</div>

		<!-- GRÁFICA -->
		<!-- Contenedor de la gráfica dentro de la fila expandible -->
		<div class="pantalla-grafica">
			<!-- Botón para volver a los datos -->
			<button class="verDatos">← Volver a Datos</button>

			<img src="${item.graficaBase64}" class="grafica-generada" />

		</div>

	</div>


					</div>
				</td>
			</tr>
			`;

			tabla.innerHTML += fila + filaDatos;
		});


		// Abrir automáticamente la primera fila
		if (historialPeticiones.length > 0) {
			let idAuto = `datos_${historialPeticiones[0].numero}`;
			let div = document.getElementById(idAuto);

			if (div) {
				div.style.maxHeight = "500px";
				let filaPrincipal = div.parentNode?.previousElementSibling;
				if (filaPrincipal) {
					let icono = filaPrincipal.querySelector(".celda-toggle");
					if (icono) icono.textContent = "▲";
				}
			}
		}

		// Agregar eventos del slide
		agregarEventosSlide();
	}

	document.getElementById("tablaHistorialRHC").addEventListener("click", function(e) {
		const fila = e.target.closest(".toggle-row");
		if (!fila) return; // No es una fila toggle

		const id = fila.dataset.id; // ID del div expandible
		const contenido = document.getElementById(id);
		const icono = fila.querySelector(".celda-toggle");
		if (!contenido || !icono) return;

		if (contenido.style.maxHeight && contenido.style.maxHeight !== "0px") {
			contenido.style.maxHeight = "0px";
			icono.textContent = "▼";
		} else {
			ajustarAltura(contenido);
			icono.textContent = "▲";
		}
	});

 	document.addEventListener('click', function(e) {
		if (e.target.classList.contains('openEntropyTable')) {
			// Encontrar la tabla correspondiente
			const tablaDiv = e.target.closest('.table-box');
			if (!tablaDiv) return;

			// Convertir el contenido de la tabla en JSON
			const datosTabla = {};
			tablaDiv.querySelectorAll('table tr').forEach((fila, idx) => {
				if (idx === 0) return; // saltar encabezado
				const celdas = fila.querySelectorAll('td');
				if (celdas.length === 2) {
					const header = celdas[0].textContent.trim();
					const token = celdas[1].textContent.trim();
					if (header !== '—') datosTabla[header] = token;
				}
			});

			abrirEntropyViewer(datosTabla);
		}
	});

	// Funcion para agregar eventos del slide
	function agregarEventosSlide() {
		historialPeticiones.forEach(item => {
			const contenedor = document.getElementById(`datos_${item.numero}`);
			const pantalla = contenedor.querySelector(".pantalla-grafica");
			const datosPantalla = contenedor.querySelector(".pantalla-datos");
			const btnAbrir = contenedor.querySelector(".slideEntropyTable");
			const btnCerrar = contenedor.querySelector(".verDatos");

			if (btnAbrir)
				btnAbrir.addEventListener("click", () => {
					pantalla.classList.add("active");
					if (modoAnimacion === "SLIDE") datosPantalla.classList.add("oculta");
					setTimeout(() => ajustarAltura(contenedor), 100);
				});

			if (btnCerrar)
				btnCerrar.addEventListener("click", () => {
					pantalla.classList.remove("active");
					datosPantalla.classList.remove("oculta");
					setTimeout(() => ajustarAltura(contenedor), 100);
				});
		});
	}


	function ajustarAltura(contenido) {
		contenido.style.maxHeight = contenido.scrollHeight + "px";
	}


	function toggleDatos(id, icono) {
		const contenido = document.getElementById(id);
		if (!contenido) return;

		if (contenido.style.maxHeight && contenido.style.maxHeight !== "0px") {
			contenido.style.maxHeight = "0px";
			icono.textContent = "▼";
		} else {
			ajustarAltura(contenido);
			icono.textContent = "▲";
		}
	}

	// Función para saltos aleatorios
	function saltarBotones() {
		const botones = document.querySelectorAll('.openEntropy, .slideEntropyTable, .openEntropyTable');
		botones.forEach(btn => {
			const altura = Math.random() * 10 + 5; // salto aleatorio entre 5 y 15px
			const duracion = Math.random() * 200 + 200; // duración entre 200 y 400ms
//			const duracion = Math.random() * 400 + 400; // ahora: 400-800ms
			btn.style.transition = `transform ${duracion}ms ease`;
			btn.style.transform = `translateY(-${altura}px)`;

			// Volver a la posición normal
			setTimeout(() => {
				btn.style.transform = `translateY(0)`;
			}, duracion);
		});

		// Repetir cada 500ms
//		setTimeout(saltarBotones, 500);
		setTimeout(saltarBotones, 2000); // ahora saltan cada 2 segundos
	}

	// Iniciar animación después de cargar la página
	document.addEventListener('DOMContentLoaded', () => {
		saltarBotones();
	});
