> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# 🧰 Recursos

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

Este directorio contiene recursos prácticos y reutilizables diseñados para apoyar la implementación en el mundo real de conceptos de seguridad relacionados con el Protocolo RHC.

A diferencia de la sección PoC, que se enfoca en demostrar el protocolo en sí, los recursos proporcionados aquí están pensados para ser integrados directamente en aplicaciones.

---

## 📦 Recursos Disponibles

### 🔐 Encabezados de Seguridad (PHP)

Una implementación completa de encabezados de seguridad HTTP que incluye:

- Content Security Policy (CSP) con constructor dinámico
- HSTS, X-Frame-Options, Referrer-Policy
- Control de caché y configuraciones seguras por defecto
- Soporte para múltiples entornos (desarrollo / producción)

📁 Ubicación: `security-headers/`

---

## 🎯 Propósito

Estos recursos tienen como objetivo:

- Proporcionar implementaciones listas para producción
- Apoyar a los desarrolladores en la adopción segura
- Complementar las mejores prácticas de OWASP con código real

---

## 🔗 Relación con RHC

Mientras que RHC se enfoca en la **integridad de la comunicación**, los recursos en este directorio ayudan a establecer una **línea base segura a nivel de aplicación y navegador**.

Ambas capas están diseñadas para trabajar juntas.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
