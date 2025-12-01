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
 * 
 *  Este archivo no ejecuta lógica; únicamente expone constantes
 *  que serán consumidas por:
 *      - middleware/rhc_intermediate.php
 *      - api/index.php
 *  y cualquier otro módulo que requiera la definición estandarizada
 *  del entorno RHC.
 * 
 *  @file        api/config/rhc_config.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @purpose     Proveer la configuración estructural del sistema RHC.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Headers para el RHC válidos
	define('RHC_HEADERS', [
		'validos' => [
			'X-Server-Certified',
			'X-Server-Sig',
			'X-Server-Flag'
		]
	]);
?>