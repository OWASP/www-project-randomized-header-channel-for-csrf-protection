<?php
/**
 * ==========================================================
 *  RHC DYNAMIC ADAPTIVE MIDDLEWARE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel) NIVEL ADAPTATIVO DINÁMICO
 *  en entorno servidor PHP.
 * 
 *  Clase middleware estática para el protocolo RHC y su validación de nivel adaptativo dinámico.
 * 
 *  Esta clase implementa la lógica del **Nivel 4 (Dynamic Adaptive)** del Protocolo RHC.
 *  Valida que **uno o más encabezados CSRF activos** estén presentes según la configuración 
 *  establecida, mientras que los encabezados falsos o señuelo (decoys) son ignorados.  
 * 
 *  Reglas principales:
 *    - Debe existir al menos un header válido en cada petición.
 *    - No se puede exceder el número máximo de headers válidos permitidos.
 *    - Los headers no definidos generan error.
 *    - Los decoys son ignorados pero contribuyen a la entropía y ruido controlado.
 * 
 *  Si alguna regla no se cumple, el middleware responde con un error HTTP 400 (Bad Request) 
 *  y detiene la ejecución.
 * 
 * 
 *  @standard    RHC-NS-01 — Naming Standard Specification
 *  @reference   ../../docs/rhc-ns-01_naming_standard.md
 * 
 *  @file        api/middleware/rhc_dynamic_adaptive.php
 * 
 *  @project    RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @usedby     PHP — Ejemplo de uso:
 * 
 *              use Middleware\RHC\RHC_DynamicAdaptive;
 *              $selectedHeaders = RHC_DynamicAdaptive::validate();
 * 
 *  @purpose    Validar que uno o más headers CSRF activos transporte el token.
 * 
 *  @package    Middleware\RHC
 *  @category   Security
 *  @see        https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (code) + CC BY 4.0 (documentation)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025 
 * ==========================================================
 */

	// ===== Definir el espacio de nombres lógicos =====

	// Namespace del middleware RHC.
	namespace Middleware\RHC;

	use \Response;

	/**
	 * ==========================================================
	 *  RHC_DynamicAdaptive — Protocolo RHC Nivel 4 Adaptativo
	 *  ----------------------------------------------------------
	 *  Middleware de validación de encabezados en modo:
	 *  Randomized Header Channel (Nivel 4 — Adaptativo Dinámico).
	 * 
	 *  Esta clase valida encabezados CSRF dinámicos enviados desde
	 *  el cliente. Determina cuáles son válidos, cuántos fueron
	 *  enviados, y aplica reglas estrictas del protocolo RHC.
	 *
	 *  @author  Fernando Flores
	 *  @version 1.0.0
	 *  @license Apache 2.0 (code) + CC BY 4.0 (documentation)
	 */
	class RHC_DynamicAdaptive {
		/** @var array Lista de headers válidos del servidor */
		private array $validHeaders;

		/** @var array Lista de headers señuelo (decoys) */
		private array $decoyHeaders;

		/** @var int Número máximo permitido de headers válidos */
		private int $maxValid;

		/**
		 * Constructor del middleware RHC Nivel 4.
		 *
		 * @param array $validHeaders     Lista de encabezados válidos (names HTTP normal, ej: "X-Server-Sig")
		 * @param array $decoyHeaders     Lista de encabezados señuelo
		 * @param int   $maxValid         Número máximo permitido de headers válidos
		 */
		public function __construct(array $validHeaders, array $decoyHeaders, int $maxValid) {
			$this->validHeaders = $validHeaders;
			$this->decoyHeaders = $decoyHeaders;

			// Ajustar límites automáticamente
			$maxDefined = count($validHeaders);
			$maxValid = max(1, min($maxValid, $maxDefined));
			$this->maxValid = $maxValid;
		}

		/**
		 * Normaliza un nombre de header (X-Server-Sig → HTTP_X_SERVER_SIG).
		 *
		 * @param string $header
		 * @return string
		 */
		private function normalizeHeaderName(string $header): string {
			return 'HTTP_' . strtoupper(str_replace('-', '_', $header));
		}

		/**
		 * Extrae headers HTTP del entorno $_SERVER según la lista interna.
		 *
		 * @param array $list
		 * @return array
		 */
		private function extractHeaders(array $list): array {
			$found = [];

			foreach ($list as $h) {
				$key = $this->normalizeHeaderName($h);

				if (!empty($_SERVER[$key])) {
					$found[$h] = $_SERVER[$key];
				}
			}

			return $found;
		}

		/**
		 * Ejecuta la validación completa del protocolo RHC Nivel 4.
		 *
		 * @return array Headers válidos enviados por el cliente.
		 * @throws void  Envía un error y detiene ejecución si no cumple.
		 */
		public function validate(): array {
			// ======================================================
			// 1. Extraer headers válidos enviados por el cliente
			// ======================================================
			$foundValid = $this->extractHeaders($this->validHeaders);

			// Si no hay ninguno → error
			if (count($foundValid) === 0) {
				Response::error("RHC — No se recibió ningún encabezado válido.", 400);
				exit();
			}

			// ======================================================
			// 2. Validar que no exceda el máximo permitido
			// ======================================================
			if (count($foundValid) > $this->maxValid) {
				Response::error(
					"RHC — Se enviaron más encabezados válidos (".count($foundValid).
					") que el máximo permitido ({$this->maxValid}).",
					400,
					$foundValid
				);
				exit();
			}

			// ======================================================
			// 3. Validación adicional (no más que los definidos)
			// ======================================================
			if (count($foundValid) > count($this->validHeaders)) {
				Response::error(
					"RHC — Violación del protocolo: se enviaron encabezados no definidos.",
					400,
					$foundValid
				);
				exit();
			}

			// ======================================================
			// 4. Si todo es válido, devolver headers encontrados
			// ======================================================
			return $foundValid;
		}
	}
?>