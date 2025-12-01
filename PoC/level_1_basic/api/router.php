<?php
/**
 * ==========================================================
 *  API ROUTER — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Gestiona la asignación de rutas hacia los endpoints
 *  correspondientes.
 * 
 *  @file        api/router.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 1 — Básico
 *  @purpose     Dirigir peticiones al endpoint correspondiente.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ===== Cargar dependencias base =====

	// Incluir protección para evitar ejecución directa o acceso no autorizado.
	require_once __DIR__ . '/include/endpoint_protector.php'; 


	/* =======================================================
		--- Enrutamiento básico (simple, limpio y claro) ---
	-------------------------------------------------------
	En este PoC el recurso está centrado en "productos"
	(en producción, recupéralo dinámicamente desde REQUEST_URI).
	======================================================= */


	// Leer el metodo de la solicitud
	$method     = $_SERVER['REQUEST_METHOD'];

/*
	// Leer la URL solicitada
	$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	// Extraer recurso, ejemplo: /api/productos → "productos"
	$uriParts = explode('/', trim($requestUri, '/'));
	$resource = $uriParts[1] ?? ''; // ejemplo: "productos"
//*/

	// Se asigna el recurso, centrado en "productos"
	$resource = "productos";

	// Construir la ruta del archivo correspondiente
	$routeFile = __DIR__ . '/routes/' . basename($resource) . '.php';

	// Cargar la ruta del endpoint si existe
	if ($resource && file_exists($routeFile)) {
		require_once $routeFile;
	} else {
		echo Response::error('Recurso no encontrado', 404);
	}
?>