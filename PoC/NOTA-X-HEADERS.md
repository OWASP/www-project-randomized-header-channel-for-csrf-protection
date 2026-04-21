> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# ⚠️ Nota técnica — Encabezados con prefijo `X-`  
> Esta nota aplica a **todos los niveles del PoC** del Protocolo RHC.  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## Contexto

Esta serie de Proof of Concept utiliza encabezados personalizados con el prefijo **`X-`**, por ejemplo:

- `X-Server-Certified`
- `X-Server-Sig`
- `X-Server-Flag`

Este uso es **exclusivamente demostrativo** y **no debe replicarse en producción**.

---

## ¿Por qué evitar `X-` en producción?

Según OWASP y las prácticas modernas de HTTP:

- El prefijo `X-` está **obsoleto** (deprecado desde RFC 6648).
- Algunos proxies, firewalls, CDNs o balanceadores pueden filtrarlos, ignorarlos o reescribirlos.
- No forman parte del estándar HTTP actual.
- Reducen la compatibilidad con herramientas modernas.
- Pueden provocar inconsistencias o falsos positivos en WAFs.

---

## Forma recomendada en producción

Usar nombres modernos sin el prefijo `X-`:

| PoC (demostración) | Producción (recomendado) |
|--------------------|--------------------------|
| `X-Server-Certified` | `Server-Certified` |
| `X-Server-Sig` | `Server-Signature` |
| `X-Server-Flag` | `Server-Flag` |

---

## Nota importante para el RHC

El mecanismo del RHC **no depende del prefijo**, solo del nombre del encabezado.

En el PoC se usa `X-` porque facilita la demostración, ayuda a visualizar los elementos en la UI y simplifica el aprendizaje y la depuración. En producción deben eliminarse.

---

## Recomendaciones finales para producción

- Quitar el prefijo `X-` de todos los encabezados RHC.
- Mantener una nomenclatura moderna y neutral.
- Validar valores mediante HMAC, tokens firmados o hashes no replicables.
- Nunca enviar secretos en texto plano.
- Usar HTTPS obligatorio.
- Combinar RHC con autenticación real (API Keys, JWT, etc.).

---

> 🧷 **Resumen:** Los encabezados con `X-` se usan únicamente para esta demostración.
> En producción deben sustituirse por encabezados modernos sin prefijo, como recomienda OWASP.

---

*Referencia: [RFC 6648](https://www.rfc-editor.org/rfc/rfc6648) — Deprecation of the `X-` prefix*
*Ver también: [OWASP Secure Headers Project](https://owasp.org/www-project-secure-headers/)*

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
