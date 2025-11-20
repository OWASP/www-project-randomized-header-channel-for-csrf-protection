<?php
	// ===============================
	// FRONT-END (Simulación del Cliente web o appweb)
	// ===============================
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Técnica de Dispersión de Encabezados - Ejemplo</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9fafb; color: #333; }
		.container { max-width: 800px; margin: 0 auto; text-align: center; }
		h1 { color: #0066cc; margin-bottom: 0px; }
		.testmessage1 { font-weight: bold; color: #333; }
		.testmessage2 { font-weight: bold; background-color: #00ff15; color: #fff; padding: 4px 8px; border-radius: 4px; }
		.testmessage1, .testmessage2 { display: inline;	}
		select, input, button { padding: 8px; margin: 5px; }
		table { border-collapse: collapse; width: 60%; margin-top: 20px; }
		th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
		th { background-color: #0066cc; color: white; }
		.green { background-color: #c6f6c6; }
		.gray { background-color: #f0f0f0; }
		#errorMsg { color: #b00020; font-weight: bold; margin-top: 10px; display: none; }
		#result { margin-top: 20px; padding: 10px; border-radius: 5px; background: #eef; }
	</style>
</head>
<body>
	<div class="container">
		<h1>Técnica de Dispersión de Encabezados</h1>
		<p class="testmessage1">PoC cargado correctamente </p>
		<p class="testmessage2">✔</p>

		<p>Selecciona un producto y realiza peticiones hacia el Servidor por medio de la API. Se mostrará qué encabezado fue utilizado y cuál recibió el servidor.</p>
	</div>
	<form id="productForm">
		<label>Producto:</label>
		<select id="productSelect">
			<option value="1">Producto 1</option>
			<option value="2">Producto 2</option>
			<option value="3">Producto 3</option>
		</select><br>

		<label>Clave:</label>
		<input type="text" id="productKey" placeholder="Ej. P001"><br>

		<label>Descripción:</label>
		<input type="text" id="productDesc" placeholder="Ej. Botella de vino tinto"><br>

		<label>Precio:</label>
		<input type="number" id="productPrice" placeholder="Ej. 250.00"><br>

		<div id="errorMsg"></div>

		<button type="button" onclick="solicitudAJAX()">Petición AJAX</button>
		<button type="button" onclick="solicitudFetch()">Petición Fetch</button>
	</form>

	<div class="container">
		<table id="headersTable">
			<tr><th>Encabezado</th><th>Estado</th></tr>
		</table>

		<div id="result">Esperando acción...</div>
	</div>
<script>
	// ===============================
	// CONFIGURACIÓN Y CONSTANTES
	// ===============================
	// Headers válidos
	const headersValidos = ['X-Server-Certified', 'X-Server-Sig', 'X-Server-Flag'];
	// Simular obtención de token
	const token = "TOKEN123456";
	// Restablece la tabla visual
    const apiURL = "http://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/api/";

	// ===============================
	// INICIALIZACIÓN
	// ===============================
	window.onload = function() {
		cargarEncabezadosEnTabla();
	};

	// ===============================
	// FUNCIONES DE INTERFAZ
	// ===============================
	function cargarEncabezadosEnTabla() {
		const tabla = document.getElementById('headersTable');
		tabla.innerHTML = '<tr><th>Encabezado</th><th>Estado</th></tr>';
		headersValidos.forEach((header, index) => {
			const fila = `
				<tr>
					<td>${header}</td>
					<td id="h${index + 1}" class="gray">No usado</td>
				</tr>`;
			tabla.innerHTML += fila;
		});
	}

	function resetTablaHeaders() {
		document.querySelectorAll('#headersTable td:nth-child(2)').forEach(td => {
			td.textContent = "No usado";
			td.className = "gray";
		});
	}

	function mostrarError(mensaje) {
		const errorDiv = document.getElementById('errorMsg');
		errorDiv.style.display = "block";
		errorDiv.textContent = mensaje;
	}

	function limpiarError() {
		const errorDiv = document.getElementById('errorMsg');
		errorDiv.style.display = "none";
		errorDiv.textContent = "";
	}

	function limpiarCampos() {
		document.getElementById('productKey').value = "";
		document.getElementById('productDesc').value = "";
		document.getElementById('productPrice').value = "";
	}

	function llenarCampos(data) {
		document.getElementById('productKey').value = data.clave || "";
		document.getElementById('productDesc').value = data.descripcion || "";
		document.getElementById('productPrice').value = data.precio || "";
	}

	// ===============================
	// TÉCNICA DE DISPERSIÓN
	// ===============================
	function seleccionarEncabezado() {
		const headerSeleccionado = headersValidos[Math.floor(Math.random() * headersValidos.length)];
		const idx = headersValidos.indexOf(headerSeleccionado);

		resetTablaHeaders();
		document.getElementById('h' + (idx + 1)).textContent = "Usado";
		document.getElementById('h' + (idx + 1)).className = "green";

		return { [headerSeleccionado]: token };
	}

	// ===============================
	// SOLICITUDES AL SERVIDOR
	// ===============================
	function solicitudAJAX() {
		enviarPeticion('ajax');
	}

	function solicitudFetch() {
		enviarPeticion('fetch');
	}

	function enviarPeticion(tipo) {
		limpiarError();

		const id_producto = document.getElementById('productSelect').value;
		const headersDispersos = seleccionarEncabezado();

		const headersFinales = {
			...headersDispersos,
			"Authorization": "Bearer FAKEJWT123",
			"Content-Type": "application/json"
		};

		const body = JSON.stringify({ id_producto });

		const options = {
			method: "POST",
			headers: headersFinales,
			body: body
		};

		if (tipo === 'ajax') {
			solicitudConAJAX(options);
		} else {
			solicitudConFetch(options);
		}
	}

	function solicitudConAJAX(options) {
		const xhr = new XMLHttpRequest();
		xhr.open("POST", apiURL, true);

		for (const [key, value] of Object.entries(options.headers)) {
			xhr.setRequestHeader(key, value);
		}

		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				procesarRespuesta(xhr.status, xhr.responseText);
			}
		};

		xhr.send(options.body);
	}

	function solicitudConFetch(options) {
		fetch(apiURL, options)
			.then(res => res.text())
			.then(text => procesarRespuesta(200, text))
			.catch(err => procesarRespuesta(500, JSON.stringify({ error: err.message })));
	}

	// ===============================
	// PROCESAR RESPUESTA DEL SERVIDOR
	// ===============================
	function procesarRespuesta(status, respuesta) {
		let resultDiv = document.getElementById("result");
		resultDiv.innerHTML = "";

		if (status !== 200) {
			limpiarCampos();
			mostrarError("Error en la solicitud. El servidor devolvió un error o no respondió correctamente.");
			return;
		}

		try {
			const data = JSON.parse(respuesta);

			if (data.producto.error) {
				limpiarCampos();
				mostrarError("Error: " + data.producto.error);
				resultDiv.innerHTML = `
					<strong>Respuesta del servidor:</strong><br>
					Encabezado recibido: <b>${data.header_recibido}</b><br>
					Token: <b>${data.token}</b>
				`;
			} else {
				limpiarError();
				llenarCampos(data.producto);
				resultDiv.innerHTML = `
					<strong>Respuesta del servidor:</strong><br>
					Encabezado recibido: <b>${data.header_recibido}</b><br>
					Token: <b>${data.token}</b>
				`;
			}
		} catch (e) {
			limpiarCampos();
			mostrarError("Error al procesar la respuesta del servidor.");
		}
	}
</script>

</body>
</html>
