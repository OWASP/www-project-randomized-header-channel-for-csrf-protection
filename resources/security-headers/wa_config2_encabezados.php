<?php
/**
 * ==========================================================
 *  SECURITY HEADERS CONFIGURATION — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Implementación completa Y práctica de encabezados HTTP de seguridad
 *  para aplicaciones web en PHP.
 * 
 * 
 *  Incluye configuración de:
 *    - Content Security Policy (CSP) dinámico
 *    - Strict-Transport-Security (HSTS)
 *    - X-Frame-Options
 *    - Referrer-Policy
 *    - X-Content-Type-Options
 *    - Expect-CT
 *    - Cache-Control
 * 
 *  Este recurso está diseñado como una implementación real
 *  reutilizable y documentada para entornos de desarrollo
 *  y producción.
 * 
 *  "Incluye un generador CSP dinámico con documentación detallada integrada."
 * 
 *  @file        resources/security-headers/wa_config2_encabezados.php
 * 
 *  @project     RHC Protocol Core
 *  @component   Security Headers Resource
 *  @purpose     Proveer una implementación lista para usar de encabezados
 *               de seguridad HTTP con soporte dinámico para CSP.
 * 
 *  @category    Web Security / HTTP Headers
 *  @alignment   OWASP Secure Headers Project (complementary resource)
 * 
 *  @relation    Este recurso complementa el Proyecto de Encabezados Seguros
 *               de OWASP, implementa controles de seguridad a nivel
 *               de políticas del navegador (CSP, HSTS, etc.), mientras
 *               que RHC extiende la protección mediante un canal de
 *               integridad de comunicación basado en encabezados HTTP.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (código) + CC BY 4.0 (documentación)
 *  @version     1.0.0
 *  @codename    Secure Foundation
 *  @date        Abril 2026
 * ==========================================================
 */
?>

<?php
	// ***************************************
	// ********  MODO DE PRODUCCIÓN  *********
	// ***************************************
	// Cambia a TRUE en entorno de producción
	define("_WA_ES_PRODUCCION_", FALSE);
?>

