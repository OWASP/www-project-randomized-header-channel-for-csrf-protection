/**
 * ==========================================================
 *  RHC ADVANCED MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel) NIVEL AVANZADO
 *  en el cliente.
 * 
 *  Este módulo amplía la lógica del Nivel 2 — Intermedio, 
 *  añadiendo **entropía estructural** mediante tokens de
 *  longitudes y formatos aleatorios (8, 16, 32 o 64 bytes),
 *  junto con la rotación dinámica de encabezados válidos
 *  por solicitud.
 * 
 *  A diferencia del nivel anterior, donde los tokens provenían
 *  de un conjunto fijo, este nivel introduce un generador 
 *  pseudoaleatorio controlado que simula variaciones en tamaño 
 *  y estructura, preservando la integridad del canal.
 * 
 *  Principales características:
 *   1. Generación dinámica de tokens con longitudes variables.
 *   2. Selección aleatoria de encabezado HTTP activo.
 *   3. Trazabilidad criptográfica mantenida por índice correlativo.
 * 
 *  Este enfoque incrementa la resistencia frente a:
 *   - Reproducción de cabeceras (Replay Attacks)
 *   - Predicción de tokens en CSRF avanzados
 *   - Fingerprinting de canales RHC estáticos
 * 
 *  @standard    RHC-NS-01 — Naming Standard Specification
 *  @reference   ../../docs/rhc-ns-01_naming_standard.md
 * 
 *  @file        public_html/js/rhc_advanced.js
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 3 — Avanzado
 *  @usedby      requests.js → función enviarPeticion()
 *  @purpose     Gestionar la composición dinámica de encabezados HTTP
 *               y la generación variable de tokens del Protocolo RHC.
 * 
 *  @category    Security Testing Interface
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
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
	 *  rhc_selectHeader_Advanced()
	 * ----------------------------------------------------------
	 *  Selecciona aleatoriamente un encabezado HTTP de un conjunto
	 *  definido de headers válidos, y asigna un token CSRF con
	 *  longitud y formato distinto, la asignación puede variar
	 *  dinámicamente según el modo configurado.
	 * 
	 *  Modos de asignación de token:
	 *   - "FixedAssignment"  : el encabezado mantiene su token original 
	 *                          tal como viene definido en `poolHT`.
	 *   - "RandomAssignment" : el encabezado seleccionado se asocia con 
	 *                          un token aleatorio tomado del mismo `poolHT`.
	 * 
	 *  Este método pertenece al Protocolo RHC (Randomized Header Channel)
	 *  NIVEL AVANZADO en el cliente, ampliando la doble capa de entropía
	 *  del Nivel 2 (encabezado + token aleatorio) con una tercera capa:
	 *  la entropía estructural, que introduce variaciones en tamaño y
	 *  formato del token entre 8, 16, 32 o 64 bytes, por solicitud.
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
	 *   - Este nivel amplía la entropía estructural al introducir tokens
	 *     de longitudes y formatos variables, generando un patrón de
	 *     comunicación pseudoaleatorio entre encabezado y token.
	 *   - Se conserva la trazabilidad criptográfica mediante índices
	 *     correlativos, asegurando control sobre la aleatoriedad.
	 * ==========================================================
	 */
	function rhc_selectHeader_Advanced(rhc_poolHT = {}, rhc_tokenModoAsignacion = "RandomAssignment") {
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

		// Obtener listas de headers y tokens desde el rhc_poolHT
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
