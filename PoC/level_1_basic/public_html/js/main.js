/**
 * ==========================================================
 *  MAIN — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo principal de inicialización del Protocolo RHC.
 * 
 *  Gestiona la configuración base del sistema, incluyendo:
 *    - Definición de encabezados válidos
 *    - Determinación de la URL base de la API según el host
 *    - Validación de dominios permitidos
 *    - Inicialización del pool de encabezados dinámicos
 * 
 *  Este módulo integra los demás módulos del sistema (UI Controls,
 *  Requests) y garantiza que las operaciones RHC solo se ejecuten
 *  en entornos autorizados.
 *
 *  @file        public_html/js/main.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 1 — Básico
 *  @purpose     Inicializar y validar la configuración base del sistema,
 *               asegurando ejecución segura y adaptativa del protocolo.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ----------------------------------------------------------
	// Definición de encabezados válidos
	// ----------------------------------------------------------

	// Definición de encabezados válidos
	let headersDefinidos = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];

	let poolHT = {}; // Mapa completo {header: token}
	let uiHeadersValidos = [];
	let uiTokensValidos = [];
	let uiHDG = {};


	// URL base del API
	const hostname = window.location.hostname;
	const apiURL = ["localhost", "127.0.0.1"].includes(hostname)
		? "https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_1_basic/api/"
		: hostname === "www.www-project-randomized-header-channel-for-csrf-protection.test"
			? "https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_1_basic/api/"
			: "";

	console.log("Host:", hostname);
	console.log("API URL:", apiURL);

	// ----------------------------------------------------------
	// Validación del dominio permitido y la URL base del API
	// ----------------------------------------------------------
	if (!apiURL) {
		console.error("🚫 URL del API no configurada.");
		alert("Error: URL del API no configurada, NO se ejecutar el módulo RHC Protocol Core.");

		// Deshabilitar botones
		document.querySelectorAll("button, input[type='submit']").forEach(btn => btn.disabled = true);

		// Evitar que continúe la ejecución del resto del script
		throw new Error("Ejecución detenida: dominio no autorizado.");
	}


	// Inicialización
	window.onload = function() {
		// Modo 'shared': todos los headers tienen el mismo token
		userLogin(headersDefinidos, 'shared').then(pool => {
			poolHT = pool;
			// Extraer headers y tokens en arreglos separados
			uiHeadersValidos = Object.keys(poolHT);
			uiTokensValidos = Object.values(poolHT);

			cargarEnTablaHeaders();
			cargarEnTablaTokens();
			document.querySelector('button')?.focus();
		});
	};
