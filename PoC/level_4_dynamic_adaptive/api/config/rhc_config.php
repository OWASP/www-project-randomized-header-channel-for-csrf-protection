<?php
/**
 * ==========================================================
 *  API CONFIG — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Archivo de configuración principal del Protocolo
 *  RHC (Randomized Header Channel) en entorno servidor.
 * 
 *  Este módulo define los parámetros base utilizados por
 *  el middleware del protocolo, incluyendo:
 * 
 *    • La lista de encabezados válidos que pueden transportar
 *      el token CSRF dentro del canal RHC.
 *    • El conjunto de encabezados señuelo (decoys) usados
 *      para incrementar la entropía y reducir patrones predecibles.
 *    • El límite máximo de encabezados válidos permitidos por
 *      solicitud, lo cual forma parte del control anti–abuso y de
 *      la regulación dinámica del Nivel 4 del protocolo.
 * 
 *  Este archivo no ejecuta lógica; únicamente expone constantes
 *  que serán consumidas por:
 *      - middleware/rhc_dynamic_adaptive.php
 *      - api/index.php
 *  y cualquier otro módulo que requiera la definición estandarizada
 *  del entorno RHC.
 * 
 *  @file        api/config/rhc_config.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Proveer la configuración estructural del sistema RHC.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Headers para el RHC válidos y decoys
	define('RHC_HEADERS', [
		'validos' => [
			'X-Server-Certified',
			'X-Server-Sig',
			'X-Server-Flag'
		],
		'decoys' => [
			'X-Server-Atlas',
			'X-Server-Orchid',
			'X-Server-Drift',
			'X-Server-Quartz',
			'X-Server-Veil'
		]
	]);

	// Número máximo de encabezados válidos permitidos por el servidor, en una petición RHC.
	// Este límite aplica solo a headers de la lista "validos".
	define('RHC_MAX_VALID_HEADERS', 2);
?>