> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Nivel 3 — Advanced

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

**Ruta:** `/PoC/level_3_advanced/`  
**Propósito:** Implementar entropía variable en tokens y encabezados del Protocolo RHC mediante longitudes dinámicas, codificaciones mixtas y patrones internos no lineales.

---

## 🧠 Descripción general

Este nivel es la evolución directa del **Nivel 2 — Intermediate**, que introdujo el modelo de **doble entropía** (encabezado aleatorio + token dinámico).  

En el **Nivel 3**, el Protocolo RHC incorpora **entropía variable**, modificando:  

- **Longitud del token:** 8, 16, 32, 64 o más bytes por solicitud.  
- **Codificación:** hexadecimal, Base64 o híbrida.  
- **Estructura interna:** patrones generados dinámicamente por ciclo.  

Este enfoque rompe cualquier posibilidad de **previsibilidad o correlación**, elevando la dificultad para ejecutar ataques:  

- de *token replay*  
- de correlación de patrones  
- de análisis estadístico  

---

## ⚙️ Funcionamiento

1. Se definen múltiples tokens con **longitudes y codificaciones distintas**.  
2. En cada solicitud se selecciona aleatoriamente:
   - el **encabezado activo RHC**
   - el **token de entropía variable**
3. El servidor valida el token según su patrón y tipo.  
4. La interfaz muestra el encabezado, longitud y token transmitido.  

Esto simula un canal de **entropía dinámica**, donde cada ciclo produce parámetros completamente únicos.

---

## 🔒 Seguridad mínima aplicada

Para garantizar la protección básica del entorno sin requerir configuraciones adicionales, este nivel incorpora un archivo **`.htaccess`** ubicado en el directorio raiz.  
Su propósito es **evitar el listado de archivos  de los directorios internos** que contienen lógica crítica (middleware, rutas y utilidades internas), sin afectar la ejecución del sistema en un entorno local o de demostración.

---

## ⚖️ Implementación demostrativa vs. integración en producción

> En esta PoC, así como entorno de producción, la validación del Protocolo RHC se implementa correctamente mediante el middleware:  

> `api/middleware/rhc_advanced.php`

 - El uso del middleware garantiza:
   - **separación de responsabilidades**
   - **modularidad completa**
   - **arquitectura alineada con el modelo de seguridad adaptativa del protocolo RHC**

 - En modo demostrativo, la aplicación expone los valores seleccionados (header, token) para fines educativos.
   - En producción, esta información **no debe exponerse**.

---

## 🧩 Estructura sugerida

```text
level_3_advanced/
│
├── api/
│   │
│   ├── include/
│   │   ├── endpoint_protector.php      → Protección mínima contra ejecución directa o acceso no autorizado.
│   │   ├── response.php                → Estandarización uniforme de respuestas en formato JSON.
│   │   └── validator.php               → Validaciones para la configuración y encabezados para del Protocolo RHC.
│   ├── middleware/
│   │   ├── cors.php                    → Configuración de CORS (Cross-Origin Resource Sharing).
│   │   └── rhc_advanced.php            → Verifica y valida el Protocolo RHC (Randomized Header Channel), nivel avanzado.
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
│   │   ├── rhc_advanced.js             → Módulo del Protocolo RHC (Randomized Header Channel), nivel avanzado.
│   │   └── ui_controls.js              → Control de la interfaz visual e interacción UI del sistema.
│   └── index.php                       → Interfaz simple para realizar solicitudes al servidor.
│
├── .htaccess                           → Protección mínima del entorno (bloquea listado de directorios y exposición de archivos).
└── README.md                           → Documento de referencia del nivel avanzado.
```

---

## 🔬 Objetivo técnico

- Introducir **entropía variable** en tokens y encabezados.  
- Eliminar correlaciones entre **longitud**, **codificación** o **valor** del token.  
- Incrementar la resistencia ante **ataques predictivos** y **de replay**.  
- Consolidar la base técnica para el **Nivel 4 — Dynamic Adaptive**.

---

## 🔗 Alineación con estándares de verificación OWASP (Conceptual)

Este nivel introduce entropía variable en longitud y codificación, eliminando correlaciones estáticas y elevando el costo de análisis del canal.

| Estándar | Capítulo | Relación |
|---|---|---|
| **ASVS** | V4 — API and Web Service | La variabilidad estructural del token por ciclo dificulta la correlación y automatización del consumo de la API |
| **ASVS** | V12 — Secure Communication | La entropía variable en longitud y codificación refuerza la no repetibilidad del canal sobre el transporte seguro existente |
| **MASVS** | MASVS-RESILIENCE-4 | Los patrones dinámicos del canal incrementan el costo de análisis de tráfico externo, complementando las técnicas de protección en tiempo de ejecución |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en estos estándares.

> 📄 Análisis detallado: [`/docs/adoption/ecosystem-alignment.md`](../../docs/adoption/ecosystem-alignment.md)

---

## 📌 Referencias

- Instalación y ejecución: [`/docs/installation.md`](../../docs/installation.md)
- Nota sobre prefijo `X-`: [`NOTA-X-HEADERS.md`](../NOTA-X-HEADERS.md)
- Nomenclatura: [`RHC-NS-01`](../../docs/rhc-ns-01_naming_standard.md)

---

> “Cada bit adicional de entropía es una decisión menos para un atacante.”

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
