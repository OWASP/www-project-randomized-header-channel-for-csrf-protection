/**
 * ==========================================================
 *  MAIN — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo principal de inicialización del Protocolo RHC.
 * 
 *  Gestiona la configuración base del sistema, incluyendo:
 *    - Definición de encabezados válidos y señuelo (decoys)
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
 *  @implementation Nivel 4 — Adaptativo Dinámico
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
	const headersDefinidos = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];
	// Número máximo de encabezados válidos que pueden incluirse en una petición RHC.
	// Controla cuántos headers de la lista `headersDefinidos` se seleccionan y mezclan
	// con los encabezados señuelo (`headersDecoys`) antes del envío.
	// Ejemplo: si vale 2 → se usarán entre 1 y 2 headers válidos + todos los señuelos.
	const headersEnviarMax = 2;
	// Definición de encabezados señuelos (Decoys)
	const headersDecoys = ['X-Server-Atlas', 'X-Server-Orchid', 'X-Server-Drift', 'X-Server-Quartz', 'X-Server-Veil'];

	let poolHT = {}; // Mapa completo {header: token}

	// Estas dos constantes controlan la longitud mínima y máxima (en BYTES) de los
	// tokens generados.
	// Cada token se define en bytes para poder ser generados. Estos bytes
	// se convierte en 2 caracteres hexadecimales.
	// 		Ejemplo: 6 bytes → 12 caracteres hex. 10 bytes → 20 caracteres hex.
	// Definir la longitud en bytes garantiza coherencia con la fuente de aleatoriedad
	// y permite controlar de manera precisa la entropía del
	// token generado.
	// -----------------------------------------------------------------------------
	// Longitud mínima permitida para cada token generado (en bytes).
	// Debe ser ≥ 4 para evitar patrones repetitivos y entropía baja.
	// -----------------------------------------------------------------------------
	const tokenLongitudMin = 6;   // 6 bytes = 12 caracteres hexadecimales
	// -----------------------------------------------------------------------------
	// Longitud máxima permitida para cada token generado (en bytes).
	// No debería superar los 64 bytes para evitar tokens excesivamente largos.
	// -----------------------------------------------------------------------------
	const tokenLongitudMax = 10;  // máximo en bytes
	
	// URL base del API
	const hostname = window.location.hostname;
	const apiURL = ["localhost", "127.0.0.1"].includes(hostname)
		? "https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_4_dynamic_adaptive/api/"
		: hostname === "www.www-project-randomized-header-channel-for-csrf-protection.test"
			? "https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_4_dynamic_adaptive/api/"
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
		regenerarPoolHT(); 
	};
