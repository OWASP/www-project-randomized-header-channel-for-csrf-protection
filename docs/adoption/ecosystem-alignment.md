> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.  
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.  

# RHC – Mapeo con Marcos de Seguridad  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).  

---

## Visión General  

El **Randomized Header Channel (RHC)** es un **mecanismo proactivo de endurecimiento del canal de comunicación a nivel de flujo**.  
**No reemplaza** la autenticación, autorización, el cifrado ni las prácticas de codificación segura.  
En su lugar, **reduce la predictibilidad del canal y la viabilidad de automatización**, incrementando el costo operativo para el atacante.

---

## 1. OWASP Top 10 & OWASP API Top 10  

### Posicionamiento  

RHC **complementa** los controles de OWASP mediante:  

- Incremento de la entropía estructural en el canal de solicitudes  
- Interrupción de ataques de repetición, correlación y automatización  
- Reducción de la viabilidad económica de la explotación a escala  

### Idea Clave  

> OWASP se enfoca en *qué vulnerabilidades existen*  
> RHC se enfoca en *qué tan viable es explotarlas de forma repetible y escalable*  

---

## 2. Mapeo con el Marco de Ciberseguridad de NIST  

RHC se alinea principalmente con la función **PROTEGER (PROTECT)**.  

| **Categoría NIST** |       **Significado**        |                **Contribución de RHC**                 |
| ------------------ | ---------------------------- | ------------------------------------------------------ |
| PR.DS              | Seguridad de los Datos       | Reduce la utilidad del tráfico interceptado al introducir variabilidad en el canal |
| PR.PT              | Tecnología de Protección     | Introduce entropía estructural                         |
| PR.AC              | Control de Acceso            | Complementa la protección de sesiones                  |

RHC es **un mecanismo preventivo**, no detectivo ni reactivo.  

---

## 3. Mapeo con MITRE ATT&CK  

MITRE describe **cómo operan los atacantes**.  

RHC incrementa la complejidad de los ataques y disminuye la capacidad de escalar la explotación automatizada:  

- Correlación y análisis de tráfico de red  
- Abuso a nivel de aplicación  
- Explotación automatizada mediante bots  
- Ataques de repetición y replicación de flujo  

> MITRE pregunta: *¿Qué tan fácil es para el atacante?*  
> RHC responde: *Más difícil, más ruidoso y más costoso*.  

---

## 4. Alineación con Estándares de Verificación OWASP (ASVS / MASVS / AIVSS)  

> Esta sección extiende el mapeo de ecosistema del protocolo RHC, incorporando los estándares de verificación de seguridad de OWASP como una capa complementaria de posicionamiento.  
>
> La referencia cruzada con estos estándares fue sugerida por **Colin Watson (OWASP)** durante la revisión del trabajo relacionado con FCHA, con el objetivo de facilitar la comprensión del lugar que ocupa RHC dentro del ecosistema de verificación de seguridad.  

---

### 4.1 Naturaleza de la alineación  

A diferencia del OWASP Top 10, que describe categorías de riesgo, los estándares como ASVS, MASVS y AIVSS definen **controles verificables** para evaluar el nivel de seguridad de un sistema.  

En este contexto, RHC no introduce nuevos controles dentro de estos estándares, sino que aporta una capa complementaria adicional:  

> **CIL — Communication Integrity Layer**  
> Capa encargada de validar la continuidad, coherencia y variabilidad del canal de comunicación como secuencia de flujo en el tiempo.

Esto complementa los enfoques tradicionales centrados en:  

- Identidad  
- Autenticación  
- Autorización  
- Contenido de los mensajes  

---

### 4.2 Alineación por estándar  

---

#### 4.2.1 OWASP ASVS — Application Security Verification Standard (v5.0.0)  

El **OWASP ASVS v5.0.0** define un marco de verificación de seguridad para aplicaciones web basado en:  

