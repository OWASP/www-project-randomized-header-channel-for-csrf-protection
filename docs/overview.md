> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Visión General — OWASP Randomized Header Channel para Protección CSRF  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

Este documento es el punto de entrada al repositorio RHC Protocol Core.  
Está dirigido a cualquier lector que llegue al proyecto por primera vez.

---

## Antes de leer cualquier documento

Si algún término técnico no te resulta familiar, comienza aquí:

> 📖 [`docs/adoption/terminology.md`](./adoption/terminology.md) — Glosario de términos de seguridad utilizados en este proyecto.

---

## ¿Qué es este proyecto?

El protocolo **Randomized Header Channel (RHC)** introduce entropía dinámica controlada en el canal de comunicación HTTP, haciendo que cada flujo legítimo sea único, coherente y no clonable.

> Para la descripción completa, el problema que aborda y su posición en la arquitectura de seguridad, ver el documento principal:  
> 📄 [`README.md`](../README.md)

---

## Orden de lectura recomendado

El repositorio está organizado para leerse en capas — de lo conceptual a lo técnico.

### 1. Contexto y fundamento
Empieza aquí si quieres entender el *por qué* del protocolo antes del *cómo*:

- [`docs/adoption/terminology.md`](./adoption/terminology.md) — Glosario de términos
- [`docs/paradigm-shift.md`](./paradigm-shift.md) — Por qué los enfoques tradicionales son insuficientes
- [`docs/conceptual/marco_conceptual_rhc.md`](./conceptual/marco_conceptual_rhc.md) — Marco conceptual del protocolo

### 2. Comprensión técnica
Una vez establecido el contexto, estos documentos explican el protocolo en detalle:

- [`docs/architecture.md`](./architecture.md) — Arquitectura y modelo conceptual
- [`docs/methodology.md`](./methodology.md) — Metodología del protocolo
- [`docs/scope-and-limitations.md`](./scope-and-limitations.md) — Alcance y limitaciones técnicas

### 3. Implementación
- [`PoC/README.md`](../PoC/README.md) — Los 4 niveles del PoC y cómo ejecutarlos
- [`docs/installation.md`](./installation.md) — Guía de instalación

### 4. Modelo de amenazas e integración
- [`docs/adoption/threat-model.md`](./adoption/threat-model.md) — Ataques conocidos y alcance de mitigación
- [`docs/adoption/integration.md`](./adoption/integration.md) — Alineación con frameworks de seguridad

### 5. Para revisores OWASP
- [`docs/adoption/reviewer-guide.md`](./adoption/reviewer-guide.md) — Guía específica para revisores

---

## Referencias externas

- Flores Alvarado, F. *Randomized Header Channel: Un enfoque práctico para la mitigación de CSRF*. Medium, 2025.  
- OWASP Foundation. [CSRF Prevention Cheat Sheet](https://owasp.org/www-project-cheat-sheets/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)  
- Repositorio PoC: [OWASP RHC GitHub](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
