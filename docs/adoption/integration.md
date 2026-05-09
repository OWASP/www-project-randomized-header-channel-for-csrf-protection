> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC – Sección de Integración

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Mapeo con Frameworks de Seguridad

El protocolo **Randomized Header Channel (RHC)** es un **mecanismo de seguridad complementario**, diseñado para reducir la **predictibilidad** y el **abuso por automatización** en los canales de comunicación.

RHC **no reemplaza** mecanismos de cifrado, autenticación o autorización como **TLS**, **OAuth** o **arquitecturas Zero Trust**.
En su lugar, **añade entropía estructural** a la capa de comunicación, incrementando el **costo operativo de los ataques**.

> RHC debe posicionarse como una *capa de endurecimiento defensivo* enfocada en la imprevisibilidad del canal de comunicación.

---

## Ejemplo de implementación real — BotellaControl

**"RHC nació en el desarrollo de BotellaControl"** — un sistema de medición de contenido en contenedores translúcidos, utilizando un modelo de rotación basado en tiempo.

**Modelo de rotación implementado:**

El ciclo del canal se renueva cuando el token JWT de autenticación expira y el cliente ejecuta el proceso de refresh. Cada renovación genera un nuevo estado del canal, manteniendo la continuidad de la sesión sin interrumpir al usuario.

Este es el modelo más simple de rotación temporal — y es suficiente para activar las propiedades de seguridad fundamentales del protocolo en un entorno de producción real.

> Ver modelo de rotación completo en:  
> [`docs/adoption/terminology.md`](./terminology.md)

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
