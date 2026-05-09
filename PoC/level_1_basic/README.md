> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Nivel 1 — Basic

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

**Ruta:** `/PoC/level_1_basic/`  
**Propósito:** Implementar la base funcional del protocolo RHC con una estructura mínima y determinista.

---

## 🧠 Descripción general

Este nivel establece la estructura más simple del protocolo **Randomized Header Channel (RHC)**.  
Su objetivo es demostrar cómo **un solo token CSRF** puede distribuirse aleatoriamente entre **tres encabezados personalizados**, rompiendo parcialmente la previsibilidad del tráfico.

---

## ⚙️ Funcionamiento

1. Se definen **tres encabezados** en el cliente (por ejemplo: `X-CSRF-A`, `X-CSRF-B`, `X-CSRF-C`).  
2. Solo **uno de ellos** se elige aleatoriamente para transportar el token en cada solicitud.  
3. El servidor valida la existencia del token dentro del encabezado activo y responde según la verificación.

Este enfoque reduce la probabilidad de éxito en ataques CSRF automatizados al eliminar la consistencia de canal.

---

## 🔒 Seguridad mínima aplicada

Para garantizar la protección básica del entorno sin requerir configuraciones adicionales, este nivel incorpora un archivo **`.htaccess`** ubicado en el directorio raiz.  
Su propósito es **evitar el listado de archivos de los directorios internos** que contienen lógica crítica (middleware, rutas y utilidades internas), sin afectar la ejecución del sistema en un entorno local o de demostración.

---

## ⚖️ Implementación demostrativa vs. integración en producción

> En esta PoC, así como entorno de producción, la validación del Protocolo RHC se implementa correctamente mediante el middleware:  

> `api/middleware/rhc_basic.php`

 - El uso del middleware garantiza:
   - **separación de responsabilidades**
   - **modularidad completa**
   - **arquitectura alineada con el modelo de seguridad adaptativa del protocolo RHC**

 - En modo demostrativo, la aplicación expone los valores seleccionados (header, token) para aprendizaje.
   - En producción, esta información **no debe exponerse**.

---

## 🧩 Estructura sugerida

```text
level_1_basic/
│
├── api/
│   │
│   ├── include/
│   │   ├── endpoint_protector.php      → Protección mínima contra ejecución directa o acceso no autorizado.
│   │   ├── response.php                → Estandarización uniforme de respuestas en formato JSON.
│   │   └── validator.php               → Validaciones para la configuración y encabezados para del Protocolo RHC.
│   ├── middleware/
│   │   ├── cors.php                    → Configuración de CORS (Cross-Origin Resource Sharing).
│   │   └── rhc_basic.php               → Verifica y valida el Protocolo RHC (Randomized Header Channel), nivel basico.
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
│   │   ├── rhc_basic.js                → Módulo del Protocolo RHC (Randomized Header Channel), nivel basico.
│   │   └── ui_controls.js              → Control de la interfaz visual e interacción UI del sistema.
│   └── index.php                       → Interfaz simple para realizar solicitudes al servidor.
│
├── .htaccess                           → Protección mínima del entorno (bloquea listado de directorios y exposición de archivos).
└── README.md                           → Documento de referencia del nivel básico.
```

---

## 🔬 Objetivo técnico

- Introducir la **dispersión aleatoria** de encabezados como mecanismo de protección.
- Validar compatibilidad con autenticación basada en JWT o sesiones tradicionales.
- Servir como **base conceptual y técnica** para los niveles superiores.

---

## 🔗 Alineación con estándares de verificación OWASP (Conceptual)

Este nivel introduce la dispersión aleatoria de encabezados como primera capa de variabilidad en el canal de comunicación.

| Estándar | Capítulo | Relación |
|---|---|---|
| **ASVS** | V7 — Session Management | La dispersión aleatoria del token entre encabezados complementa los controles de sesión al introducir variabilidad en el canal |
| **ASVS** | V12 — Secure Communication | RHC opera sobre el canal de comunicación existente añadiendo entropía inicial al flujo |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en estos estándares.

> 📄 Análisis detallado: [`/docs/adoption/ecosystem-alignment.md`](../../docs/adoption/ecosystem-alignment.md)

---

## 📌 Referencias

- Instalación y ejecución: [`/docs/installation.md`](../../docs/installation.md)
- Nota sobre prefijo `X-`: [`NOTA-X-HEADERS.md`](../NOTA-X-HEADERS.md)
- Nomenclatura: [`RHC-NS-01`](../../docs/rhc-ns-01_naming_standard.md)

---

> “El orden comienza cuando el caos aprende a repetirse de forma diferente cada vez.”

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
