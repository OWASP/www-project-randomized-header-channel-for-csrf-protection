> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Propiedades de Seguridad — RHC Protocol Core

**Autor:** Fernando Flores Alvarado
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)
**Licencia:** CC BY 4.0 (documentación)
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

Este documento define formalmente las propiedades de seguridad que el protocolo RHC garantiza, las que emergen de su comportamiento y las suposiciones de seguridad sobre las que opera. Toda referencia a propiedades de seguridad en otros documentos del repositorio apunta a este archivo como fuente única de verdad.

> **Nota sobre terminología:** Las propiedades están nombradas en inglés siguiendo la convención estándar en literatura de seguridad y criptografía de protocolos. Las descripciones y el análisis se presentan en español.

---

## 1. Propiedades Fundamentales

Estas propiedades son inherentes al diseño del protocolo y definen su identidad como mecanismo de seguridad.

---

### 1.1 Channel State Opacity

**Definición:** El estado interno del canal RHC es opaco para cualquier observador que no forme parte de la comunicación legítima. Un cliente externo al canal no puede determinar el estado actual del pool de slots aleatorios, independientemente de las herramientas o técnicas de observación que utilice.

**Descripción técnica:**
El servidor mantiene un estado de validación esperado derivado del pool aleatorio configurado. Este estado no es inferible a partir de la observación pasiva del tráfico HTTP, ya que los headers RHC son seleccionados de forma no determinista en cada solicitud. Sin acceso al estado del canal, no es posible generar solicitudes válidas.

**Consecuencia directa:**
Herramientas de análisis, automatización o ataque que no integren la lógica del cliente RHC quedan operativamente neutralizadas. Este comportamiento no es una limitación del protocolo, sino una consecuencia directa de sus propiedades de seguridad.

**Relación con otros mecanismos:**
A diferencia de esquemas basados en tokens estáticos o nonces con marca de tiempo, la opacidad de RHC no depende de secretos transmitidos — depende del estado compartido del canal establecido en el diseño del sistema.

---

### 1.2 State-Bound Unforgeability

**Definición:** Una solicitud HTTP solo es válida si fue construida con conocimiento del estado actual del canal. No es posible forjar una solicitud válida conociendo únicamente la estructura del mensaje, los endpoints o los headers observados.

**Descripción técnica:**
La validez de una solicitud está ligada al estado del pool en el momento de su construcción. Un atacante que capture tráfico legítimo obtiene la estructura de la solicitud, pero no puede reproducirla de forma válida sin conocer el estado del canal en ese momento, ni puede inferir el estado futuro a partir del estado observado.

**Distinción frente a esquemas tradicionales:**
| Esquema | Base de validez |
|---|---|
| Token CSRF estático | Valor del token en el cuerpo o header |
| HMAC / firma digital | Secreto compartido fijo |
| Nonce con timestamp | Valor único + ventana de tiempo |
| **RHC** | **Estado dinámico del canal (pool aleatorio)** |

---

### 1.3 Replay Resistance

**Definición:** Una solicitud válida capturada no puede ser reproducida exitosamente en un momento posterior.

**Descripción técnica:**
La resistencia al replay en RHC es *state-dependent*, no tiempo-dependiente. Una solicitud deja de ser válida no porque haya expirado un intervalo de tiempo, sino porque el estado del canal ha avanzado. Esta distinción es relevante: los esquemas basados en timestamp son vulnerables a ataques dentro de la ventana de tolerancia; RHC no tiene ventana de tolerancia basada en tiempo.

**Corolario:**
Ataques de tipo replay clásico, incluyendo los que intentan aprovechar latencia de red o diferencias de reloj entre sistemas, no son efectivos contra RHC bajo condiciones normales de operación.

---

### 1.4 Ephemeral Validity Window

**Definición:** Cada solicitud tiene una ventana de validez que no está determinada por el tiempo, sino por el estado del canal en el momento de su construcción.

**Descripción técnica:**
Una solicitud construida con el estado `S(n)` del canal solo es válida mientras el canal permanezca en ese estado. Cuando el estado avanza a `S(n+1)`, la solicitud construida con `S(n)` pierde validez, independientemente del tiempo transcurrido. Esto hace que la ventana de validez sea operativamente efímera sin requerir sincronización de relojes entre cliente y servidor.

**Implicación arquitectónica:**
Esta propiedad elimina una clase de vulnerabilidades asociadas a la administración de expiración temporal de tokens, y es especialmente relevante en entornos de alta concurrencia donde la sincronización de tiempo no puede garantizarse.

---

## 2. Propiedades Derivadas

Estas propiedades emergen del comportamiento del protocolo como consecuencia de las propiedades fundamentales.

---

### 2.1 Correlation Resistance

**Definición:** La observación de múltiples solicitudes válidas consecutivas no permite inferir el estado actual, pasado ni futuro del canal.

**Descripción técnica:**
Dado que la selección del slot es no determinista, la secuencia de headers observada en el tráfico no revela información sobre la distribución o el estado del pool. Un atacante con acceso a `n` solicitudes válidas capturadas no obtiene ventaja estadística para predecir la siguiente solicitud válida.

---

### 2.2 Non-Deterministic Communication Pattern

**Definición:** El patrón de comunicación del canal no es predecible para un observador externo.

**Descripción técnica:**
Cada solicitud produce un patrón de headers distinto, generado de forma no determinista en el cliente. Esto rompe los fundamentos de técnicas de ataque que dependen de:

- Scripting basado en patrones repetibles
- Fuzzing dirigido a estructuras estables
- Automatización ciega de flujos HTTP

Esta propiedad tiene implicaciones directas en la resistencia del protocolo frente a herramientas de análisis automatizado.

---

