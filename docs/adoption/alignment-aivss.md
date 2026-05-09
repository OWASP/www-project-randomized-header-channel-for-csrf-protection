> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC – Alineación con OWASP AIVSS v1.0  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).  

> 📎 Este documento es el análisis granular de la alineación con AIVSS.  
> Para el contexto general y la tabla de resumen, consulta [`ecosystem-alignment.md`](./ecosystem-alignment.md).

---

## Sobre este documento  

Este archivo desarrolla en detalle la alineación entre el protocolo **RHC (Randomized Header Channel)** y el **OWASP AI Security Verification Standard (AIVSS) v1.0**.  

> ⚠️ **Nota sobre el estado del estándar:** AIVSS v1.0 se encuentra en desarrollo activo (estado Incubator). Su estructura es similar a ASVS: cada capítulo (`C07`, `C09`, etc.) contiene secciones con requisitos individuales numerados (`C7.3.4`, `C9.5.1`, etc.) y niveles de verificación (L1/L2/L3). Los req_id presentados en este documento corresponden al repositorio oficial en su estado actual y **pueden evolucionar** conforme el estándar avance hacia una versión estable.  

> ℹ️ **Nota de terminos:** En este documento se utiliza el término *covert channel* para referirse a mecanismos de comunicación que operan dentro de canales aparentemente legítimos. En el contexto de FCHA, este concepto se interpreta como patrones de comunicación replicados entre agentes dentro de flujos válidos.

### Capítulos analizados  

| Capítulo | Nombre | Archivo oficial |
|---|---|---|
| C07 | Model Behavior, Output Control & Safety Assurance | `0x10-C07-Model-Behavior.md` |
| C09 | Autonomous Orchestration & Agentic Action Security | `0x10-C09-Orchestration-and-Agentic-Action.md` |
| C11 | Adversarial Robustness & Attack Resistance | `0x10-C11-Adversarial-Robustness.md` |
| C13 | Monitoring, Logging & Anomaly Detection | `0x10-C13-Monitoring-and-Logging.md` |
| C14 | Human Oversight and Trust | `0x10-C14-Human-Oversight.md` |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en AIVSS. Posiciona RHC/CIL como una capa complementaria dentro del marco de verificación existente, no como un reemplazo de ningún control.  

---

## Tabla de mapeo general — RHC y AIVSS v1.0  

| Capítulo AIVSS | Archivo | Relación con FCHA / RHC |
|---|---|---|
| C07 — Model Behavior, Output Control & Safety Assurance | `0x10-C07-Model-Behavior.md` | FCHA puede manifestarse como un *covert channel* en el flujo de comunicación entre agentes; RHC/CIL complementa este dominio introduciendo verificación de continuidad del canal, más allá del análisis del contenido de salida |
| C09 — Autonomous Orchestration & Agentic Action Security | `0x10-C09-Orchestration-and-Agentic-Action.md` | Mientras este dominio valida la identidad, autorización y coherencia de acciones entre agentes, RHC complementa verificando la continuidad y consistencia del canal de comunicación a lo largo del flujo completo |
| C11 — Adversarial Robustness & Attack Resistance | `0x10-C11-Adversarial-Robustness.md` | FCHA representa un vector de ataque que no requiere comprometer credenciales ni endpoints; RHC complementa incrementando el costo de explotación mediante variabilidad y validación del comportamiento del canal |
| C13 — Monitoring, Logging & Anomaly Detection | `0x10-C13-Monitoring-and-Logging.md` | Mientras este dominio detecta anomalías a partir de eventos observables, RHC/CIL complementa permitiendo analizar la continuidad del canal como secuencia, facilitando la identificación de desviaciones en el flujo |
| C14 — Human Oversight and Trust | `0x10-C14-Human-Oversight.md` | En escenarios donde los agentes operan con mínima supervisión humana, RHC introduce una capa técnica que añade fricción al canal de comunicación, reduciendo la viabilidad de flujos no legítimos sin intervención |

---

## C07 — Model Behavior, Output Control & Safety Assurance  

