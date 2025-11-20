<?php
	// ========================================
	// END-POINT DEL BACK-END PRIVADO (solo accesible por la API)
	// ========================================
	function getProductData($id) {
		error_log("Entrando a getProductData() con ID=$id");

		$productos = [
			1 => ['clave' => 'P001', 'descripcion' => 'Botella de vino tinto 750ml', 'precio' => 250],
			2 => ['clave' => 'P002', 'descripcion' => 'Botella de tequila añejo 1L', 'precio' => 480],
		];

		if (!isset($productos[$id])) {
			error_log("Producto no encontrado para ID=$id");
			return ['error' => 'Producto no encontrado'];
		}

		error_log("Producto encontrado: " . $productos[$id]['clave']);
		return $productos[$id];
	}
?>