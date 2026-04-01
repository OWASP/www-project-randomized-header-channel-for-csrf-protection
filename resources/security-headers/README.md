# 🛡️ Configuración de Encabezados de Seguridad (PHP)

Este recurso proporciona una implementación práctica, completa y orientada a producción para configurar encabezados HTTP de seguridad en aplicaciones web desarrolladas en PHP.

Incluye un enfoque dinámico y extensible para definir políticas como **Content Security Policy (CSP)**, junto con otros encabezados críticos de seguridad.

---

## 📦 Archivos incluidos

| Archivo | Idioma | Descripción |
|--------|--------|------------|
| `wa_config2_encabezados.php` | Español 🇲🇽 | Implementación completa con documentación detallada |
| `wa_config2_headers.php` | Inglés 🌐 | Implementación equivalente traducida |

Ambos archivos son idénticos en estructura y funcionalidad — únicamente cambia el idioma de la documentación.

---

## 🛡️ Encabezados de seguridad implementados

Esta implementación incluye:

- **Strict-Transport-Security (HSTS)** → Fuerza el uso de HTTPS
- **Referrer-Policy** → Control del encabezado Referer
- **X-Content-Type-Options** → Prevención de MIME sniffing
- **X-XSS-Protection: 0** — Deshabilitado explícitamente (obsoleto en navegadores modernos; la protección XSS se delega a CSP)
- **Expect-CT** → Cumplimiento de Certificate Transparency
- **X-Permitted-Cross-Domain-Policies** → Restricción de cargas cross-domain
- **X-Frame-Options: DENY** — Protección contra clickjacking
- **Content-Security-Policy (CSP)** → Generador dinámico completo de CSP con todas las directivas:
  - `default-src`, `script-src`, `style-src`, `font-src`, `img-src`
  - `connect-src`, `media-src`, `object-src`, `frame-src`, `child-src`
  - `worker-src`, `manifest-src`, `form-action`, `frame-ancestors`
  - `upgrade-insecure-requests`, `block-all-mixed-content`
  - `report-uri` y `report-to` para reporte de violaciones
- **Cache-Control / Pragma** → Prevención de cacheo de datos sensibles
- **Compresión de salida (gzip)**

---

## ⚙️ Características principales

- Construcción dinámica de CSP mediante directivas estructuradas
- Configuración adaptable a entorno (desarrollo vs producción)
- Documentación inline detallada (aprendizaje + uso práctico)
- Soporte para arquitecturas con API, backend y múltiples dominios
- Integración de reportes CSP (`report-uri` y `Report-To`)

---

## 🎯 Propósito

El objetivo de este recurso es servir como una:

> **Implementación real, reutilizable y lista para producción**

para desarrolladores que desean configurar correctamente encabezados HTTP de seguridad en entornos PHP.

Diseñado para ser:

- ✅ Educativo (explicado paso a paso)
- ✅ Práctico (listo para integrar)

---

## 🔗 Relación con Secure Headers

Este recurso complementa el proyecto OWASP Secure Headers Project proporcionando un ejemplo concreto de implementación.

- Secure Headers define **qué encabezados utilizar**
- Este recurso demuestra **cómo implementarlos correctamente en código**

---

## 🔐 Relación con RHC (Randomized Header Channel)

Esta implementación opera a nivel de:

> 🧱 **Políticas de seguridad del navegador (browser-level security)**

En contraste, el protocolo **RHC** introduce una capa adicional:

> 🔐 **Communication Integrity Layer (CIL)**

### Punto de conexión clave: `form-action` en CSP

La directiva `form-action` ayuda a mitigar ataques CSRF desde el navegador, pero tiene limitaciones importantes:

- No cubre solicitudes AJAX / fetch
- Depende completamente del navegador
- No valida la integridad del canal de comunicación

### Aquí es donde entra RHC

RHC complementa estas limitaciones mediante:

- Encabezados HTTP aleatorizados
- Validación de canal cliente-servidor
- Independencia del navegador
- Soporte para clientes no-browser

👉 En conjunto:

- **Security Headers → Definen reglas**
- **RHC → Verifica la legitimidad de la comunicación**

Son capas distintas, pero **complementarias**.

---

## 🌍 Soporte multi-idioma

La seguridad debe ser accesible.

Este recurso está disponible en español e inglés para facilitar su adopción en diferentes comunidades de desarrollo.

---

## ⚠️ Notas importantes

- La configuración de CSP debe adaptarse cuidadosamente a cada aplicación
- Evita el uso de `unsafe-inline` y `unsafe-eval` salvo que sea estrictamente necesario
- Utiliza `Content-Security-Policy-Report-Only` antes de aplicar políticas en producción

---

## ⚙️ Uso básico

1. Copia el archivo a tu proyecto (usa la versión de idioma que se ajuste a tu equipo).
2. Reemplaza `yourdomain` / `tudominio` con los valores reales de tu dominio.
3. Establece `_WA_ES_PRODUCCION_` en `TRUE` en tu entorno de producción.
4. Incluye el archivo al inicio del punto de entrada de tu aplicación, antes de cualquier salida.
5. Ajusta cada arreglo de directivas CSP según las necesidades específicas de recursos de tu aplicación.

---

## 👤 Autor y Créditos

**Fernando Flores Alvarado**  
Líder de Proyecto OWASP — [Randomized Header Channel for CSRF Protection (RHC)](https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/)

Este recurso también está listado en el **[OWASP Secure Headers Project](https://owasp.org/www-project-secure-headers/)** dentro de *Tools & Libraries*.

---

## ⚖️ Licencia

Este recurso se distribuye bajo:

- Apache License 2.0 (código)
- CC BY 4.0 (documentación)

---

## 🤝 Contribución

Puedes usar, adaptar y mejorar este recurso libremente.