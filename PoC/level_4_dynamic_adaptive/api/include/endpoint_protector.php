<?php
/**
 * ==========================================================
 *  ENDPOINT PROTECTOR — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Evita la ejecución directa de archivos PHP pertenecientes
 *  a la API. Este script actúa como guardia de seguridad,
 *  bloqueando accesos fuera del flujo legítimo del sistema.
 * 
 *  Este archivo debe incluirse al inicio de cada endpoint
 *  o módulo interno de la API para impedir accesos directos
 *  desde el navegador o entornos no autorizados.
 *  Si se intenta acceder de forma directa, el servidor
 *  devolverá un código HTTP 403 (Forbidden).
 * 
 *  Características:
 *     1. Bloquea acceso directo desde navegador.
 *     2. Permite ejecución legítima por include/require.
 *     3. Permite ejecución desde CLI (php script.php).
 *     4. Compatible con entornos de desarrollo y producción.
 * 
 *  @file        api/include/endpoint_protector.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Evitar ejecución directa de archivos PHP.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ---------------------------------------------------------
	// 1) Permitir ejecución si la aplicación fue inicializada
	//    correctamente (IN_API debe definirse en index.php)
	// ---------------------------------------------------------
	if (!defined('IN_API')) {
		// Establecer el código de respuesta HTTP
		http_response_code(403); // Forbidden
		exit();
	}

	// ---------------------------------------------------------
	// 2) Bloquear acceso directo desde navegador (ejecución directa)
	// ---------------------------------------------------------
	// Comprobación robusta: comparar ruta real del archivo con SCRIPT_FILENAME
	if (isset($_SERVER['SCRIPT_FILENAME']) && realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'])) {
		// Establecer el código de respuesta HTTP
		http_response_code(403); // Forbidden
		exit();
	}
?>