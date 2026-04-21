> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Instalación y Ejecución Local — Protocolo RHC  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

**Autor:** Fernando Flores Alvarado  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
**Versión:** 1.0.0

---

## Requisitos previos

Antes de ejecutar cualquier nivel del PoC, asegúrate de tener instalado:

- **PHP** 7.4 o superior
- **Servidor web local:** [Laragon](https://laragon.org/) (recomendado), XAMPP o equivalente
- **Navegador moderno** con soporte para Fetch API y AJAX
- **HTTPS habilitado localmente** (Laragon lo configura automáticamente)

> Los PoC están desarrollados en PHP (back-end) y JavaScript vanilla (front-end).  
> No requieren frameworks adicionales ni gestores de paquetes (npm, composer, etc.).

---

## 📚 Documentación del código

Todos los archivos fuente de los **Proof of Concept (PoC)** utilizan el formato **DocBlock**, basado en los estándares **PHPDoc** (para PHP) y **JSDoc** (para JavaScript).

Este formato permite documentar archivos completos, funciones, clases y constantes de forma estructurada y legible, siendo reconocido por los principales entornos de desarrollo (VS Code, PhpStorm, NetBeans) y por herramientas automáticas de generación de documentación, como **phpDocumentor** o **Doxygen**.  
Admite etiquetas especializadas como `@author`, `@version`, `@param`, `@return`, `@see`, entre otras, lo que facilita la comprensión, trazabilidad y mantenimiento del código a nivel profesional.

---

## Instalación general

1. Clona o descarga el repositorio completo dentro de tu carpeta raíz del servidor web:

   - **Laragon:** `C:/laragon/www/`
   - **XAMPP:** `C:/xampp/htdocs/`

   ```
   www/
   └── www-project-randomized-header-channel-for-csrf-protection/
       └── PoC/
           ├── level_1_basic/
           ├── level_2_intermediate/
           ├── level_3_advanced/
           └── level_4_dynamic_adaptive/
   ```

2. Inicia Laragon (o tu servidor equivalente) y asegúrate de que Apache y PHP estén activos.

3. Accede a cada nivel según las instrucciones específicas de las secciones siguientes.

---

## Niveles disponibles

| Nivel | Nombre | Descripción breve |
|-------|--------|-------------------|
| 1 | Basic | Un token CSRF distribuido entre 3 headers fijos |
| 2 | Intermediate | Entropía dual: header aleatorio + token dinámico |
| 3 | Advanced | Entropía variable en longitud, codificación y estructura |
| 4 | Dynamic Adaptive | Canal no-determinista con decoys y filtrado adaptativo |

> Cada nivel expande al anterior. Se recomienda comenzar por el Nivel 1.

---

## Nivel 1 — Basic

**Ruta:** `/PoC/level_1_basic/`

### Configuración

Edita la variable `apiURL` en `public_html/js/main.js` para que apunte a la API local:

```javascript
// Localhost
const apiURL = 'https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_1_basic/api/';

// Dominio local (Laragon)
const apiURL = 'https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_1_basic/api/';
```

### Ejecución

Abre en tu navegador:

```
https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_1_basic/public_html/
```

o con dominio local:

```
https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_1_basic/public_html/
```

Prueba usando los botones **Petición Fetch** o **Petición AJAX**.

---

## Nivel 2 — Intermediate

**Ruta:** `/PoC/level_2_intermediate/`

### Configuración

Edita `public_html/js/main.js`:

```javascript
// Localhost
const apiURL = 'https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_2_intermediate/api/';

// Dominio local
const apiURL = 'https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_2_intermediate/api/';
```

### Ejecución

Abre en tu navegador:

```
https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_2_intermediate/public_html/
```

o con dominio local:

```
https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_2_intermediate/public_html/
```

Prueba usando los botones **Petición Fetch** o **Petición AJAX**.

---

## Nivel 3 — Advanced

**Ruta:** `/PoC/level_3_advanced/`

### Configuración

Edita `public_html/js/main.js`:

```javascript
// Localhost
const apiURL = 'https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_3_advanced/api/';

// Dominio local
const apiURL = 'https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_3_advanced/api/';
```

### Ejecución

Abre en tu navegador:

```
https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_3_advanced/public_html/
```

o con dominio local:

```
https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_3_advanced/public_html/
```

Prueba usando los botones **Petición Fetch** o **Petición AJAX**.

---

## Nivel 4 — Dynamic Adaptive

**Ruta:** `/PoC/level_4_dynamic_adaptive/`

Este es el nivel más avanzado. Incluye además un **visor de entropía** integrado (Entropy Lab).

### Configuración

Edita `public_html/js/main.js`:

```javascript
// Localhost
const apiURL = 'https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_4_dynamic_adaptive/api/';

// Dominio local
const apiURL = 'https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_4_dynamic_adaptive/api/';
```

### Ejecución — Interfaz principal

Abre en tu navegador:

```
https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_4_dynamic_adaptive/public_html/
```

o con dominio local:

```
https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_4_dynamic_adaptive/public_html/
```

Prueba usando los botones **Petición Fetch** o **Petición AJAX**.


### Ejecución — Laboratorio de entropía (visor de análisis)

Abre en tu navegador:

```
https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/level_4_dynamic_adaptive/public_html/entropy/entropy_viewer.php
```

o con dominio local:

```
https://www.www-project-randomized-header-channel-for-csrf-protection.test/PoC/level_4_dynamic_adaptive/public_html/entropy/entropy_viewer.php
```

El visor muestra métricas en tiempo real del canal: distribución de headers, variabilidad de tokens, detección de anomalías y análisis de secuencias (MegaCadena).

El **Analizador de entropía RHC** (`public_html/entropy/`) corresponde a la **Fase 1** del Analizador de entropía RHC: muestra entropía Shannon por header, por token y entropía total de la solicitud actual.

> 📋 Para el alcance completo del analizador y sus fases de desarrollo, ver: [`docs/entropy-analyzer-roadmap.md`](./entropy-analyzer-roadmap.md)

---

## Observaciones de seguridad

> Estos PoC son implementaciones de referencia con fines educativos y de demostración.  
> **No están diseñados para uso en producción tal como están.**

Para entornos productivos se recomienda:

- Usar HTTPS con certificados válidos
- Implementar verificación criptográfica real de tokens (HMAC, firmas, expiración, asociación con sesión/JWT)
- Agregar cabeceras de seguridad HTTP (CSP, HSTS, X-Frame-Options, etc.)

---

## 📝 Nota técnica (aplica a todos los niveles del PoC)

# ⚠️ Nota sobre encabezados con prefijo `X-`
### (Recomendación OWASP / Entornos de producción)

Esta Proof of Concept utiliza encabezados personalizados con el prefijo **`X-`**, por ejemplo:

 - X-Server-Certified
 - X-Server-Sig
 - X-Server-Flag

Este uso es **solo demostrativo** y **no debe utilizarse en producción real**.

> Ver nota completa sobre encabezados: [`/PoC/NOTA-X-HEADERS.md`](../PoC/NOTA-X-HEADERS.md)

---

## Estructura de archivos por nivel

Todos los niveles siguen la misma arquitectura base:

```
level_N_*/
│
├── api/
│   │
│   ├── include/
│   │   ├── endpoint_protector.php      → Protección mínima contra ejecución directa o acceso no autorizado.
│   │   ├── response.php                → Estandarización uniforme de respuestas en formato JSON.
│   │   └── validator.php               → Validaciones para la configuración y encabezados para del Protocolo RHC.
│   ├── middleware/
│   │   ├── cors.php                    → Configuración de CORS (Cross-Origin Resource Sharing).
│   │   └── rhc_[nivel].php             → Middleware RHC específico por nivel.
│   │                                     Verifica y valida el Protocolo RHC (Randomized Header Channel)
│   │                                        - rhc_basic.php            - (Nivel basico)
│   │                                        - rhc_intermediate.php     - (Nivel intermedio)
│   │                                        - rhc_advanced.php         - (Nivel avanzado)
│   │                                        - rhc_dynamic_adaptive.php - (Nivel adaptativo dinámico)
│   ├── routes/
│   │   └── productos.php               → Gestiona la asignación de rutas y métodos HTTP.
│   ├── index.php                       → Punto de entrada de la API (maneja todas las peticiones)
│   └── router.php                      → Gestiona la asignación de rutas hacia los endpoints correspondientes.
│
├── back-end/
│   │
│   ├── controllers/
│   │   └── controlador_productos.php   → Controlador de productos (Capa de negocio)
│   ├── core/
│   │   └── config.php                  → Configuraciones globales del back-end
│   └── models/
│       └── modelo_productos.php        → Modelo de productos (Capa de datos)
│
├── public_html/
│   │
│   ├── css/
│   │   └── style.css                   → Hoja de estilo para el diseño de la interfaz del usuario.
│   ├── js/
│   │   ├── main.js                     → Módulo principal de la aplicacion.
│   │   ├── requests.js                 → Gestiona las peticiones y respuestas HTTP del sistema.
│   │   ├── rhc_[nivel].js              → Módulo de la lógica del protocolo RHC (cliente), por nivel.
│   │   │                                  - rhc_basic.js            - (Nivel basico)
│   │   │                                  - rhc_intermediate.js     - (Nivel intermedio)
│   │   │                                  - rhc_advanced.js         - (Nivel avanzado)
│   │   │                                  - rhc_dynamic_adaptive.js - (Nivel adaptativo dinámico)
│   │   └── ui_controls.js              → Control de la interfaz visual e interacción UI del sistema.
│   └── index.php                       → Interfaz simple para realizar solicitudes al servidor.
│
├── .htaccess                           → Protección mínima del entorno (bloquea listado de directorios y exposición de archivos).
└── README.md                           → Documento de referencia por nivel.
```

# ⚠️ Solo para Nivel 4 — Adaptativo dinámico
### Laboratorio de entropía (visor de análisis)

```text
level_4_dynamic_adaptive/
│
└── public_html/
    ├── entropy/
    │   ├── css/
    │   │   └── style.css               → Estilos visuales.
    │   ├── include/
    │   │   ├── entropy_analyzer.php    → API interna del módulo para calcular la entropía.
    │   │   └── entropy_lib.php         → Biblioteca central; implementa el cálculo matemático de entropía (Shannon).
    │   ├── js/
    │   │   ├── analyzer.js             → Lógica de análisis de tokens y fetch
    │   │   ├── chart.js                → Renderizado de Chart.js
    │   │   └── ui_control.js           → Funciones parea la Interfaz (mensajes, ocultar/mostrar elementos, etc.)
    │   ├── entropy_viewer.php          → Interfaz principal del laboratorio de entropía (Entropy Lab).
    │   └── index.php                   → Redirección automática hacia entropy_viewer.php.
    │
    └── js/
        └── entropy_analyzer.js         → Módulo interno de análisis matemático y generación de gráficas PNG para auditoría del Protocolo RHC.

```

---

## Referencias

- [Documentación general de los PoC](../PoC/README.md)
- [Arquitectura del protocolo](./architecture.md)
- [Metodología RHC](./methodology.md)
- [Repositorio OWASP](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