### 2.3 Asymmetric Observability

**Definición:** Un cliente legítimo con acceso al estado del canal puede operar con plena funcionalidad. Un observador externo sin acceso al estado del canal tiene capacidad de observación pero no de participación válida.

**Descripción técnica:**
Esta asimetría es una propiedad de diseño intencional. RHC no oculta la estructura de la comunicación — los headers son visibles en el tráfico. Lo que no es observable externamente es el estado que hace válida esa estructura. La distinción entre *ver* y *poder reproducir* es el núcleo de esta propiedad.

**Relevancia operativa:**
Esta propiedad es la base del impacto de RHC sobre herramientas de testing y automatización. Un equipo de QA con acceso al código del cliente puede integrar la lógica RHC y operar normalmente. Un atacante externo, sin ese acceso, no puede replicar el comportamiento del canal.

---

## 3. Propiedades Operativas

Estas propiedades describen el comportamiento del protocolo en contextos de despliegue real.

---

### 3.1 Complementary Layering

**Definición:** RHC opera como una capa adicional de seguridad sin reemplazar ni interferir con los mecanismos de seguridad existentes.

**Descripción técnica:**
RHC opera en la **Capa de Integridad de la Comunicación (CIL)**, una capa arquitectónica diferenciada de las capas de cifrado (TLS), autenticación y autorización. Su activación no modifica el comportamiento de los mecanismos de seguridad subyacentes ni requiere que estos sean reemplazados.

| Capa de seguridad | Mecanismo | ¿Reemplazado por RHC? |
|---|---|---|
| Cifrado en tránsito | TLS/HTTPS | ❌ No |
| Autenticación | Tokens, OAuth, MFA | ❌ No |
| Autorización | RBAC, ACL | ❌ No |
| Integridad del canal | RHC (CIL) | ✅ Operado por RHC |
| Protección CSRF (formularios) | SameSite, tokens ocultos | ❌ No (ver [`scope-and-limitations.md`](./scope-and-limitations.md)) |

---

### 3.2 Automation Resistance

**Definición:** RHC incrementa significativamente el costo operativo de la automatización de ataques basada en patrones repetibles de comunicación.

**Descripción técnica:**
La automatización de flujos de solicitudes contra endpoints protegidos por RHC requiere que el cliente atacante implemente y mantenga sincronización con el estado del canal. Esto eleva el costo técnico de los ataques automatizados desde la ejecución de herramientas genéricas hasta el desarrollo de clientes específicos con conocimiento del protocolo.

Esta propiedad afecta también a herramientas legítimas de testing. Ver [Sección 4 — Suposiciones de Seguridad](#4-suposiciones-de-seguridad) y [`scope-and-limitations.md`](./scope-and-limitations.md) para orientación sobre adaptación de herramientas.

---

### 3.3 Operational Cost Amplification

**Definición:** El costo operativo de un ataque exitoso contra un endpoint protegido por RHC es sustancialmente mayor que el costo del mismo ataque contra un endpoint sin protección de canal.

**Descripción técnica:**
Esta propiedad es la expresión cuantitativa de la efectividad de RHC como mecanismo defensivo. No implica que los ataques sean imposibles, sino que requieren recursos, conocimiento y esfuerzo significativamente mayores. En el modelo de defensa en profundidad, incrementar el costo del ataque es un objetivo de seguridad válido e importante.

---

## 4. Suposiciones de Seguridad

Las propiedades descritas en este documento son válidas bajo las siguientes suposiciones. Si alguna de estas suposiciones no se cumple, las propiedades correspondientes pueden degradarse.

---

### 4.1 Client-Side Entropy Dependency

**Suposición:** El cliente implementa selección genuinamente aleatoria del slot del pool en cada solicitud.

**Implicación:**
Si el cliente utiliza un generador de números pseudoaleatorios predecible, o si la lógica de selección es determinista, las propiedades de `Channel State Opacity`, `Correlation Resistance` y `Non-Deterministic Communication Pattern` se degradan de forma proporcional a la predictibilidad del cliente.

**Recomendación para implementadores:**
Utilizar APIs de aleatoriedad criptográficamente seguras disponibles en el entorno de ejecución del cliente (por ejemplo, `crypto.getRandomValues()` en entornos de navegador).

---

### 4.2 Canal Subyacente Íntegro

**Suposición:** La comunicación entre cliente y servidor ocurre sobre un canal que garantiza confidencialidad e integridad (TLS/HTTPS).

**Implicación:**
RHC no está diseñado para operar sobre canales no cifrados. En ausencia de TLS, un atacante con capacidad de interceptación activa podría observar el estado del canal y comprometer las propiedades fundamentales del protocolo.

---

### 4.3 Integridad del Código Cliente

**Suposición:** El código del cliente que implementa la lógica RHC no ha sido comprometido.

**Implicación:**
Si el cliente es comprometido (por ejemplo, mediante inyección de código JavaScript), el atacante puede obtener acceso directo al estado del canal, neutralizando todas las propiedades de seguridad del protocolo. Esto es consistente con el modelo de amenaza general de aplicaciones web: un cliente comprometido invalida cualquier mecanismo de seguridad del lado del cliente.

---

## 5. Declaración de Efectividad

Las propiedades documentadas en este archivo no son afirmaciones teóricas — son consecuencias del diseño del protocolo que pueden verificarse en implementación. RHC no garantiza seguridad absoluta ni reemplaza un modelo de defensa en profundidad. Su contribución es específica: incrementar el costo operativo de los ataques que dependen de la predecibilidad o la reproducibilidad del canal de comunicación.

> *"Este comportamiento no es una limitación del protocolo, sino una consecuencia directa de sus propiedades de seguridad."*

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*
