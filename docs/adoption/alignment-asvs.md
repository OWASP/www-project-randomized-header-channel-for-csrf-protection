> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.  
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.  

# RHC – Alineación con OWASP ASVS v5.0.0  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).  
 
> 📎 Este documento es el análisis detallado de la alineación con ASVS.  
> Para el contexto general y la tabla de resumen, consulta [`ecosystem-alignment.md`](./ecosystem-alignment.md).  

---

## Sobre este documento  

Este archivo desarrolla en detalle la alineación entre el protocolo **RHC (Randomized Header Channel)** y el **OWASP Application Security Verification Standard (ASVS) v5.0.0**.  

> La referencia cruzada con ASVS fue sugerida por **Colin Watson (OWASP)** durante la revisión del trabajo relacionado con FCHA, con el objetivo de facilitar la comprensión del lugar que ocupa RHC dentro del ecosistema de verificación de seguridad.  

### Estructura del análisis  

Para cada capítulo relevante se presenta:  

1. **Tabla de mapeo** — req_id verificados contra el CSV oficial del repositorio ASVS v5.0.0  
2. **Análisis formal** — contexto del capítulo, límite del modelo, brecha identificada (FCHA), contribución de RHC y posicionamiento técnico  

### Capítulos analizados  

| Capítulo | Nombre | Archivo oficial |
|---|---|---|
| V7 | Session Management | `0x16-V7-Session-Management.md` |
| V12 | Secure Communication | `0x21-V12-Secure-Communication.md` |
| V4 | API and Web Service | `0x13-V4-API-and-Web-Service.md` |
| V15 | Secure Coding and Architecture | `0x24-V15-Secure-Coding-and-Architecture.md` |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en ASVS. Posiciona RHC/CIL como una capa complementaria dentro del marco de verificación existente, no como un reemplazo de ningún control.  

---

## V7 — Session Management  

