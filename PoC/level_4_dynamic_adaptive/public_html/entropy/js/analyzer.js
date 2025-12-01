/**
 * ==========================================================
 *  ANALYZER MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo encargado de analizar tokens o encabezados y medir
 *  su entropía mediante consultas al backend (entropy_analyzer.php).
 *
 *  Este módulo permite:
 *    • Escaneo línea por línea de múltiples tokens
 *    • Solicitudes dinámicas al servidor usando Fetch API
 *    • Normalización de etiquetas para el gráfico
 *    • Proceso automático con debounce para análisis en tiempo real
 *
 *  Es parte fundamental del laboratorio de entropía, integrándose
 *  con el sistema de visualización Chart.js y con el front-end
 *  interactivo del Protocolo RHC.
 *
 *  @file        public_html/entropy/js/analyzer.js
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Realizar análisis remoto de entropía y generar datasets.
 *
 *  @module      Frontend\EntropyAnalyzer
 *  @category    Security Analysis / Dynamic Entropy Evaluation
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	async function analyzeTokens() {
		const input = document.getElementById('tokenList').value.trim();

		if (!input) {
			showMessage("Introduce al menos un token o encabezado.");
			return;
		}

		const lines = input.split('\n').filter(l => l.trim() !== '');
		const results = [];
		let concatenated = "";

		for (let line of lines) {
			const res = await fetch(`./include/entropy_analyzer.php?data=${encodeURIComponent(line)}`);
			const json = await res.json();

			results.push({
				label: line.slice(0, 15) + (line.length > 15 ? '…' : ''),
				value: json.entropy
			});

			concatenated += line;
		}

		// Calcular entropía total del string concatenado
		const totalRes = await fetch(`./include/entropy_analyzer.php?data=${encodeURIComponent(concatenated)}`);
		const totalJson = await totalRes.json();

		results.push({
			label: "ENTROPÍA TOTAL",
			value: totalJson.entropy
		});

		renderChart(results);
	}

	// Debounce
	let debounceTimer;
	document.getElementById('tokenList').addEventListener('input', () => {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(() => {
			analyzeTokens();
		}, 100);
	});
