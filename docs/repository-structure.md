> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Estructura del Repositorio — RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## Propósito

Este documento describe la estructura completa del repositorio RHC Protocol Core,
incluyendo la ubicación y propósito de cada archivo y carpeta.

Se mantiene como documento independiente para que el README principal permanezca
estable ante cambios en la organización interna del repositorio.

---

## 📚 Estructura del repositorio

```
www-project-randomized-header-channel-for-csrf-protection/
│
├── 🛠️ assets/                           → Recursos para el repositorio.
│   ├── images/                          → Recursos visuales (diagramas, esquemas)
│   │   ├── avance-rhc-channel-entropy-metrics-viewer.png
│   │   └── README.md
│   └── README.md
│
├── 📘 docs/                             → Documentación técnica, conceptual y referencias.
│   │
│   ├── adoption/                        → Guías de adopción, integración y alineación
│   │   ├── ecosystem-alignment.md       → Alineación con estándares y marcos de seguridad
│   │   ├── integration.md               → Enfoque de integración en sistemas existentes
│   │   ├── reviewer-guide.md            → Guía para evaluadores del proyecto
│   │   ├── threat-model.md              → Modelo de amenazas y superficie de ataque
│   │   └── terminology.md               → Definiciones y conceptos clave
│   │
│   ├── conceptual/                      → Documentación conceptual profunda
│   │   └── marco_conceptual_rhc.md
│   │
│   ├── rhc-level-4-extensibility/       → Documentación extendida del Nivel 4
│   │   ├── attack-scenarios.md             → Comportamiento del canal ante ataques (Cómo responde el canal)
│   │   ├── attack-scenarios-intuition.md   → Explicación intuitiva de escenarios
│   │   ├── complexity-model.md             → Modelo de complejidad del canal: crecimiento progresivo y no lineal del espacio de búsqueda del atacante (Ω)
│   │                                         Extensibilidad del Nivel 4: diseño abierto del canal y evolución dinámica de su complejidad
│   │   ├── extensibility.md                → Arquitectura extensible y restricciones de diseño
│   │   ├── formal-model.md                 → Formalización matemática del canal
│   │   └── formal-model-overview.md        → Versión intuitiva del modelo (lectura accesible)
│   │
│   ├── architecture.md                  → Arquitectura del sistema RHC
│   ├── breaker.md                       → Análisis de ruptura / testing de seguridad
│   ├── builder.md                       → Construcción e implementación del protocolo
│   ├── entropy-analyzer-roadmap.md      → Roadmap del Analizador de entropía RHC: Fases progresivas del análisis del canal, su comportamiento dinámico y métricas RHC.
│   ├── examples.md                      → Ejemplos HTTP oficiales de los 4 niveles del protocolo
│   ├── installation.md                  → Guía de instalación
│   ├── methodology.md                   → Fundamentos físico-matemáticos del protocolo
│   ├── overview.md                      → Vista general del protocolo
│   ├── paradigm-shift.md                → Cambio de paradigma en seguridad
│   ├── references.md                    → Fuentes teóricas y artículos citados
│   ├── repository-structure.md          → Este documento 
│   ├── rhc-ns-01_naming_standard.md     → Estándar de nombres RHC-NS-01
│   └── scope-and-limitations.md         → Alcance técnico y limitaciones conocidas
│
├── 🧪 PoC/                              → Implementaciones demostrativas del protocolo
│   ├── level_1_basic/                   → Nivel básico: tres headers y un token
│   ├── level_2_intermediate/            → Nivel intermedio: headers aleatorios y tres tokens
│   ├── level_3_advanced/                → Nivel avanzado: entropía variable por longitud
│   ├── level_4_dynamic_adaptive/        → Nivel dinámico-adaptativo: dispersión y decoys
│   └── README.md                        → Índice y descripción general de los niveles
│
├── 🧰 resources/                       → Implementaciones de seguridad listas para producción alineadas con OWASP
│   ├── security-headers/                → Implementación productiva de encabezados HTTP basada en OWASP Secure Headers
│   │   ├── wa_config2_encabezados.php   → Implementación en español
│   │   ├── wa_config2_headers.php       → Implementación en inglés
│   │   └── README.md                    → Documentación del recurso
│   └── README.md                        → Índice y descripción de recursos reutilizables
│
├── 🌐 publications/                     → Publicaciones externas y borradores
│   ├── medium/
│   │   └── article_links.md             → Enlaces a publicaciones en Medium
│   ├── devto/
│   │   └── drafts/                      → Notas o borradores para artículos en Dev.to.
│   │       └── README.md                → Índice y resumen de los borradores.
│   └── arxiv/
│       └── README.md                    → Resumen de papers y enlaces a versiones en línea.
│
├── 🧭 roadmap/                         → Plan de desarrollo y registro histórico.
│   ├── roadmap_2025.md                  → Objetivos y metas previstas para 2025.
│   └── changelog.md                     → Registro de cambios.
│
├── 📄 NOTICE                            → Atribución de autoría y origen del proyecto.
├── 📄 NOTICE.md                         → Versión extendida para GitHub.
├── ⚖️ LICENSE                           → Apache License 2.0 (código fuente).
├── ⚖️ LICENSE.md                        → Formato Markdown para GitHub.
├── 🧾 LICENSE_CC                        → Creative Commons BY 4.0 (documentación).
├── 🧾 LICENSE_CC.md                     → Versión Markdown para lectura en GitHub.
├── LICENSE_ALIGNMENT.md                 → Compatibilidad de licencias (Apache 2.0 + CC BY 4.0).
├── 🧩 VERSION                          → Datos técnicos de versión actual.
├── 🧩 VERSION.md                       → Versión Markdown con metadatos adicionales.
└── ⚙️ .gitignore                       → Exclusión de archivos locales o temporales.
```

---

## Notas de organización

**docs/rhc-level-4-extensibility/** es la carpeta que contiene la documentación extendida
del Nivel 4 del protocolo. Sus tres archivos son complementarios y se referencian entre sí —
se recomienda comenzar por `extensibility.md`.

**docs/adoption/** contiene los documentos orientados a revisores externos, evaluadores OWASP
e implementadores que necesitan entender cómo integrar el protocolo en sistemas existentes.

**PoC/** contiene implementaciones funcionales en PHP organizadas como progresión pedagógica.
Cada nivel es la evolución del anterior — no son independientes entre sí.

**resources/** contiene implementaciones de seguridad listas para producción,
diseñadas para integrarse directamente en aplicaciones reales y alineadas con
buenas prácticas reconocidas por OWASP.

A diferencia de los PoC, que demuestran el funcionamiento del protocolo RHC,
los recursos en este directorio representan capas de seguridad aplicables en
entornos productivos, enfocadas en fortalecer la configuración del cliente,
navegador y servidor.

Estos componentes funcionan como una **Security Implementation Layer (SIL)** complementaria a RHC,
permitiendo establecer una base sólida de seguridad sobre la cual el protocolo opera.

Algunos recursos han sido referenciados dentro del ecosistema OWASP,
reforzando su utilidad práctica y alineación con estándares del sector.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*