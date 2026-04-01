<?php
/**
 * ==========================================================
 *  SECURITY HEADERS CONFIGURATION — RHC Protocol Core
 *  ----------------------------------------------------------
 *  Complete and practical implementation of HTTP security headers
 *  for PHP-based web applications.
 * 
 *  Includes configuration for:
 *    - Dynamic Content Security Policy (CSP)
 *    - Strict-Transport-Security (HSTS)
 *    - X-Frame-Options
 *    - Referrer-Policy
 *    - X-Content-Type-Options
 *    - Expect-CT
 *    - Cache-Control
 * 
 *  This resource is designed as a real-world, reusable, and
 *  well-documented implementation for both development and
 *  production environments.
 * 
 *  "Includes a dynamic CSP builder with detailed inline documentation."
 * 
 *  @file        resources/security-headers/wa_config2_headers.php
 * 
 *  @project     RHC Protocol Core
 *  @component   Security Headers Resource
 *  @purpose     Provide a ready-to-use implementation of HTTP security
 *               headers with dynamic CSP support.
 * 
 *  @category    Web Security / HTTP Headers
 *  @alignment   OWASP Secure Headers Project (complementary resource)
 * 
 *  @relation    This resource complements the OWASP Secure Headers Project
 *               by implementing browser-level security controls (CSP, HSTS, etc.),
 *               while RHC extends protection through a communication integrity
 *               channel based on HTTP headers.
 * 
 *  @author      Fernando Flores Alvarado
 *  @license     Apache 2.0 (code) + CC BY 4.0 (documentation)
 *  @version     1.0.0
 *  @codename    Secure Foundation
 *  @date        April 2026
 * ==========================================================
 */
?>

<?php
	// ***************************************
	// ********  PRODUCTION MODE  ************
	// ***************************************
	// Set to TRUE in production environment
	define("_WA_ES_PRODUCCION_", FALSE);
?>

