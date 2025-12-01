<?php
/**
 * ==========================================================
 *  FRONT-END INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  Simula el entorno del cliente web o app web.
 * 
 *  Se definen tres encabezados CSRF (CSRF Header Select);
 *  uno de ellos se elige aleatoriamente para transportar
 *  el token en cada solicitud.
 * 
 *  @file        public_html/index.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 1 — Básico
 *  @purpose     Simular el cliente de pruebas del canal RHC
 * 
 *  @module      Frontend\Simulator
 *  @category    Security Testing Interface
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>RHC Nivel 1 — Canal Aleatorio de Encabezados</title>
	<!-- Favicon-->
	<link rel="icon" type="image/x-icon" href="">
	<!-- style -->
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>

	<div class="container">
		<h1>Protocolo RHC — Nivel 1 — Básico</h1>
		<h2>Canal Aleatorio de Encabezados</h2>

		<p class="testmessage1">PoC cargada correctamente </p>
		<p class="testmessage2">✔</p>

		<p>
			En este <strong>nivel inicial del Protocolo RHC (Randomized Header Channel)</strong>, se emplea un 
			<strong>único token CSRF</strong> que es transportado aleatoriamente por uno de los 
			<strong>tres encabezados personalizados</strong> en cada solicitud.  
			Este mecanismo introduce la primera capa de <strong>entropía controlada</strong>,
			reduciendo la <strong>previsibilidad</strong> del canal de comunicación y mitigando intentos de explotación
			basados en patrones estáticos <strong>(ataques automatizados)</strong> o ataques <strong>CSRF (Cross-Site Request Forgery)</strong>.
		</p>

		<div class="info-box">
			<span class="icon">💡</span>
			<p>
				<strong>Instrucciones:</strong> selecciona un producto del menú y ejecuta una solicitud mediante 
				<strong>AJAX</strong> o <strong>Fetch API</strong>.  
				El sistema mostrará cuál encabezado fue seleccionado para transportar el token y cuál fue recibido por el servidor,
				demostrando la <strong>rotación aleatoria</strong> propia del <strong>nivel básico</strong> del protocolo RHC.
			</p>
		</div>

		<div class="form-section">
			<form id="productForm">
				<label>Producto:</label>
				<select id="productSelect">
					<option value="1">Producto 1</option>
					<option value="2">Producto 2</option>
					<option value="3">Producto 3</option>
				</select><br>

				<label>Clave:</label>
				<input type="text" id="productKey" disabled><br>

				<label>Descripción:</label>
				<input type="text" id="productDesc" disabled><br>

				<label>Precio:</label>
				<input type="number" id="productPrice" disabled><br>

				<div id="errorMsg"></div>

				<div class="button-group">
					<button type="button" onclick="solicitudAJAX()">Petición AJAX</button>
					<button type="button" onclick="solicitudFetch()">Petición Fetch</button>
				</div>

			</form>

			<div class="tables-wrapper">
				<!-- Tabla de encabezados -->
				<div class="table-box">
					<h3>Encabezados</h3>
					<table id="headersTable">
						<tr><th>Encabezado</th><th>Estado</th></tr>
					</table>
				</div>

				<!-- Tabla de tokens -->
				<div class="table-box">
					<h3>Tokens</h3>
					<table id="tokensTable">
						<tr><th>Token</th><th>Estado</th></tr>
					</table>
				</div>
			</div>

			<div id="result">Esperando acción...</div>
		</div>
	</div>

<!-- ==========================================================
     MÓDULOS JS — RHC Protocol Core (Nivel 1 — Básico)
     ----------------------------------------------------------
     Cada módulo JavaScript implementa una función específica dentro
     del entorno de simulación del cliente del Protocolo RHC.
     ========================================================== -->
	<!-- Módulo ui_controls -->
	<script src="./js/ui_controls.js"></script>
	<!-- Módulo rhc_basic -->
	<script src="./js/rhc_basic.js"></script>
	<!-- Módulo request -->
	<script src="./js/requests.js"></script>
	<!-- Módulo main — Inicializa y valida la configuración -->
	<script src="./js/main.js"></script>

</body>
</html>