Archivo: `0x16-V7-Session-Management.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| V7.2.3 | L1 | Fundamental Session Management Security | Este requisito establece la necesidad de tokens con alta entropía; RHC complementa este control añadiendo variabilidad del canal sin reemplazar los mecanismos criptográficos |
| V7.2.4 | L1 | Fundamental Session Management Security | Mientras este control requiere rotación de tokens, RHC añade verificación de continuidad del flujo entre autenticaciones |
| V7.5.1 | L2 | Defenses Against Session Abuse | Este control aborda el abuso de sesiones activas; sin embargo, no cubre el escenario donde la sesión es válida pero el flujo es replicado (FCHA). RHC complementa este control introduciendo validación del comportamiento del canal, cubriendo esa brecha |
| V7.5.3 | L3 | Defenses Against Session Abuse | En operaciones sensibles, RHC actúa como una capa complementaria de verificación del canal, reforzando los controles existentes |

---

### Análisis Formal — V7 Session Management  

El capítulo V7 del ASVS v5.0.0 establece controles para garantizar la seguridad de los mecanismos de sesión, enfocándose en:  

- Generación segura de tokens  
- Entropía criptográfica suficiente  
- Rotación y expiración de sesiones  
- Mitigación de abuso de sesiones activas  

Los controles mapeados con RHC en este capítulo son:  

- V7.2.3: requiere tokens con al menos 128 bits de entropía generados mediante CSPRNG  
- V7.2.4: requiere rotación de tokens en cada autenticación y reautenticación  
- V7.5.1: requiere reautenticación completa antes de modificar atributos sensibles de la cuenta (aborda abuso de sesiones activas)  
- V7.5.3: requiere verificación adicional antes de operaciones criticas (aborda abuso de sesiones activas)  

#### Límite del modelo ASVS  

Estos controles aseguran que:  

✅ El token sea impredecible  
✅ La sesión sea válida  
✅ La autenticación sea correcta  

Sin embargo, **no verifican que la interacción mantenga continuidad, sea coherente o legítima como flujo en el tiempo**.  

En particular:  

- No se valida la continuidad entre requests  
- No se detecta reutilización estructural del flujo  
- No se evalúa la coherencia temporal o contextual del canal  

#### Brecha identificada (FCHA)  

El ataque FCHA (Flow Channel Hijacking Attack) explota precisamente este vacío:  

> Un atacante puede reutilizar una sesión válida sin romper autenticación ni tokens,  
> replicando el patrón de comunicación del cliente legítimo.  

Esto ocurre porque:  

- ✅ ASVS valida identidad  
- ✅ ASVS valida sesión  
- ❌ ASVS no valida el **comportamiento del canal**  

#### Contribución de RHC  

El protocolo RHC introduce una capa adicional:  

> **CIL — Communication Integrity Layer**  

Que permite:  

- Verificar continuidad del flujo entre requests  
- Introducir entropía dinámica en cada interacción  
- Detectar desviaciones en patrones de comunicación  

Relación específica con cada control mapeado:  

- Sobre V7.2.3 → añade entropía dinámica del canal sobre la entropía estática del token  
- Sobre V7.2.4 → refuerza la rotación mediante validación de continuidad del flujo  
- Sobre V7.5.1 → cubre el escenario donde la sesión es válida pero el flujo es replicado (FCHA)  
- Sobre V7.5.3 → actúa como verificación secundaria del canal en operaciones sensibles  

#### Posicionamiento técnico  

RHC no reemplaza los controles de V7. Opera como:  

> **Un mecanismo complementario que extiende la seguridad de sesión  
> hacia la validación de la continuidad y consistencia del flujo del canal.**  

Mientras ASVS V7 responde a:  
> *"¿La sesión es segura?"*  

RHC responde a:  
> *"¿La sesión se está utilizando de forma legítima a lo largo del tiempo?"*  

#### Conclusión  

El capítulo V7 establece una base sólida para la seguridad de sesiones, con enfoque en identidad y control de estado. RHC amplía este modelo hacia la integridad del flujo de comunicación, lo cual resulta especialmente relevante en:  

- Aplicaciones con sesiones persistentes  
- APIs con tokens reutilizables  
- Sistemas con alta interacción automatizada  
- Entornos donde el patrón de uso es tan importante como la autenticación  

---

## V12 — Secure Communication  

Archivo: `0x21-V12-Secure-Communication.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| V12.1.1 | L1 | General TLS Security Guidance | Este requisito asegura el uso de versiones TLS recomendadas; RHC opera sobre esta base introduciendo verificación de continuidad del canal |
| V12.3.1 | L2 | General Service to Service Communication Security | Mientras este control protege todas las conexiones entre servicios mediante cifrado, RHC complementa añadiendo validación de continuidad del flujo |
| V12.3.5 | L3 | General Service to Service Communication Security | En arquitecturas distribuidas, RHC añade una capa complementaria que evalúa la coherencia del canal más allá de los mecanismos de transporte seguro (mTLS) |

---

### Análisis Formal — V12 Secure Communication  

El capítulo V12 del ASVS v5.0.0 define los controles necesarios para garantizar la seguridad de las comunicaciones entre clientes, servicios y componentes del sistema, enfocándose en:  

- Configuración segura de TLS  
- Protección contra ataques de red (MITM, downgrade, etc.)  
- Validación de certificados y autenticación mutua (mTLS)  
- Seguridad en comunicaciones entre servicios  

Los controles mapeados con RHC en este capítulo son:  

- V12.1.1: establece el uso obligatorio de TLS 1.2/1.3 como base de comunicación segura  
- V12.3.1: define controles para todas las conexiones entrantes y salientes entre servicios  
- V12.3.5: fortalece escenarios distribuidos mediante autenticación fuerte entre endpoints (mTLS, service mesh)  

#### Límite del modelo ASVS  

Los controles de V12 garantizan que:  

✅ La comunicación esté cifrada  
✅ La integridad del mensaje esté protegida en tránsito  
✅ Las identidades de los extremos sean verificables  

Sin embargo, **no validan la continuidad, coherencia o legitimidad del canal de comunicación a lo largo del tiempo.**”

En particular:  

- No se valida la continuidad entre mensajes  
- No se detecta reutilización estructural del tráfico  
- No se evalúa la consistencia del flujo del canal  
- No se distingue entre tráfico legítimo y tráfico replicado con fidelidad  

#### Brecha identificada (FCHA)  

El ataque FCHA explota esta limitación:  

> Un atacante puede reproducir tráfico válido sobre un canal TLS legítimo,  
> sin necesidad de romper el cifrado ni comprometer certificados.  

Esto ocurre porque:  

- ✅ TLS protege el **contenido del mensaje**  
- ✅ TLS protege el **canal criptográfico**  
- ❌ TLS no protege la **consistencia del flujo del canal**  

