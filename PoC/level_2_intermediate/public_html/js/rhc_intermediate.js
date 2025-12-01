/**
 * ==========================================================
 *  RHC INTERMEDIATE MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel) NIVEL INTERMEDIO
 *  en el cliente.
 * 
 *  Este módulo separa la lógica de configuración (headersDispersos),
 *  es responsable de la composición dinámica de encabezados HTTP
 *  y de retornar un solo objeto que contiene el encabezado seleccionado
 *  junto con su token. Esto mantiene el código modular, legible y extensible.
 * 
 *  A diferencia del nivel básico, este nivel introduce un mecanismo
 *  de doble entropía: selección aleatoria del encabezado HTTP y asignación
 *  variable del token según el modo configurado por el usuario:
 *   - Modo A — Asignación fija: cada encabezado mantiene su token asociado.
 *   - Modo B — Asignación aleatoria: el token se elige aleatoriamente
 *     de la lista disponible en cada solicitud.
 * 
 *  Combina encabezados comunes y personalizados, fortaleciendo la
 *  imprevisibilidad del canal RHC frente a ataques CSRF o replay.
 * 
 *  @standard    RHC-NS-01 — Naming Standard Specification
 *  @reference   ../../docs/rhc-ns-01_naming_standard.md
 * 
 *  @file        public_html/js/rhc_intermediate.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @usedby      requests.js → función enviarPeticion()
 *  @purpose     Gestionar la composición dinámica de encabezados HTTP
 *               del Protocolo RHC (Randomized Header Channel) NIVEL INTERMEDIO
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
	 *  rhc_selectHeader_Intermediate()
	 * ----------------------------------------------------------
	 *  Selecciona aleatoriamente un encabezado HTTP de un conjunto
	 *  definido de headers válidos, y determina el token asociado
	 *  según el modo de asignación configurado:
	 * 
	 *  Modos de asignación de token:
	 *   - "FixedAssignment"  : el encabezado mantiene su token original 
	 *                          tal como viene definido en `rhc_poolHT`.
	 *   - "RandomAssignment" : el encabezado seleccionado se asocia con 
	 *                          un token aleatorio tomado del mismo `rhc_poolHT`.
	 * 
	 *  Este método pertenece al Protocolo RHC (Randomized Header Channel)
	 *  NIVEL INTERMEDIO en el cliente, introduciendo doble capa de
	 *  entropía (aleatoriedad): en la selección del encabezado como en
	 *  la asignación del token por cada solicitud.
	 * 
	 *  Validaciones incluidas:
	 *    - Comprueba que `rhc_poolHT` exista y contenga al menos un par válido.
	 *    - Verifica que cada encabezado tenga un token de tipo string, no vacío,
	 *      y sin espacios en blanco.
	 *    - Si alguna de las condiciones falla, la función devuelve un
	 *      objeto vacío `{}`.
	 * 
	 *  @param {Object}  rhc_poolHT - Objeto mapa con encabezados y sus tokens. 
	 *                            Ejemplo: { "X-Server-Sig": "tok_abcd1234", ... }
	 *  @param {string}  rhc_tokenModoAsignacion - Modo de asignación del token.
	 *                            Valores posibles: "FixedAssignment" | "RandomAssignment"
	 *                            (por defecto: "RandomAssignment")
	 * 
	 *  @return {Object} - Objeto con un único par {header: token}, por ejemplo:
	 *                     { "X-Server-Sig": "tok_abcd1234" }
	 * 
	 *  @notes
	 *   - Este nivel introduce una segunda capa de entropía, combinando la
	 *     dispersión del encabezado con la variabilidad en la asignación del token.
	 *   - Permite alternar entre modos fijos o dinámicos, generando un
	 *     canal de comunicación menos predecible sin perder compatibilidad.
	 * ==========================================================
	 */
	function rhc_selectHeader_Intermediate(rhc_poolHT = {}, rhc_tokenModoAsignacion = "RandomAssignment") {
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

		// Obtener listas de headers y tokens desde el pool
		const rhc_headers = Object.keys(rhc_poolHT);
		const rhc_tokens = Object.values(rhc_poolHT);

		// Seleccionar encabezado aleatorio
		const rhc_indexHeader = Math.floor(Math.random() * rhc_headers.length);
		const rhc_headerSeleccionado = rhc_headers[rhc_indexHeader];

		// Seleccionar token según modo
		let rhc_tokenSeleccionado;
		// Asignación según modo
		if (rhc_tokenModoAsignacion === 'FixedAssignment') {
			// Mantiene el token correspondiente a su header
			rhc_tokenSeleccionado = rhc_poolHT[rhc_headerSeleccionado];
		} else {
			// Asigna token aleatorio del conjunto existente
			const indexToken = Math.floor(Math.random() * rhc_tokens.length);
			rhc_tokenSeleccionado = rhc_tokens[indexToken];
		}

		// Retornar objeto con el encabezado seleccionado y su token
		return { [rhc_headerSeleccionado]: rhc_tokenSeleccionado };
	}
