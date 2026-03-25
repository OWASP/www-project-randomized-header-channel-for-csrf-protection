# RHC Protocol Core

**Autor:** Fernando Flores Alvarado  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
**Colaboración inicial:** OWASP Project – Randomized Header Channel for CSRF Protection  
**Estado:** Repositorio base independiente  
**Versión:** 1.0.0 (2025)  
**Codename:** Origin Entropy  

---

## 🧠 Visión general

**RHC Protocol Core** define los principios fundamentales del *Randomized Header Channel (RHC)* —  
una metodología de seguridad basada en la **dispersión de encabezados** y el **caos controlado** como forma de defensa estructurada ante ataques de tipo **CSRF**, **inyección**, y **repetición automatizada**.

El protocolo representa una evolución conceptual en ciberseguridad,  
fusionando los principios físicos de la **entropía** y el **orden dentro del desorden**,  
con un enfoque práctico aplicable a arquitecturas modernas **stateless**, **JWT-based** y **Zero Trust**.

> “El caos controlado es la forma más pura de defensa digital.” — *Fernando Flores Alvarado*

---

## 🌱 Origen del proyecto

Este proyecto nació en mi lengua madre, el español.

Como autor, desarrollador e investigador, la concepción original,
la documentación y la evolución del protocolo RHC fueron pensadas
y construidas en español como lenguaje base.

Este origen no es casual.

Es parte de una identidad.
Y de un propósito.

Desde una convicción personal, y como instrumento guiado hacia la creación
y el conocimiento, este proyecto surge como una forma de aportar,
compartir y construir valor desde su origen hacia el mundo,
bajo una filosofía de responsabilidad en la forma de compartir conocimiento.

---

## 🧠 Fundamento conceptual

RHC se basa en un **cambio de paradigma** en la forma en que se protegen los
canales de comunicación en sistemas modernos, distribuidos y automatizados.

En lugar de asumir que la seguridad se resuelve únicamente en los extremos
(identidades, tokens o endpoints), RHC introduce el concepto de **integridad
dinámica del canal de comunicación**, enfocándose en el comportamiento del flujo
a lo largo del tiempo.

Este enfoque aborda una superficie de ataque emergente en arquitecturas
clásicas, modernas y asistidas por IA, donde la validación de identidad no es
suficiente para garantizar la coherencia, continuidad y legitimidad de una
comunicación.

📄 **Lectura recomendada:**
- [Cambio de paradigma — Seguridad de las comunicaciones en sistemas modernos](./docs/paradigm-shift.md)

---

## 🎯 Objetivos

- Definir la **arquitectura núcleo** del Protocolo RHC (aleatoriedad, autenticación y entropía controlada).  
- Documentar la metodología **Controlled Chaos** como modelo de defensa adaptable.  
- Preservar la **autenticidad intelectual y trazabilidad** de la invención original.  
- Establecer una base formal para **investigación y publicaciones académicas**.  
- Facilitar la integración en proyectos **OWASP** y ecosistemas abiertos de seguridad.  

---

## 🔬 Fundamento técnico

El protocolo RHC se sustenta en la idea de que **la previsibilidad es la raíz de la vulnerabilidad**.  
Por tanto, su estructura introduce **niveles de entropía dinámica** en los encabezados de cada solicitud,  
rompiendo patrones estáticos sin perder coherencia ni trazabilidad.

Cada nivel del protocolo (del básico al dinámico–adaptativo) representa una capa superior de  
**complejidad matemática y adaptación contextual**, reflejando los principios de:

- **Entropía estructurada:** orden funcional dentro del desorden aparente.  
- **Dispersión controlada:** separación lógica de tokens y encabezados por ciclo de autenticación.  
- **Evolución adaptativa:** respuesta contextual ante el entorno de ejecución y carga del sistema.  

> “Lo que no se puede identificar, no se puede rastrear.”  
> — *Concepto base de la identidad digital dinámica.*

---

## 🔬 Avance del Analizador RHC

![Avance del analizador RHC](assets/images/avance-rhc-channel-entropy-metrics-viewer.png)

