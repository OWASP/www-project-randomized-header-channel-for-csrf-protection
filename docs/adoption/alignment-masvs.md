> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC – Alineación con OWASP MASVS v2.x  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).  

> 📎 Este documento es el análisis granular de la alineación con MASVS.  
> Para el contexto general y la tabla de resumen, consulta [`ecosystem-alignment.md`](./ecosystem-alignment.md).

---

## Sobre este documento  

Este archivo desarrolla en detalle la alineación entre el protocolo **RHC (Randomized Header Channel)** y el **OWASP Mobile Application Security Verification Standard (MASVS) v2.x**.  

> ⚠️ **Nota sobre la estructura del estándar:** MASVS v2.x utiliza un modelo de controles de un solo nivel, donde cada categoría contiene controles individuales (`MASVS-CATEGORY-N`) como unidad mínima. A diferencia de ASVS, no existen sub-requisitos numerados (por ejemplo, `V7.2.3`). El nivel de detalle presentado en este documento corresponde al **máximo nivel de trazabilidad disponible** en la especificación oficial.  

### Controles analizados  

| Control | Categoría | Statement oficial |
|---|---|---|
| MASVS-NETWORK-1 | Network | *The app secures all network traffic according to the current best practices.* |
| MASVS-NETWORK-2 | Network | *The app performs identity pinning for all remote endpoints under the developer's control.* |
| MASVS-AUTH-1 | Authentication | *The app uses secure authentication and authorization protocols and follows the relevant best practices.* |
| MASVS-RESILIENCE-4 | Resilience | *The app implements anti-dynamic analysis techniques.* |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en MASVS. Posiciona RHC/CIL como una capa complementaria dentro del marco de verificación existente, no como un reemplazo de ningún control.  

---

## Tabla de mapeo — RHC y MASVS v2.x  

| Control MASVS | Declaración oficial | Relación con RHC |
|---|---|---|
| MASVS-NETWORK-1 | *La aplicación asegura todo el tráfico de red de acuerdo con las mejores prácticas actuales.* | RHC introduce una capa adicional de entropía y variabilidad en el canal de comunicación, complementando las prácticas seguras de transporte al dificultar la correlación y automatización del tráfico |
| MASVS-NETWORK-2 | *La aplicación implementa pinning de identidad para todos los endpoints remotos bajo control del desarrollador.* | Mientras el pinning asegura la autenticidad del endpoint remoto, RHC complementa este control introduciendo verificación de continuidad del canal, abordando la coherencia del flujo más allá de la identidad del servidor |
| MASVS-AUTH-1 | *La aplicación utiliza protocolos seguros de autenticación y autorización y sigue las mejores prácticas relevantes.* | RHC no interviene en los mecanismos de autenticación, pero complementa estos flujos añadiendo validación de continuidad del canal, reduciendo la viabilidad de reutilización de patrones de comunicación válidos |
| MASVS-RESILIENCE-4 | *La aplicación implementa técnicas contra el análisis dinámico.* | Los patrones dinámicos introducidos por RHC incrementan la variabilidad del tráfico en tiempo de ejecución, elevando el costo de análisis dinámico y dificultando la ingeniería inversa del comportamiento del canal |

---

## Análisis Formal — MASVS-NETWORK-1  

**Control:** *The app secures all network traffic according to the current best practices.*  

Este control establece que la aplicación móvil debe proteger todas sus comunicaciones de red siguiendo las mejores prácticas vigentes. En la práctica esto implica el uso correcto de TLS, evitar APIs inseguras de bajo nivel y no deshabilitar las configuraciones seguras de la plataforma.  

### Límite del modelo MASVS  

MASVS-NETWORK-1 asegura que:  

✅ El tráfico esté cifrado  
✅ Se usen las mejores prácticas de transporte  
✅ No se deshabiliten configuraciones seguras de la plataforma  

Sin embargo, **no verifica la continuidad, coherencia o legitimidad del canal de comunicación a lo largo del tiempo**

