<?php
/**
 * ==========================================================
 *  CORS (Cross-Origin Resource Sharing) — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Middleware de CORS para pruebas o demostraciones del API
 *  RHC Nivel 4 — Adaptativo Dinámico.
 * 
 *  Este archivo habilita CORS de manera **abierta**, permitiendo
 *  que cualquier frontend pueda enviar peticiones al servidor
 *  sin restricciones.
 * 
 *  ⚠️ ADVERTENCIA: No usar en entornos de producción.
 * 
 *  Características de esta configuración PoC:
 *    - Todos los orígenes permitidos (*)
 *    - Todos los métodos HTTP permitidos (*)
 *    - Todos los headers permitidos (*)
 *    - No se permite envío de cookies a través de CORS
 *    - Manejo automático de solicitudes OPTIONS (preflight)
 * 
 *  @file        api/middleware/cors.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Configuración CORS abierta para entorno PoC.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Permitir cualquier origen (solo para PoC o investigación)
	header("Access-Control-Allow-Origin: *");
	// Permitir todos los métodos HTTP
	header("Access-Control-Allow-Methods: *");
	// Permitir todos los headers
	header('Access-Control-Allow-Headers: *');
	// Control de envío de cookies (false en PoC)
	header("Access-Control-Allow-Credentials: false");
	// Manejo de solicitudes OPTIONS (preflight)
	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		// Establecer el código de respuesta HTTP
		http_response_code(204); // No Content
		exit();
	}
?>