*Avance del analizador RHC: visualización de métricas de entropía y coherencia del canal a lo largo de una secuencia de solicitudes.  
La herramienta permite observar patrones, rupturas y variabilidad contextual entre headers y tokens.*

---

## 🧩 Relación con OWASP

El proyecto **OWASP Randomized Header Channel for CSRF Protection**  
representa la aplicación práctica del núcleo RHC a la mitigación de ataques CSRF.  
Este repositorio, en cambio, documenta el **núcleo independiente y conceptual** del protocolo, así como sus posibles extensiones hacia autenticación distribuida y defensas adaptativas.

> **OWASP Project Page:**  
> [https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/](https://owasp.org/www-project-randomized-header-channel-for-csrf-protection/)

> **OWASP GitHub Repo:**  
> [https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)

> **Personal Fork (referencia):**  
> [https://github.com/Fer0306/www-project-randomized-header-channel-for-csrf-protection](https://github.com/Fer0306/www-project-randomized-header-channel-for-csrf-protection)

---

## 📚 Estructura del repositorio

```
RHC_Protocol_Core/
│
├── 🛠️ assets/                       → Recursos para el repositorio.
│   ├── images/                       → Recursos visuales (diagramas, logotipos, esquemas).
│   │   ├── avance-rhc-channel-entropy-metrics-viewer.png
│   │   └── README.md                 → Descripción de los recursos de images.
│   └── README.md                     → Descripción de los recursos.
│
├── 📘 docs/                          → Documentación técnica, conceptual y referencias.
│   │
│   ├── adoption/                     → Guías de adopción, integración y alineación.
│   │   ├── ecosystem-alignment.md    → Alineación del RHC con estándares y marcos de seguridad.
│   │   ├── integration.md            → Enfoque de integración del protocolo en sistemas existentes.
│   │   ├── reviewer-guide.md         → Guía para evaluadores del proyecto RHC.
│   │   ├── threat-model.md           → Modelo de amenazas y superficie de ataque.
│   │   └── terminology.md            → Definiciones y conceptos clave utilizados.
│   │
│   ├── conceptual/                   → Documentación conceptual profunda.
│   │   └── marco_conceptual_rhc.md
│   │
│   ├── methodology.md                → Fundamentos físico–matemáticos del protocolo.
│   ├── overview.md                   → Vista general del protocolo.
│   ├── architecture.md               → Arquitectura del sistema RHC.
│   ├── paradigm-shift.md             → Cambio de paradigma en seguridad.
│   ├── installation.md               → Guía de instalación.
│   ├── builder.md                    → Construcción e implementación del protocolo.
│   ├── breaker.md                    → Análisis de ruptura / testing de seguridad.
│   ├── references.md                 → Fuentes teóricas y artículos citados.
│   └── rhc-ns-01_naming_standard.md  → Estándar de nombres y convenciones internas del protocolo RHC (RHC-NS-01).
│
├── 🧪 PoC/                           → Implementaciones demostrativas del protocolo RHC.
│   ├── level_1_basic/                → Nivel básico: tres encabezados y un token.
│   ├── level_2_intermediate/         → Nivel intermedio: tres encabezados aleatorios y tres tokens.
│   ├── level_3_advanced/             → Nivel avanzado: entropía variable por longitud y forma.
│   ├── level_4_dynamic_adaptive/     → Nivel dinámico–adaptativo: dispersión inteligente y decoys.
│   └── README.md                     → Índice y descripción general de los niveles PoC.
│
├── 🌐 publications/                  → Publicaciones externas y borradores.
│   ├── medium/
│   │   └── article_links.md          → Enlaces a publicaciones en Medium.
│   ├── devto/
│   │   └── drafts/                   → Notas o borradores para artículos en Dev.to.
│   │       └── README.md             → Índice y resumen de los borradores.
│   └── arxiv/
│       └── README.md                 → Resumen de papers y enlaces a versiones en línea.
│
├── 🧭 roadmap/                       → Plan de desarrollo y registro histórico.
│   ├── roadmap_2025.md               → Objetivos y metas previstas para 2025.
│   └── changelog.md                  → Registro de cambios en español.
│
├── 📄 NOTICE                         → Atribución de autoría y origen del proyecto.
├── 📄 NOTICE.md                      → Versión extendida para GitHub.
├── ⚖️ LICENSE                        → Apache License 2.0 (código fuente).
├── ⚖️ LICENSE.md                     → Formato Markdown para GitHub.
├── 🧾 LICENSE_CC                     → Creative Commons BY 4.0 (documentación).
├── 🧾 LICENSE_CC.md                  → Versión Markdown para lectura en GitHub.
├── LICENSE_ALIGNMENT.md          → Compatibilidad de licencias (Apache 2.0 + CC BY 4.0).
├── 🧩 VERSION                        → Datos técnicos de versión actual.
├── 🧩 VERSION.md                     → Versión Markdown con metadatos adicionales.
└── ⚙️ .gitignore                     → Exclusión de archivos locales o temporales.
```

---

## 🚀 Estado actual del proyecto

- Fase: **Estructura y documentación completa.**  
- Integración futura con OWASP: alineación metodológica y revisión de seguridad.

---

## 📘 Referencias externas

- [Medium – Advanced CSRF Mitigation Strategy: Randomized Header Channel using Pattern Dispersion](https://medium.com/@fernandofa0306/advanced-csrf-mitigation-strategy-randomized-header-channel-using-pattern-dispersion-20d54b1d4c6e)  
- [Medium – Controlled Chaos: Multi-Layered CSRF Defense Using Dynamic Header Dispersion](https://medium.com/@fernandofa0306/controlled-chaos-multi-layered-csrf-defense-using-dynamic-header-dispersion-a14926288207)  
- [GitHub – OWASP *www-project-randomized-header-channel-for-csrf-protection*](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)

---

## 🧭 Filosofía y propósito

> “Compartir con responsabilidad es inspirar para construir el futuro.”  
>  
> Este proyecto nace bajo la convicción de que la seguridad no debe ser una barrera,  
> sino una forma de evolución consciente entre el orden y el caos.  
> RHC Protocol Core busca trascender la técnica y convertirse en una arquitectura  
> que combine propósito, precisión y humanidad.

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo licencias duales: *Apache 2.0 (código)* y *CC BY 4.0 (documentación)*.

---

## 🧾 Licencias

Este proyecto utiliza un esquema de licencias dual:

- **Código y PoC:** [Apache License 2.0](./LICENSE.md)  
  Permite uso, modificación y distribución, siempre manteniendo la atribución al autor original.

- **Documentación, textos y diagramas:** [Creative Commons BY 4.0](./LICENSE_CC.md)  
  Permite compartir y adaptar el contenido, dando crédito al autor.

> 📸 Las imágenes, diagramas y logotipos incluidos en la carpeta [`/assets/images/`](./assets/images/)  
> forman parte del material documental y están cubiertos por la licencia **Creative Commons BY 4.0**.  
> Su reutilización requiere atribución explícita a *Fernando Flores Alvarado*.

---

## 🧠 Explicación del Modelo de Licenciamiento

RHC Protocol Core utiliza un modelo de licenciamiento dual diseñado para equilibrar la **adopción abierta**, la **atribución del autor** y las **restricciones de seguridad del mundo real**.

### 🔓 Implementación Abierta (Código)

El código y las Pruebas de Concepto (PoC) se publican bajo la **Licencia Apache 2.0**, lo que permite:

- Uso libre en entornos comerciales y no comerciales  
- Modificación interna y personalización  
- Integración en sistemas privados o sensibles sin necesidad de divulgación  

Esto permite que organizaciones como instituciones financieras, entidades gubernamentales, sistemas de salud o empresariales, adopten RHC **sin exponer sus arquitecturas internas ni sus configuraciones de seguridad**.

---

### 📘 Conocimiento Abierto (Documentación)

Toda la documentación, metodología y materiales conceptuales se publican bajo **Creative Commons BY 4.0**, lo que requiere:

- Atribución adecuada al autor original  
- Reconocimiento del origen del concepto RHC  

Esto garantiza que, aunque las implementaciones puedan variar y mantenerse privadas,  
el **origen intelectual del protocolo permanezca rastreable y preservado**.

---

### 🛡️ Filosofía de Diseño

Este modelo de licenciamiento refleja un principio central de RHC:

> Las implementaciones de seguridad deben permanecer adaptables y confidenciales,  
> mientras que el conocimiento y la innovación deben permanecer abiertos y compartidos.

Cada organización puede:

- Implementar RHC de manera diferente  
- Definir sus propias estructuras de encabezados
- Diseñar sus propios modelos de entropía
- Evolucionar el protocolo internamente  

Sin requerir que el autor acceda o incluso conozca sus sistemas internos.

---

### 🌍 Por qué esto es importante

Este enfoque permite:

- Adopción segura en **entornos de alta seguridad y/o sensibilidad**  
- Protección de la **confidencialidad institucional**  
- Escalabilidad global del concepto RHC  
- **Atribución clara y permanente del autor**  

---

> “RHC se adapta a cada sistema, pero su origen permanece igual.”  
> — Fernando Flores Alvarado

---

## 🏢 Para Empresas / Instituciones

RHC Protocol Core está diseñado para ser adoptado en **entornos del mundo real** donde la seguridad, la confidencialidad y la escalabilidad son críticas.

### 🔐 Sin Necesidad de Exposición

Las organizaciones pueden implementar RHC sin necesidad de:

- Compartir su arquitectura interna  
- Exponer configuraciones de seguridad  
- Proporcionar acceso a sistemas propietarios  

RHC está diseñado para ser **auto-integrado**, lo que significa que cada institución lo adapta internamente según su propia infraestructura.

---

### ⚙️ Implementación Flexible

Cada organización puede:

- Definir sus propias estructuras de encabezado  
- Personalizar estrategias de entropía  
- Seleccionar el nivel de implementación adecuado (Básico → Adaptativo)  
- Evolucionar el modelo internamente con el tiempo  

Esto asegura compatibilidad con:

- Sistemas financieros  
- Plataformas gubernamentales  
- Infraestructuras de salud  
- Aplicaciones empresariales  

---

### 🛡️ Seguridad por Diseño

RHC introduce protección a nivel de **comunicación**, lo que lo hace:

- Resistente a ataques basados en patrones  
- No replicable entre entornos distintos
- Consciente del contexto y adaptable **(Adaptativo al contexto de ejecución)**

Incluso si dos instituciones implementan RHC, su comportamiento puede ser completamente diferente.

---

### 🤝 Atribución sin Riesgo

El modelo de licenciamiento garantiza:

- Reconocimiento del autor original  
- Libertad de implementación interna  
- Sin obligación de divulgar o exponer adaptaciones sensibles  

Esto permite a las organizaciones adoptar RHC con confianza,  
preservando tanto la **integridad de la seguridad** como la **atribución intelectual**.

---

> RHC no es una implementación fija —  
> es un modelo de seguridad que evoluciona dentro de cada sistema.

---

### 📂 Guía de documentación

### 📘 Guías de adopción, integración y alineación.

- [🔧 Enfoque de integración](./docs/adoption/integration.md)
- [🛡️ Modelo de amenazas](./docs/adoption/threat-model.md)
- [📘 Guía para revisores](./docs/adoption/reviewer-guide.md)
- [🧠 Terminología](./docs/adoption/terminology.md)
- [🌐 Alineación con el ecosistema](./docs/adoption/ecosystem-alignment.md)

### 📘 Documentación Técnica

- [📗 Methodology Overview](./docs/methodology.md)
- [📘 Naming Standard (RHC-NS-01)](./docs/rhc-ns-01_naming_standard.md)
- [📜 License Alignment](./LICENSE_ALIGNMENT.md)
- [🔗 References](./docs/references.md)

---

### 📙 Documentación Conceptual

- [🧠 Cambio de paradigma del Protocolo RHC](./docs/paradigm-shift.md)
- [🧭 Marco Conceptual del Protocolo RHC](./docs/conceptual/marco_conceptual_rhc.md)

---

**© 2025 Fernando Flores Alvarado — Todos los derechos reservados bajo las licencias indicadas.**  

---
