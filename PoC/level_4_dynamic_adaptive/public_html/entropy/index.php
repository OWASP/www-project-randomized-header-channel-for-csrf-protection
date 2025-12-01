<?php
/**
 * ==========================================================
 *  ENTROPY INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Punto de entrada del subsistema de entropía.
 *  Redirige automáticamente al visor principal 
 *  (entropy_viewer.php), garantizando navegación consistente 
 *  dentro del laboratorio.
 *
 *  Este archivo sirve exclusivamente como wrapper de acceso 
 *  rápido, asegurando que no existan accesos directos 
 *  incorrectos dentro del módulo.
 *
 *  @file        public_html/entropy/index.php
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Redirigir al módulo “Entropy Viewer”.
 *
 *  @module      System\Router
 *  @category    Internal Navigation / Routing
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	header("Location: entropy_viewer.php");
	exit;
?>