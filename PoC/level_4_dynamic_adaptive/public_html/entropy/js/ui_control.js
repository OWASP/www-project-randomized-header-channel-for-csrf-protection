/**
 * ==========================================================
 *  UI CONTROL MODULE — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Módulo encargado del manejo de interfaz para el laboratorio
 *  de entropía. Centraliza:
 *
 *    • Mensajes de error o advertencia
 *    • Resaltado visual del textarea
 *    • Renderizado automático cuando se reciben datos por GET/POST
 *
 *  Este módulo permite interacción clara, retroalimentación
 *  inmediata y compatibilidad con el flujo completo del
 *  Entropy Viewer, funcionando como puente entre usuario y
 *  las operaciones internas de análisis.
 *
 *  @file        public_html/entropy/js/ui_control.js
 *
 *  @project     RHC Protocol Core
 *  @implementation Nivel 4 — Adaptativo Dinámico
 *  @purpose     Controlar mensajes, validación visual y autoprocesamiento.
 *
 *  @module      Frontend\UIController
 *  @category    UX / Interface Support
 *
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	function showMessage(msg, color = "#ff6b6b") {
		const box = document.getElementById("msgBox");
		const textarea = document.getElementById("tokenList");

		box.textContent = msg;
		box.style.color = color;

		textarea.classList.add('error');

		setTimeout(() => {
			box.textContent = "";
			textarea.classList.remove('error');
		}, 3000);
	}

	// Mostrar datos recibidos automáticamente
	document.addEventListener('DOMContentLoaded', () => {
		if (pool) {
			const textarea = document.getElementById('tokenList');
			textarea.value = Object.entries(pool).map(([k,v]) => `${k}\n${v}`).join('\n');
			analyzeTokens();
		}
	});
