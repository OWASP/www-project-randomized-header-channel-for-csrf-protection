<?php
/**
 * ==========================================================
 *  PRODUCTOS MODEL (Representa la capa de datos) — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Aquí se simula una base de datos local en memoria.
 *  Esta capa abstrae el origen de los datos y permite
 *  su consumo por el controlador sin exponer detalles internos.
 * 
 *  @file        back-end/models/modelo-productos.php
 * 
 *  @project     RHC Protocol Core
 *  @implementation Nivel 2 — Intermedio
 *  @purpose     Gestionar los datos simulados del recurso productos.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Origin Entropy
 *  @date        Noviembre 2025
 * ==========================================================
 */

	function getProductsData() {
		return [
			1 => ['clave' => 'P001', 'descripcion' => 'Botella de vino tinto 750ml', 'precio' => 250],
			2 => ['clave' => 'P002', 'descripcion' => 'Botella de tequila añejo 1L', 'precio' => 480],
		];
	}

	function getProductData($id) {
		// Obtener los propductos de la base de datos (SIMULACION)
		$productos = getProductsData();

		// Valida si existe el producto
		if (!isset($productos[$id])) {
			// Regresa un Error
			return ['error' => 'Producto no encontrado'];
		}

		// Regresa los Datos
		return $productos[$id];
	}
?>