Archivo: `0x10-C07-Model-Behavior.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| C7.3.4 | L3 | Output Safety & Privacy Filtering | Mientras este requisito aborda la detección de posibles *covert channels* estadísticos en el espacio de salida del modelo, FCHA puede manifestarse como un patrón de comunicación replicado entre agentes; RHC/CIL complementa este control introduciendo verificación de continuidad del canal |

---

### Análisis Formal — C07 Model Behavior  

El capítulo C07 del AIVSS v1.0 establece controles para garantizar que los outputs del modelo sean técnicamente seguros, validados y monitoreados. Su objetivo de control es asegurar que respuestas inseguras, malformadas o de alto riesgo no lleguen a usuarios ni a sistemas downstream.  

Se enfoca principalmente en:  

- Validación del formato y estructura de los outputs  
- Detección y control de outputs no confiables  
- Filtrado de contenido inseguro o privado  
- Detección de *covert channels* estadísticos en el espacio de salida  

El control mapeado con RHC en este capítulo es:  

- C7.3.4: verifica que los outputs generados sean analizados en busca de *covert channels* esteganográficos estadísticos — patrones sesgados de elección de tokens o anomalías en la distribución de outputs que podrían codificar datos ocultos  

#### Límite del modelo AIVSS  

El control C7.3.4 asegura que:  

✅ Los outputs sean analizados en busca de *covert channels* en el espacio de salida del modelo  
✅ Las detecciones sean marcadas para revisión  

Sin embargo, **su enfoque está en el contenido del output, no en la estructura del canal de comunicación entre agentes**.

En particular:  

- No verifica la continuidad del flujo de comunicación como secuencia  
- No detecta la replicación del patrón de interacción entre agentes  
- No evalúa la coherencia temporal del canal más allá del contenido individual  

#### Brecha identificada (FCHA)  

> FCHA puede manifestarse no solo como un ataque sobre el contenido,  
> sino como un patrón de comunicación replicado entre agentes  
> que opera dentro del espacio válido de outputs del modelo.  

Esto ocurre porque:  

- ✅ C7.3.4 protege el **contenido del output frente a *covert channels***  
- ❌ C7.3.4 no protege la **coherencia del flujo de comunicación como secuencia**  

#### Contribución de RHC  

RHC/CIL complementa C7.3.4 desde la perspectiva del canal:  

> **CIL — Communication Integrity Layer**  

- C7.3.4 analiza el output individual en busca de anomalías estadísticas  
- RHC analiza el canal de comunicación como secuencia en busca de desviaciones en la continuidad del flujo  
- Ambos operan en capas distintas y son complementarios  

#### Posicionamiento técnico  

Mientras AIVSS C07 responde a:  
> *"¿El output del modelo es seguro y no contiene *covert channels*?"*  

RHC responde a:  
> *"¿El canal de comunicación entre agentes mantiene coherencia y continuidad como flujo?"*  

---

## C09 — Autonomous Orchestration & Agentic Action Security  

Archivo: `0x10-C09-Orchestration-and-Agentic-Action.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| C9.5.1 | L2 | Secure Messaging and Protocol Hardening | Este requisito valida la integridad semántica y estructural de los mensajes entre agentes; RHC/CIL complementa este control añadiendo verificación de continuidad del canal como secuencia a lo largo del flujo completo |
| C9.4.2 | L2 | Agent and Orchestrator Identity, Signing, and Tamper-Evident Audit | Mientras este control garantiza la identidad y trazabilidad criptográfica de las acciones, RHC refuerza la coherencia del canal entre dichas acciones mediante validación de continuidad de la secuencia de comunicación |

---

### Análisis Formal — C09 Autonomous Orchestration  

El capítulo C09 del AIVSS v1.0 establece que los sistemas autónomos y multi-agente deben ejecutar únicamente acciones autorizadas, intencionadas y acotadas. Su objetivo de control se enfoca en la identidad del agente como principal, las cadenas de acción, la autorización basada en outputs del modelo y la dinámica de sistemas multi-agente.  

Los controles mapeados con RHC en este capítulo son:  

- C9.5.1: verifica que los outputs de agentes propagados a agentes downstream sean validados contra restricciones semánticas además de validación de esquema  
- C9.4.2: verifica que las acciones iniciadas por agentes estén criptográficamente vinculadas a la cadena de ejecución y firmadas con timestamp para no-repudio y trazabilidad  

#### Límite del modelo AIVSS  

