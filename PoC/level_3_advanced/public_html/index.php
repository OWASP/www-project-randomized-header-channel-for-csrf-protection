<?php
/**
 * ==========================================================
 *  FRONT-END INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  Simula el entorno del cliente web o app web.
 * 
 *  Este nivel representa la evolución directa del Nivel 2 — Intermedio.
 *  Mientras que el Nivel 2 introducía una doble capa de entropía 
 *  (encabezado + token aleatorio), el Nivel 3 amplía este modelo
 *  incorporando una **entropía variable**, por solicitud basada en:
 * 
 *   1. Longitud y formato dinámico de los tokens CSRF.
 *   2. Rotación aleatoria de los encabezados activos.
 * 
 *  Este enfoque incrementa la imprevisibilidad estructural del canal,
 *  mediante la variación multifactorial de sus componentes,
 *  dificultando la detección de patrones repetitivos, pero manteniendo
 *  al mismo tiempo la trazabilidad criptográfica del flujo.
 * 
 *  @file        public_html/index.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 3 — Avanzado
 *  @purpose     Simular el cliente de pruebas del canal RHC con
 *               tokens de longitud y formato variable.
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
	<title>RHC Nivel 3 — Entropía Variable y Encabezados Dinámicos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="">
	<!-- style -->
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>

	<div class="container">
		<h1>Protocolo RHC — Nivel 3 — Avanzada</h1>
		<h2>Entropía Variable y Rotación Dinámica de Encabezados</h2>

		<p class="testmessage1">PoC cargada correctamente </p>
		<p class="testmessage2">✔</p>

		<p>
			En este <strong>nivel avanzado del Protocolo RHC (Randomized Header Channel)</strong>, 
			el sistema evoluciona respecto al Nivel 2 mediante la incorporación de un modelo de 
			<strong>entropía variable</strong>.  
			En lugar de mantener una longitud y formato de token constante, este nivel permite 
			<strong>tokens CSRF</strong> de longitud y estructura variable —por ejemplo, 8, 16, 32 o 64 bytes— 
			y una <strong>rotación aleatoria de encabezados activos</strong>.  
			Esta variabilidad multifactorial incrementa la <strong>complejidad estructural</strong> 
			y refuerza la <strong>resiliencia criptográfica</strong> del canal, 
			minimizando patrones de reconocimiento sin afectar su trazabilidad.
		</p>

		<div class="info-box">
			<span class="icon">💡</span>
			<p>
				<strong>Instrucciones:</strong> selecciona un producto y ejecuta una solicitud mediante 
				<strong>AJAX</strong> o <strong>Fetch API</strong>.  
				El sistema mostrará el encabezado seleccionado y el <strong>token CSRF</strong> utilizado, 
				incluyendo su longitud variable y formato específico.  
				Según el <strong>modo activo de asignación</strong>, 
				el comportamiento del canal se ajusta como sigue:
				<br><br>
				– <strong>Modo A — Asignación fija:</strong> cada encabezado conserva su token asociado.<br>
				– <strong>Modo B — Asignación aleatoria:</strong> el token varía en cada solicitud.
				<br><br>
				Este nivel representa el <strong>entorno avanzado</strong> del canal RHC, 
				donde la entropía opera de forma <strong>dinámica y multifactorial</strong>.
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
     MÓDULOS JS — RHC Protocol Core (Nivel 3 — Avanzado)
     ----------------------------------------------------------
     Cada módulo JavaScript implementa una función específica dentro
     del entorno de simulación del cliente del Protocolo RHC.
     ========================================================== -->
	<!-- Módulo ui_controls -->
	<script src="./js/ui_controls.js"></script>
	<!-- Módulo rhc_advanced -->
	<script src="./js/rhc_advanced.js"></script>
	<!-- Módulo request -->
	<script src="./js/requests.js"></script>
	<!-- Módulo main — Inicializa y valida la configuración -->
	<script src="./js/main.js"></script>

</body>
</html>
