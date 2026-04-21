> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# 🧾 Registro de Cambios — RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## 📘 Convención de versiones

Este documento sigue la convención **SemVer (Semantic Versioning)** en el formato:

- **MAJOR (versión mayor):** cambios que alteran la estructura o rompen compatibilidad.  
- **MINOR (versión menor):** nuevas funciones o mejoras compatibles.  
- **PATCH (parche):** correcciones o documentación menor.  

---

## 🧩 v1.0.0 — Origin Entropy *(Noviembre 2025)*

**Estado:** ✅ Completada

### Cambios principales:
- 🧠 Creación de la estructura base del repositorio (`RHC_Protocol_Core/`).
- 📘 Documentación técnica principal:
  - `README.md` — Descripción general, licencias y estructura.
  - `methodology.md` — Fundamento técnico del protocolo.
  - `LICENSE_ALIGNMENT.md` — Compatibilidad dual de licencias.
  - `references.md` — Fuentes teóricas y de publicación.
- ⚖️ Inclusión de licencias:
  - `LICENSE` — Apache License 2.0 (código y PoC).
  - `LICENSE_CC.md` — Creative Commons BY 4.0 (documentación).
- 📄 Creación de archivos de atribución y control:
  - `NOTICE` — Autoría y origen del proyecto.
  - `VERSION` — Detalle técnico y simbólico de la versión.
  - `.gitignore` — Exclusión de archivos locales.
- 🧪 Estructura inicial del PoC:
  - Nivel 1: Básico.
  - Nivel 2: Intermedio.
  - Nivel 3: Avanzado.
  - Nivel 4: Dinámico–Adaptativo.
- 🧭 Adición de `roadmap_2025.md` y `changelog.md`.

### Descripción:
Versión fundacional del **RHC Protocol Core**, estableciendo los cimientos conceptuales del  
modelo de dispersión aleatoria y entropía controlada (*Controlled Chaos*).

> “Origin Entropy marca el punto cero donde el caos se convierte en estructura.”  
> — *Fernando Flores Alvarado*

---

## 🧩 v1.1.0 — Controlled Expansion *(Q1 2026)*

**Estado:** ✅ Completada — Abril 2026

### Cambios realizados:

#### 🧪 PoC funcionales por nivel
- Implementación completa y validada de los 4 niveles del protocolo en PHP + JavaScript vanilla.
- Cada nivel documentado con su propio `README.md` incluyendo estructura, flujo y descripción técnica.
- Validación de comportamiento en entorno local (Laragon, Apache, HTTPS).
- Correcciones de comportamiento en validadores por nivel (enero–marzo 2026).

#### 📘 Documentación técnica expandida
- `docs/architecture.md` — Arquitectura del sistema y modelo de entropía.
- `docs/overview.md` — Vista general y orden de lectura recomendado.
- `docs/paradigm-shift.md` — Cambio de paradigma en seguridad de comunicaciones.
- `docs/scope-and-limitations.md` — Alcance técnico y limitaciones explícitas del protocolo.
- `docs/builder.md` y `docs/breaker.md` — Guías de construcción y análisis de ruptura.
- `docs/installation.md` — Guía de instalación local completa para los 4 niveles.
- `docs/rhc-ns-01_naming_standard.md` — Estándar de nombres RHC-NS-01.
- `docs/repository-structure.md` — Mapa completo del repositorio.

#### 🧠 Documentación conceptual y formal del Nivel 4
- `docs/conceptual/marco_conceptual_rhc.md` — Marco conceptual expandido.
- `docs/rhc-level-4-extensibility/extensibility.md` — Arquitectura extensible del Nivel 4.
- `docs/rhc-level-4-extensibility/formal-model.md` — Formalización matemática del canal.
- `docs/rhc-level-4-extensibility/formal-model-overview.md` — Versión intuitiva con ejemplos visuales.
- `docs/rhc-level-4-extensibility/attack-scenarios.md` — Análisis de 5 clases de ataque.
- `docs/rhc-level-4-extensibility/attack-scenarios-intuition.md` — Versión intuitiva de escenarios.

#### 🛡️ Adopción y alineación con estándares
- `docs/adoption/terminology.md` — Glosario de términos de seguridad (OWASP, NIST, MITRE, HMAC, WAF, Ω).
- `docs/adoption/threat-model.md` — Modelo de amenazas y superficie de ataque.
- `docs/adoption/integration.md` — Alineación con frameworks de seguridad existentes.
- `docs/adoption/ecosystem-alignment.md` — Posición del protocolo en el ecosistema de seguridad.
- `docs/adoption/reviewer-guide.md` — Guía específica para revisores OWASP.

#### 📦 Ejemplos y recursos
- `docs/examples.md` — Ejemplos HTTP oficiales de los 4 niveles del protocolo.
- `resources/security-headers/wa_config2_headers.php` — Implementación de seguridad HTTP alineada con OWASP Secure Headers Project (inglés).
- `resources/security-headers/wa_config2_encabezados.php` — Versión en español.
- `resources/security-headers/README.md` — Documentación del recurso.

#### 🖼️ Assets
- `assets/images/avance-rhc-channel-entropy-metrics-viewer.png` — Captura del visor de entropía.
- `assets/images/README.md` y `assets/README.md` — Documentación de recursos visuales.

#### 📰 Publicaciones
- Artículos publicados en Medium: ver `publications/medium/article_links.md`.
- Borrador arXiv registrado: ver `publications/arxiv/README.md`.
- Borradores Dev.to en preparación: ver `publications/devto/drafts/README.md`.

#### 🔗 Integración OWASP
- Proyecto aceptado en OWASP Foundation — Incubator Stage (ID: NFRSD-6904).
- Repositorio oficial compartido: `github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection`.
- Contacto establecido con OWASP Secure Headers Project (Dominique Righetto).
- Contacto establecido con OWASP Agentic AI Top 10 (Steve Wilson).
- Coordinación con OWASP Mexico City Chapter.

### Descripción:
Esta versión consolida el protocolo como un proyecto de investigación documentado, funcional y alineado con estándares OWASP. El repositorio pasa de estructura inicial a proyecto listo para revisión técnica oficial.

---

## 🧩 v2.0.0 — Distributed Flow *(Planeada: Q4 2026)*

**Estado:** 📋 Planeada  

### Cambios previstos:
- Modularización del protocolo RHC.
- Incorporación de autenticación servidor-servidor (ServerAuth Flow).
- Expansión hacia defensa distribuida en entornos Zero Trust.
- Refactorización de PoC para interoperabilidad y escalabilidad.
- Inclusión de benchmarks de rendimiento y validación técnica.

---

## 🧩 v2.5.0 — Research & Academic Integration *(Planeada: 2027)*

**Estado:** 📋 Planeada  

### Cambios previstos:
- Publicación de paper técnico en *arXiv* y medios académicos.
- Validación por comunidad OWASP y expertos en ciberseguridad.
- Ampliación del enfoque hacia IA y Machine Learning aplicado a predicción de patrones.
- Difusión en conferencias (OWASP Summit, GDG, DEFCON).

---

## 🧩 v3.0.0 — Controlled Chaos Framework *(Planeada: 2028+)*

**Estado:** 🔭 Fase conceptual  

### Cambios previstos:
- Unificación de todas las capas del protocolo bajo el *Controlled Chaos Framework*.
- Extensión del modelo a nuevas áreas: detección de anomalías, defensa adaptativa predictiva y autoorganización de tráfico seguro.
- Creación de comunidad abierta de desarrollo y contribución técnica.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