<?php
	/**************************************************************************
	***********************  API SERVER CONSTANTS  ****************************
	**************************************************************************/
	/***************************************
	**********  API DOMAIN  ***************
	***************************************/
	// Define the SUBDOMAIN of the API BACK-END server
	define("_WA_SUBDOMINIO_API_", (_WA_ES_PRODUCCION_ ? "api." : "api.") );
	// Define the DOMAIN of the API BACK-END server
	define("_WA_DOMINIO_API_", (_WA_ES_PRODUCCION_ ? "yourdomain" : "yourdomain") );
	// Define the TOP LEVEL DOMAIN (TLD) of the API BACK-END server
	define("_WA_DOMINIO_API_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/**************************************************************************
	***********************  BACK-END SERVER CONSTANTS  ***********************
	**************************************************************************/
	/***************************************
	**********  BACK-END DOMAIN  **********
	***************************************/
	// Define the SUBDOMAIN of the BACK-END server
	define("_WA_SUBDOMINIO_BACK_END_", (_WA_ES_PRODUCCION_ ? "www." : "www.") );
	// Define the DOMAIN of the BACK-END server
	define("_WA_DOMINIO_BACK_END_", (_WA_ES_PRODUCCION_ ? "yourdomain" : "yourdomain") );
	// Define the TOP LEVEL DOMAIN (TLD) of the BACK-END server
	define("_WA_DOMINIO_BACK_END_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/**************************************************************************
	***********************  WEB APPLICATION SERVER CONSTANTS  ****************
	**************************************************************************/
	/***************************************
	****************  DOMAIN  **************
	***************************************/
	// Define the SUBDOMAIN of the web application server
	define("_WA_SUBDOMINIO_", (_WA_ES_PRODUCCION_ ? "www." : "www.") );
	// Define the DOMAIN of the web application
	define("_WA_DOMINIO_", (_WA_ES_PRODUCCION_ ? "yourdomain" : "yourdomain") );
	// Define the TOP LEVEL DOMAIN (TLD) of the web application
	define("_WA_DOMINIO_TLD_", (_WA_ES_PRODUCCION_ ? ".com" : ".test") );

	/***************************************
	**********  LOCAL IPs (DEV)  ***********
	***************************************/
	// Define local development IPs allowed to bypass production checks
	define("_WA_IP_LOCALHOST_", [
		"127.0.0.1"       // Localhost
	]);
?>

<?php
	// Build the full domains for the webapp and the backend
	$_DOMINIO_WEBAPP = _WA_SUBDOMINIO_ . _WA_DOMINIO_ . _WA_DOMINIO_TLD_;
	$_DOMINIO_BACK_END = _WA_SUBDOMINIO_BACK_END_ . _WA_DOMINIO_BACK_END_ . _WA_DOMINIO_BACK_END_TLD_;
	$_URL_BACK_END = "";
	$_URL_API = "";

	// Build the backend URL
	if ($_DOMINIO_WEBAPP !== $_DOMINIO_BACK_END) {
		// Build the backend URL
		$_URL_BACK_END = "https://" . $_DOMINIO_BACK_END . "/";
	}

	// Build the API URL
	if ( !_WA_ES_PRODUCCION_ && in_array($_SERVER["HTTP_HOST"], _WA_IP_LOCALHOST_) ) {
		// With IP
		$_URL_API = "https://" . $_SERVER["HTTP_HOST"] . "/" . _WA_DOMINIO_API_ . "/" . rtrim(_WA_SUBDOMINIO_API_, '.')  . "/";
	} else {
		$_URL_API = "https://" . _WA_SUBDOMINIO_API_ . _WA_DOMINIO_API_ . _WA_DOMINIO_API_TLD_ . "/";
	}// End of if ( !_WA_ES_PRODUCCION_ && in_array($_SERVER["HTTP_HOST"], _WA_IP_LOCALHOST_) )

/**************************************************************************
***********************  SECURITY HEADERS CONFIGURATION  ******************
**************************************************************************/
// Security headers for web applications
	// Configure secure HSTS header
	// To force connection over HTTPS
	header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

	// Configure Referrer-Policy header: strict-origin-when-cross-origin
	// Defines how the browser should send the Referer header in requests.
	// In this case, the Referer will only be sent on cross-origin requests.
	header("Referrer-Policy: strict-origin-when-cross-origin");

	// Configure X-Content-Type-Options header
	// Prevents the browser from interpreting files as a different MIME type.
	// Stops the browser from guessing the content type (protects downloads).
	header("X-Content-Type-Options: nosniff");

	// Configure X-XSS-Protection header: 0
	// This header is DEPRECATED in modern browsers (Chrome, Firefox, Edge).
	// It is sent with value 0 to explicitly disable it and avoid known vulnerabilities.
	// XSS protection should be delegated to a properly configured Content-Security-Policy (CSP).
	header("X-XSS-Protection: 0");

	// Configure Expect-CT header
	// Allows websites to opt in to Certificate Transparency (CT) policy enforcement.
	header("Expect-CT: max-age=86400, enforce, report-uri='https://" . $_DOMINIO_BACK_END . "/apps/logs/expect-ct/report-ct.php'");

	// Configure X-Permitted-Cross-Domain-Policies header:
	// This header specifies whether domain content can be loaded into other domains.
	header("X-Permitted-Cross-Domain-Policies: none");

    // Configure X-Frame-Options: DENY header
    // Prevents your page from being loaded inside a frame (iframe) by other sites.
    header("X-Frame-Options: DENY");


/***********************************************************************************************************
// **********************************************************************************************************
//								CONTENT SECURITY POLICY (CSP)
// ----------------------------------------------------------------------------------------------------

	**What is Content Security Policy (CSP)?**

		- CSP is a security measure that helps protect your website
			against attacks such as **Cross-Site Scripting (XSS)** and **Clickjacking**.
			It controls which resources can be loaded on your page from other
			domains or external sources.
	
	**General behavior of CSP directives:**
	
		- CSP directives allow you to specify which sources and
		  domains can load resources such as **scripts**, **stylesheets**,
		  **images**, **network connections**, etc.
		- The `default-src` directive is the most general and sets a policy
		  for all other directives not explicitly specified.
	
	**Common CSP directive formats:**
	
		1. `'self'`: Allows loading resources only from the same domain.
		2. `'none'`: Blocks access to resources, even from the same domain.
		3. `https://example.com/`: Allows loading resources from the specified domain.
		4. `data:`: Allows loading resources in embedded data format, such as base64 images.
		5. `'unsafe-inline'` and `'unsafe-eval'`: Allow the use of inline scripts and dynamic code evaluations. (Not recommended, as they can be a security risk!)
	
// ----------------------------------------------------------------------------------------------------

	// =================================================================
	//		HOW TO CONFIGURE CONTENT SECURITY POLICY (CSP) DIRECTIVES
	// =================================================================

		1. **default-src 'none'**: Blocks loading of all resources by default.
		2. **script-src 'self'**: Allows loading scripts only from the same domain.
		3. **style-src 'self' https://fonts.googleapis.com/**: Allows loading styles from the same domain and Google Fonts.
		4. **img-src 'self' data:**: Allows loading images from the same domain and embedded resources (base64).
		5. **connect-src 'self' https://api.example.com/**: Allows connections to the API of the same domain and the specific API domain.

	// =================================================================
	//		HOW TO BUILD A CSP HEADER WITH ITS DIRECTIVES
	// =================================================================

		$cspHeader = "
			default-src 'none';  // Blocks everything by default
			script-src 'self';   // Allows only scripts from the same domain
			style-src 'self';    // Allows only styles from the same domain
			img-src 'self';      // Allows only images from the same domain
			connect-src 'self';  // Allows only connections (fetch, XHR) from the same domain
		";
		header("Content-Security-Policy: $cspHeader");

	// ==========================================================
	//		AVAILABLE DIRECTIVES
	// ==========================================================

	+---------------------------+-------------------------------------------------------------------------------------------------------+
	|	  **Directive**			|									**Description**														|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| default-src				| Default source for all resources (if no other directive is specified).								|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| script-src				| Valid sources for JavaScript scripts. Allows loading scripts from specific domains.					|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| style-src					| Valid sources for CSS stylesheets. Allows loading stylesheets from specific domains.					|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| font-src					| Valid sources for loading web fonts from specific domains.											|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| img-src					| Valid sources for loading images. Allows loading images from specific domains.						|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| connect-src				| Valid sources for network connections (e.g., `fetch`, `XHR`, websockets, etc.).						|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| media-src					| Valid sources for loading media files such as audio or video.											|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| object-src				| Valid sources for loading embedded objects such as Flash, Java, etc.									|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| frame-src					| Valid sources for loading iframes and other HTML frames.												|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| child-src					| Valid sources for loading resources inside a `<frame>` or `<iframe>`.									|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| worker-src				| Valid sources for loading web workers and shared workers.												|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| manifest-src				| Valid sources for loading PWA (Progressive Web App) manifest files.									|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| form-action				| Valid sources for submitting forms. Controls which domains forms can be submitted to,					|
	|							| preventing **CSRF** (Cross-Site Request Forgery) attacks.												|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| frame-ancestors			| Valid sources for embedding the page in an `<iframe>` (clickjacking protection).						|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| upgrade-insecure-requests	| Requests automatic upgrade from HTTP to HTTPS for all resource requests.								|
	+---------------------------+-------------------------------------------------------------------------------------------------------+
	| block-all-mixed-content	| Blocks all mixed content (loading HTTP content over an HTTPS page).									|
	+---------------------------+-------------------------------------------------------------------------------------------------------+


				// ==========================================================
				// 🛡 CONTENT SECURITY POLICY (CSP) CONFIGURATION
				// ----------------------------------------------------------
				// This script generates a dynamic and organized CSP header,
				// useful for both production and development environments.
				// ==========================================================


	**Building a dynamic CSP header:**
	- Directives are built dynamically using the `buildDirective()` function,
	  which takes the defined sources and generates a valid directive in the proper
	  format for the `Content-Security-Policy` header.
	- Each directive receives a set of allowed sources (e.g., `'self'`, `https://fonts.googleapis.com/`, etc.).
	- The resulting CSP header is then sent to the browser to apply the security restrictions.

	**How to configure a CSP for your project?**
	- Define the directives required for your application.
	- Specify trusted sources for each type of resource (scripts, styles, images, etc.).
	- Build the CSP header using the `buildDirective()` function and send it via the `Content-Security-Policy` header.

	**Important:**
	- If you do not specify a directive, the default policy `'self'` is used, or it is completely blocked with `'none'`.
	- Every source you add should be carefully reviewed to ensure it is safe.
	- Do not use `unsafe-inline` or `unsafe-eval` unless absolutely necessary, as they can open the door to XSS attacks.

		- 'unsafe-eval' allows JavaScript to execute using eval(), which is
		  one of the main entry points for XSS attacks.

		- 'unsafe-inline' allows inline JavaScript scripts to execute (for example,
		  inside a <script> tag without an external file), which can be exploited
		  by attackers to inject malicious code.


	+----------------------------------------------------------------------------+
	|	EXAMPLE CONFIGURATION AND BEHAVIOR OF CSP SOURCES (style-src)           |
	+----------------------------------------------------------------------------+

	This configuration controls from where CSS stylesheets
	(`<link rel="stylesheet">`, `style`) can be loaded.

	** Behavior based on the content of $styleSrc:

		1. $styleSrc = [];
			Result: style-src 'self';
			Allows loading CSS only from the same domain.

		2. $styleSrc = [];
			$styleSrc[] = "https://fonts.googleapis.com/";
			Result: style-src 'self' https://fonts.googleapis.com/;
			Allows the own domain and Google Fonts.

		3. $styleSrc = ["'none'"];
			Result: style-src 'none';
			Blocks ALL CSS loading. Neither from the own domain nor from external ones.
			Use only if you want to completely prevent the use of styles.

		IMPORTANT:
			- The `buildDirective()` function automatically adds `'self'`
				if `$sources` contains custom URLs (but NOT if you use `'none'`).
			- Therefore, you do not need to manually write `'self'` when adding domains.
				Only add it explicitly if needed or if you disable that logic.

		This logic applies to all directives: script-src, img-src, etc.

// **********************************************************************************************************
// *********************************************************************************************************/

	// Define additional resources for each directive

		// ALLOWS loading of resources (JS scripts, styles, images, and more) from the same domain or other specified domains.
		// $defaultSrc = ["https://cdn.example.com/", "https://styles.example.com/", "http://www.w3.org/"];
		$defaultSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$defaultSrc[] = "'none'";

		// Allows loading JS scripts from the same domain or other specified domains.
		// $scriptSrc = ["https://cdn.example.com/", "https://cdnjs.cloudflare.com/", "'unsafe-eval'"];
		$scriptSrc = [];
		// Allows loading resources from "https://cdn.jsdelivr.net/".
        $scriptSrc[] = "https://cdn.jsdelivr.net/";
		// ALLOWS dynamic code evaluation. (Does NOT prevent XSS attacks)
        $scriptSrc[] = "'unsafe-eval'";
		// Allows loading resources from "https://code.jquery.com/".
//		$scriptSrc[] = "https://code.jquery.com/";

		// Allows loading CSS stylesheets from the same domain or other specified domains.
		// $styleSrc = ["https://styles.example.com/", "https://another-styles.example.com/"];
		$styleSrc = [];
		// Allows loading stylesheets for Google Fonts
//		$styleSrc[] = "https://fonts.googleapis.com/";

		// Allows loading web fonts from the same domain or other specified domains.
		// $fontSrc = ["https://fonts.example.com/", "https://another-fonts.example.com/"];
		$fontSrc = [];
		// Allows loading Google Fonts
//		$fontSrc[] = "https://fonts.googleapis.com/";

		// Allows loading images (jpg, jpeg, png, gif, etc.) from the same domain or other specified domains.
		// $imgSrc = ["https://images.example.com/", "https://another-images.example.com/", "data:"];
		$imgSrc = [];
		// Allows loading images from the specified domain (BACK-END server - access to authenticated or private images).
		$imgSrc[] = "https://" . $_DOMINIO_BACK_END . "/";
		// Add data: to the list of allowed images
		// - `data:` format for inline embedded images (base64)
		// Note: Useful for dynamically generated icons or images, but has risks if input is not properly filtered.
		$imgSrc[] = "data:";

		// Allows network connections (`fetch`, `XHR`, websockets, etc.) from the same domain or other specified domains.
		// Connectivity examples (API, WebSocket, CDN JSON, etc.)
		// $connectSrc[] = "https://api.example.com/";           // External API
		// $connectSrc[] = "wss://chat.example.com/";            // Secure WebSocket
		// $connectSrc[] = "https://json.cdnserver.com/";        // Loading data from a CDN
		$connectSrc = [];
		// Allows connection to the BACK-END.
		if ($_URL_BACK_END !== "") { $connectSrc[] = $_URL_BACK_END; }
		// Allows connection to the API.
		$connectSrc[] = $_URL_API;
		// Add Google Storage URL (for the model)
		$connectSrc[] = "https://storage.googleapis.com/";

		// Allows loading multimedia files (audio, video) from the same domain or other specified domains.
		// $mediaSrc = ["https://videos.example.com/", "https://another-videos.example.com/"];
		$mediaSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$mediaSrc[] = "'none'";

		// Allows loading embedded objects (Flash, Java, etc.) from the same domain or other specified domains.
		// $objectSrc = ["https://widgets.example.com/", "https://another-widgets.example.com/"];
		$objectSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$objectSrc[] = "'none'";

		// Allows loading content in iframes and other HTML frames (videos, maps, etc.) from the same domain or other specified domains.
		// $frameSrc = ["https://www.youtube.com/", "https://maps.google.com/"];
		$frameSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$frameSrc[] = "'none'";

		// Allows loading content in frames and iframes (similar to frame-src) from the same domain or other specified domains.
		// child-src is deprecated in many browsers, but may still be useful in some specific cases.
		// $childSrc = ["https://widgets.example.com/", "https://www.youtube.com/", "https://maps.google.com/"];
		$childSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$childSrc[] = "'none'";

		// Allows loading Web Workers and Shared Workers (required for technologies like WebAssembly, PWA, etc.) from the same domain or other specified domains.
		// $workerSrc = ["https://workers.example.com/", "https://workers.miapp.com/"];
		$workerSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$workerSrc[] = "'none'";

		// ==================================================================
		// Defines where the manifest.json file (PWA) can be loaded from.
		// Useful if your application supports installation as an App.
		// ==================================================================
		// Allows loading PWA manifest files from the same domain or other specified domains.
		// $manifestSrc = ["https://pwa.example.com/", "https://pwa.miapp.com/"];
		$manifestSrc = [];
		// DOES NOT allow loading resources from the same domain or any other domain.
		// Blocks everything by default.
		$manifestSrc[] = "'none'";

		// Defines valid sources for form submissions from the same domain or other specified domains.
		// This directive is useful to prevent **CSRF** (Cross-Site Request Forgery) attacks.
		// ========================================================================================
		//								SECURITY
		// ========================================================================================
		//	What are malicious external forms?
		//		- It occurs when an external site attempts to submit forms to your server,
		//		  possibly for spam, phishing, or even
		//		  CSRF (Cross-Site Request Forgery) attacks.
		//
		//	Example:
		//		An attacker loads your bank transfer page inside an
		//		invisible iframe. The user thinks they are clicking "like" on a cat,
		//		but they are actually clicking "Transfer money".
		// ========================================================================================
		//	- Secure default configuration:
		// 		Only allows forms submitted from your own domain
		//				$formAction = ["'self'"];
		//
		//	  	IMPORTANT NOTE:
		//			- This blocks other websites from attempting to submit
		// 			  malicious forms to your backend.
		//
		//	- Allow submission from a subdomain or external service:
		//		If you have a payment system (Bank, PayPal, etc.), embedded form, or integration
		// 		that needs to send data to your domain, you can allow it:
		//				$formAction = [];
		//				$formAction[] = "'self'";
		//				$formAction[] = "https://payments.yourbank.com";
		//				$formAction[] = "https://my-external-app.com";
		//
		//	  	IMPORTANT NOTES:
		//			- Do not include URLs you do not control or do not need. Avoid leaving the door open!
		//			- This is not the same as allowing CORS. This directive only affects form submissions,
		//			  not fetch, XHR, or AJAX.
		//
		// Allow form submissions ONLY from the same domain.
		$formAction = ["'self'"];

		// Defines which domains can embed your site via <iframe>, <frame>, <object>, etc.
		// This directive is useful to prevent clickjacking attacks.
		// ========================================================================================
		//								SECURITY
		// ========================================================================================
		//	What is clickjacking?
		//		- It is an attack where a malicious site loads your site inside a
		// 		  hidden or disguised <iframe>, so the user unknowingly clicks
		// 		  on elements of your app (such as important buttons or links).
		//
		//	Example:
		//		An attacker loads your bank transfer page inside an
		//		invisible iframe. The user thinks they are clicking "like" on a cat,
		//		but they are actually clicking "Transfer money".
		// ========================================================================================
		//	- Allows your site to be embedded only from itself.
		//	  Ideal if your application is embedded only within its own pages (e.g. SPA apps or internal systems).
		//		$frameAncestors = []; or also: $frameAncestors = ["'self'"];
		//
		//	- Allows your application to be embedded from specific domains (e.g. dashboards, authorized external portals).
		//		$frameAncestors = [];
		//		$frameAncestors[] = "https://dashboard.example.com";
		//		$frameAncestors[] = "https://clients.mycompany.com";
		$frameAncestors = [];
		// Blocks any iframe that attempts to embed your site.
		// Blocks everything by default.
		$frameAncestors[] = "'none'";

		// This directive does NOT use arrays (it is a flag) - TRUE / FALSE
		// Requests automatic upgrade from HTTP to HTTPS for all resource requests.
		// TRUE  - YES Forces HTTPS
		// FALSE - NO  Does not force HTTPS
		$upgradeInsecureRequests = TRUE;	// Forces HTTPS

		// This directive does NOT use arrays (it is a flag) - TRUE / FALSE
		// Blocks all mixed content (loading HTTP content over an HTTPS page).
		// TRUE  - YES Blocks mixed content
		// FALSE - NO  Does not block mixed content
		$blockAllMixedContent    = TRUE;	// Blocks mixed content


		// ===================================================
		//		FUNCTION TO BUILD CSP DIRECTIVES
		// ===================================================
		function buildDirective($directiveName, $sources, $addSelf = true) {
			// If it contains 'none', ignore everything else and return only 'none'
			if (in_array("'none'", $sources)) {
				return "$directiveName 'none';";
			}
		
			$sourcesString = implode(' ', $sources);
			return trim("$directiveName " . ($addSelf ? "'self' " : "") . $sourcesString) . ";";
		}


		// ===================================================
		// 		BUILD ALL CSP DIRECTIVES
		//			WITH COMPACT NAMES
		// ===================================================
		$DirDE_Src = buildDirective('default-src', $defaultSrc);	// Default source
		$DirSC_Src = buildDirective('script-src', $scriptSrc);		// JS Scripts
		$DirIM_Src = buildDirective('img-src', $imgSrc);			// Images
		$DirST_Src = buildDirective('style-src', $styleSrc);		// CSS Styles
		$DirFO_Src = buildDirective('font-src', $fontSrc);			// Web fonts
		$DirCO_Src = buildDirective('connect-src', $connectSrc);	// Network connections
		$DirME_Src  = buildDirective('media-src', $mediaSrc);		// Audio and video files
		$DirOB_Src  = buildDirective('object-src', $objectSrc);		// Embedded objects (Flash, Java, etc.)
		$DirFR_Src  = buildDirective('frame-src', $frameSrc);		// Embedded iframes (other sites)
		$DirCH_Src  = buildDirective('child-src', $childSrc);		// Resources in <frame> or <iframe>
		$DirWO_Src  = buildDirective('worker-src', $workerSrc);		// Web workers
		$DirMA_Src  = buildDirective('manifest-src', $manifestSrc);	// PWA manifest

		// Does NOT automatically include 'self'
		$DirFA_Act = buildDirective('form-action', $formAction, false);    // External forms (CSRF)
		// Does NOT automatically include 'self'
		$DirFA_Anc = buildDirective('frame-ancestors', $frameAncestors, false);// Clickjacking protection


		// ===================================================
		// 		BUILD THE FINAL CSP HEADER
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

			// Add flags if enabled
			if ($upgradeInsecureRequests) {
				$cspHeader .= " upgrade-insecure-requests;";
			}
			if ($blockAllMixedContent) {
				$cspHeader .= " block-all-mixed-content;";
			}


	// ===================================================
	//        ADD CSP REPORT ENDPOINTS
	// ===================================================
	// 1. Add report-uri (more compatible, but deprecated — still widely used)
	$cspHeader .= " report-uri https://" . $_DOMINIO_BACK_END . "/apps/logs/csp/report-csp.php;";
	// 2. Add Report-To header (more modern, not yet supported by all browsers)
	header('Report-To: {"group":"csp-endpoint","max_age":10886400,"endpoints":[{"url":"https://' . $_DOMINIO_BACK_END . '/apps/logs/csp/report-csp.php"}],"include_subdomains":true}');
	// Associate the group defined in the Report-To header
	$cspHeader .= " report-to csp-endpoint;";


	// ===================================================
	//		SEND THE CSP HEADER TO THE BROWSER
	// ===================================================
	if (_WA_ES_PRODUCCION_) {
		// If in production, activate the security policy (blocks disallowed content)
		header("Content-Security-Policy: $cspHeader");
	} else {
		// If not in production (likely in a development or test environment),
		// use "Content-Security-Policy-Report-Only" to only receive violation reports,
		// but **without blocking** any content. This allows testing the policy before enforcing it.

//		header("Content-Security-Policy-Report-Only: $cspHeader");
		header("Content-Security-Policy: $cspHeader");
	}

// error_log("FRONT-END: ".$cspHeader);

?>
<?php
	// Configure Cache-Control and Pragma headers
	// Controls how content is cached by browsers and proxies.
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");

/**************************************************************************
***********************  OUTPUT CONFIGURATION  ****************************
**************************************************************************/
	// Configure output compression (gzip)
	if (substr_count($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
		ob_start("ob_gzhandler");
	} else {
		ob_start();
	}
?>