#### Contribución de RHC  

El protocolo RHC introduce una capa adicional:  

> **CIL — Communication Integrity Layer**  

Que permite:  

- Validar la continuidad del canal de comunicación a lo largo del tiempo  
- Introducir entropía dinámica en cada interacción  
- Detectar desviaciones en el flujo de comunicación
- Diferenciar entre tráfico original y tráfico replicado  

Relación específica con cada control mapeado:  

- Sobre V12.1.1 → RHC es estrictamente una capa complementaria — no sustituye TLS, lo extiende añadiendo validación adicional del flujo de comunicación  
- Sobre V12.3.1 → en comunicaciones entre servicios, RHC introduce verificación de continuidad entre mensajes  
- Sobre V12.3.5 → en arquitecturas distribuidas basadas en microservicios o agentes, RHC permite validar la coherencia del flujo completo, no solo la autenticidad de cada nodo  

#### Posicionamiento técnico  

RHC no compite con TLS ni con los controles de V12. Opera como:  

> **Una capa complementaria que extiende la seguridad del canal  
> desde la integridad criptográfica hacia la validación de la continuidad y consistencia del flujo de comunicación.**  

Mientras ASVS V12 responde a:  
> *"¿Es seguro el canal?"*  

RHC responde a:  
> *"¿El canal se está comportando de forma legítima a lo largo del tiempo?"*  
> o
> *"¿El flujo de comunicación mantiene continuidad y consistencia a lo largo del tiempo?"*

#### Conclusión  

El capítulo V12 establece una base sólida de seguridad en comunicaciones con enfoque criptográfico y de identidad. RHC amplía este modelo incorporando validación de continuidad y consistencia del flujo de comunicación, lo cual resulta especialmente relevante en:  

- APIs modernas  
- Microservicios  
- Sistemas distribuidos  
- Arquitecturas basadas en agentes  

---

## V4 — API and Web Service  

