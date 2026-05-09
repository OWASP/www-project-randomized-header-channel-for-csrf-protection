> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Guía para Revisores OWASP — RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

Este documento está dirigido a revisores técnicos, investigadores y miembros de la comunidad OWASP que evalúan el proyecto RHC en cuanto a su alcance, arquitectura, modelo conceptual y alineación con principios modernos de seguridad.

> Si algún término no resulta familiar, ver primero:  
> 📖 [`docs/adoption/terminology.md`](./terminology.md)

---

## Qué es RHC

RHC (*Randomized Header Channel*) es un protocolo experimental de endurecimiento defensivo orientado a proteger la integridad dinámica del canal de comunicación entre cliente y servidor.

El proyecto introduce el concepto de:

- **CIL (Communication Integrity Layer)** como capa arquitectónica complementaria
- **FCHA (Flow Channel Hijacking Attack)** como clase conceptual de ataque
- Un modelo de comunicación no determinista basado en estado dinámico del canal

RHC no reemplaza mecanismos de seguridad existentes — opera como capa complementaria dentro de una estrategia de defensa en profundidad.

---

## Cómo debe evaluarse este proyecto

RHC debe evaluarse como:

- Un protocolo experimental de endurecimiento del canal de comunicación
- Una capa complementaria de integridad del flujo (CIL)
- Un mecanismo de incremento de costo operacional para ataques automatizados
- Un modelo arquitectónico de comunicación no determinista

RHC no debe evaluarse como:

- Reemplazo de TLS/HTTPS
- Reemplazo de autenticación o autorización
- Reemplazo de WAFs
- Reemplazo de validación de inputs
- Solución universal contra vulnerabilidades web

---

## Orden de revisión recomendado

Para una evaluación completa y eficiente del proyecto, se recomienda seguir este orden:

### Nivel 1 — Visión general y alcance

1. [`README.md`](../../README.md)  
   Visión general, problema que aborda y posición en la arquitectura.

2. [`docs/overview.md`](../overview.md)  
   Resumen técnico del protocolo y sus componentes.

3. [`docs/paradigm-shift.md`](../paradigm-shift.md)  
   Cambio conceptual propuesto por RHC respecto a modelos tradicionales.

4. [`docs/scope-and-limitations.md`](../scope-and-limitations.md)  
   Alcance técnico, limitaciones conocidas y declaraciones explícitas.

---

### Nivel 2 — Modelo conceptual y propiedades

5. [`docs/security-properties.md`](../security-properties.md)  
   Propiedades fundamentales, derivadas y operativas del protocolo.

6. [`docs/adoption/threat-model.md`](./threat-model.md)  
   Modelo de amenazas y superficie de ataque considerada.

7. [`docs/architecture.md`](../architecture.md)  
   Arquitectura del protocolo.

8. [`docs/cross-standard-gap-analysis.md`](../cross-standard-gap-analysis.md)  
   Análisis conceptual de brechas estructurales en estándares actuales.

---

### Nivel 3 — Formalización y extensibilidad

9. [`docs/rhc-level-4-extensibility/formal-model-overview.md`](../rhc-level-4-extensibility/formal-model-overview.md)  
   Explicación intuitiva del modelo formal.

10. [`docs/rhc-level-4-extensibility/formal-model.md`](../rhc-level-4-extensibility/formal-model.md)  
    Formalización matemática del canal.

11. [`docs/rhc-level-4-extensibility/complexity-model.md`](../rhc-level-4-extensibility/complexity-model.md)  
    Modelo de crecimiento del espacio de búsqueda del atacante (Ω).

12. [`docs/rhc-level-4-extensibility/extensibility.md`](../rhc-level-4-extensibility/extensibility.md)  
    Diseño extensible y evolución dinámica del canal.

---

### Nivel 4 — Evidencia y alineación

13. [`docs/evidence-mapping.md`](../evidence-mapping.md)  
    Relación entre evidencia empírica, propiedades FCHA y mitigaciones RHC.

14. [`docs/adoption/ecosystem-alignment.md`](./ecosystem-alignment.md)  
    Alineación conceptual con estándares y marcos de seguridad (OWASP, NIST y MITRE ATT&CK).

15. [`PoC/README.md`](../../PoC/README.md)  
    Índice y descripción general de los niveles del protocolo,

---

## Aportes principales del proyecto

El proyecto propone los siguientes aportes conceptuales y arquitectónicos:

- Introducción de la CIL (Communication Integrity Layer)
- Definición conceptual inicial del FCHA
- Modelo de canal basado en estado dinámico no determinista
- Separación conceptual entre identidad y continuidad del flujo
- Modelo extensible de endurecimiento del canal
- Formalización matemática progresiva del espacio de ataque (Ω)
- Integración conceptual con ASVS, MASVS y AIVSS

---

## Qué evalúa este proyecto — y qué no

### RHC aborda

- Canales de comunicación predecibles
- Automatización ofensiva basada en patrones repetibles
- Reproducción estructural de solicitudes
- Ausencia de integridad dinámica del canal
- Continuidad del flujo de comunicación
- Incremento del costo operacional de automatización ofensiva

### RHC no aborda

- SQL Injection
- Cross-Site Scripting (XSS)
- Vulnerabilidades de autenticación
- Vulnerabilidades de autorización
- Seguridad de lógica de negocio
- Cifrado en tránsito (TLS/HTTPS)

> Para detalles completos consultar:  
> [`docs/scope-and-limitations.md`](../scope-and-limitations.md)

---

## Alineación con principios OWASP

| Principio | Aplicación dentro de RHC |
|---|---|
| Defensa en Profundidad | Opera como capa complementaria |
| Secure by Design | La entropía es estructural al protocolo, no un complemento opcional |
| Declaración honesta del alcance | Las limitaciones están centralizadas y documentadas |
| Principio de mínimo privilegio | Solo se expone el estado necesario del canal |
| Resiliencia operacional | Incrementa el costo de automatización ofensiva |

---

## Preguntas frecuentes de revisión

### **¿RHC es una variante de CSRF tokens?**

No.  
RHC opera sobre la continuidad e integridad dinámica del canal de comunicación (CIL), no sobre validación estática de solicitudes individuales.

---

### **¿RHC reemplaza TLS?**

No.  
TLS protege confidencialidad e integridad criptográfica del transporte.  
RHC protege continuidad dinámica y comportamiento del canal.

---

### **¿Por qué los PoC están implementados en PHP?**

PHP fue el lenguaje de origen del proyecto.  
El protocolo es independiente del lenguaje y la implementación de referencia es demostrativa.

---

### **¿El FCHA existe formalmente en CAPEC o MITRE?**

Actualmente no.  
El proyecto desarrolla documentación conceptual, modelos y evidencia técnica como base para futuras propuestas de clasificación dentro del ecosistema MITRE/CAPEC.

---

### **¿Cómo se relaciona RHC con ASVS, MASVS y AIVSS?**

RHC propone una capa complementaria no formalizada explícitamente dentro de los modelos actuales de verificación.

El proyecto incluye alineaciones conceptuales con:

- OWASP ASVS
- OWASP MASVS
- OWASP AIVSS

especialmente en:
- gestión de sesión,
- resiliencia,
- robustez adversarial,
- agentic orchestration,
- y protección de canales dinámicos.

---

## Estado del proyecto al momento de esta revisión

| Componente | Estado |
|---|---|
| Marco conceptual FCHA/CIL | ✅ Completo |
| Documentación técnica principal | ✅ Completa |
| Propiedades de seguridad documentadas | ✅ Completo |
| Formalización matemática inicial | ✅ Completa |
| Modelo de complejidad Ω | ✅ Completo |
| PoC Niveles 1–4 | ✅ Funcional |
| Analizador de Entropía — Fase 1 | ✅ Publicado (integrado en Nivel 4 PoC) |
| Analizador de Entropía — Fase 2 | 🔄 En desarrollo — ver [roadmap](../entropy-analyzer-roadmap.md) |
| Middleware PSR-15 | 🔄 En desarrollo |
| Publicaciones técnicas externas | 🔄 Parcial |
| Revisión comunitaria independiente | 🔜 Pendiente |
| Evolución documental MITRE/CAPEC | 🔄 En preparación |

---

## Revisión rápida recomendada (30–45 min)

Para revisores con tiempo limitado se recomienda:

1. [`README.md`](../../README.md)
2. [`docs/paradigm-shift.md`](../paradigm-shift.md)
3. [`docs/security-properties.md`](../security-properties.md)
4. [`docs/adoption/ecosystem-alignment.md`](./ecosystem-alignment.md)
5. [`docs/rhc-level-4-extensibility/formal-model-overview.md`](../rhc-level-4-extensibility/formal-model-overview.md)

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*