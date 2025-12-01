<?php
/**
 * ==========================================================
 *  FRONT-END INDEX — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación del Protocolo RHC (Randomized Header Channel)
 *  Simula el entorno del cliente web o app web.
 * 
 *  Este nivel representa la fase más robusta del canal RHC, 
 *  incorporando...
 * 
 *  @file        public_html/index.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Simular el cliente de pruebas del canal RHC...
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
	<title>RHC Nivel 4 — Dispersión Dinámica y Encabezados Adaptativos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="">
	<!-- style -->
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>

	<div class="container">
		<h1>Protocolo RHC — Nivel 4 — Adaptativo Dinámico</h1>
		<h2>Dispersión Dinámica, Encabezados Señuelo y Adaptación Contextual</h2>

		<p class="testmessage1">PoC cargada correctamente </p>
		<p class="testmessage2">✔</p>

		<p>
			En este <strong>nivel del Protocolo RHC (Randomized Header Channel)</strong>, 
			el canal alcanza una fase <strong>dinámica y adaptativa</strong> que 
			supone una evolución estructural respecto al modelo de entropía variable del Nivel 3.  
			El sistema no solo implementa la <strong>rotación aleatoria de encabezados válidos</strong> 
			y la variación de longitud en los <strong>tokens CSRF</strong>, sino que además introduce 
			<strong>encabezados señuelo</strong> y mecanismos de 
			<strong>dispersión dinámica</strong> que ajustan su comportamiento en tiempo real 
			según el contexto operativo.  
			Esta arquitectura incrementa la <strong>entropía contextual</strong> y refuerza la 
			<strong>resiliencia criptográfica</strong>, impidiendo inferencias predecibles 
			y garantizando una trazabilidad segura del flujo de comunicación.
		</p>

		<div class="info-box">
			<span class="icon">💡</span>
			<p>
				<strong>Instrucciones:</strong> selecciona un producto y ejecuta una solicitud mediante 
				<strong>AJAX</strong> o <strong>Fetch API</strong>.  
				El sistema mostrará los <strong>encabezados válidos</strong> y 
				los <strong>encabezados señuelo</strong>, junto con los <strong>tokens CSRF</strong> asignados, 
				cada uno con longitud y formato variable según el modo configurado.  
				<br><br>
				– <strong>Longitud fija:</strong> el token mantiene una longitud constante definida. <br>
				– <strong>Longitud variable:</strong> la longitud y el formato del token cambian en cada solicitud.  
				<br><br>
				Este entorno representa el <strong>nivel dinámico-adaptativo</strong> del canal RHC, donde la entropía 
				y la dispersión operan de forma simultánea para aumentar la seguridad estructural y contextual del canal.
			</p>
		</div>

		<div class="form-section">
			<div class="tables-wrapper">
				<!-- Selector de Productos -->
				<div class="table-box">
					<div id="productDataSelector" class="productData">
						<label>Producto:</label>
						<select id="productSelect">
							<option value="1">Producto 1</option>
							<option value="2">Producto 2</option>
							<option value="3">Producto 3</option>
						</select><br>
					</div>
				</div>

				<!-- Selector de tipo de longitud de token -->
				<div class="table-box">
					<div class="token-length-box">
						<label for="tokenLengthMode">Tipo de longitud de token:</label><br>
						<select id="tokenLengthMode">
							<option value="FixedLength" selected>Longitud  — Fija</option>
							<option value="VariableLength">Longitud  — Variable</option>
						</select>
					</div>
				</div>

				<!-- Información de Productos -->
				<div class="table-box">
					<h3 class="productTitle">Producto</h3>
					<div id="productData" class="productData">
						<label>Clave:</label>
						<input type="text" id="productKey" disabled><br>

						<label>Descripción:</label>
						<input type="text" id="productDesc" disabled><br>

						<label>Precio:</label>
						<input type="number" id="productPrice" disabled><br>

						<div id="errorProductosMsg"></div>
					</div>
				</div>

				<!-- Tabla de Headers y Tokens -->
				<div class="table-box">
					<h3 class="productTitle">Headers y Tokens - Sigiente petición</h3>

					<div class="legend">
						<span><span class="legend-circle green-circle"></span> Válidos</span>
						<span><span class="legend-circle gray-circle"></span> Señuelo (decoys)</span>
						<!-- Abrir Entropy Viewer -->
						<span id="openEntropy" class="openEntropy" title="Abrir Entropy Viewer"> 📊</span>
					</div>

					<table id="headerstokensTable">
						<tr><th>Header</th><th>Token</th></tr>
					</table>
				</div>
			</div>

			<form id="productForm">
				<div id="esperaAcción">Esperando acción...</div>
				<div class="button-group">
					<button type="button" onclick="solicitudAJAX()">Petición AJAX</button>
					<button type="button" onclick="solicitudFetch()">Petición Fetch</button>
				</div>
				<div id="errorServidorMsg"></div>
			</form>


			<!-- Hisotrial -->
			<div class="historial-container">
				<h3 class="titulo-historial">Historial de Peticiones del Protocolo RHC</h3>
				<h3 class="titulo-historial">Nivel 4 — Adaptativo Dinámico</h3>
				<table class="tabla-historial">
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha / Hora</th>
							<th>Descripción</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tablaHistorialRHC">
						<!-- Se llena dinámicamente -->
					</tbody>
				</table>
			</div>

		</div>
	</div>

<!-- ==========================================================
     MÓDULOS JS — RHC Protocol Core (Nivel 4 — Adaptativo Dinámico)
     ----------------------------------------------------------
     Cada módulo JavaScript implementa una función específica dentro
     del entorno de simulación del cliente del Protocolo RHC.
     ========================================================== -->
	<!-- Módulo ui_controls -->
	<script src="./js/ui_controls.js"></script>
	<!-- Módulo rhc_dynamic_adaptive -->
	<script src="./js/rhc_dynamic_adaptive.js"></script>
	<!-- Módulo request -->
	<script src="./js/requests.js"></script>
	<!-- Módulo entropy_analyzer -->
	<script src="./js/entropy_analyzer.js"></script>
	<!-- Módulo main — Inicializa y valida la configuración -->
	<script src="./js/main.js"></script>

</body>
</html>
