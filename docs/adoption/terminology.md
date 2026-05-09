> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Terminología de Seguridad

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

Este documento centraliza las definiciones de términos técnicos, símbolos matemáticos y conceptos propios del protocolo RHC utilizados en la documentación del proyecto.

---

## Índice

1. [Estándares y marcos de referencia](#1-estándares-y-marcos-de-referencia)
2. [Mecanismos y tecnologías de seguridad](#2-mecanismos-y-tecnologías-de-seguridad)
3. [Componentes de infraestructura y protocolo](#3-componentes-de-infraestructura-y-protocolo)
4. [Ataques y técnicas](#4-ataques-y-técnicas)
5. [Notación matemática](#5-notación-matemática)
6. [Conceptos propios del protocolo RHC](#6-conceptos-propios-del-protocolo-rhc)
7. [Glosario de términos de estándares externos](#7-glosario-de-términos-de-estándares-externos)

---

## 1. Estándares y marcos de referencia

### OWASP
Open Web Application Security Project (OWASP), es una organización internacional sin fines de lucro.
Se enfoca en identificar y mitigar vulnerabilidades comunes en aplicaciones web y APIs.

### Marco de Ciberseguridad del NIST (NIST CSF)

Marco estadounidense basado en riesgos desarrollado por el **National Institute of Standards and Technology (NIST)** para gestionar y reducir el riesgo de ciberseguridad.

Define cinco funciones:
- Identificar
- Proteger
- Detectar
- Responder
- Recuperar

#### PR.DS – Seguridad de los Datos
Se refiere a la protección de los datos en tránsito y en reposo para garantizar la confidencialidad e integridad.

#### PR.PT – Tecnología de Protección
Salvaguardas y controles técnicos diseñados para limitar o contener el impacto de los incidentes de ciberseguridad.

#### PR.AC – Control de Acceso
Mecanismos que gestionan y hacen cumplir quién puede acceder a sistemas, recursos y datos, y bajo qué condiciones.

### MITRE ATT&CK
Una base de conocimiento de acceso público que modela el **comportamiento real de los atacantes, incluyendo tácticas, técnicas y procedimientos (TTPs)**.
Se enfoca en cómo operan los adversarios, en lugar de centrarse en controles defensivos.

---

## 2. Mecanismos y tecnologías de seguridad

### HMAC
*Hash-based Message Authentication Code*. Mecanismo criptográfico que combina una función hash (como SHA-256) con una clave secreta compartida para verificar simultáneamente la **integridad** y la **autenticidad** de un mensaje o token.

A diferencia de un hash simple, HMAC no puede ser replicado sin conocer la clave secreta, lo que lo hace resistente a falsificación incluso si el atacante conoce el formato del token.

> En el contexto del RHC, se recomienda HMAC para la firma de tokens en entornos productivos.

### WAF
*Web Application Firewall*. Capa de seguridad que se interpone entre el cliente y la aplicación web, analizando el tráfico HTTP/HTTPS en busca de patrones maliciosos o no autorizados.

Puede operar como dispositivo físico, servicio en la nube (Cloudflare, AWS WAF) o módulo de software. Un **falso positivo** ocurre cuando el WAF bloquea tráfico legítimo por considerarlo sospechoso, lo que puede ocurrir con encabezados no estándar como los de prefijo `X-`.

> El protocolo RHC debe validarse contra la configuración WAF del entorno destino antes de desplegarse en producción.
>
> Los frameworks explican *dónde* encaja RHC, no qué reemplaza.

### Pinning
Técnica de seguridad que valida la identidad del servidor mediante claves criptográficas o certificados predefinidos, en lugar de depender exclusivamente de la cadena de confianza de autoridades certificadoras (CA).

Reduce el riesgo de ataques de intermediario (MitM) en entornos donde la infraestructura de PKI no puede garantizarse completamente.

### Certificate Pinning / Public Key Pinning
Técnica que asocia explícitamente un servicio con un certificado o clave pública específica, evitando confiar únicamente en autoridades certificadoras (CA).

Previene ataques donde un certificado válido pero no autorizado es utilizado para interceptar la comunicación.

### Anti-hooking
Conjunto de técnicas diseñadas para detectar o prevenir la interceptación de funciones en tiempo de ejecución (hooking), comúnmente utilizadas por malware o herramientas de análisis.

Se emplea para proteger la integridad del flujo de ejecución de una aplicación.

### mTLS (Mutual TLS)
Extensión de TLS donde tanto cliente como servidor se autentican mutuamente mediante certificados digitales.

Proporciona autenticación bidireccional además de confidencialidad e integridad en la comunicación.

### Sandboxing
Técnica de aislamiento que ejecuta código en un entorno controlado para limitar su acceso a recursos del sistema.

Se utiliza para reducir el impacto de código no confiable o potencialmente malicioso.

### Control de inputs
Mecanismo que valida, filtra o restringe los datos de entrada hacia un sistema para prevenir comportamientos no deseados o maliciosos.

### Control de outputs incorrectos
Conjunto de mecanismos destinados a prevenir, detectar o filtrar salidas erróneas, inseguras o no deseadas generadas por un sistema.

---

## 3. Componentes de infraestructura y protocolo

### Proxy
Intermediario que reenvía solicitudes entre cliente y servidor. Puede utilizarse para control de acceso, monitoreo o anonimización.

### Load Balancer
Componente que distribuye tráfico entre múltiples servidores para mejorar disponibilidad, escalabilidad y tolerancia a fallos.

### Endpoints
Puntos específicos de acceso a un servicio o API donde se reciben o envían solicitudes.

### Headers HTTP
Metadatos incluidos en solicitudes y respuestas HTTP que describen el contexto de la comunicación (autenticación, formato, control de caché, etc.).

### Headers seteados
Encabezados HTTP definidos explícitamente por la aplicación o infraestructura para controlar el comportamiento del protocolo o del flujo de comunicación.

### WebSocket
Protocolo de comunicación bidireccional y persistente sobre una única conexión TCP, utilizado para interacción en tiempo real.

### Service Mesh
Capa de infraestructura que gestiona la comunicación entre servicios en arquitecturas distribuidas, proporcionando control, observabilidad y seguridad.

### Sistemas downstream
Componentes o servicios que reciben datos o acciones desde otro sistema dentro de un flujo de procesamiento.

### Agentes downstream
Agentes dentro de un sistema multi-agente que reciben instrucciones, datos o eventos de otros agentes previos en la cadena de ejecución.

### Timestamp
Marca de tiempo asociada a un evento o acción, utilizada para ordenar, validar o auditar secuencias dentro de un sistema.

### Payload
Datos contenidos dentro de una solicitud o respuesta que representan la información principal transmitida.

### Base64
Esquema de codificación que convierte datos binarios en texto ASCII.

Se utiliza comúnmente para transporte de datos, aunque puede emplearse para ocultar contenido en ciertos contextos.

### Trazabilidad
Capacidad de reconstruir el historial de acciones, eventos o decisiones dentro de un sistema mediante registros verificables.

### Semántica
Significado lógico o intención de un dato, mensaje o instrucción, más allá de su estructura o formato.

### Malware
Software diseñado para ejecutar acciones maliciosas en un sistema, como robo de información, control remoto o alteración de procesos.

---

## 4. Ataques y técnicas

### MITM (Man-in-the-Middle)
Ataque donde un adversario intercepta y potencialmente altera la comunicación entre dos partes sin que estas lo detecten.

### Downgrade Attack
Ataque que fuerza a un sistema a utilizar versiones más débiles de un protocolo o mecanismo de seguridad.

### Replay estructural
Técnica donde un atacante replica la estructura de una secuencia de comunicación válida para simular comportamiento legítimo sin comprender completamente su contenido.

### Scraping
Extracción automatizada de datos desde sistemas o interfaces, generalmente sin autorización explícita.

### Bots
Programas automatizados que interactúan con sistemas simulando comportamiento humano o ejecutando tareas repetitivas a gran escala.

### Ataque de inyección
Clase de ataque donde se introducen datos maliciosos en un sistema para alterar su comportamiento (ej. SQL injection).

### Tampering (manipulación de datos)
Alteración no autorizada de datos en tránsito o en reposo con el objetivo de modificar su significado o efecto.

### Vector de ataque
Camino o método mediante el cual un atacante logra explotar una vulnerabilidad en un sistema.

---

## 5. Notación matemática

### `!` — Factorial

El signo `!` se llama **factorial**. Aplicado a un número entero positivo, significa multiplicar ese número por todos los enteros anteriores hasta llegar a 1.

```
1! = 1
2! = 2 × 1 = 2
3! = 3 × 2 × 1 = 6
4! = 4 × 3 × 2 × 1 = 24
5! = 5 × 4 × 3 × 2 × 1 = 120
6! = 6 × 5 × 4 × 3 × 2 × 1 = 720
7! = 7 × 6 × 5 × 4 × 3 × 2 × 1 = 5040
```

El factorial es la base de la fórmula de combinaciones `C(n, k)`, utilizada en el modelo de complejidad del canal RHC para calcular el espacio de búsqueda del atacante.

> Ver: [`docs/rhc-level-4-extensibility/complexity-model.md`](../rhc-level-4-extensibility/complexity-model.md)

### Ω (Omega)

Letra del alfabeto griego (mayúscula). En matemáticas se utiliza convencionalmente para representar un **espacio total de posibilidades** — el universo completo de combinaciones posibles dentro de un sistema.

En el contexto del protocolo RHC, `Ω` representa el **espacio de búsqueda del atacante**: el conjunto total de combinaciones que tendría que explorar para reproducir el canal sin acceso al estado interno del sistema.

```
Ω = |H| × |T| × |E|
```

Cuanto mayor sea `Ω`, mayor es el costo computacional y temporal del ataque.

> Ver: [`docs/rhc-level-4-extensibility/formal-model-overview.md`](../rhc-level-4-extensibility/formal-model-overview.md)

---

## 6. Conceptos propios del protocolo RHC

### CIL — Communication Integrity Layer

*Capa de Integridad de la Comunicación.* Capa arquitectónica introducida por el protocolo RHC, encargada de validar la continuidad del comportamiento del canal entre interacciones.

A diferencia de las capas de cifrado (TLS) o autenticación, la CIL no verifica la identidad del cliente ni la confidencialidad del mensaje — verifica que el flujo de comunicación mantiene el patrón de comportamiento esperado según el estado del canal (modelo de rotación).

RHC opera en la CIL como mecanismo de endurecimiento defensivo complementario a las capas de seguridad existentes.

> Ver:
> - [`docs/scope-and-limitations.md`](../scope-and-limitations.md)
> - [`docs/security-properties.md`](../security-properties.md)

### Modelo de rotación

Mecanismo interno del canal RHC que determina cómo se genera un nuevo pool de headers al finalizar cada ciclo de validación exitoso. No está estandarizado — cada institución que adopte RHC define sus propios métodos de selección de headers válidos, decoys y reordenamiento de la lista resultante.

El canal opera sobre tres estados posibles:

- **Continuidad:** validación correcta → acceso al recurso → generación de nuevo pool con los métodos internos definidos.  
- **Inválido recuperable:** la institución puede definir mecanismos de segunda oportunidad (refresh, reautenticación).  
- **Inválido terminal:** intentos fallidos reiterados → rechazo definitivo (HTTP 403) → reinicio completo del canal.  

Lo que RHC garantiza en cualquier implementación es que el nuevo estado del canal sea opaco externamente y verificable internamente.  

> Ver:
> - [`docs/rhc-level-4-extensibility/extensibility.md`](../rhc-level-4-extensibility/extensibility.md)
> - [`docs/rhc-level-4-extensibility/complexity-model.md`](../rhc-level-4-extensibility/complexity-model.md)

### FCHA — Flow Channel Hijacking Attack

*Ataque de Secuestro de Canal de Flujo.* Clase de ataque que explota la ausencia de una Capa de Integridad de la Comunicación (CIL) para interferir con el flujo de comunicación entre cliente y servidor.

FCHA se diferencia de los ataques clásicos de secuestro de sesión en que no explota el canal ya establecido, sino el **proceso mediante el cual el canal gana confianza** — es decir, la continuidad del comportamiento del flujo, no las credenciales o tokens que lo identifican.

> Ver: [`docs/adoption/threat-model.md`](./threat-model.md)

### Analizador de Entropía RHC

Herramienta de observabilidad del canal desarrollada como parte del protocolo RHC. Permite analizar el canal de comunicación como secuencia de flujo en el tiempo, evaluando su variabilidad y coherencia para identificar desviaciones que no serían visibles analizando mensajes individuales.

- **Fase 1:** publicada
- **Fase 2:** en desarrollo

> Referenciado en la alineación con AIVSS C13 — Monitoring, Logging & Anomaly Detection.

---

## 7. Glosario de términos de estándares externos

Esta sección reúne términos técnicos cuya definición proviene directamente de estándares externos referenciados en la documentación del proyecto. Se incluyen aquí para facilitar la lectura de los documentos de alineación sin necesidad de consultar las fuentes originales.

### *covert channels* esteganográficos estadísticos
Patrones en la salida de un sistema que, mediante distribuciones sesgadas o selección específica de tokens, pueden codificar información oculta sin alterar aparentemente el contenido visible. Incluye anomalías en la distribución de outputs que podrían usarse para transmitir datos de forma encubierta.

**Estándar de origen:** AIVSS v1.0  
**Referenciado en:** [`docs/adoption/alignment-aivss.md`](./alignment-aivss.md) — Análisis Formal C07, Análisis Formal C13

### Jailbreak
Técnica de ataque que busca evadir las restricciones de comportamiento de un modelo de IA mediante secuencias de instrucciones que, individualmente, no son maliciosas, pero en conjunto logran manipular el comportamiento del sistema.

**Estándar de origen:** AIVSS v1.0  
**Referenciado en:** [`docs/adoption/alignment-aivss.md`](./alignment-aivss.md) — Análisis Formal C13

### Binario de aplicación / Runtime
El binario es el código compilado o ejecutable de una aplicación. El runtime es el entorno de ejecución activo en tiempo de operación. Ambos son superficie de análisis en técnicas de ingeniería inversa y análisis dinámico.

**Estándar de origen:** OWASP MASVS v2.x  
**Referenciado en:** [`docs/adoption/alignment-masvs.md`](./alignment-masvs.md) — Análisis Formal MASVS-RESILIENCE-4

---

**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *"Compartir con responsabilidad es inspirar para construir el futuro."*
