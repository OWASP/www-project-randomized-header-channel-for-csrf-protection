> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Alcance y Limitaciones — RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

Este documento centraliza la definición formal del alcance de aplicación del protocolo RHC y sus limitaciones técnicas conocidas. Toda referencia a limitaciones en otros documentos del repositorio apunta a este archivo como fuente única de verdad.

---

## 1. Alcance de aplicación

El protocolo RHC está diseñado para operar en flujos de comunicación donde el cliente tiene capacidad de establecer **headers HTTP personalizados** de forma programática.

Los entornos compatibles incluyen:

- Aplicaciones de una sola página (SPA) que utilizan `fetch` o `XMLHttpRequest`
- Aplicaciones móviles que consumen APIs REST o GraphQL
- Microservicios y arquitecturas distribuidas con comunicación servidor a servidor
- Entornos CI/CD, webhooks y sistemas orientados a eventos
- Cualquier cliente HTTP con control programático sobre los headers de la solicitud

---

## 2. Limitación técnica — Compatibilidad con formularios HTML

### Descripción

Los envíos de formularios HTML estándar (`<form method="POST">`) realizados por el navegador **no permiten establecer headers HTTP personalizados**. Esta restricción es inherente al modelo de transporte HTTP y al comportamiento nativo del navegador, y no constituye una deficiencia del protocolo RHC sino una delimitación explícita de su dominio de aplicación.

En consecuencia, **RHC no aplica a flujos de solicitud iniciados mediante formularios HTML nativos**.

### Impacto en el alcance

| Tipo de solicitud | Compatible con RHC |
|---|---|
| `fetch` / `XMLHttpRequest` (AJAX) | ✅ Sí |
| Aplicaciones móviles (HTTP client) | ✅ Sí |
| Comunicación servidor a servidor | ✅ Sí |
| Envío nativo de `<form>` HTML | ❌ No |
| Redirecciones HTTP del navegador | ❌ No |

### Recomendación para implementadores

Las aplicaciones que combinen flujos JavaScript/AJAX con formularios HTML tradicionales deben implementar mecanismos complementarios de protección CSRF para los flujos basados en formularios, tales como los descritos en el [OWASP CSRF Prevention Cheat Sheet](https://owasp.org/www-project-cheat-sheets/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html).

RHC y los mecanismos tradicionales de protección CSRF (tokens en campos ocultos, cookies con atributo `SameSite`) son **complementarios y pueden coexistir** en la misma aplicación.

---

## 3. Limitaciones adicionales conocidas

### 3.1 Dependencia de JavaScript en el cliente

RHC requiere que el cliente ejecute lógica JavaScript para seleccionar el slot aleatorio y construir la solicitud con el header correcto. Entornos que deshabiliten JavaScript o que dependan de renderizado del lado del servidor sin capa de cliente no son compatibles en su configuración base.

### 3.2 Configuración de CORS

El uso de headers personalizados activa las solicitudes de preflight CORS (`OPTIONS`). El servidor debe estar correctamente configurado para exponer y aceptar los headers RHC en su política CORS. Una configuración incorrecta puede bloquear solicitudes legítimas. Consultar [`/PoC/NOTA-X-HEADERS.md`](../PoC/NOTA-X-HEADERS.md) para orientación específica.

### 3.3 Proxies y gateways intermedios

Algunos proxies, balanceadores de carga o API gateways pueden filtrar o modificar headers HTTP no estándar. Se recomienda validar la transparencia del canal en el entorno de despliegue objetivo antes de implementar RHC en producción.

---

## 4. Fuera del alcance del protocolo

RHC no tiene como objetivo reemplazar ni sustituir los siguientes mecanismos de seguridad:

- Cifrado en tránsito (TLS/HTTPS)
- Autenticación y gestión de sesiones
- Autorización y control de acceso
- Protección contra inyección (XSS, SQLi, etc.)
- Mecanismos de autenticación multifactor (MFA)

RHC opera en la **Capa de Integridad de la Comunicación (CIL)** como mecanismo de endurecimiento defensivo complementario, incrementando el costo operativo de los ataques sin reemplazar las capas de seguridad fundamentales.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