Los controles de C09 aseguran que:  

✅ Las acciones estén autorizadas y acotadas  
✅ Los mensajes entre agentes sean validados semánticamente  
✅ Las acciones sean trazables y criptográficamente vinculadas  

Sin embargo, **no verifican la continuidad del canal de comunicación como secuencia completa de comunicación**.  

En particular:  

- La validación semántica verifica el contenido del mensaje, no la coherencia de la secuencia de comunicación  
- La firma criptográfica vincula la acción a la cadena, no el comportamiento del canal entre acciones  
- No existe control sobre si el patrón de comunicación entre agentes es legítimo o replicado  

#### Brecha identificada (FCHA en pipelines multi-agente)  

> En pipelines multi-agente, FCHA puede manifestarse como la replicación  
> de un flujo de comunicación válido entre agentes,  
> donde cada mensaje individual es semánticamente correcto  
> pero la secuencia completa representa un flujo no autorizado.  

Esto ocurre porque:  

- ✅ C9.5.1 protege la **integridad semántica de cada mensaje**  
- ✅ C9.4.2 protege la **identidad y trazabilidad de cada acción**  
- ❌ Ninguno protege la **coherencia del canal como secuencia de flujo completo**  

#### Contribución de RHC  

RHC introduce una capa complementaria en pipelines multi-agente:  

> **CIL — Communication Integrity Layer**  

- Sobre C9.5.1 → RHC añade verificación de continuidad del canal como secuencia sobre la validación semántica ya existente  
- Sobre C9.4.2 → RHC refuerza la coherencia entre acciones firmadas verificando la secuencia de comunicación que las conecta  

#### Posicionamiento técnico  

Mientras AIVSS C09 responde a:  
> *"¿Las acciones del agente son autorizadas, trazables y semánticamente válidas?"*  

RHC responde a:  
> *"¿El canal de comunicación entre agentes mantiene continuidad y coherencia como secuencia de interacción?"*  

---

## C11 — Adversarial Robustness & Attack Resistance  

Archivo: `0x10-C11-Adversarial-Robustness.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| C11.2.1 | L1 | Adversarial-Example Hardening | Este requisito cubre la evaluación frente a técnicas de ataque conocidas; FCHA representa un vector que no requiere comprometer credenciales ni endpoints, y RHC complementa incrementando el costo de explotación mediante variabilidad del canal |
| C11.2.2 | L2 | Adversarial-Example Hardening | Mientras este control se enfoca en la detección de comportamientos maliciosos en producción, RHC/CIL añade una capa complementaria al verificar la continuidad del canal como señal adicional de anomalía |

---

### Análisis Formal — C11 Adversarial Robustness  

El capítulo C11 del AIVSS v1.0 establece que los sistemas de IA deben permanecer confiables, resistentes al abuso y preservadores de la privacidad ante ataques de evasión, inferencia, extracción o envenenamiento.  

Los controles mapeados con RHC en este capítulo son:  

- C11.2.1: verifica que los modelos que sirven funciones de alto riesgo sean evaluados contra técnicas de ataque conocidas relevantes para su modalidad  
- C11.2.2: verifica que la detección de ejemplos adversariales genere alertas en producción, con respuestas de bloqueo para endpoints de alto riesgo  

#### Límite del modelo AIVSS  

Los controles de C11.2 aseguran que:  

✅ Los modelos sean evaluados contra técnicas de ataque conocidas  
✅ Se detecten y alerten comportamientos maliciosos en producción  

Sin embargo, **su enfoque está en los inputs y outputs del modelo**, no en el canal de comunicación como secuencia.  

En particular:  

- No evalúan la variabilidad del flujo de comunicación como vector de ataque  
- No cubren el escenario donde el vector no requiere manipular inputs del modelo  
- No detectan la replicación de la secuencia de comunicación como técnica de ataque  

#### Brecha identificada (FCHA como vector de ataque)  

FCHA es un vector de ataque que opera fuera del alcance tradicional de C11:  

> Un atacante puede ejecutar FCHA sin manipular inputs del modelo,  
> sin comprometer credenciales ni endpoints,  
> replicando únicamente el patrón de comunicación esperado.  

Esto ocurre porque:  

- ✅ C11 protege contra **ataques que manipulan el modelo**  
- ❌ C11 no cubre **ataques que replican la secuencia de comunicación sin manipular el modelo**  

#### Contribución de RHC  

RHC incrementa el costo del vector FCHA desde la perspectiva del canal:  

- Sobre C11.2.1 → RHC introduce variabilidad en el canal que eleva el costo de cualquier técnica de replicación de secuencia  
- Sobre C11.2.2 → la variabilidad del canal RHC actúa como señal adicional de anomalía complementaria a la detección de ejemplos adversariales  

#### Posicionamiento técnico  

Mientras AIVSS C11 responde a:  
> *"¿El modelo es robusto frente a ataques sobre sus inputs?"*  

RHC responde a:  
> *"¿El canal de comunicación mantiene suficiente variabilidad estructural para impedir la replicación de secuencias a bajo costo?"*  

---

## C13 — Monitoring, Logging & Anomaly Detection  

Archivo: `0x10-C13-Monitoring-and-Logging.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| C13.2.7 | L3 | Abuse Detection and Alerting | Este requisito detecta patrones multi-turno de abuso donde ningún turno individual es malicioso; el Analizador de Entropía RHC complementa este enfoque evaluando la continuidad del canal como secuencia completa de comunicación |
| C13.2.8 | L3 | Abuse Detection and Alerting | Mientras este control monitorea indicadores de *covert channels* en tráfico LLM, RHC aporta observabilidad adicional basada en la variabilidad y coherencia de la secuencia del canal |

