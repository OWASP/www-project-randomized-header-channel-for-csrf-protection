<?php
/**
 * ==========================================================
 *  CONFIGURACIÓN GLOBAL DEL ENTORNO BACK-END — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Define constantes, rutas y parámetros esenciales para la
 *  inicialización del sistema y la conexión entre capas.
 * 
 *  @file        back-end/core/config.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 3 — Avanzado
 *  @purpose     Centralizar configuraciones y valores globales del entorno.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	/* =======================================================
	   ENTORNO DE EJECUCIÓN
	   -------------------------------------------------------
	   Define parámetros globales de la aplicación y su entorno.
	======================================================= */

	// Nombre de la aplicación.
	define('APP_NAME', 'RHC Protocol Core');

	/**
	 * Entorno actual de ejecución.
	 * Valores posibles:
	 *   - development : entorno de desarrollo (muestra errores y logs detallados)
	 *   - production  : entorno de producción (oculta errores y optimiza rendimiento)
	 */
	define('APP_ENV', 'development');


	/* =======================================================
	   IDIOMA, LOCALIZACIÓN Y FORMATO
	   -------------------------------------------------------
	   Define la configuración regional por defecto de la app.
	======================================================= */

	// Idioma base de la aplicación.
	define('APP_DEFAULT_LANG', 'es');

	// Locale (idioma + país) para formatos locales (números, fechas, moneda, etc.)
	define('APP_DEFAULT_LOCALE', 'es-MX');

	// Zona horaria por defecto de los usuarios y procesos de la app.
	define('APP_DEFAULT_TIMEZONE', 'America/Mexico_City');


	/* =======================================================
	   CONFIGURACIÓN DE CARACTERES
	   -------------------------------------------------------
	   Define la codificación de caracteres global.
	======================================================= */

	// Codificación interna del sistema (UTF-8 recomendado).
	define('APP_CHARSET', 'UTF-8');


	/* =======================================================
	   RUTAS INTERNAS
	   -------------------------------------------------------
	   Define rutas internas del sistema para organización del código.
	======================================================= */

	// Ruta base del backend (nivel raíz del core).
	define('BASE_PATH', dirname(__DIR__, 1)); // back-end/

	// Ruta de controladores.
	define('CONTROLLER_PATH', BASE_PATH . '/controllers');

	// Ruta de modelos.
	define('MODEL_PATH', BASE_PATH . '/models');


	/**
	 * Indica si la aplicación se encuentra en modo depuración.
	 * Se activa automáticamente cuando APP_ENV = 'development'.
	 */
	define('APP_DEBUG', APP_ENV === 'development');


	/* =======================================================
	   CONFIGURACIÓN DEL SISTEMA
	   -------------------------------------------------------
	   Parámetros globales del servidor y la base de datos.
	======================================================= */

	// Zona horaria global del sistema (UTC recomendado).
	// - Se utiliza para registrar fechas en la base de datos.
	// - Evita desajustes entre usuarios de distintas zonas.
	define('SYS_TIMEZONE', 'UTC');


	/* =======================================================
	   CONFIGURACIÓN GLOBAL PARA EL SERVIDOR PHP EN EJECUCIÓN
	======================================================= */

	// Establecer la zona horaria.
	date_default_timezone_set(SYS_TIMEZONE);

	// Establecer la codificación de caracteres.
	mb_internal_encoding(APP_CHARSET);

?>