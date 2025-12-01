<?php
/**
 * ==========================================================
 *  ENTROPY ANALYZER — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo backend responsable de procesar solicitudes de 
 *  análisis de entropía mediante el método de Shannon.
 * 
 *  Este archivo actúa como una API interna del laboratorio
 *  gráfico de entropía. Recibe datos desde el front-end o 
 *  desde el módulo principal RHC Protocol Core, los valida, 
 *  calcula su nivel de entropía y devuelve los resultados en 
 *  formato JSON para uso inmediato por el cliente.
 * 
 *  Incluye un modo de muestras automáticas cuando no se 
 *  proporciona entrada, permitiendo demostración autónoma del 
 *  sistema y compatibilidad con pruebas internas.
 *
 *  @file        public_html/entropy/include/entropy_analyzer.php
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Proceso central de cálculo de entropía del lado servidor.
 *
 *  @module      Backend\EntropyAnalyzer
 *  @category    Security Analysis / Entropy Computation
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	require_once __DIR__ . './entropy_lib.php';

	// Leer parámetro (puede venir del JS frontend)
	$input = $_GET['data'] ?? '';

	if ($input === '') {
		// Generar ejemplos automáticos
		$samples = [
			['label' => 'LOW',  'value' => calculate_entropy('AAAAAAAAAAAAAAA')],
			['label' => 'MID',  'value' => calculate_entropy('ABABABCDCDCD1234')],
			['label' => 'HIGH', 'value' => calculate_entropy(bin2hex(random_bytes(16)))],
		];
		header('Content-Type: application/json');
		echo json_encode($samples);
		exit;
	}

	// Calcular la entropía de la cadena recibida
	header('Content-Type: application/json');
	echo json_encode([
		'input'   => $input,
		'entropy' => calculate_entropy($input)
	]);
?>