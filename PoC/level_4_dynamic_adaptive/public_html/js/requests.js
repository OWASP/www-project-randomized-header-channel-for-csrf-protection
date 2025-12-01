/**
 * ==========================================================
 *  REQUESTS MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo de comunicación con el servidor mediante AJAX o Fetch API.
 *  Gestiona solicitudes a la API, manejo de respuestas JSON
 *  y errores provenientes del back-end.
 * 
 *  Este módulo implementa el Protocolo RHC (Randomized Header Channel)
 *  NIVEL ADAPTATIVO DINÁMICO utilizando el operador "spread" (...) para fusionar
 *  fácilmente el objeto que contiene el encavezado seleccionado con su
 *  token, manteniendo el código modular, legible y extensible.
 * 
 *  @file        public_html/js/requests.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @integration RHC Dynamic Adaptive Module (rhc_dynamic_adaptive.js)
 *               Usa la función rhc_selectHeader_DynamicAdaptive() para incorporar
 *               encabezados dinámicos generados por el Protocolo RHC
 *               (Randomized Header Channel) NIVEL ADAPTATIVO DINÁMICO.
 *  @purpose     Centralizar las peticiones y respuestas HTTP del sistema.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Longitud predeterminada para tokens en modo 'custom'. Se utiliza únicamente
	// cuando no se proporciona una longitud explícita en el arreglo customLens[],
	// y no tiene relación con el rango dinámico del modo aleatorio. Expresada en
	// bytes (1 byte = 2 caracteres hexadecimales).
	const tokenLongitudPorDefecto = 10;

	// -----------------------------------------------------------------------------
	// REGENERAR POOL DE HEADERS Y TOKENS (Nivel 4 Adaptativo Dinámico)
	// -----------------------------------------------------------------------------
	// Esta función reconstruye el conjunto completo de encabezados simulados (poolHT)
	// generando tokens con longitudes fijas o variables según el modo seleccionado.
	//
	// Modo 'FixedLength':
	//    - Todos los tokens tienen una longitud constante (12 bytes = 24 caracteres hex)
	//    - Útil para pruebas base o entornos controlados.
	//
	// Modo 'VariableLength':
	//    - Cada token tiene una longitud aleatoria dentro del rango [minLen, maxLen]
	//    - Aumenta la entropía y evita patrones predecibles.
	//    - Refuerza la trazabilidad criptográfica dentro del canal RHC.
	//
	function regenerarPoolHT() {
		// Tipo de longitud de token simulados
		// Inicializamos la variable con el valor del select si existe, o usamos 'FixedLength' por defecto
		// Valores posibles: "FixedLength", "VariableLength"
		const tokenLengthMode = document.getElementById('tokenLengthMode').value || 'FixedLength';

		// Mezcla headers válidos y señuelos definidos
		const headersCombinados = mezclarHeaders(headersDefinidos, headersDecoys, headersEnviarMax);

		let modeType = 'custom';
		let customLens = [];

		if (tokenLengthMode === 'FixedLength') {
			// Genera longitudes fija (usa el valor por defecto del modo 'custom')
			customLens = [];
		} else {
			// Genera longitudes variables (entropía aumentada)
			const minLen = tokenLongitudMin;  // mínimo en bytes
			const maxLen = tokenLongitudMax;  // máximo en bytes
			// Genera una longitud aleatoria para cada header del pool
			customLens = headersCombinados.map(() => {
				const randLen = Math.floor(Math.random() * (maxLen - minLen + 1)) + minLen;
				return randLen;
			});
		}

		userLogin(headersCombinados, modeType, customLens)
			.then(pool => { 
				poolHT = pool;
				cargarTablaHeaderTokens();
			});
	}

	// -----------------------------------------------------------------------------
	// SELECCIONAR Y MEZCLAR HEADERS VÁLIDOS Y SEÑUELOS (RHC Nivel 4 Adaptativo)
	// -----------------------------------------------------------------------------
	// Esta función selecciona de manera aleatoria una cantidad de encabezados válidos
	// pertenecientes a "headersA". El número máximo permitido se define mediante
	// "hEnviarMaximo", valor que se normaliza y ajusta a los límites válidos.
	//
	// Una vez seleccionados los encabezados válidos, estos se combinan con los 
	// encabezados señuelo (headersB). Finalmente, al conjunto completo se le aplica
	// mezcla (shuffle) mediante el algoritmo Fisher–Yates para garantizar una
	// distribución totalmente impredecible.
	//
	// Ejemplo de comportamiento:
	//     headersA = ['A', 'B', 'C']
	//     headersB = ['X', 'Y', 'Z']
	//     → Se elige aleatoriamente 2 válidos: ['B', 'C']
	//     → Se combinan con los señuelos → ['B', 'C', 'X', 'Y', 'Z']
	//     → Se mezclan → ['Y', 'B', 'X', 'C', 'Z']
	//
	// La función realiza:
	//   1. Validación del conjunto de headers válidos disponible.
	//   2. Normalización del parámetro "hEnviarMaximo".
	//   3. Selección aleatoria de entre 1 y hEnviarMaximo headers válidos.
	//   4. Combinación de headers válidos + señuelos.
	//   5. Mezcla final mediante el algoritmo Fisher–Yates.
	//
	// El resultado es un arreglo completamente aleatorizado de encabezados,
	// apto para el mecanismo del canal RHC nivel 4 (Adaptativo Dinámico).
	//
	function mezclarHeaders(headersA, headersB, hEnviarMaximo = 1) {
		// ---------------------------------------------------------------
		// Paso 1: Validar que haya encabezados definidos
		// ---------------------------------------------------------------
		if (!headersA || headersA.length === 0) {
			console.warn("⚠️ No hay encabezados definidos en 'headersDefinidos'. No se seleccionará ninguno.");
			return [];
		}

		// ---------------------------------------------------------------
		// Paso 2: Definir y validar el límite máximo de envío
		// ---------------------------------------------------------------
		// Normalizar valor recibido y convertir a entero
		hEnviarMaximo = parseInt(hEnviarMaximo);
		// Si no es un entero válido, usar valor Maximo por defecto
		if (!Number.isInteger(hEnviarMaximo)) {
			hEnviarMaximo = headersA.length;
		}

		// Ajustar a los límites permitidos
		if (hEnviarMaximo < 1) hEnviarMaximo = 1;
		if (hEnviarMaximo > headersA.length) hEnviarMaximo = headersA.length;

		// ---------------------------------------------------------------
		// Paso 3: Elegir un número aleatorio de encabezados válidos
		// ---------------------------------------------------------------
		const cantidadSeleccionada = Math.floor(Math.random() * hEnviarMaximo) + 1;

		// Tomar una copia y barajarla antes de elegir
		const headersAleatorios = [...headersA].sort(() => Math.random() - 0.5);
		const headersSeleccionados = headersAleatorios.slice(0, cantidadSeleccionada);

		// ---------------------------------------------------------------
		// Paso 4: Combinar con los encabezados señuelo
		// ---------------------------------------------------------------
		const combinados = [...headersSeleccionados, ...headersB];

		// ---------------------------------------------------------------
		// Paso 5: Aplicar mezcla Fisher-Yates para aleatorizar el orden final
		// ---------------------------------------------------------------
		for (let i = combinados.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[combinados[i], combinados[j]] = [combinados[j], combinados[i]];
		}

		// Devuelve el conjunto final de headers combinados
		return combinados;
	}

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
				const len = customLens[i] || tokenLongitudPorDefecto; // valor por defecto en bytes
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
				const randomLength = Math.floor(Math.random() * (tokenLongitudMax - tokenLongitudMin + 1)) + tokenLongitudMin;
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

	// BLOQUEAR Y DESBLOQUEAR BOTONES DE PETICIÓN
	function bloquearBotonesPeticion() {
		const btnAJAX = document.querySelector("button[onclick='solicitudAJAX()']");
		const btnFetch = document.querySelector("button[onclick='solicitudFetch()']");

		if (btnAJAX) btnAJAX.disabled = true;
		if (btnFetch) btnFetch.disabled = true;

		document.getElementById("esperaAcción").textContent = "Procesando petición...";
	}

	function desbloquearBotonesPeticion() {
		const btnAJAX = document.querySelector("button[onclick='solicitudAJAX()']");
		const btnFetch = document.querySelector("button[onclick='solicitudFetch()']");

		if (btnAJAX) btnAJAX.disabled = false;
		if (btnFetch) btnFetch.disabled = false;

		document.getElementById("esperaAcción").textContent = "Esperando acción...";
	}

	function solicitudAJAX() {
		enviarPeticion('ajax');
	}

	function solicitudFetch() {
		enviarPeticion('fetch');
	}

	function enviarPeticion(tipo) {

		// Evita SPAM de clics
		bloquearBotonesPeticion();

		limpiarErrorProductos();
		limpiarErrorServidor();
		// Obtener el producto seleccionado en el formulario
		const id_producto = document.getElementById('productSelect').value;


		// Seleccionar encabezado aleatorio mediante el 
		// Protocolo RHC (Randomized Header Channel) NIVEL ADAPTATIVO DINÁMICO.
		const headersDispersos = rhc_selectHeader_DynamicAdaptive(poolHT);

		// Asignamos encabezados dinámicos + comunes antes de 
		// realizar una peticion al servidor.
		const headersFinales = {
			...headersDispersos, // ← Implementación del Protocolo RHC (Randomized Header Channel) NIVEL ADAPTATIVO DINÁMICO
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
	async function procesarRespuesta(status, respuesta) {

		// Limpiar todo al inicio
		limpiarCampos();
		limpiarErrorProductos();
		limpiarErrorServidor();

		// Intentar parsear JSON una sola vez
		let respuestaJSON;
		try {
			respuestaJSON = JSON.parse(respuesta);
		} catch (e) {
			const mensaje = "Error al procesar la respuesta del servidor: JSON inválido.";
			mostrarErrorServidor(mensaje);

			// ===== Registro del Historial =====
			const estado = 'error';
			const datosRespuesta = {
				columna1 : { poolHT },
				columna2 : { mensaje }
			};
			await registrarPeticion(estado, datosRespuesta);

			await regenerarPoolHT();

			desbloquearBotonesPeticion();

			return;
		}

		// Manejo de errores de status
		if (status !== 200 || respuestaJSON.status === "error") {
			const mensaje = respuestaJSON.message || "Error en la solicitud. El servidor no respondió correctamente.";
			mostrarErrorServidor("Servidor respondió: " + mensaje);

			// ===== Registro del Historial =====
			const estado = 'error';
			const headers = respuestaJSON?.data?.encabezados_no_reconocidos || {};
			const datosRespuesta = {
				columna1 : { poolHT },
				columna2 : { mensaje, headers }
			};
			await registrarPeticion(estado, datosRespuesta);

			await regenerarPoolHT();

			desbloquearBotonesPeticion();

			return;
		}

		// Validar que existan los datos y el producto
		const data = respuestaJSON.data || {};
		const producto = data.producto || {};

		if (producto.error) {
			mostrarErrorProductos("Error: " + producto.error);
		} else {
			// Llenar los campos con los datos del producto
			llenarCampos(producto);
		}

		// ===== Registro del Historial =====
		const estado = 'OK';
		const headers = data.header_recibido || {};
		const datosRespuesta = {
			columna1 : { poolHT },
			columna2 : { headers }
		};
		await registrarPeticion(estado, datosRespuesta);

		await regenerarPoolHT();

		desbloquearBotonesPeticion();
	}
