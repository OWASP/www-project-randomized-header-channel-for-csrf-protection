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
 *  @implementation Nivel 2 — Intermedio
 *  @purpose     Controlar la capa visual e interacción UI del sistema.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Cargar en tabla los encabezados
	function cargarEnTablaHeaders() {
		const tabla = document.getElementById('headersTable');
		tabla.innerHTML = '<tr><th>Encabezado</th><th>Estado</th></tr>';
		uiHeadersValidos.forEach((header, index) => {
			tabla.innerHTML += `
				<tr>
					<td>${header}</td>
					<td id="h${index + 1}" class="gray">No usado</td>
				</tr>`;
		});
	}

	// Actualiza la tabla de encabezados, marcando cuál
	// fue el encabezado seleccionado por el Protocolo RHC.
	function actualizarTablaHeaders(headerSeleccionado, type = "OK") {
		limpiarTablaHeaders(); // Limpia la tabla antes de actualizar
		const idx = uiHeadersValidos.indexOf(headerSeleccionado);
		if (idx !== -1) {
			const fila = document.querySelectorAll('#headersTable tr')[idx + 1]; // +1 porque el header de la tabla ocupa la primera fila
			if (fila) {
				// Columna 1 → color según type
				fila.cells[0].className = type !== "OK" ? "red" : "gray";

				// Columna 2 → mostrar "Usado" siempre en verde
				fila.cells[1].textContent = "Usado";
				fila.cells[1].className = "green";
			}
		}
	}

	// Limpia la tabla de encabezados
	function limpiarTablaHeaders() {
		document.querySelectorAll('#headersTable tr').forEach((fila, index) => {
			if (index === 0) return; // saltar la fila de encabezado
			// Columna 1 → gris
			fila.cells[0].className = "gray";
			// Columna 2 → "No usado" y gris
			fila.cells[1].textContent = "No usado";
			fila.cells[1].className = "gray";
		});
	}

	// Cargar en tabla los tokens
	function cargarEnTablaTokens() {
		const tabla = document.getElementById('tokensTable');
		tabla.innerHTML = '<tr><th>Token</th><th>Estado</th></tr>';
		uiTokensValidos.forEach((token, index) => {
			// Agregamos la clase 'hidden' a todas las filas excepto la primera
			const clase = index === 0 ? '' : 'hidden';
			tabla.innerHTML += `
				<tr class="${clase}">
					<td>${token}</td>
					<td id="t${index + 1}" class="gray">No usado</td>
				</tr>`;
		});
	}

	// Actualiza la tabla de tokens, marcando cuál fue el seleccionado
	function actualizarTablaTokens(tokenSeleccionado) {
		limpiarTablaTokens();
		const idx = uiTokensValidos.indexOf(tokenSeleccionado);
		if (idx !== -1) {
			const celda = document.getElementById('t' + (idx + 1));
			if (celda) {
				celda.textContent = "Usado";
				celda.className = "green";
			}
		}
	}

	// Limpia la tabla de tokens
	function limpiarTablaTokens() {
		document.querySelectorAll('#tokensTable td:nth-child(2)').forEach(td => {
			td.textContent = "No usado";
			td.className = "gray";
		});
	}

	// Mensajes de error
	function mostrarError(mensaje) {
		const errorDiv = document.getElementById('errorMsg');
		errorDiv.style.visibility = "visible";
		errorDiv.textContent = mensaje;
	}

	function limpiarError() {
		const errorDiv = document.getElementById('errorMsg');
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
	document.getElementById('tokenMode')?.addEventListener('change', function() {
		tokenModoAsignacion = this.value;
	});