Archivo: `0x13-V4-API-and-Web-Service.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| V4.1.3 | L2 | Generic Web Service Security | Este control asegura que los headers seteados por capas intermediarias no puedan ser sobreescritos por el usuario final; RHC utiliza este canal de headers como mecanismo de variabilidad controlada que opera bajo esa misma protección |
| V4.1.5 | L3 | Generic Web Service Security | Mientras este control introduce integridad criptográfica a nivel de mensaje, RHC añade una dimensión complementaria basada en la continuidad del comportamiento del canal |
| V4.4.3 | L2 | WebSocket | Este control aborda la gestión de tokens en comunicaciones persistentes; RHC puede implementarse como capa complementaria para verificar la continuidad del canal en estos flujos |

> Las firmas digitales por mensaje aseguran integridad criptográfica. RHC, en cambio, introduce integridad en el comportamiento del canal. Ambos operan en niveles distintos y son complementarios.  

---

### Análisis Formal — V4 API and Web Service  

El capítulo V4 del ASVS v5.0.0 establece los controles de seguridad para APIs y servicios web, que hoy representan el núcleo de interacción en aplicaciones modernas, enfocándose en:  

- Validación de requests y responses  
- Protección de endpoints contra manipulación  
- Integridad de mensajes y control de inputs  
- Seguridad en canales persistentes (WebSocket)  

Los controles mapeados con RHC en este capítulo son:  

- V4.1.3: asegura que los headers seteados por capas intermediarias (load balancer, proxy) no puedan ser sobreescritos por el usuario final  
- V4.1.5: requiere firmas digitales por mensaje para transacciones sensibles que atraviesan múltiples sistemas  
- V4.4.3: define controles para tokens dedicados en canales WebSocket cuando la gestión de sesión estándar no puede usarse  

#### Límite del modelo ASVS  

Los controles de V4 aseguran que:  

✅ Las APIs validen correctamente los datos de entrada  
✅ Los endpoints no puedan ser manipulados fácilmente  
✅ Existan mecanismos de integridad a nivel de mensaje  

Sin embargo, **no abordan completamente la dimensión de automatización del flujo**.  

En particular:  

- No se verifica la predictibilidad estructural de los requests  
- No se detecta la repetibilidad del patrón de consumo de la API  
- No se evalúa la coherencia del flujo entre múltiples llamadas encadenadas  
- No se distingue entre consumo legítimo y consumo automatizado a escala  

#### Brecha identificada (FCHA en APIs)  

El ataque FCHA se vuelve especialmente potente en este contexto:  

> Un atacante puede consumir la API usando tokens válidos, respetando  
> formatos y validaciones, replicando exactamente el patrón de requests  
> esperado — sin necesidad de romper autenticación ni evadir validaciones.  

Esto ocurre porque:  

- ✅ ASVS protege la **validez de cada request**  
- ✅ ASVS protege la **estructura del mensaje**  
- ❌ ASVS no protege la **legitimidad del flujo de comunicación como comportamiento continuo**

#### Contribución de RHC  

El protocolo RHC introduce una capa dinámica en el canal API:  

> **CIL — Communication Integrity Layer**  

Aplicado a APIs, permite:  

- Introducir variabilidad no predecible por request  
- Rompe la capacidad de replicar flujos automatizados  
- Detectar consumo anómalo basado en patrones  
- Aumentar el costo de scraping, bots y replay estructural  

Relación específica con cada control mapeado:  

- Sobre V4.1.3 → RHC utiliza headers como canal dinámico; este control garantiza que esos headers no sean manipulables por el cliente  
- Sobre V4.1.5 → RHC es conceptualmente análogo a firmas por mensaje, pero enfocado en comportamiento continuo del flujo en lugar de integridad criptográfica individual  
- Sobre V4.4.3 → en WebSockets, RHC puede funcionar como token de canal persistente con verificación dinámica de continuidad  

#### Posicionamiento técnico  

RHC no reemplaza los controles de V4. Opera como:  

> **Una capa complementaria que reduce la automatización maliciosa  
> sin afectar la validez funcional de la API.**  

Mientras ASVS V4 responde a:  
> *"¿La API valida correctamente cada request?"*  

RHC responde a:  
> *"¿La API está siendo consumida de forma legítima como flujo?"*  

#### Conclusión  

El capítulo V4 asegura que las APIs sean seguras desde el punto de vista estructural y de validación — **request-level security**. RHC amplía este modelo hacia **flow-level security**, lo cual resulta especialmente relevante en:  

- APIs públicas  
- Plataformas expuestas a bots  
- Integraciones masivas  
- Sistemas con alto grado de automatización  

---

## V15 — Secure Coding and Architecture  

Archivo: `0x24-V15-Secure-Coding-and-Architecture.md`  

| req_id | Nivel | Sección | Relación con RHC |
|---|---|---|---|
| V15.1.5 | L3 | Secure Coding and Architecture Documentation | Este requisito exige documentar las partes de la aplicación donde se usa "funcionalidad peligrosa"; la implementación de CIL como capa de verificación del canal debe documentarse explícitamente bajo este criterio |
| V15.2.5 | L3 | Security Architecture and Dependencies | Este control requiere protecciones adicionales alrededor de funcionalidad de riesgo — sandboxing, encapsulación, aislamiento; RHC introduce aislamiento lógico del canal como mecanismo complementario dentro de este modelo |

---

### Análisis Formal — V15 Secure Coding and Architecture  

El capítulo V15 del ASVS v5.0.0 define los principios de diseño seguro y las prácticas de codificación que aseguran que la arquitectura sea resistente a fallos de seguridad estructurales, enfocándose en:  

- Documentación de decisiones y funcionalidad de seguridad  
- Diseño de arquitectura segura  
- Gestión de dependencias y aislamiento de componentes  
- Reducción del impacto ante compromisos parciales del sistema  

Los controles mapeados con RHC en este capítulo son:  

- V15.1.5: requiere documentar explícitamente las partes de la aplicación donde se usa "funcionalidad peligrosa"  
- V15.2.5: requiere implementar protecciones adicionales alrededor de esa funcionalidad — sandboxing, encapsulación, contenerización o aislamiento de red — para limitar el pivoteo de un atacante entre componentes  

#### Límite del modelo ASVS  

Los controles de V15 aseguran que:  

✅ La arquitectura esté documentada  
✅ Los componentes estén correctamente aislados  
✅ Las dependencias estén controladas  
✅ Existan protecciones alrededor de funcionalidad de riesgo  

Sin embargo, **no definen explícitamente la integridad del canal de comunicación como una capa arquitectónica independiente**.  

En particular:  

- No se modela el canal de comunicación como superficie de seguridad propia  
- No se define verificación de continuidad del flujo como control arquitectónico  
- No se contempla el comportamiento del canal como parte del diseño seguro  

#### Brecha identificada (FCHA a nivel arquitectónico)  

El ataque FCHA evidencia este vacío arquitectónico:  

> Un sistema puede estar correctamente diseñado a nivel de componentes,  
> pero seguir siendo vulnerable si el canal de comunicación no tiene  
> integridad propia como entidad de diseño.  

Esto ocurre porque:  

- ✅ La arquitectura valida componentes  
- ✅ La arquitectura define límites y aislamientos  
- ❌ La arquitectura no valida el flujo como entidad protegida  

La ausencia de CIL no es un error de implementación — es una **decisión de diseño implícita que V15 no evalúa explícitamente**.  

#### Contribución de RHC  

El protocolo RHC introduce formalmente esta capa faltante:  

> **CIL — Communication Integrity Layer**  

Desde la perspectiva de V15, CIL se posiciona como:  

- Un componente arquitectónico explícito que debe documentarse (V15.1.5)  
- Un mecanismo de aislamiento lógico del canal complementario a las protecciones de V15.2.5  
- Una capa transversal entre transporte y aplicación  

Permite:  

- Limitar el impacto de compromisos de sesión o credenciales  
- Evitar que un flujo válido sea reutilizado fuera de su contexto original  
- Detectar desalineaciones entre componentes aparentemente válidos  

Relación específica con cada control mapeado:  

- Sobre V15.1.5 → CIL debe documentarse como funcionalidad que introduce verificación dinámica del canal — su presencia o ausencia es una decisión de diseño explícita  
- Sobre V15.2.5 → RHC actúa como mecanismo de aislamiento lógico del canal, reduciendo el impacto de un compromiso parcial y dificultando el pivoteo entre componentes  

#### Posicionamiento técnico  

RHC no reemplaza los principios de V15. Opera como:  

> **Una extensión arquitectónica que introduce el canal de comunicación  
> como una capa de seguridad explícita y verificable.**  

Mientras ASVS V15 responde a:  
> *"¿La arquitectura es segura por diseño?"*  

RHC responde a:  
> *"¿La comunicación dentro de esa arquitectura mantiene integridad  
> a lo largo del tiempo?"*  

#### Conclusión  

El capítulo V15 establece una base sólida para el diseño seguro de aplicaciones — arquitectura **estructural y estática**. RHC amplía este modelo hacia **seguridad arquitectónica dinámica**, introduciendo:  

- Control sobre el flujo en tiempo real  
- Integridad del flujo como propiedad de diseño
- Una nueva capa arquitectónica explícita: CIL  

Esto resulta especialmente relevante en:  

- Sistemas distribuidos  
- Microservicios  
- Arquitecturas orientadas a eventos  
- Sistemas multi-agente y automatizados  

---

## Posición general frente a ASVS  

ASVS valida la correcta implementación de controles individuales (tokens, TLS, autenticación, APIs, arquitectura).  

RHC introduce una capa adicional de verificación no contemplada explícitamente en el estándar:  

> **La Capa de Integridad de la Comunicación (CIL), que introduce verificación  
> de la continuidad y consistencia del flujo de comunicación**  

Esto implica que:  

- ASVS protege **componentes individuales**  
- RHC protege el **comportamiento del sistema como secuencia**  

RHC no contradice ASVS — lo **extiende en una capa transversal entre transporte y aplicación**.  

| Capítulo |        Cobertura de ASVS            |                       Aporte de RHC                      |
| -------- | ----------------------------------- | -------------------------------------------------------- |
| V7       | Seguridad del token y la sesión     | Continuidad y consistencia del flujo de sesión           |
| V12      | Integridad criptográfica del canal  | Continuidad y consistencia del flujo de comunicación     |
| V4       | Validez estructural de cada request | Legitimidad del patrón de consumo como flujo             |
| V15      | Arquitectura segura por componentes | Canal de comunicación como capa arquitectónica explícita |


> 📎 Referencia oficial: [OWASP ASVS](https://owasp.org/www-project-application-security-verification-standard/) — Versión estable actual: 5.0.0  
> 📄 Contexto general y tabla de resumen: [`ecosystem-alignment.md`](./ecosystem-alignment.md)  

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*
