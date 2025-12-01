<?php
/**
 * ==========================================================
 *  FRONT-END INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  Simula el entorno del cliente web o app web.
 * 
 *  Este entorno demuestra la aplicación del canal RHC
 *  con doble capa de entropía:
 *   1. Selección aleatoria del encabezado HTTP que
 *      transportará el token.
 *   2. Variación opcional del token en cada solicitud,
 *      dependiendo del modo configurado por el usuario.
 * 
 *  Modos disponibles:
 *   - Modo A — Asignación fija: cada encabezado mantiene
 *     un token asociado por índice.
 *   - Modo B — Asignación aleatoria: el token cambia
 *     aleatoriamente en cada solicitud.
 * 
 *  @file        public_html/index.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @purpose     Simular el cliente de pruebas del canal RHC
 *               en su versión con entropía dual.
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
	<title>RHC Nivel 2 — Entropía Dual de Encabezados y Tokens</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="">
	<!-- style -->
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>

	<div class="container">
		<h1>Protocolo RHC — Nivel 2 — Intermedio</h1>
		<h2>Entropía Dual: Selección Aleatoria de Encabezado y Asignación Dinámica de Token</h2>

		<p class="testmessage1">PoC cargada correctamente </p>
		<p class="testmessage2">✔</p>

		<p>
			En este <strong>nivel intermedio del Protocolo RHC (Randomized Header Channel)</strong> se introduce una 
			<strong>doble capa de entropía</strong>.  
			En primer lugar, el sistema selecciona aleatoriamente el <strong>encabezado HTTP</strong> que transportará el token CSRF.  
			Posteriormente, según el modo configurado, el <strong>token CSRF</strong> puede permanecer fijo o variar dinámicamente en cada solicitud.  
			Este enfoque incrementa significativamente la <strong>imprevisibilidad estructural</strong> del canal y mejora su resistencia frente a ataques
			<strong>CSRF (Cross-Site Request Forgery)</strong> y <strong>Replay</strong>.
		</p>

		<div class="info-box">
			<span class="icon">💡</span>
			<p>
				<strong>Instrucciones:</strong> selecciona un producto y ejecuta una solicitud utilizando 
				<strong>AJAX</strong> o <strong>Fetch API</strong>.  
				El sistema mostrará qué encabezado fue seleccionado para transportar el token y cuál fue recibido por el servidor, 
				de acuerdo con el <strong>modo activo de asignación</strong>:
				<br><br>
				– <strong>Modo A — Asignación fija:</strong> cada encabezado conserva su token asociado.<br>
				– <strong>Modo B — Asignación aleatoria:</strong> el token varía dinámicamente en cada solicitud.
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

				<div class="token-section">
					<label>Modo de asignación de token:</label><br>
					<select id="tokenMode">
						<option value="FixedAssignment" selected>Modo A — Asignación fija</option>
						<option value="RandomAssignment">Modo B — Asignación aleatoria</option>
					</select>

					<div class="button-group">
						<button type="button" onclick="solicitudAJAX()">Petición AJAX</button>
						<button type="button" onclick="solicitudFetch()">Petición Fetch</button>
					</div>
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
     MÓDULOS JS — RHC Protocol Core (Nivel 2 — Intermedio)
     ----------------------------------------------------------
     Cada módulo JavaScript implementa una función específica dentro
     del entorno de simulación del cliente del Protocolo RHC.
     ========================================================== -->
	<!-- Módulo ui_controls -->
	<script src="./js/ui_controls.js"></script>
	<!-- Módulo rhc_intermediate -->
	<script src="./js/rhc_intermediate.js"></script>
	<!-- Módulo request -->
	<script src="./js/requests.js"></script>
	<!-- Módulo main — Inicializa y valida la configuración -->
	<script src="./js/main.js"></script>

</body>
</html>
