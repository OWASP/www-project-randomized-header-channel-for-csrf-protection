<?php
/**
 * ==========================================================
 *  ENTROPY LIBRARY — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Biblioteca central del sistema de análisis de entropía.
 *  Contiene la implementación del cálculo matemático de 
 *  entropía utilizando el modelo de Shannon basado en 
 *  frecuencia simbólica.
 * 
 *  Es utilizada por el módulo principal del laboratorio
 *  (entropy_viewer.php) y por la API interna 
 *  (entropy_analyzer.php). Funciona de forma autónoma y no 
 *  requiere dependencias externas, garantizando precisión y 
 *  estabilidad matemática en la medición.
 *
 *  @file        public_html/entropy/include/entropy_lib.php
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Calcular entropía de cadenas de texto y tokens.
 *
 *  @module      Backend\EntropyMathCore
 *  @category    Security Analysis / Shannon Entropy
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// ============================================
	// RHC Entropy Library - Conceptual Core
	// ============================================
	function calculate_entropy($input) {
		if (strlen($input) === 0) return 0.0;

		$frequency = count_chars($input, 1);
		$len = strlen($input);
		$entropy = 0.0;

		foreach ($frequency as $freq) {
			$p = $freq / $len;
			$entropy -= $p * log($p, 2);
		}
 
		return round($entropy, 3);
	}
?>