---

### Análisis Formal — C13 Monitoring and Logging  

El capítulo C13 del AIVSS v1.0 establece visibilidad en tiempo real y forense sobre lo que el modelo y otros componentes de IA ven, hacen y retornan. Su objetivo es permitir la detección, triaje y aprendizaje de amenazas específicas de IA.  

Los controles mapeados con RHC en este capítulo son:  

- C13.2.7: verifica que el análisis de trayectoria de conversación a nivel de sesión detecte patrones multi-turno de jailbreak donde ningún turno individual es abiertamente malicioso, pero la conversación agregada exhibe indicadores de ataque  
- C13.2.8: verifica que el tráfico de API LLM sea monitoreado en busca de indicadores de *covert channels*, incluyendo payloads codificados en Base64, patrones de consulta estructurados no humanos, y firmas de comunicación consistentes con actividad de comando y control de malware  

#### Límite del modelo AIVSS  

Los controles de C13.2 aseguran que:  

✅ Se detecten patrones multi-turno de abuso  
✅ Se monitorea el tráfico LLM en busca de *covert channels*  

Sin embargo, **su enfoque es la detección a partir del contenido y los metadatos de los mensajes**, no desde la perspectiva del canal de comunicación como entidad propia.  

En particular:  

- No evalúan la continuidad del canal como secuencia independientemente del contenido  
- No detectan desviaciones en el comportamiento estructural de la secuencia del canal  
- No proveen observabilidad sobre la variabilidad del canal en el tiempo  

#### Contribución de RHC  

El **Analizador de Entropía RHC** es la herramienta de observabilidad del canal que complementa directamente estos controles:  

> **Analizador de Entropía RHC — Fase 1 publicada, Fase 2 en desarrollo**  

- Sobre C13.2.7 → el Analizador evalúa la continuidad del canal como secuencia completa, complementando la detección de patrones multi-turno que ningún turno individual revela  
- Sobre C13.2.8 → el Analizador monitorea la variabilidad y coherencia de la secuencia del canal, añadiendo una capa de observabilidad sobre la estructura del flujo más allá del contenido  

#### Posicionamiento técnico  

Mientras AIVSS C13 responde a:  
> *"¿Qué está pasando en el contenido y los metadatos de las interacciones?"*  

RHC responde a:  
> *"¿Cómo se está comportando el canal de comunicación como secuencia en el tiempo?"*  

---

## C14 — Human Oversight and Trust  

