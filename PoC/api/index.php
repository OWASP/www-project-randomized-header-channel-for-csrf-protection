<?php
	// ========================================
	// API - Valida encabezados y reenvía al back-end
	// ========================================

/*
    ========================================
    CORS (Cross-Origin Resource Sharing)
    ========================================

    Esta sección está actualmente comentada porque durante las pruebas locales
    (accediendo directamente a localhost) el encabezado HTTP_ORIGIN **no se envía**.

    Explicación técnica:
    - Los navegadores envían el encabezado 'Origin' solo cuando la solicitud
        proviene de un contexto web (por ejemplo, desde un frontend servido por
        http://localhost o https://localhost).
    - Si se hace una petición directa al archivo PHP desde localhost o herramientas
        como Postman, no se incluye el encabezado Origin y la verificación de CORS
        fallaría.
    - Por eso, durante pruebas locales se deshabilita temporalmente CORS para
        permitir la ejecución sin bloqueos.

    Nota de producción:
    - En un servidor real, con un dominio válido, el encabezado HTTP_ORIGIN sí
        se enviará automáticamente.
    - Esta sección de CORS se debe habilitar en producción para:
        • Restringir orígenes permitidos
        • Permitir métodos y cabeceras específicas
        • Mantener la seguridad ante solicitudes cross-origin maliciosas

    Opciones para pruebas locales:
    1. Mantener CORS comentado (como ahora) para que el script funcione.
    2. Usar un servidor local con el mismo dominio que $Allowed_Origins_Cors,
        para que el encabezado Origin se envíe correctamente.
*/

/*
	// --- CORS ---
	error_log("=== INICIO DE CORS ===");
	$Allowed_Origins_Cors = ["http://localhost","https://localhost"];
	if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $Allowed_Origins_Cors)) {
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
			error_log("=== CORS - petición o solicitud de origen (HTTP_ORIGIN) permitida. ===");
		}
		// Permitir origen de dominios específicos
		header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
		// Permitir métodos específicos
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		// Permitir cabeceras específicas
		header("Access-Control-Allow-Headers: Content-Type, Authorization, X-SERVER-CERTIFIED, X-SERVER-SIG, X-SERVER-FLAG");
		// Permitir el envío de cookies a través de CORS
		header("Access-Control-Allow-Credentials: false");
		// Verificar SI el navegador hace una petición o solicitud OPTIONS (preflight)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			error_log("=== CORS - petición o solicitud OPTIONS ===");
			// Establecer el código de respuesta HTTP
            http_response_code(204); // No Content
            exit();
        }
    } else {
        // Verificar SI el navegador hace una petición o solicitud OPTIONS (preflight)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			error_log("=== CORS - petición o solicitud OPTIONS (preflight) no permitida. ===");
			// Establecer el código de respuesta HTTP
            http_response_code(403); // Forbidden
            exit();
        } else {
			error_log("=== CORS - petición o solicitud de origen (HTTP_ORIGIN) no permitida. ===");
			// Establecer el código de respuesta HTTP
			http_response_code(403); // Forbidden
			exit();
		}
    }
//*/

	// --- TÉCNICA DE DISPERSIÓN ---
	error_log("=== INICIO DE TÉCNICA DE DISPERSIÓN ===");

	$validHeaders = ['HTTP_X_SERVER_CERTIFIED', 'HTTP_X_SERVER_SIG', 'HTTP_X_SERVER_FLAG'];
	$found = [];

	foreach ($validHeaders as $h) {
		if (!empty($_SERVER[$h])) {
			$found[] = $h;
			error_log("Encabezado recibido: $h = " . $_SERVER[$h]);
		}
	}

	// Validación de dispersión (solo 1 encabezado)
	if (count($found) !== 1) {
		http_response_code(400);
		error_log("Error: número de encabezados CSRF inválido (" . count($found) . ")");
		exit("Error: uso inválido de encabezados CSRF");
	}

	$selectedHeader = $found[0];
	$csrfToken = $_SERVER[$selectedHeader];
	error_log("Encabezado CSRF válido detectado: $selectedHeader");


	// --- PETICIÓN PARA BACK-END ---
	error_log("=== INICIO DE PETICIÓN PARA BACK-END ===");

	// Leer cuerpo JSON
	$input = json_decode(file_get_contents('php://input'), true);
	error_log("Cuerpo recibido: " . print_r($input, true));

	// Cargar end-point del back-end
	require_once __DIR__ . '/../back-end/productos.php';
	// Obtener respuesta del end-point enviando los datos recividos
	$response = getProductData($input['id_producto'] ?? 0);
	error_log("Respuesta del end-point: " . print_r($response, true));

	// Respuesta del servidor para el cliente
	header('Content-Type: application/json');
	echo json_encode([
		"header_recibido" => $selectedHeader,
		"token" => $csrfToken,
		"producto" => $response
	]);
?>