- **Niveles de verificación (L1, L2, L3)**, que representan la profundidad y el nivel de seguridad requerido de los controles  
- **Capítulos funcionales (V1–V17)**, que organizan las áreas de seguridad (sesiones, comunicaciones, APIs, arquitectura, etc.)  

RHC opera como un **mecanismo complementario transversal**, alineándose principalmente con los capítulos:  

- **V4 — API and Web Service**  
- **V7 — Session Management**  
- **V12 — Secure Communication**  
- **V15 — Secure Coding and Architecture**  

Introduce una capa adicional:  

> **Capa de Integridad de la Comunicación (CIL), encargada de validar la continuidad del flujo entre interacciones**  

Esta capa **no está explícitamente contemplada en ASVS**, pero complementa los controles existentes al añadir validación sobre el flujo de comunicación como secuencia, más allá de los controles individuales evaluados en cada nivel (L1–L3).  

| Área ASVS | Capítulo / Sección relevante | Relación con RHC |
|---|---|---|
| Gestión de sesiones | V7 — Session Management | RHC complementa los controles de sesión introduciendo una capa de entropía y verificación de continuidad del canal, sin reemplazar los mecanismos de generación y gestión de tokens |
| Comunicaciones seguras | V12 — Secure Communication | RHC opera sobre canales protegidos (TLS), como una capa adicional, añadiendo verificación de continuidad del flujo del canal de comunicación |
| Controles a nivel de API | V4 — API and Web Service | RHC complementa los controles de API añadiendo variabilidad en el canal de comunicación, dificultando la correlación y automatización de flujos |
| Diseño seguro (arquitectura) | V15 — Secure Coding and Architecture | RHC incorpora la CIL como una capa arquitectónica adicional, haciendo explícita la validación de continuidad del canal como parte del diseño del sistema |

#### Posicionamiento técnico en ASVS  

ASVS valida la correcta implementación de controles individuales dentro de una aplicación (tokens, TLS, autenticación, etc.).  

RHC introduce **CIL** como una **capa de verificación de la continuidad del flujo de comunicación**, no contemplada explícitamente en el estándar.

Esto implica que:  

- ASVS valida **interacciones individuales**  
- RHC/CIL valida **la coherencia del flujo completo de comunicación**

RHC no contradice ASVS — lo **complementa al añadir una capa transversal entre transporte y aplicación, validando la continuidad de la comunicación entre interacciones**.  