<?php
	/**************************************************************************
	***********************  CONSTANTES DEL SERVIDOR API  ********************
	**************************************************************************/
	/***************************************
	**********  DOMINIO DE LA API  *********
	***************************************/
	// Define el SUBDOMINIO del servidor de la API en BACK-END
	define("_WA_SUBDOMINIO_API_", (_WA_ES_PRODUCCION_ ? "api." : "api.") );
	// Define el DOMINIO del servidor de la API en BACK-END
	define("_WA_DOMINIO_API_", (_WA_ES_PRODUCCION_ ? "tudominio" : "tudominio") );
	// Define el DOMINIO DE NIVEL SUPERIOR (TLD) del servidor de la API en BACK-END
	define("_WA_DOMINIO_API_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/**************************************************************************
	***********************  CONSTANTES DEL SERVIDOR BACK-END  ***************
	**************************************************************************/
	/***************************************
	**********  DOMINIO DE BACK-END  *******
	***************************************/
	// Define el SUBDOMINIO del servidor de BACK-END
	define("_WA_SUBDOMINIO_BACK_END_", (_WA_ES_PRODUCCION_ ? "www." : "www.") );
	// Define el DOMINIO del servidor de BACK-END
	define("_WA_DOMINIO_BACK_END_", (_WA_ES_PRODUCCION_ ? "tudominio" : "tudominio") );
	// Define el DOMINIO DE NIVEL SUPERIOR (TLD) del servidor de BACK-END
	define("_WA_DOMINIO_BACK_END_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/**************************************************************************
	***********************  CONSTANTES DEL SERVIDOR  ************************
	***********************   DE LA APLICACIÓN WEB   ************************
	**************************************************************************/
	/***************************************
	****************  DOMINIO  *************
	***************************************/
	// Define el SUBDOMINIO del servidor de la aplicación web
	define("_WA_SUBDOMINIO_", (_WA_ES_PRODUCCION_ ? "www." : "www.") );
	// Define el DOMINIO de la aplicación web
	define("_WA_DOMINIO_", (_WA_ES_PRODUCCION_ ? "tudominio" : "tudominio") );
	// Define el DOMINIO DE NIVEL SUPERIOR (TLD) de la aplicación web
	define("_WA_DOMINIO_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/***************************************
	******  IPs LOCALES (DESARROLLO)  ******
	***************************************/
	// Define las IPs locales de desarrollo permitidas
	define("_WA_IP_LOCALHOST_", [
		"127.0.0.1"       // Localhost
	]);
?>

<?php
	// Construir los dominios completos para la webapp y el backend
	$_DOMINIO_WEBAPP = _WA_SUBDOMINIO_ . _WA_DOMINIO_ . _WA_DOMINIO_TLD_;
	$_DOMINIO_BACK_END = _WA_SUBDOMINIO_BACK_END_ . _WA_DOMINIO_BACK_END_ . _WA_DOMINIO_BACK_END_TLD_;
	$_URL_BACK_END = "";
	$_URL_API = "";

	// Construir la URL del backend
	if ($_DOMINIO_WEBAPP !== $_DOMINIO_BACK_END) {
		// Construir la URL del backend
		$_URL_BACK_END = "https://" . $_DOMINIO_BACK_END . "/";
	}

	// Construir la URL de la API
	if ( !_WA_ES_PRODUCCION_ && in_array($_SERVER["HTTP_HOST"], _WA_IP_LOCALHOST_) ) {
		// Con IP
		$_URL_API = "https://" . $_SERVER["HTTP_HOST"] . "/" . _WA_DOMINIO_API_ . "/" . rtrim(_WA_SUBDOMINIO_API_, '.')  . "/";
	} else {
		$_URL_API = "https://" . _WA_SUBDOMINIO_API_ . _WA_DOMINIO_API_ . _WA_DOMINIO_API_TLD_ . "/";
	}// Fin de if ( !_WA_ES_PRODUCCION_ && in_array($_SERVER["HTTP_HOST"], _WA_IP_LOCALHOST_) )

/**************************************************************************
********************** CONFIGURACIÓN DE ENCABEZADOS ***********************
**********************         DE SEGURIDAD         ***********************
**************************************************************************/
// Encabezados de seguridad para aplicaciones web
	// Configurar encabezados HSTS seguros
	// Para forzar la conexión a través de HTTPS
	header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

	// Configurar encabezado Referrer-Policy: strict-origin-when-cross-origin
	// Define cómo el navegador debe enviar el encabezado Referer en las solicitudes.
	// En este caso, solo se enviará el Referer en solicitudes cruzadas de origen.
	header("Referrer-Policy: strict-origin-when-cross-origin");

	// Configurar encabezados X-CTO
	// Para prevenir la interpretación de archivos como MIME equivocados.
	// Impide que el navegador adivine el tipo de contenido (protege descargas).
	header("X-Content-Type-Options: nosniff");

	// Configurar encabezado X-XSS-Protection: 0
	// Este header está DEPRECATED en navegadores modernos (Chrome, Firefox, Edge).
	// Se envía con valor 0 para desactivarlo explícitamente y evitar vulnerabilidades conocidas.
	// La protección contra XSS debe delegarse a un Content-Security-Policy (CSP) bien configurado.
	header("X-XSS-Protection: 0");

	// Configurar encabezado CT
	// Permite a los sitios web optar por el cumplimiento de la política de Transparencia de Certificados (CT).
	header("Expect-CT: max-age=86400, enforce, report-uri='https://" . $_DOMINIO_BACK_END . "/apps/logs/expect-ct/report-ct.php'");

	// Configurar encabezado X-Permitted-Cross-Domain-Policies:
	// Este encabezado especifica si el contenido del dominio se puede cargar en otros dominios.
	header("X-Permitted-Cross-Domain-Policies: none");

    // Configurar encabezado X-Frame-Options: DENY
    // Evita que tu página sea cargada dentro de un marco (iframe) por otros sitios.
    header("X-Frame-Options: DENY");


/***********************************************************************************************************
// **********************************************************************************************************
//								CONTENT SECURITY POLICY (CSP)
// ----------------------------------------------------------------------------------------------------

	**¿Qué es Content Security Policy (CSP)?**

		- CSP es una medida de seguridad que ayuda a proteger tu sitio web 
			contra ataques como **Cross-Site Scripting (XSS)** y **Clickjacking**. 
			Controla qué recursos pueden ser cargados en tu página desde otros 
			dominios o fuentes externas.
	
	**Comportamiento general de las directivas CSP:**
	
		- Las directivas de CSP permiten especificar desde qué fuentes y 
		  dominios se pueden cargar recursos como **scripts**, **hojas de 
		  estilo**, **imágenes**, **conexiones de red**, etc.
		- La directiva `default-src` es la más general y establece una política 
		  para todas las demás directivas que no se especifiquen explícitamente.
	
	**Formato común de las directivas CSP:**
	
		1. `'self'`: Permite cargar recursos solo desde el mismo dominio.
		2. `'none'`: Bloquea el acceso a los recursos, incluso del mismo dominio.
		3. `https://example.com/`: Permite cargar recursos desde el dominio especificado.
		4. `data:`: Permite cargar recursos en formato de datos incrustados, como imágenes base64.
		5. `'unsafe-inline'` y `'unsafe-eval'`: Permiten el uso de inline scripts y evaluaciones de código dinámico. (¡No recomendado, ya que puede ser un riesgo de seguridad!)
	
// ----------------------------------------------------------------------------------------------------

	// =================================================================
	//		COMO SE CONFIGURAN LAS DIRECTIVAS CONTENT SECURITY POLICY (CSP)
	// =================================================================

		1. **default-src 'none'**: Bloquea la carga de todos los recursos por defecto.
		2. **script-src 'self'**: Permite cargar scripts solo desde el mismo dominio.
		3. **style-src 'self' https://fonts.googleapis.com/**: Permite cargar estilos desde el mismo dominio y de Google Fonts.
		4. **img-src 'self' data:**: Permite cargar imágenes desde el mismo dominio y recursos embebidos (base64).
		5. **connect-src 'self' https://api.example.com/**: Permite hacer conexiones a la API del mismo dominio y el dominio específico de la API.

	// =================================================================
	//		COMO SE CONTRUYE UN ENCAVEZADO CSP CON SUS DIRECTIVAS
	// =================================================================

		$cspHeader = "
			default-src 'none';  // Bloquea todo por defecto
			script-src 'self';   // Permite solo scripts desde el mismo dominio
			style-src 'self';    // Permite solo estilos desde el mismo dominio
			img-src 'self';      // Permite solo imágenes desde el mismo dominio
			connect-src 'self';  // Permite solo conexiones (fetch, XHR) desde el mismo dominio
		";
		header("Content-Security-Policy: $cspHeader");

	// ==========================================================
	//		DIRECTIVAS QUE SE PUEDEN CONFIGURAR
	// ==========================================================

	+---------------------------+-------------------------------------------------------------------------------------------------------+
	|	  **Directiva**			|									**Descripción**														|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| default-src				| Fuente predeterminada para todos los recursos (si no se especifica otra directiva).					|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| script-src				| Fuentes válidas para scripts JavaScript. Permite cargar scripts desde dominios específicos.			|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| style-src					| Fuentes válidas para hojas de estilo CSS. Permite cargar hojas de estilos desde dominios específicos.	|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| font-src					| Fuentes válidas para cargar fuentes tipográficas (web fonts) desde dominios específicos.				|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| img-src					| Fuentes válidas para cargar imágenes. Permite cargar imágenes desde dominios específicos.				|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| connect-src				| Fuentes válidas para conexiones de red (por ejemplo, `fetch`, `XHR`, websockets, etc.).				|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| media-src					| Fuentes válidas para cargar archivos de medios, como audio o video.									|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| object-src				| Fuentes válidas para cargar objetos incrustados, como Flash, Java, etc.								|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| frame-src					| Fuentes válidas para cargar iframes y otros marcos HTML.												|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| child-src					| Fuentes válidas para cargar recursos dentro de un `<frame>` o `<iframe>`.								|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| worker-src				| Fuentes válidas para cargar web workers y shared workers.												|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| manifest-src				| Fuentes válidas para cargar archivos manifest de PWA (Progressive Web Apps).							|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| form-action				| Fuentes válidas para enviar formularios. Controla desde qué dominios se pueden enviar formularios,	|
	|							| evitando ataques de tipo **CSRF** (Cross-Site Request Forgery).										|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| frame-ancestors			| Fuentes válidas para incrustar la página en un `<iframe>` (protección contra clickjacking).			|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| upgrade-insecure-requests	| Solicita el cambio automático de HTTP a HTTPS para todas las solicitudes de recursos.					|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| block-all-mixed-content	| Bloquea todo el contenido mixto (cargar contenido HTTP sobre una página HTTPS).						|
	+---------------------------+-------------------------------------------------------------------------------------------------------+


				// ==========================================================
				// 🛡 CONFIGURACIÓN DE CONTENT SECURITY POLICY (CSP)
				// ----------------------------------------------------------
				// Este script genera un encabezado CSP dinámico y organizado,
				// útil para ambientes de producción y desarrollo.
				// ==========================================================


	**Construcción de un encabezado CSP dinámico:**
	- Las directivas se construyen de manera dinámica utilizando la función `buildDirective()`,
	  la cual toma las fuentes definidas y genera una directiva válida en el formato adecuado para
	  el encabezado `Content-Security-Policy`.
	- Cada directiva recibe un conjunto de fuentes que se permiten (por ejemplo, `'self'`, `https://fonts.googleapis.com/`, etc.).
	- El encabezado CSP resultante es luego enviado al navegador para que aplique las restricciones de seguridad.

	**¿Cómo se configura un CSP para tu proyecto?**
	- Define las directivas que son necesarias para tu aplicación.
	- Especifica las fuentes confiables para cada tipo de recurso (scripts, estilos, imágenes, etc.).
	- Construye el encabezado CSP con la función `buildDirective()` y envíalo con el encabezado `Content-Security-Policy`.

	**Importante:**
	- Si no especificas una directiva, se utiliza la política predeterminada `'self'`, o se bloquea completamente con `'none'`.
	- Cada fuente que agregues debe ser revisada cuidadosamente para garantizar que sea segura.
	- No utilices `unsafe-inline` o `unsafe-eval` a menos que sea absolutamente necesario, ya que pueden abrir puertas a ataques XSS.

		- 'unsafe-eval' permite que se ejecute JavaScript utilizando eval(), lo cual es
		  una de las principales puertas de entrada para ataques XSS.

		- 'unsafe-inline' permite que se ejecuten scripts JavaScript inline (por ejemplo,
		  dentro de una etiqueta <script> sin un archivo externo), lo que puede ser aprovechado
		  por atacantes para inyectar código malicioso.


	+----------------------------------------------------------------------------+
	|	EHEMPLO DE CONFIGURACION Y COMPORTAMIENTO DE LAS FUENTES CSP (style-src)            |
	+----------------------------------------------------------------------------+

	Esta configuración controla desde dónde se pueden cargar las hojas
	de estilo CSS (`<link rel="stylesheet">`, `style`).

	** Comportamiento según el contenido de $styleSrc:

		1. $styleSrc = [];
			Resultado: style-src 'self';
			Permite cargar CSS desde el mismo dominio únicamente.

		2. $styleSrc = [];
			$styleSrc[] = "https://fonts.googleapis.com/";
			Resultado: style-src 'self' https://fonts.googleapis.com/;
			Permite el dominio propio y Google Fonts.

		3. $styleSrc = ["'none'"];
			Resultado: style-src 'none';
			Bloquea TODA carga de CSS. Ni del propio dominio ni de externos.
			Se usa solo si quieres evitar completamente el uso de estilos.

		IMPORTANTE:
			- La función `buildDirective()` agrega automáticamente `'self'`
				si `$sources` contiene URLs personalizadas (pero NO si usas `'none'`).
			- Por eso, no necesitas escribir manualmente `'self'` al agregar dominios.
				Solo agrégalo si lo necesitas explícitamente o desactivas esa lógica.

		Esta lógica aplica para todas las directivas: script-src, img-src, etc.

// **********************************************************************************************************
// *********************************************************************************************************/

	// Definir los recursos adicionales para cada directiva

		// SI Permite la carga de recursos (Script JS, Estilos, Imagenes y mas recursos) del mismo dominio o de otros dominios indicados.
		// $defaultSrc = ["https://cdn.example.com/", "https://styles.example.com/", "http://www.w3.org/"];
		$defaultSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$defaultSrc[] = "'none'";

		// Permite la carga de Script JS del mismo dominio o de otros dominios indicados.
		// $scriptSrc = ["https://cdn.example.com/", "https://cdnjs.cloudflare.com/", "'unsafe-eval'"];
		$scriptSrc = [];
		// Permite la carga de recursos de "https://cdnjs.cloudflare.com/".
        $scriptSrc[] = "https://cdn.jsdelivr.net/";
		// SI permitir la evaluación de código dinámico. (NO Previene ataques XSS)
        $scriptSrc[] = "'unsafe-eval'";
		// Permite la carga de recursos de "https://code.jquery.com/".
//		$scriptSrc[] = "https://code.jquery.com/";

		// Permite la carga de Hojas de Estilos CSS del mismo dominio o de otros dominios indicados..
		// $styleSrc = ["https://styles.example.com/", "https://another-styles.example.com/"];
		$styleSrc = [];
		// Permite la carga de Hojas de Estilos para las Fuentes de Google (Google Fonts)
//		$styleSrc[] = "https://fonts.googleapis.com/";

		// Permite la carga de Fuentes tipográficas (web fonts) del mismo dominio o de otros dominios indicados.
		// $fontSrc = ["https://fonts.example.com/", "https://another-fonts.example.com/"];
		$fontSrc = [];
		// Permite la carga de las Fuentes de Google (Google Fonts)
//		$fontSrc[] = "https://fonts.googleapis.com/";

		// Permite la carga de Imágenes (jpg, jpeg, png, gif, etc.) del mismo dominio o de otros dominios indicados.
		// $imgSrc = ["https://images.example.com/", "https://another-images.example.com/", "data:"];
		$imgSrc = [];
		// Permite la carga de imágenes del dominio especificado (servidor BACK-END - acceso a imágenes autenticadas o privadas).
		$imgSrc[] = "https://" . $_DOMINIO_BACK_END . "/";
		// Agregar data: a la lista de imágenes permitidas
		// - Formato `data:` para imágenes embebidas en línea (base64)
		// Nota: Esto es útil para íconos o imágenes generadas dinámicamente, pero tiene riesgos si no filtras bien).
		$imgSrc[] = "data:";

		// Permite las conexiones de red (`fetch`, `XHR`, websockets, etc.) del mismo dominio o de otros dominios indicados.
		// Ejemplos de conectividad (API, WebSocket, CDN JSON, etc.)
		// $connectSrc[] = "https://api.example.com/";           // API externa
		// $connectSrc[] = "wss://chat.example.com/";            // WebSocket seguro
		// $connectSrc[] = "https://json.cdnserver.com/";        // Carga de datos desde un CDN
		$connectSrc = [];
		// Permite la conexión al BACK-END.
		if ($_URL_BACK_END !== "") { $connectSrc[] = $_URL_BACK_END; }
		// Permite la conexión a la API.
		$connectSrc[] = $_URL_API;
		// Agregamos la URL de Google Storage (para el modelo)
		$connectSrc[] = "https://storage.googleapis.com/";

		// Permite la carga de Archivos Multimedia (audio, video) del mismo dominio o de otros dominios indicados.
		// $mediaSrc = ["https://videos.example.com/", "https://another-videos.example.com/"];
		$mediaSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$mediaSrc[] = "'none'";

		// Permite la carga de Objetos Incrustados (Flash, Java, etc.) del mismo dominio o de otros dominios indicados.
		// $objectSrc = ["https://widgets.example.com/", "https://another-widgets.example.com/"];
		$objectSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$objectSrc[] = "'none'";

		// Permite la carga de Contenido en Iframes y otros marcos HTML (videos, mapas, etc.) del mismo dominio o de otros dominios indicados.
		// $frameSrc = ["https://www.youtube.com/", "https://maps.google.com/"];
		$frameSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$frameSrc[] = "'none'";

		// Permite la carga de Contenido en Frames e Iframes (similar a frame-src) del mismo dominio o de otros dominios indicados.
		// child-src está obsoleto en muchos navegadores, pero aún puede ser útil en algunos casos específicos.
		// $childSrc = ["https://widgets.example.com/", "https://www.youtube.com/", "https://maps.google.com/"];
		$childSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$childSrc[] = "'none'";

		// Permite la carga de Web Workers y Shared Workers (Necesario si usas tecnologías como WebAssembly, PWA, etc.) del mismo dominio o de otros dominios indicados.
		// $workerSrc = ["https://workers.example.com/", "https://workers.miapp.com/"];
		$workerSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$workerSrc[] = "'none'";

		// ==================================================================
		// Define de dónde se puede cargar el archivo manifest.json (PWA).
		// Es útil si tu aplicación tiene soporte para instalación como App.
		// ==================================================================
		// Permite la carga de Archivos Manifest para PWA (Progressive Web Apps) del mismo dominio o de otros dominios indicados.
		// $manifestSrc = ["https://pwa.example.com/", "https://pwa.miapp.com/"];
		$manifestSrc = [];
		// NO Permite la carga de recursos del mismo dominio o de ningun otro dominio.
		// Bloquea todo por defecto.
		$manifestSrc[] = "'none'";

		// Permite las Fuentes válidas para Enviar Formularios del mismo dominio o de otros dominios indicados.
		// Esta directiva es útil para prevenir ataques de tipo **CSRF** (Cross-Site Request Forgery).										|
		// ========================================================================================
		//								SEGURIDAD
		// ========================================================================================
		//	¿Qué son los formularios externos maliciosos?
		//		- Es cuando un sitio externo intenta enviar formularios a tu servidor,
		//		  posiblemente para hacer spam, phishing, o incluso
		//		  ataques CSRF (Cross-Site Request Forgery).
		//
		//	Ejemplo:
		//		Un atacante carga tu página de transferencia bancaria dentro de
		//		un iframe invisible. El usuario cree que está dando “me gusta” a un gato,
		//		pero en realidad hace clic en "Transferir dinero".
		// ========================================================================================
		//	- Configuración segura por defecto:
		// 		Solo permite formularios enviados desde tu propio dominio
		//				$formAction = ["'self'"];
		//
		//	  	NOTA IMPORTANTE:
		//			- Esto bloquea que otros sitios web puedan intentar enviar
		// 			  formularios maliciosos hacia tu backend.
		//
		//	- Permitir envío desde un subdominio o servicio externo:
		//		Si tienes un sistema de pagos(Banco, PayPal, etc), formulario embebido o integración
		// 		que necesita enviar datos hacia tu dominio, puedes permitirlo:
		//				$formAction = [];
		//				$formAction[] = "'self'";
		//				$formAction[] = "https://pagos.tubanco.com";
		//				$formAction[] = "https://mi-app-externa.com";
		//
		//	  	NOTAS IMPORTANTE:
		//			- No incluyas URLs que no controlas o no necesitas. ¡Evita dejar la puerta abierta!
		//			- No es lo mismo que permitir CORS. Esta directiva solo afecta al envío de
		//			  formularios, no a fetch, XHR o AJAX.
		//
		// Permite enviar formularios SOLO desde el mismo dominio.
		$formAction = ["'self'"];

		// Define qué dominios pueden embeber tu sitio mediante <iframe>, <frame>, <object>, etc.
		// Esta directiva es útil para prevenir ataques de tipo clickjacking.
		// ========================================================================================
		//								SEGURIDAD
		// ========================================================================================
		//	¿Qué es el clickjacking?
		//		- Es un ataque donde un sitio malicioso carga tu sitio dentro de
		// 		  un <iframe> oculto o disfrazado, para que el usuario haga clic sin
		// 		  saber en elementos de tu app (como botones o enlaces importantes).
		//
		//	Ejemplo:
		//		Un atacante carga tu página de transferencia bancaria dentro de
		//		un iframe invisible. El usuario cree que está dando “me gusta” a un gato,
		//		pero en realidad hace clic en "Transferir dinero".
		// ========================================================================================
		//	- Permite que tu sitio sea embebido únicamente desde sí mismo.
		//	  Ideal si tu aplicación se incrusta solo dentro de sus propias páginas (ej. apps SPA o sistemas internos).
		//		$frameAncestors = []; ó también: $frameAncestors = ["'self'"];
		//
		//	- Permite que tu aplicación sea embebida desde dominios específicos (ej. dashboards, portales externos autorizados).
		//		$frameAncestors = [];
		//		$frameAncestors[] = "https://dashboard.example.com";
		//		$frameAncestors[] = "https://clientes.miempresa.com";
		$frameAncestors = [];
		// Bloquea cualquier iframe que intente embeber tu sitio
		// Bloquea todo por defecto.
		$frameAncestors[] = "'none'";

		// Esta directiva NO utiiza arrays (Es un flags) - TRUE / FALSE
		// Solicita el cambio automático de HTTP a HTTPS para todas las solicitudes de recursos.
		// TRUE - SI Fuerza HTTPS
		// FALSE -NO Fuerza HTTPS
		$upgradeInsecureRequests = TRUE;	// Fuerza HTTPS

		// Esta directiva NO utiiza arrays (Es un flags) - TRUE / FALSE
		// Bloquea todo el contenido mixto (cargar contenido HTTP sobre una página HTTPS).
		// TRUE - SI Bloquea contenido mixto
		// FALSE -NO Bloquea contenido mixto
		$blockAllMixedContent    = TRUE;	// Bloquea contenido mixto


		// ===================================================
		//		FUNCIÓN PARA CONSTRUIR DIRECTIVAS CSP
		// ===================================================
		function buildDirective($directiveName, $sources, $addSelf = true) {
			// Si contiene 'none', ignoramos todo lo demás y devolvemos solo 'none'
			if (in_array("'none'", $sources)) {
				return "$directiveName 'none';";
			}
		
			$sourcesString = implode(' ', $sources);
			return trim("$directiveName " . ($addSelf ? "'self' " : "") . $sourcesString) . ";";
		}


		// ===================================================
		// 		CONSTRUIR TODAS LAS DIRECTIVAS CSP
		//				CON NOMBRES COMPACTOS
		// ===================================================
		$DirDE_Src = buildDirective('default-src', $defaultSrc);	// Fuente por defecto
		$DirSC_Src = buildDirective('script-src', $scriptSrc);		// Scripts JS
		$DirIM_Src = buildDirective('img-src', $imgSrc);			// Imágenes
		$DirST_Src = buildDirective('style-src', $styleSrc);		// Estilos CSS
		$DirFO_Src = buildDirective('font-src', $fontSrc);			// Fuentes tipográficas
		$DirCO_Src = buildDirective('connect-src', $connectSrc);	// Conexiones de red
		$DirME_Src  = buildDirective('media-src', $mediaSrc);		// Archivos de audio y video
		$DirOB_Src  = buildDirective('object-src', $objectSrc);		// Objetos embebidos (Flash, Java, etc.)
		$DirFR_Src  = buildDirective('frame-src', $frameSrc);		// iframes embebidos (otros sitios)
		$DirCH_Src  = buildDirective('child-src', $childSrc);		// Recursos en <frame> o <iframe>
		$DirWO_Src  = buildDirective('worker-src', $workerSrc);		// Web workers
		$DirMA_Src  = buildDirective('manifest-src', $manifestSrc);	// PWA manifest

		// NO incluye 'self' automáticamente
		$DirFA_Act = buildDirective('form-action', $formAction, false);    // Formularios externos (CSRF)
		// NO incluye 'self' automáticamente
		$DirFA_Anc = buildDirective('frame-ancestors', $frameAncestors, false);// Protección contra Clickjacking


		// ===================================================
		// 		CONSTRUIR EL ENCAVEZADO FINAL CSP
		// ===================================================
		$cspHeader = implode(" ", [
				$DirDE_Src,
				$DirSC_Src,
				$DirIM_Src,
				$DirST_Src,
				$DirFO_Src,
				$DirCO_Src,
				$DirME_Src,
				$DirOB_Src,
				$DirFR_Src,
				$DirCH_Src,
				$DirWO_Src,
				$DirMA_Src,
				$DirFA_Act,
				$DirFA_Anc
			]);

			// Agregar los flags si están habilitados
			if ($upgradeInsecureRequests) {
				$cspHeader .= " upgrade-insecure-requests;";
			}
			if ($blockAllMixedContent) {
				$cspHeader .= " block-all-mixed-content;";
			}


	// ===================================================
	//        AGREGAR RUTAS DE REPORTES CSP
	// ===================================================
	// 1. Agregar report-uri (más compatible, pero deprecated pero aún muy usado)
	$cspHeader .= " report-uri https://" . $_DOMINIO_BACK_END . "/apps/logs/csp/report-csp.php;";
	// 2. Agregar encabezado Report-To (más moderno, aún no soportado por todos los navegadores)
	header('Report-To: {"group":"csp-endpoint","max_age":10886400,"endpoints":[{"url":"https://' . $_DOMINIO_BACK_END . '/apps/logs/csp/report-csp.php"}],"include_subdomains":true}');
	// Asociar el grupo definido en el header Report-To
	$cspHeader .= " report-to csp-endpoint;";


	// ===================================================
	//		ENVIAR EL ENCABEZADO CSP AL NAVEGADOR
	// ===================================================
	if (_WA_ES_PRODUCCION_) {
		// Si estamos en producción, activamos la política de seguridad (bloquea contenidos no permitidos)
		header("Content-Security-Policy: $cspHeader");
	} else {
		// Si no estamos en producción (probablemente en un entorno de desarrollo o prueba),
		// usamos "Content-Security-Policy-Report-Only" para solo recibir reportes de violaciones,
		// pero **sin bloquear** ningún contenido. Esto permite probar la política antes de aplicarla.

//		header("Content-Security-Policy-Report-Only: $cspHeader");
		header("Content-Security-Policy: $cspHeader");
	}

// error_log("FRONT-END: ".$cspHeader);

?>
<?php
	// Configurar encabezado Cache-Control y Pragma
	// Controla cómo el contenido es almacenado en caché por los navegadores y proxies.
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");

/**************************************************************************
********************** CONFIGURACIÓN DE SALIDA ****************************
**************************************************************************/
	// Configurar compresión de salida (gzip)
	if (substr_count($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
		ob_start("ob_gzhandler");
	} else {
		ob_start();
	}
?>