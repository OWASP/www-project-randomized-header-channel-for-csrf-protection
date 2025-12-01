/**
 * ==========================================================
 *  REQUESTS MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo de comunicación con el servidor mediante AJAX o Fetch API.
 *  Gestiona solicitudes a la API, manejo de respuestas JSON
 *  y errores provenientes del back-end.
 * 
 *  Este módulo implementa el Protocolo RHC (Randomized Header Channel)
 *  NIVEL INTERMEDIO utilizando el operador "spread" (...) para fusionar
 *  fácilmente el objeto que contiene el encavezado seleccionado con su
 *  token, manteniendo el código modular, legible y extensible.
 * 
 *  @file        public_html/js/requests.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @integration RHC Intermediate Module (rhc_intermediate.js)
 *               Usa la función rhc_selectHeader_Intermediate() para incorporar
 *               encabezados dinámicos generados por el Protocolo RHC
 *               (Randomized Header Channel) NIVEL INTERMEDIO.
 *  @purpose     Centralizar las peticiones y respuestas HTTP del sistema.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ------------------------------------------------------
	// Generar el token hexadecimal con la longitud elegida
	// ------------------------------------------------------
	//  La función randomHex(randomLength) utiliza window.crypto
	//  para generar valores aleatorios criptográficamente seguros
	//  y los convierte en una cadena hexadecimal.
	//
	//  Ejemplo de salida:
	//     "a1b2c3d4e5f6"
	//     "8fa2b19c0d4e9f3a"
	//     "bc7d51e9f3a027..."
	//
	// devuelve un string hex de `bytes` bytes (por defecto 32)
	function randomHex(bytes = 32) {
		const arr = new Uint8Array(bytes);
		// window.crypto es la API segura del navegador
		(window.crypto || window.msCrypto).getRandomValues(arr);
		// convertir a hex
		return Array.from(arr, b => b.toString(16).padStart(2, '0')).join('');
	}

	// -----------------------------------------------------------------------------
	// Simula un "login" que devuelve encabezados y tokens de distintos tamaños
	// -----------------------------------------------------------------------------
	// Permite generar tokens en dos modos:
	//   - 'random' → genera longitudes aleatorias entre 6 y 32 bytes
	//   - 'custom' → usa longitudes fijas definidas en el arreglo customLens[]
	//
	// - Modo aleatorio (por defecto):
	//
	// 		const headers = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];
	// 		const result = await userLogin(headers, 'random');
	// 		console.log(result);
	//
	// - Modo personalizado:
	//
	// 		const headers = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];
	// 		const result = await userLogin(headers, 'custom', [12, 4, 8]);
	// 		console.log(result);
	//
	// - Modo compartido:
	//
	// 		const headers = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];
	// 		const result = await userLogin(headers, 'shared');
	// 		console.log(result);
	//
	async function userLogin(headersDef, modeType = 'random', customLens = []) {

		// -------------------------------------------------------------------------
		// Generar tokens según el modo seleccionado
		// -------------------------------------------------------------------------

		let tokens = [];

		if (modeType === 'shared') {
			// Modo compartido: todos los headers tienen el mismo token
			const sharedToken = randomHex(12);
			tokens = headersDef.map(() => sharedToken);

		} else if (modeType === 'custom') {
			// Modo personalizado: longitudes fijas definidas manualmente
			tokens = headersDef.map((_, i) => {
				const len = customLens[i] || 12; // valor por defecto
				return randomHex(len);
			});

		} else {
			// Modo aleatorio: genera tokens entre 6 y 32 bytes
			tokens = headersDef.map(() => {
				// Explicación matemática:
				//   - Math.random() genera un número decimal entre 0 y 1 (sin incluir 1)
				//   - Se multiplica por (32 - 6 + 1) → define el rango total de valores
				//   - Math.floor(...) redondea hacia abajo para obtener un número entero
				//   - Se suma +6 para garantizar que el valor mínimo sea 6.
				//
				// Resultado final:
				//    	randomLength ∈ [6, 32]
				//
				// Cada “byte” equivale a 2 caracteres hexadecimales:
				//    			6 bytes  = 12 caracteres hex
				//    			32 bytes = 64 caracteres hex
				const randomLength = Math.floor(Math.random() * (32 - 6 + 1)) + 6;
				return randomHex(randomLength);
			});
		}

		// -------------------------------------------------------------------------
		// Construir y retornar la respuesta simulando un login exitoso
		// -------------------------------------------------------------------------
		const response = {
			status: "success",
			message: "Usuario autenticado correctamente",
			map: {
				info: Object.fromEntries(
					headersDef.map((h, i) => [h, tokens[i]])
				)
			}
		};

		// Retornar directamente el objeto de headers/tokens
		return response.map.info;
	}

	function solicitudAJAX() {
		enviarPeticion('ajax');
	}

	function solicitudFetch() {
		enviarPeticion('fetch');
	}

	function enviarPeticion(tipo) {
		limpiarError();
		// Obtener el producto seleccionado en el formulario
		const id_producto = document.getElementById('productSelect').value;


		// Seleccionar encabezado aleatorio mediante el 
		// Protocolo RHC (Randomized Header Channel) NIVEL INTERMEDIO.
		const headersDispersos = rhc_selectHeader_Intermediate(poolHT, tokenModoAsignacion);
		uiHDG = headersDispersos;

		// ===== Actualizar visualmente las tablas =====

		// Actualizar visualmente la tabla de encabezados
		const headerSeleccionado = Object.keys(headersDispersos)[0];
		actualizarTablaHeaders(headerSeleccionado);
		// Actualizar visualmente la tabla de token's
		const tokenSeleccionado = Object.values(headersDispersos)[0];
		actualizarTablaTokens(tokenSeleccionado);


		// Asignamos encabezados dinámicos + comunes antes de 
		// realizar una peticion al servidor.
		const headersFinales = {
			...headersDispersos, // ← Implementación del Protocolo RHC (Randomized Header Channel) NIVEL INTERMEDIO
			"Authorization": "Bearer FAKEJWT123",
			"Content-Type": "application/json; charset=utf-8"
		};

		const body = JSON.stringify({ id_producto });

		const options = {
			method: "POST",
			headers: headersFinales,
			body: body
		};

		if (tipo === 'ajax') {
			solicitudConAJAX(options);
		} else {
			solicitudConFetch(options);
		}
	}

	// -------------------------------
	// AJAX
	// -------------------------------
	function solicitudConAJAX(options) {
		const xhr = new XMLHttpRequest();
		xhr.open("POST", apiURL, true);

		for (const [key, value] of Object.entries(options.headers)) {
			xhr.setRequestHeader(key, value);
		}

		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				procesarRespuesta(xhr.status, xhr.responseText);
			}
		};

		xhr.send(options.body);
	}

	// -------------------------------
	// FETCH
	// -------------------------------
	function solicitudConFetch(options) {
		fetch(apiURL, options)
			.then(res => res.text())
			.then(text => procesarRespuesta(200, text))
			.catch(err => procesarRespuesta(500, JSON.stringify({ error: err.message })));
	}

	// -------------------------------
	// PROCESAR RESPUESTA
	// -------------------------------
	function procesarRespuesta(status, respuesta) {
		let resultDiv = document.getElementById("result");
		resultDiv.innerHTML = "";
		limpiarCampos();

		// Intentar parsear JSON una sola vez
		let respuestaJSON;
		try {
			respuestaJSON = JSON.parse(respuesta);
		} catch (e) {
			const mensaje = "Error al procesar la respuesta del servidor: JSON inválido.";
			mostrarError(mensaje);

			return;
		}

		// Manejo de errores de status
		if (status !== 200) {
			const mensaje = respuestaJSON.message || "Error en la solicitud. El servidor no respondió correctamente.";
			mostrarError("Servidor respondió: " + mensaje);
			const headers = respuestaJSON?.data?.encabezados_no_reconocidos || {};
			if (headers && Object.keys(headers).length > 0) {
				// ===== Actualizar visualmente las tablas =====

				// Actualizar visualmente la tabla de encabezados
				const headerSeleccionado = Object.keys(uiHDG)[0];
				actualizarTablaHeaders(headerSeleccionado, "error");
				// Actualizar visualmente la tabla de token's
				const tokenSeleccionado = Object.values(uiHDG)[0];
				actualizarTablaTokens(tokenSeleccionado, "error");
			}

			return;
		}

		const data = respuestaJSON.data;

		if (data.producto.error) {
			mostrarError("Error: " + data.producto.error);
		} else {
			limpiarError();
			llenarCampos(data.producto);
		}

		resultDiv.innerHTML = `
			<strong>Respuesta del servidor:</strong><br>
			Encabezado recibido: <b>${data.header_recibido}</b><br>
			Token: <b>${data.token}</b>
		`;
	}