Archivo: `0x10-C14-Human-Oversight.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| C14.2.1 | L1 | Human-in-the-Loop Decision Checkpoints | Este requisito establece la política de supervisión humana sobre decisiones críticas de IA; RHC introduce una capa técnica complementaria que añade fricción al canal de comunicación, reduciendo la viabilidad de ejecución de secuencias no legítimas sin intervención |

---

### Análisis Formal — C14 Human Oversight and Trust  

El capítulo C14 del AIVSS v1.0 establece que los humanos deben retener control efectivo sobre los sistemas de IA mediante mecanismos de apagado, degradación controlada, y una política explícita que determine qué decisiones y acciones de IA requieren aprobación humana.  

El control mapeado con RHC en este capítulo es:  

- C14.2.1: verifica que exista una política documentada de supervisión humana que defina cuáles decisiones y acciones de agentes de IA son clasificadas como de alto riesgo, los criterios para esa determinación, y la autoridad de aprobación requerida antes de la ejecución  

#### Límite del modelo AIVSS  

C14.2.1 asegura que:  

✅ Exista una política documentada sobre supervisión humana  
✅ Las acciones de alto riesgo requieran aprobación antes de ejecutarse  

Sin embargo, **la política define los umbrales de supervisión, pero no introduce controles técnicos sobre el canal de comunicación como secuencia que precede a esas acciones**.  

En particular:  

- La política clasifica acciones, pero no verifica la coherencia de la secuencia de comunicación que las genera  
- No existe control sobre si el canal de comunicación que lleva a una acción es legítimo o replicado  
- FCHA puede generar acciones que superen los umbrales de supervisión mediante secuencias replicadas  

#### Brecha identificada (FCHA y supervisión humana)  

> Los entornos multi-agente sin supervisión humana son el escenario de mayor riesgo FCHA:  
> una secuencia replicada puede desencadenar acciones clasificadas como de alto riesgo  
> antes de que la política de supervisión lo detecte.  

Esto ocurre porque:  

- ✅ C14.2.1 define **qué acciones requieren supervisión**  
- ❌ C14.2.1 no controla **la legitimidad de la secuencia de comunicación que genera esas acciones**  

#### Contribución de RHC  

RHC introduce fricción técnica en el canal que complementa la política de supervisión:  

- Sobre C14.2.1 → RHC incrementa el costo de ejecutar secuencias replicadas que puedan desencadenar acciones de alto riesgo  
- La política de supervisión define los umbrales — RHC dificulta alcanzarlos mediante secuencias no legítimas  
- Ambos controles son complementarios: la política actúa sobre la acción, RHC actúa sobre el canal  

#### Posicionamiento técnico  

Mientras AIVSS C14 responde a:  
> *"¿Qué decisiones de IA requieren supervisión y aprobación humana?"*  

RHC responde a:  
> *"¿El canal de comunicación que lleva a esas decisiones es legítimo y coherente como secuencia?"*  

---

## Posición general frente a AIVSS  

AIVSS verifica la seguridad de sistemas de IA desde la perspectiva del modelo, sus outputs, su comportamiento y su supervisión.  

RHC/CIL introduce un enfoque complementario:  

> **Verificar la integridad del canal de comunicación entre agentes,  
> no solo la identidad, el acceso o el contenido de los mensajes.**  

Esto implica que:  

- AIVSS protege **el modelo, sus outputs y las acciones individuales**  
- RHC protege **el canal de comunicación como secuencia de flujo**  

| Capítulo | Capa cubierta por AIVSS | Capa añadida por RHC |
|---|---|---|
| C07 | Seguridad y validación del contenido de outputs | Continuidad del canal de comunicación entre agentes |
| C09 | Identidad, autorización y trazabilidad de acciones | Coherencia del canal que conecta esas acciones como secuencia |
| C11 | Robustez frente a ataques sobre el modelo | Costo de replicación de secuencias en el canal de comunicación |
| C13 | Detección de anomalías en contenido y metadatos | Observabilidad del canal como secuencia en el tiempo |
| C14 | Política de supervisión humana sobre acciones de alto riesgo | Fricción técnica en el canal como secuencia que precede a esas acciones |

> 📎 Referencia oficial: [OWASP AIVSS](https://owasp.org/www-project-artificial-intelligence-security-verification-standard-aisvs-docs/) — Proyecto en estado Incubator (en desarrollo activo)  
> 📄 Contexto general y tabla de resumen: [`ecosystem-alignment.md`](./ecosystem-alignment.md)  

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*
