<?php
/**
 * ==========================================================
 *  ENTROPY VIEWER — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Interfaz gráfica principal del “Entropy Lab” del 
 *  Protocolo RHC. Permite visualizar comparativas de 
 *  entropía, analizar múltiples tokens en paralelo, mostrar 
 *  gráficos dinámicos con Chart.js y recibir datasets desde 
 *  el sistema principal.
 * 
 *  Este módulo integra front-end + back-end de forma segura:
 *    - Acepta datos por GET/POST (con decodificación segura)
 *    - Muestra área de entrada manual
 *    - Genera comparativas visuales
 *    - Administra el renderizado de gráficas
 *
 *  Su diseño está optimizado para auditorías, pruebas de 
 *  entropía y visualización del comportamiento estadístico de 
 *  encabezados y tokens del canal RHC.
 *
 *  @file        public_html/entropy/entropy_viewer.php
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Mostrar el análisis de entropía en formato visual.
 *
 *  @module      Frontend\EntropyViewer
 *  @category    Security Data Visualization
 *  @see         https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/ OWASP Top 10 — Cross-Site Request Forgery (CSRF)
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	// Inicializamos el array de datos
	$data = [];

	// Función auxiliar para decodificar JSON de manera segura
	function safe_json_decode($json) {
		// Convertimos a array asociativo
		$result = json_decode($json, true);
		// Verificamos errores de JSON
		if (json_last_error() !== JSON_ERROR_NONE) {
			// Podrías registrar el error o devolver un mensaje
			return null;
		}
		// Solo aceptamos arrays (evita objetos o tipos inesperados)
		if (!is_array($result)) {
			return null;
		}
		return $result;
	}

	// --- Validación POST primero (más seguro) ---
	if (isset($_POST['data'])) {
		$decoded = safe_json_decode($_POST['data']);
		if ($decoded !== null) {
			$data = $decoded;
		} else {
			// Datos POST inválidos
			// Opcional: manejar error, log, o enviar respuesta JSON
			$data = [];
		}
	}
	// --- Si no hay POST, validamos GET ---
	elseif (isset($_GET['data'])) {
		$decoded = safe_json_decode($_GET['data']);
		if ($decoded !== null) {
			$data = $decoded;
		} else {
			// Datos GET inválidos
			$data = [];
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>RHC Protocol - Entropy Lab</title>
	<link rel="stylesheet" href="./css/style.css">

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@latest"></script>
</head>
<body>

	<h2>RHC Protocol - Entropy Lab (modo comparativo)</h2>
	<p>Ingresa varios tokens o encabezados, uno por línea, para comparar su nivel de entropía:</p>

	<textarea id="tokenList" class="<?php echo !empty($data) ? 'hidden' : ''; ?>"
	placeholder="Ejemplo:
	TOK_62de8fe3ece2
	DECOY_hp6x1v
	TOK_978abcaf6d1d
	..."></textarea>

	<div id="msgBox"></div>

	<button id="analyzeBtn" onclick="analyzeTokens()" class="<?php echo !empty($data) ? 'hidden' : ''; ?>">
		Analizar Entropía
	</button>

	<canvas id="entropyChart"></canvas>

	<div class="legend">
		<div><span style="background:#23c552"></span> Alta seguridad (≥ 3.5 bits/char)</div>
		<div><span style="background:#f5b942"></span> Media (1.5–3.4 bits/char)</div>
		<div><span style="background:#d43838"></span> Baja (≤ 1.4 bits/char)</div>
	</div>

	<!-- Scripts separados -->
	<script>
		// Datos recibidos por GET/POST
		<?php if(!empty($data)): ?>
			const pool = <?php echo json_encode($data); ?>;
		<?php else: ?>
			const pool = null;
		<?php endif; ?>
	</script>
	<script src="./js/ui_control.js"></script>
	<script src="./js/analyzer.js"></script>
	<script src="./js/chart.js"></script>

</body>
</html>