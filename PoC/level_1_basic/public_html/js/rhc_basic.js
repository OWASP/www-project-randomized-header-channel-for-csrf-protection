/**
 * ==========================================================
 *  RHC BASIC MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel) NIVEL BASICO
 *  en el cliente.
 * 
 *  Este módulo separa la lógica de configuración (headersDispersos),
 *  es responsable de la composición dinámica de encabezados HTTP,
 *  y de retornar un solo objeto que contiene el encabezado seleccionado con su
 *  token. Esto mantiene el código modular, legible y extensible.
 * 
 *  Combina encabezados comunes y personalizados, fortaleciendo la
 *  imprevisibilidad del canal RHC frente a ataques CSRF o replay.
 * 
 *  @standard    RHC-NS-01 — Naming Standard Specification
 *  @reference   ../../docs/rhc-ns-01_naming_standard.md
 * 
 *  @file        public_html/js/rhc_basic.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 1 — Básico
 *  @usedby      requests.js → función enviarPeticion()
 *  @purpose     Gestionar la composición dinámica de encabezados HTTP
 *               del Protocolo RHC (Randomized Header Channel) NIVEL BÁSICO
 *               en el cliente.
 * 
 *  @category   Security
 *  @see        https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	/**
	 * ==========================================================
	 *  rhc_selectHeader_Basic()
	 * ----------------------------------------------------------
	 *  Selecciona aleatoriamente un encabezado HTTP de un conjunto
	 *  definido 'headersValidos' de encabezados válidos y asocia
	 *  un único token, y retorna un objeto con ese encabezado
	 *  y su token asociado.
	 * 
	 *  Este método pertenece al Protocolo RHC (Randomized Header Channel)
	 *  NIVEL BASICO en el cliente, entropía únicamente en la selección
	 *  del encabezado.
	 * 
	 *  Validaciones incluidas:
	 *    - Comprueba que `rhc_poolHT` exista y contenga al menos un par válido.
	 *    - Verifica que cada encabezado tenga un token de tipo string, no vacío,
	 *      y sin espacios en blanco.
	 *    - Si alguna de las condiciones falla, la función devuelve un
	 *      objeto vacío `{}`.
	 * 
	 *  @param {Object}  rhc_poolHT - Objeto mapa con encabezados y sus tokens. 
	 * 
	 *  @return {Object} - Objeto con un único par {header: token}, por ejemplo:
	 *                    { 'X-Server-Sig': 'q7r8s9t0u1v2w3x4y5z6a7b8' }
	 * 
	 *  @notes
	 *   - Este nivel introduce la primera capa de entropía del protocolo,
	 *     aplicando dispersión básica a nivel de canal mediante la selección
	 *     aleatoria del encabezado que porta el token.
	 *   - Se mantiene una correspondencia directa y estática entre cada
	 *     encabezado y su token, lo que garantiza trazabilidad simple pero efectiva.
	 * ==========================================================
	 */
	function rhc_selectHeader_Basic(rhc_poolHT = {}) {
		// Validar que el pool exista y tenga al menos un header
		if (!rhc_poolHT || Object.keys(rhc_poolHT).length === 0) {
			console.warn('[RHC] - El pool de headers/tokens está vacío o no es válido.');
			return {};
		}

		// Validar integridad de tokens asociados
		const rhc_headersInvalidos = Object.entries(rhc_poolHT)
			.filter(([header, token]) => !token || typeof token !== 'string' || token.trim() === '');
		if (rhc_headersInvalidos.length > 0) {
			console.warn(`[RHC] - Se detectaron ${rhc_headersInvalidos.length} encabezados sin token válido:`, rhc_headersInvalidos);
			return {};
		}

		// Obtener listas de headers desde el pool
		const rhc_headers = Object.keys(rhc_poolHT);

		// Seleccionar encabezado aleatorio
		const rhc_indexHeader = Math.floor(Math.random() * rhc_headers.length);
		const rhc_headerSeleccionado = rhc_headers[rhc_indexHeader];

		// Mantiene el token correspondiente a su header
		let rhc_tokenSeleccionado = rhc_poolHT[rhc_headerSeleccionado];

		// Retornar objeto con el encabezado seleccionado y su token correspondiente
		return { [rhc_headerSeleccionado]: rhc_tokenSeleccionado };
	}
