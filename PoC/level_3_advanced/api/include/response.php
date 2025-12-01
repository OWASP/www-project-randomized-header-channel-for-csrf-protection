<?php
/**
 * ==========================================================
 *  RESPONSE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Clase para la estructura estándar de respuestas JSON
 * 
 *  Gestiona la creación uniforme de respuestas en formato JSON
 *  para mantener coherencia en toda la API.
 * 
 *  @file        api/include/response.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 3 — Avanzado
 *  @purpose     Definir la estructura y formato de respuestas JSON.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	class Response {
		public static function success($data = null, $message = 'OK', $code = 200) {
			// Establecer el código de respuesta HTTP recibido o, por defecto, 200 (OK)
			http_response_code($code);
			// Indicar que la respuesta es en formato JSON con codificación UTF-8
			header('Content-Type: application/json; charset=utf-8');
			// Enviar el cuerpo de la respuesta en formato JSON
			echo json_encode([
				'status' => 'success',
				'message' => $message,
				'data' => $data
			], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		public static function error($message, $code = 400, $data = null) {
			// Establecer el código de respuesta HTTP recibido o, por defecto, 400 (Bad Request)
			http_response_code($code);
			// Indicar que la respuesta es en formato JSON con codificación UTF-8
			header('Content-Type: application/json; charset=utf-8');
			// Enviar el cuerpo de la respuesta en formato JSON
			echo json_encode([
				'status' => 'error',
				'message' => $message,
				'data' => $data
			], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
	}
?>