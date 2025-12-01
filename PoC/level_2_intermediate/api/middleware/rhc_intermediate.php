<?php
/**
 * ==========================================================
 *  RHC INTERMEDIATE MIDDLEWARE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel) NIVEL INTERMEDIO
 *  en entorno servidor PHP.
 * 
 *  Clase middleware estática para el protocolo RHC y su validación de nivel intermedio.
 * 
 *  Esta clase implementa la lógica del **Nivel 2 (Intermedio)** del Protocolo RHC.
 *  Verifica que **exactamente uno** de los encabezados CSRF esperados esté presente
 *  en la solicitud HTTP y devuelve su valor (token CSRF) si cumple la condición.
 * 
 *  Reglas principales:
 *    - Debe existir **exactamente un** encabezado válido en cada petición.
 * 
 *  Si alguna regla no se cumple, el middleware responde con un error HTTP 400 (Bad Request) 
 *  y detiene la ejecución.
 * 
 * 
 *  @standard    RHC-NS-01 — Naming Standard Specification
 *  @reference   ../../docs/rhc-ns-01_naming_standard.md
 * 
 *  @file        api/middleware/rhc_intermediate.php
 * 
 *  @project    RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @usedby     PHP — Ejemplo de uso:
 * 
 *              use Middleware\RHC\RHC_Intermediate;
 *              $selectedHeaders = RHC_Intermediate::validate();
 * 
 *  @purpose    Validar que únicamente un header CSRF válido transporte el token.
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
	 *  RHC_Intermediate — Protocolo RHC Nivel 2 — Intermedio
	 *  ----------------------------------------------------------
	 *  Middleware de validación de encabezados en modo:
	 *  Randomized Header Channel (Nivel 2 — Intermedio).
	 * 
	 *  Esta clase valida que solo un encabezado CSRF seleccionado
	 *  de forma aleatoria desde cliente esté presente, sin 
	 *  afectar la trazabilidad interna necesaria para validar
	 *  correctamente el token.
	 * 
	 *  @author  Fernando Flores
	 *  @version 1.0.0
	 *  @license Apache 2.0 (code) + CC BY 4.0 (documentation)
	 */
	class RHC_Intermediate {

		/** @var array Lista de headers válidos definidos en la configuración */
		private array $validHeaders;

		/**
		 * Constructor del middleware
		 *
		 * @param array $validHeaders Lista de nombres de encabezados válidos (sin prefijo HTTP_)
		 */
		public function __construct(array $validHeaders) {
			$this->validHeaders = $validHeaders;
		}

		/**
		 * Normaliza un nombre de header al formato de $_SERVER.
		 *
		 * @param string $header
		 * @return string
		 */
		private function normalizeHeaderName(string $header): string {
			return 'HTTP_' . strtoupper(str_replace('-', '_', $header));
		}

		/**
		 * Ejecuta la validación del canal RHC (Nivel 2).
		 *
		 * Regla:
		 *    → Debe existir **exactamente uno** de los headers válidos.
		 *
		 * @return array Header válido encontrado junto con su valor.
		 */
		public function validate(): array {

			$found = [];

			foreach ($this->validHeaders as $h) {
				$key = $this->normalizeHeaderName($h);

				if (!empty($_SERVER[$key])) {
					$found[$h] = $_SERVER[$key];
				}
			}

			// === Validación principal: 1 header válido exacto
			if (count($found) !== 1) {
				Response::error(
					"RHC — Se requiere exactamente un encabezado válido. ".
					"Se recibieron: " . count($found),
					400,
					$found
				);
				exit();
			}

			return $found;
		}
	}
?>