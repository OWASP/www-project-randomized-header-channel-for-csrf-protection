<?php
/**
 * ==========================================================
 *  API HEADER VALIDATOR — RHC Protocol Core
 * ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  aplicada en el punto de entrada principal del API.
 * 
 *  Este archivo valida exclusivamente los encabezados personalizados
 *  correspondientes al Protocolo RHC. No valida encabezados genéricos 
 *  del API ni parámetros propios del negocio.
 *
 *  IMPORTANTE:
 *  La configuración oficial de los encabezados para el Protocolo RHC se
 *  encuentra en:
 *
 *      api/config/rhc_config.php
 *
 *  Si un encabezado:
 *    - no está registrado en RHC_HEADERS, o
 *    - no está permitido en la configuración del CORS,
 * 
 *  entonces será bloqueado por el navegador (CORS) o por el validador RHC,
 *  dependiendo del entorno.
 *
 *  En validador es deliberadamente permisivo para mostrar al desarrollador
 *  qué encabezados faltan; sin embargo, en producción serían bloqueados
 *  por CORS *antes* de llegar a PHP.
 *
 *  @file        api/include/validator.php
 * 
 *  @project    RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @purpose    Validación de la configuracion para el Protocolo RHC.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.1
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Incluir protección para evitar ejecución directa o acceso no autorizado.
	require_once __DIR__ . './endpoint_protector.php'; 

	/**
	 * ============================================================================
	 *  VALIDADOR DE ENCABEZADOS — RHC Protocol Core
	 * ============================================================================
	 *
	 *  Flujo de validación:
	 *
	 *
	 *   1) Verificar que existan encabezados válidos y señuelos definidos.
	 *   2) Detectar encabezados no registrados.
	 *        - Capturar encabezados HTTP personalizados (ignorando los comunes).
	 *        - Normalizar encabezados esperados a formato interno HTTP_X_...
	 *
	 *  Si todo es correcto → continúa la ejecución normal del API.
	 * ============================================================================
	 */

	// ============================================================================
	// 1️⃣ Validar listas de encabezados definidas en rhc_config.php
	// ============================================================================
	// Validar encabezados válidos
	if (!defined('RHC_HEADERS') || empty(RHC_HEADERS['validos'])
		|| !is_array(RHC_HEADERS['validos'])) {
		$mensaje = "RHC — No hay encabezados válidos definidos en api/config/rhc_config.php.";
		// Regresa un Error
		Response::error($mensaje, 500); // Internal Server Error
		exit();
	}

	// ============================================================================
	//  Obtener parametros para la sigiente validacion
	//  	2️⃣ Detectar encabezados no registrados
	// ============================================================================
	// Definir encabezados mas comunes del navegador que no participan en RHC
	$comunes = [
		'HTTP_HOST', 'HTTP_CONNECTION', 'HTTP_PRAGMA',
		'HTTP_CACHE_CONTROL', 'HTTP_USER_AGENT', 'HTTP_ACCEPT',
		'HTTP_ORIGIN', 'HTTP_REFERER', 'HTTP_ACCEPT_ENCODING',
		'HTTP_ACCEPT_LANGUAGE', 'HTTP_SEC_CH_UA',
		'HTTP_SEC_CH_UA_MOBILE', 'HTTP_SEC_FETCH_SITE',
		'HTTP_SEC_FETCH_MODE', 'HTTP_SEC_FETCH_DEST',
		'HTTP_UPGRADE_INSECURE_REQUESTS', 'HTTP_SEC_FETCH_USER',
		'HTTP_SEC_CH_UA_PLATFORM'
	];

	// Eliminar encabezados mas comunes del navegador que no participan en RHC
	$headersPersonalizados = $_SERVER;
	foreach ($comunes as $c) {
		unset($headersPersonalizados[$c]);
	}

	// Obtener todos los encabezados HTTP recibidos
	$headersRecibidos = [];
	foreach ($headersPersonalizados as $key => $value) {
		if (strpos($key, 'HTTP_') === 0) {
			$headersRecibidos[$key] = $value;
		}
	}

	// Obtener y normalizar encabezados válidos esperados
	// Se convierten a formato interno utilizado por PHP (HTTP_X_...)
	$validosEsperados = [];
	foreach (RHC_HEADERS['validos'] as $header) {
		// Convertir a formato de $_SERVER → HTTP_X_SERVER_FLAG
		$header = str_replace('-', '_', strtoupper($header));
		if (strpos($header, 'HTTP_') !== 0) {
			$header = 'HTTP_' . $header;
		}
		$validosEsperados[] = $header;
	}

	// Detectar encabezados recibidos que coinciden
	$recibidosValidos = array_intersect(array_keys($headersRecibidos), $validosEsperados);

	// ==========================================================
	// 3️⃣ Detectar encabezados no registrados
	// ==========================================================
	$todosEsperados = $validosEsperados;
	$encabezadosNoReconocidos = array_diff(array_keys($headersRecibidos), $todosEsperados);

	if (!empty($encabezadosNoReconocidos)) {
		$mensaje =
			"RHC — Se detectaron encabezados HTTP que NO están registrados en " .
			"la configuración del Protocolo RHC (archivo: api/config/rhc_config.php). " .

			"En un entorno real, cualquier encabezado no registrado sería bloqueado " .
			"automáticamente por la política CORS si no se encuentra permitido en su " .
			"configuración correspondiente. " .

			"Además, la ausencia de estos encabezados en la configuración del Protocolo " . 
			"RHC (RHC_HEADERS) afecta directamente las validaciones internas el canal RHC. " .

			"Este comportamiento es solo para fines educativos:
			 agrega estos encabezados si son legítimos para continuar con la demostración.";

		// Registrar en logs del servidor
		error_log("RHC — Encabezados no registrados o no reconocidos: " . implode(', ', $encabezadosNoReconocidos));
		error_log(print_r($encabezadosNoReconocidos, true));
		// Enviamos los encabezados detectados como datos separados
		Response::error($mensaje, 400,
			['encabezados_no_reconocidos' => $encabezadosNoReconocidos
		]); // Bad Request
		exit();
	}

	// Si todo está bien, continúa la ejecución normal
?>