En particular:  

- No se valida que los patrones de tráfico sean legítimos  
- No se detecta reutilización estructural del tráfico  
- No se distingue entre tráfico legítimo y tráfico replicado con fidelidad  
- No se evalúa la coherencia temporal o contextual del canal  

### Brecha identificada (FCHA en contexto móvil)  

El ataque FCHA es especialmente relevante en apps móviles donde los flujos API son predecibles:  

> Una app móvil puede enviar tráfico cifrado y válido,  
> pero su patrón de comunicación puede ser replicado por un atacante  
> sin necesidad de romper el cifrado.  

Esto ocurre porque:  

- ✅ MASVS-NETWORK-1 protege el **contenido y el transporte**  
- ❌ MASVS-NETWORK-1 no protege la **consistencia del flujo del canal**  

### Contribución de RHC  

RHC complementa MASVS-NETWORK-1 introduciendo:  

> **CIL — Communication Integrity Layer**  

- Entropía dinámica por request sobre el canal ya cifrado  
- Variabilidad estructural que dificulta la correlación del tráfico  
- Verificación de continuidad del flujo entre requests  

RHC no reemplaza las mejores prácticas de red que exige este control — **opera como una capa adicional sobre ellas**.  

---

## Análisis Formal — MASVS-NETWORK-2  

**Control:** *The app performs identity pinning for all remote endpoints under the developer's control.*  

Este control establece el uso de certificate pinning o public key pinning para garantizar que la app solo confíe en CAs o certificados específicos, en lugar de todos los CAs raíz del sistema. Esto protege contra ataques MITM incluso con certificados aparentemente válidos.  

### Límite del modelo MASVS  

MASVS-NETWORK-2 asegura que:  

✅ La identidad del endpoint remoto sea verificada con alta precisión  
✅ No se acepten certificados de CAs no esperadas  
✅ Se reduzca el riesgo de MITM con certificados fraudulentos  

Sin embargo, **no aborda la coherencia del flujo una vez que la conexión está establecida**.  

En particular:  

- El pinning valida el extremo de la conexión, no el comportamiento del canal  
- Una vez establecida la conexión, el flujo puede ser replicado  
- No existe verificación de continuidad entre los mensajes intercambiados  

### Brecha identificada (FCHA)  

> Un atacante que opera dentro de un canal con pinning válido  
> puede replicar el patrón de comunicación sin necesidad de comprometer el certificado.  

Esto ocurre porque:  

- ✅ MASVS-NETWORK-2 protege la **identidad del endpoint**  
- ❌ MASVS-NETWORK-2 no protege la **consistencia del flujo del canal tras la conexión**  

### Contribución de RHC  

RHC complementa MASVS-NETWORK-2 añadiendo verificación de continuidad del canal sobre la conexión ya autenticada por pinning:  

- Sobre la identidad verificada del endpoint → RHC añade verificación del comportamiento del canal  
- Ambos controles operan en capas distintas y se complementan
- Pinning: *¿con quién me conecto?* — **RHC: *¿el flujo se comporta de forma legítima?*.**  

---

## Análisis Formal — MASVS-AUTH-1  

**Control:** *The app uses secure authentication and authorization protocols and follows the relevant best practices.*  

Este control establece que la app debe implementar protocolos de autenticación y autorización seguros en sus comunicaciones con endpoints remotos, siguiendo las mejores prácticas (OAuth 2.0, OpenID Connect, JWT con configuración segura, etc.).  

### Límite del modelo MASVS  

MASVS-AUTH-1 asegura que:  

✅ Los protocolos de autenticación sean seguros  
✅ La autorización esté correctamente implementada  
✅ Se sigan las mejores prácticas para los protocolos en uso  

Sin embargo, **no verifica la continuidad del canal de comunicación sobre el que operan esos protocolos**.  

En particular:  

- La autenticación valida la identidad, no el comportamiento del flujo  
- Un token JWT válido puede ser utilizado en un flujo replicado  
- No existe control sobre la continuidad del flujo autenticado