> 📎 Referencia oficial: [OWASP ASVS](https://owasp.org/www-project-application-security-verification-standard/) — Versión estable actual: 5.0.0  

---

#### 4.2.2 OWASP MASVS — Mobile Application Security Verification Standard (v2.x)  

El **OWASP MASVS v2.x** define controles de seguridad para aplicaciones móviles organizados en categorías funcionales.  

RHC es relevante en el contexto móvil debido a que las aplicaciones interactúan de forma intensiva con APIs REST/JSON, utilizando patrones de comunicación cliente–backend que pueden volverse predecibles. Además, el control programático sobre headers HTTP en estos entornos permite la integración directa de RHC, introduciendo variabilidad y reduciendo la predictibilidad del canal.  

> ⚠️ **Nota sobre la estructura del estándar:** MASVS v2.x utiliza un modelo de controles de un solo nivel, donde cada categoría contiene controles individuales (`MASVS-CATEGORY-N`) como unidad mínima. A diferencia de ASVS, no existen sub-requisitos numerados. El nivel de detalle presentado corresponde al máximo nivel de trazabilidad disponible en la especificación oficial.  

| Control MASVS | Declaración oficial | Relación con RHC |
|---|---|---|
| MASVS-NETWORK-1 | *La aplicación asegura todo el tráfico de red de acuerdo con las mejores prácticas actuales.* | RHC introduce entropía y variabilidad en el canal, complementando las prácticas seguras de transporte |
| MASVS-NETWORK-2 | *La aplicación implementa pinning de identidad para todos los endpoints remotos bajo control del desarrollador.* | RHC complementa el pinning introduciendo verificación de continuidad del canal más allá de la identidad del servidor |
| MASVS-AUTH-1 | *La aplicación utiliza protocolos seguros de autenticación y autorización y sigue las mejores prácticas relevantes.* | RHC complementa los flujos de autenticación añadiendo validación de continuidad del flujo del canal |
| MASVS-RESILIENCE-4 | *La aplicación implementa técnicas contra el análisis dinámico.* | Los patrones dinámicos de RHC incrementan la variabilidad del tráfico en tiempo de ejecución, elevando el costo de análisis dinámico del tráfico y el replicado de patrones de comunicación |

#### Posicionamiento técnico en MASVS  

MASVS valida la correcta implementación de controles de seguridad en aplicaciones móviles, principalmente sobre autenticación, comunicación y resiliencia.  

RHC introduce una verificación adicional sobre el canal cliente–backend:  

- MASVS protege **la comunicación y los mecanismos de autenticación**  
- RHC protege **el comportamiento del canal a lo largo del flujo**  

Esto implica que:

- MASVS valida **interacciones individuales**  
- RHC/CIL valida **la coherencia del flujo completo de comunicación**

RHC no reemplaza MASVS — lo complementa al añadir validación sobre la continuidad del canal de comunicación.  

> 📎 Referencia oficial: [OWASP MASVS](https://mas.owasp.org/MASVS/) — Versión estable actual: 2.x  

---

#### 4.2.3 OWASP AIVSS — AI Security Verification Standard (v1.0, en desarrollo)  

El **OWASP AIVSS v1.0** define controles para la verificación de seguridad en sistemas basados en inteligencia artificial, incluyendo modelos, flujos de interacción y sistemas multi-agente.  

RHC/FCHA tiene mayor relevancia en relación directa con este estándar, especialmente en escenarios donde múltiples agentes intercambian información a través de secuencias de comunicación.  

> RHC introduce propiedades de seguridad a nivel de canal que complementan los controles definidos en AIVSS a nivel de aplicación y de modelo.  

> ⚠️ **Nota sobre el estado del estándar:** AIVSS v1.0 se encuentra en desarrollo activo (estado Incubator). Su estructura incluye capítulos con requisitos individuales numerados y niveles de verificación (L1/L2/L3), los cuales pueden evolucionar con el tiempo hacia una versión estable.  

| Capítulo AIVSS | Relación con FCHA / RHC |
|---|---|
| C07 — Model Behavior, Output Control & Safety Assurance | FCHA puede manifestarse como un canal manipulado sin alterar directamente credenciales o endpoints en el flujo entre agentes; RHC/CIL introduce verificación del canal de comunicación más allá del análisis del contenido de salida |
| C09 — Autonomous Orchestration & Agentic Action Security | RHC verifica la continuidad del canal de comunicación entre agentes, complementando los controles de identidad y autorización existentes a lo largo del flujo |
| C11 — Adversarial Robustness & Attack Resistance | FCHA describe una técnica donde un flujo de comunicación puede ser reutilizado o manipulado sin comprometer directamente los mecanismos de autenticación; RHC incrementa el costo de este vector mediante variabilidad del canal |
| C13 — Monitoring, Logging & Anomaly Detection | RHC introduce observabilidad del canal como entidad propia, permitiendo analizar su comportamiento como secuencia temporal independiente del contenido de los mensajes. El Analizador de Entropía RHC (en desarrollo) complementa los controles de monitoreo, expandiendo esta capacidad al hacer visible la estructura y el comportamiento interno del canal, permitiendo identificar patrones, variabilidad y anomalías en su flujo continuo |
| C14 — Human Oversight and Trust | RHC introduce fricción técnica en el canal previa a la ejecución de acciones de alto riesgo |

#### Posicionamiento técnico en AIVSS  

AIVSS valida la seguridad de sistemas de IA considerando el comportamiento del modelo, sus salidas y las acciones derivadas.  

RHC introduce una verificación adicional centrada en el canal de comunicación:  

- AIVSS analiza **el contenido, las acciones y el comportamiento del sistema**  
- RHC analiza **la continuidad del flujo de comunicación entre agentes**  

Esto implica que:

- AIVSS valida **interacciones individuales**  
- RHC/CIL valida **la coherencia del flujo completo de comunicación**

RHC no reemplaza AIVSS — lo complementa al añadir validación sobre la secuencia de comunicación en sistemas distribuidos.  

> 📎 Referencia oficial: [OWASP AIVSS](https://owasp.org/www-project-artificial-intelligence-security-verification-standard-aisvs-docs/) — Proyecto en estado Incubator  

---

### 4.3 Posición de RHC/CIL en los estándares de verificación OWASP  

| Estándar | Versión | Relación principal con RHC | Tipo de relación |
|---|---|---|---|
| ASVS | v5.0.0 | Seguridad de sesiones, comunicaciones y APIs | Complementaria — RHC introduce CIL como una capa adicional de verificación de continuidad del canal no contemplada explícitamente en ASVS |
| MASVS | v2.x | Seguridad de red, autenticación y resiliencia en aplicaciones móviles | Complementaria — RHC introduce validación de continuidad del canal sobre flujos cliente–backend, especialmente en escenarios API predecibles |
| AIVSS | v1.0 (dev) | Flujos entre agentes, resistencia a ataques y monitoreo | Complementaria — RHC introduce verificación de continuidad del canal en flujos multi-turno entre agentes, cubriendo un aspecto no contemplado explícitamente en AIVSS |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en ninguno de estos estándares. Posiciona RHC/CIL como una capa complementaria dentro de los marcos de verificación existentes, no como un reemplazo de ninguno de ellos.  

---

### 4.4 Síntesis técnica transversal  

A partir de la alineación presentada en ASVS, MASVS y AIVSS, se observa un patrón común:  

> Los estándares OWASP validan la correcta implementación de controles individuales dentro de un sistema.  

RHC introduce una capa complementaria transversal:  

- Los estándares validan **interacciones individuales**  
- RHC/CIL valida **la coherencia del flujo completo de comunicación**

Esto implica que:  

- Los estándares protegen componentes individuales  
- RHC **protege** y **verifica** cómo **se comporta el canal de comunicaciones a lo largo de la secuencia completa del sistema**  

RHC no reemplaza estos estándares — los **complementa introduciendo una capa no modelada explícitamente,“la integridad del canal de comunicación a nivel de flujo”**.

---

### 4.5 Referencias al análisis detallado  

El análisis formal de la alineación con cada estándar se encuentra en los siguientes documentos:  

> 📄 Análisis completo por capítulo: [`alignment-asvs.md`](./alignment-asvs.md)  
> 📄 Análisis completo por control:  [`alignment-masvs.md`](./alignment-masvs.md)  
> 📄 Análisis completo por capítulo: [`alignment-aivss.md`](./alignment-aivss.md)  

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en estos estándares. Posiciona RHC/CIL como una capa complementaria dentro de los marcos de verificación existentes.  

> 📄 Análisis transversal del gap estructural:
> [`cross-standard-gap-analysis.md`](./../cross-standard-gap-analysis.md)

---

## 5. Declaración Profesional de Posicionamiento  

**Redacción correcta:**  
RHC complementa a OWASP, NIST y MITRE, así como a los estándares de verificación OWASP (ASVS, MASVS y AIVSS), al reducir la predictibilidad del canal de comunicación y limitar la explotación automatizada a escala.

**Evitar afirmar:**  
Que RHC reemplaza el cifrado, la autenticación, OWASP Top 10 o los estándares de verificación.  

---

## 6. Glosario  

- [📖 Terminología](./terminology.md)  

---

## Reflexión Final  

RHC no construye muros.  
Cambia el terreno.  

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).  

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
