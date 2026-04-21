> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Guía para Revisores OWASP — RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

Este documento está dirigido exclusivamente a los revisores de OWASP que evalúan el proyecto RHC en cuanto a su madurez, alcance y alineación con los principios de seguridad.

> Si algún término no resulta familiar, ver primero:  
> 📖 [`docs/adoption/terminology.md`](./terminology.md)

---

## Orden de revisión recomendado

Para una evaluación completa y eficiente del proyecto, se recomienda seguir este orden:

1. [`README.md`](../../README.md) — Visión general, problema que aborda y posición en la arquitectura
2. [`docs/scope-and-limitations.md`](../scope-and-limitations.md) — Alcance técnico y limitaciones conocidas
3. [`docs/adoption/threat-model.md`](./threat-model.md) — Ataques mitigados y alcance del modelo
4. [`docs/architecture.md`](../architecture.md) — Arquitectura del protocolo
5. [`docs/rhc-level-4-extensibility/formal-model.md`](../rhc-level-4-extensibility/formal-model.md) — Formalización matemática
6. [`PoC/README.md`](../../PoC/README.md) — Implementación de referencia

---

## Qué evalúa este proyecto — y qué no

### RHC aborda
- Canales de comunicación predecibles que permiten automatización, ataques de repetición y abuso a gran escala
- La ausencia de una capa de integridad del canal (CIL) en las arquitecturas de seguridad actuales
- El Flow Channel Hijacking Attack (FCHA) como clase de ataque no documentada formalmente

### RHC no aborda
- Inyección SQL
- Cross-Site Scripting (XSS)
- Lógica de autenticación
- Fallas de autorización
- Cifrado en tránsito (TLS/HTTPS)

> Para el detalle completo ver: [`docs/scope-and-limitations.md`](../scope-and-limitations.md)

---

## Alineación con principios OWASP

| Principio | Cómo lo aplica RHC |
|---|---|
| Defensa en Profundidad | Opera como capa complementaria — no reemplaza mecanismos existentes |
| Secure by Design | La entropía es estructural al protocolo, no un complemento opcional |
| Definición honesta del alcance | Las limitaciones técnicas están centralizadas y documentadas explícitamente |
| Principio de mínimo privilegio | Cada solicitud expone únicamente el header activo, no la tabla completa |

---

## Preguntas frecuentes de revisión

**¿RHC es una variante del token CSRF?**  
No. RHC opera en la Capa de Integridad del Canal (CIL), una capa diferente a la de aplicación donde viven los tokens CSRF. Ver [`README.md`](../../README.md) sección "Léase antes de evaluar".

**¿Por qué los PoC están en PHP?**  
PHP fue el lenguaje de origen del proyecto. El protocolo es agnóstico al lenguaje — la implementación de referencia demuestra el mecanismo, no prescribe la tecnología.

**¿El FCHA está reconocido formalmente?**  
Aún no. Este proyecto propone su definición y documentación formal. El envío a CAPEC (MITRE) está en preparación.

**¿Cómo se relaciona RHC con OWASP Top 10?**  
Ver [`docs/adoption/ecosystem-alignment.md`](./ecosystem-alignment.md) para el mapeo completo con marcos de seguridad.

---

## Estado del proyecto al momento de esta revisión

| Componente | Estado |
|---|---|
| Marco conceptual (FCHA / CIL) | ✅ Completo |
| Documentación en español | ✅ Completo |
| PoC Niveles 1–4 (PHP) | ✅ Funcional |
| Analizador de entropía — Fase 1 (Básico) | ✅ Publicado (integrado en Nivel 4 PoC) |
| Analizador de entropía — Fase 2 (Pro) | 🔄 En desarrollo — ver [roadmap](../entropy-analyzer-roadmap.md) |
| Middleware PSR-15 | 🔄 En desarrollo |
| Revisión comunitaria independiente | 🔜 Pendiente |
| Envío formal CAPEC (MITRE) | 🔜 En preparación |

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