### Brecha identificada (FCHA)  

Flujos móviles con JWT hacia backends remotos son especialmente susceptibles a FCHA:  

> Un atacante puede reutilizar un flujo de autenticación válido  
> replicando el flujo de comunicación autenticado sin modificar el token  
> ni romper el protocolo de autenticación.  

Esto ocurre porque:  

- ✅ MASVS-AUTH-1 protege la **identidad y autorización**  
- ❌ MASVS-AUTH-1 no protege la **continuidad y coherencia del canal autenticado**  

### Contribución de RHC  

RHC no interviene en los mecanismos de autenticación que exige este control. Opera de forma complementaria:  

- Sobre el flujo autenticado → RHC añade verificación de continuidad del canal  
- Reduce la viabilidad de reutilización de patrones de comunicación válidos  
- MASVS-AUTH-1: *¿quién eres?* — **RHC: *¿tu flujo se comporta como debe?*.**  

---

## Análisis Formal — MASVS-RESILIENCE-4  

**Control:** *The app implements anti-dynamic analysis techniques.*  

Este control establece que la aplicación debe implementar técnicas que dificulten el análisis dinámico en tiempo de ejecución — incluyendo la detección de instrumentación dinámica, anti-hooking, y mecanismos que impidan la modificación del código en tiempo de ejecución.  

### Límite del modelo MASVS  

MASVS-RESILIENCE-4 asegura que:  

✅ Sea difícil observar el comportamiento de la app en runtime  
✅ Se detecte o prevenga la instrumentación dinámica  
✅ Se incremente el costo del análisis dinámico para el atacante  

Sin embargo, **su enfoque es la protección del binario y el runtime de la app**, no del canal de comunicación como secuencia.  

En particular:  

- No cubre la variabilidad del tráfico de red en tiempo de ejecución  
- No aborda la observabilidad del patrón de comunicación desde el exterior  
- No protege contra ingeniería inversa del protocolo de comunicación a través del análisis de tráfico  

### Contribución de RHC  

RHC introduce una capa complementaria a MASVS-RESILIENCE-4 desde la perspectiva del canal:  

- Los patrones dinámicos de RHC incrementan la variabilidad del tráfico en tiempo de ejecución  
- Dificultan la ingeniería inversa del comportamiento del canal mediante análisis de tráfico externo  
- Elevan el costo de correlacionar requests para reconstruir el protocolo de comunicación  

Ambos controles apuntan al mismo objetivo desde ángulos distintos:  

- MASVS-RESILIENCE-4: *dificulta el análisis del binario y el runtime*  
- **RHC: *dificulta el análisis del canal de comunicación como comportamiento observable en el tiempo*.**  

---

## Posición general frente a MASVS  

En arquitecturas móviles donde los tokens persistentes son comunes y los flujos API son predecibles, FCHA identifica el riesgo de patrones de comunicación que se repiten entre el cliente móvil y los servicios backend.  

RHC mitiga este riesgo específico, complementando los controles existentes de MASVS sin sustituirlos:  

| Control MASVS | Capa cubierta por MASVS | Capa añadida por RHC |
|---|---|---|
| MASVS-NETWORK-1 | Seguridad del transporte y cifrado | Continuidad de la coherencia del canal de comunicación |
| MASVS-NETWORK-2 | Identidad del endpoint remoto (pinning) | Continuidad del flujo sobre la conexión autenticada |
| MASVS-AUTH-1 | Identidad y autorización del usuario | Continuidad y coherencia del canal autenticado |
| MASVS-RESILIENCE-4 | Protección del binario contra análisis dinámico | Variabilidad del canal contra análisis de tráfico externo |

> 📎 Referencia oficial: [OWASP MASVS](https://mas.owasp.org/MASVS/) — Versión estable actual: 2.x  
> 📄 Contexto general y tabla de resumen: [`ecosystem-alignment.md`](./ecosystem-alignment.md)  

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*
