<?php
/**
 * ==========================================================
 *  API INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  en el punto de entrada principal del API.
 * 
 *  Este archivo valida los encabezados CSRF (usando el middleware RHC)
 *  y reenvía la solicitud al enrutador principal.
 * 
 *  Valida encabezados CSRF (CSRF Header Validation)
 *  y reenvía la solicitud al back-end.
 * 
 *  @file        api/index.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @purpose     Validar encabezados CSRF y redirigir al back-end.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ---------------------------------------------------------
	// Definir bandera global de inicialización
	// ---------------------------------------------------------
	// Esta constante actúa como sello de autorización interno,
	// indicando que la API fue correctamente inicializada desde
	// su flujo legítimo (index.php).
	// Si no está definida, cualquier intento de ejecutar archivos
	// internos será bloqueado.
	define('IN_API', true);

	// Activar errores (solo para desarrollo)
	error_reporting(E_ALL);
	ini_set('display_errors', 1);



	// ===== Cargar dependencias base =====

	// Incluir el CORS
	require_once __DIR__ . '/middleware/cors.php';
	// Incluir la configracion
	require_once __DIR__ . '/config/rhc_config.php';
	// Incluir el response
	require_once __DIR__ . '/include/response.php';
	// Incluir las validaciones
	require_once __DIR__ . '/include/validator.php';



	/* =======================================================
				--- RHC (Randomized Header Channel) ---
	-------------------------------------------------------
	Implementacón del Protocolo RHC en la aplicación y su entorno.
	Valida encabezados CSRF (CSRF Header Validation).
	======================================================= */

	// Incluir RHC (Randomized Header Channel) Nivel 2 — Intermedio
	require_once __DIR__ . '/middleware/rhc_intermediate.php';

	// Importar la clase principal del middleware RHC
	use Middleware\RHC\RHC_Intermediate;

	// Crear una instancia del middleware RHC Nivel 2
	$rhc = new RHC_Intermediate(
			RHC_HEADERS['validos'] // Lista de headers válidos.
		);

	// Ejecutar la validación de headers en la petición actual.
	$Header = $rhc->validate();

	// Extraer nombre del header
	$selectedHeader = array_key_first($Header);
	// Extraer token
	$csrfToken = $Header[$selectedHeader];


	// ===== Validación Token's JWT y CSRF (si aplica) =====
	// Auth (JWT, CSRF)

	// ===== Enrutamiento básico =====

	// Incluir el router
	require_once __DIR__ . '/router.php';
?>