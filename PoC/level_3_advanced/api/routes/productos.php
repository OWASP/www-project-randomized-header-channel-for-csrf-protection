<?php
/**
 * ==========================================================
 *  PRODUCTOS ENDPOINT — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Define las acciones validando los métodos HTTP disponibles
 *  para el recurso “productos”.
 *  Interactúa con el controlador para obtener los datos solicitados.
 * 
 *  @file        api/routes/productos.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 3 — Avanzado
 *  @purpose     Definir y gestionar las rutas del recurso productos.
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
	require_once __DIR__ . '/../include/endpoint_protector.php';
    // Cargar el controlador de productos
    require_once __DIR__ . '/../../back-end/controllers/controlador_productos.php';


    /* =======================================================
                --- Procesamiento del recurso  ---
    -------------------------------------------------------
    Se ejecuta la lógica del controlador de productos.
    ======================================================== */

    // Crear instacia del controlador de productos
    $controller = new ProductosController();

    // Validamos el Metodo
    switch ($method) {

        case 'POST':
            // Leer cuerpo JSON
            $data = json_decode(file_get_contents('php://input'), true);
            // Obtener respuesta del controlador enviando los datos recividos
            $response = $controller->getProductById($data['id_producto'] ?? 0);
            // Respuesta del servidor para el cliente
            echo Response::success([
                "header_recibido" => $selectedHeader,
                "token" => $csrfToken,
                "producto" => $response
            ]);
        break;

        default:
			// Regresa un Error
            echo Response::error('Método no permitido', 405);
    }
?>
