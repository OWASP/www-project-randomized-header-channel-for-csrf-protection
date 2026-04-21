> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.  
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Ejemplos — Randomized Header Channel (RHC)

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

Este documento contiene los **ejemplos oficiales del Protocolo RHC**, incluyendo los flujos HTTP de los **4 niveles**, fragmentos de request y descripción del comportamiento esperado del canal en cada nivel.

> Para la descripción técnica completa de cada nivel, sus componentes y la implementación PoC, ver:  
> 🧪 [`PoC/README.md`](../PoC/README.md)

> Para la arquitectura del sistema y el modelo de entropía, ver:  
> 🏗️ [`docs/architecture.md`](./architecture.md)

> Para el marco conceptual y fundamento físico-matemático, ver:  
> 🧠 [`docs/conceptual/marco_conceptual_rhc.md`](./conceptual/marco_conceptual_rhc.md)

---

## 🔷 Nivel 1 — *Dispersión Aleatoria*

El cliente utiliza una tabla con encabezados válidos definida desde el inicio y un solo token CSRF generado por el servidor.

### Flujo

1. El servidor publica una tabla fija: `H1, H2, H3`.
2. El cliente selecciona un header al azar.
3. El token CSRF se inserta en ese header.
4. El servidor valida el header y el token.

### Ejemplo HTTP

```http
POST /v1/transfer
X-RHC-Header-2: 6F8dP2sQ9RmC1aZ7Xh4K
Content-Type: application/json
```

> Para la implementación funcional de este nivel, ver:  
> [`PoC/level_1_basic/`](../PoC/level_1_basic/)

---

## 🔷 Nivel 2 — *Entropía Dual*

El cliente utiliza una tabla con encabezados válidos y tres tokens CSRF, donde en cada ciclo se elige un header al azar y un token CSRF al azar.

### Flujo

1. El servidor publica una tabla fija: `H1, H2, H3`.
2. El cliente selecciona un header al azar.
3. El cliente selecciona uno de los 3 tokens CSRF al azar.
4. El token se inserta en ese header.
5. El servidor valida el header y el token.

### Ejemplo HTTP

```http
POST /v1/payments
X-RHC-Header-3: Zp7Qm4Ay81FsK9TdHr6W
Content-Type: application/json
```

> Para la implementación funcional de este nivel, ver:  
> [`PoC/level_2_intermediate/`](../PoC/level_2_intermediate/)

---

## 🔷 Nivel 3 — *Entropía Variable*

El cliente utiliza encabezados válidos como en los niveles anteriores, pero los tokens CSRF tienen **longitudes y codificaciones variables** generadas mediante `bin2hex(random_bytes($longitud))`, lo que incrementa la entropía real y elimina la posibilidad de inferir estructura por observación de tráfico.

### Flujo

1. El servidor publica una tabla fija: `H1, H2, H3`.
2. El cliente selecciona un header al azar.
3. El cliente selecciona un token CSRF al azar (longitud variable: 8, 16, 32 o 64 bytes).
4. El token se inserta en ese header.
5. El servidor valida el header y el token.

### Ejemplo HTTP — Token largo

```http
POST /v1/payments
X-CSRF-H3: qP4fA1wZ9kT7mB3sJ2uR8hX0VyM5nLgC
Content-Type: application/json
```

### Ejemplo HTTP — Token mediano

```http
POST /v1/payments
X-CSRF-H1: 73sPqr52WbKJgA4cL3sPYv
Content-Type: application/json
```

### Ejemplo HTTP — Token corto

```http
POST /v1/payments
X-CSRF-H2: fQ9dL7xS1mA4
Content-Type: application/json
```

> Para la implementación funcional de este nivel, ver:  
> [`PoC/level_3_advanced/`](../PoC/level_3_advanced/)

---

## 🔷 Nivel 4 — *Adaptativo Dinámico* (Dynamic Adaptive RHC)

El **Nivel 4** es la forma más robusta del protocolo. El canal ya no es solo un conjunto de headers: es un **canal vivo, dinámico y adaptativo**.

Supera los niveles previos mediante:

- Rotación dinámica de encabezados válidos
- Headers señuelo (decoys) con ruido estadístico, indistinguibles externamente
- Filtros adaptativos del servidor según contexto (carga, endpoint, intentos fallidos, hora)
- Canal que muta según condiciones externas (**Dynamic Channel Rotation — DCR**)
- Entropía multifactor
- Reacción autónoma ante patrones sospechosos (**Defense Reflex**)

Es el primer nivel **no-determinista**: imposible de resolver por análisis estático o fuerza bruta tradicional.

El servidor utiliza **filtros adaptativos** que reconocen los headers correctos e ignoran decoys.

> 📌 El atacante NO puede crear correlación estable entre headers válidos y decoys sin acceso al estado interno del sistema.

---


## ✔ 1. Headers válidos dinámicos (N por ciclo)
De una lista total, se eligen **N headers válidos** que cambian por ciclo según:
- carga (PoC)
- tiempo
- endpoint
- intentos fallidos
- comportamiento del cliente

---

## ✔ 2. Headers señuelo (Decoys) con ruido útil
- Parecen legítimos
- No se distinguen externamente
- El servidor sí puede identificarlos
- Pueden rotar o mutar

---

## ✔ 3. Filtro adaptativo del servidor
Cambia su respuesta según:
- carga (PoC)
- IP o fingerprint
- número de fallos
- endpoint
- nivel del recurso
- hora del día

El mismo cliente puede recibir escenarios distintos.

---

## ✔ 4. Dynamic Channel Rotation (DCR)
La rotación puede dispararse por:
- intentos fallidos
- métricas de entropía
- ruido
- tiempo

Una rotación invalida:
- tokens
- headers válidos
- disposición interna del canal

---

## ✔ 5. Entropía multifactor

| Factor              | Origen                |
|---------------------|-----------------------|
| Encabezados válidos | Rotados dinámicamente |
| Tokens              | Longitud variable     |
| Decoys              | Ruido estadístico     |
| Ruido útil          | Dispersión            |
| Distribución        | Anti-correlación      |
| Filtro adaptativo   | Contextual            |

El atacante NO puede crear correlación estable.

---

## ✔ 6. Reacción autónoma (Defense Reflex)
### PoC:
- decoys fijos
- longitudes dinámicas
- headers válidos fijos
- dispersión fija

### Implementación real:
- aumentar decoys ante sospecha
- modificar longitudes de token
- reducir headers válidos
- aumentar dispersión
- posible: cerrar canal temporalmente

---

### Ejemplo HTTP

```http
POST /v1/identity/update
X-RHC-H1: Cf9Gx2A7tPqLs91kZb3uQm4NsyW86Rhv   ← decoy
X-RHC-H4: TmQ8yLr29FvS13KpWg5aXb7cN0HqD4Mt   ← token real (ciclo actual)
X-RHC-H6: qP4fA1wZ9kT7mB3sJ2uR8hX0VyM5nLgC   ← decoy
X-RHC-H2: mD73sPq18YvHr52WbKx9Rf0tJgA4cLzE   ← decoy
X-RHC-H5: R9tK0wLh6BfP2uS3nQ7vX1cZpM4eD8Yr   ← token real (ciclo actual)
X-RHC-H7: Zk5Pq1Nf8GyA7uT4wE9bC3hL0sV6mJdR   ← decoy
X-RHC-H3: Hc8Lx4Vw1SgD9pQ2tR3mF6aYkB0uZ7Jn   ← decoy
X-RHC-H8: F2aQp8Vx3WnL7rC1bS9uH4kD0M5tJ6Gz   ← token real (ciclo actual)
X-RHC-H9: yN1rT5mP8bQ4vS2kJ6aW9gF3D0xH7LzC   ← decoy
Content-Type: application/json
```

> Para la implementación funcional de este nivel, incluyendo el **Analizador de entropía RHC** con el análisis de métricas, ver:  
> [`PoC/level_4_dynamic_adaptive/`](../PoC/level_4_dynamic_adaptive/)

> Para la documentación extendida del Nivel 4 (modelo formal, escenarios de ataque, extensibilidad), ver:  
> [`docs/rhc-level-4-extensibility/`](./rhc-level-4-extensibility/)

---

## 📊 Diagramas

Los diagramas del sistema están disponibles en:

- [`docs/architecture.md`](./architecture.md) — Modelo conceptual, componentes y diagrama de despliegue
- [`docs/conceptual/marco_conceptual_rhc.md`](./conceptual/marco_conceptual_rhc.md) — Fundamento físico-matemático y evolución del canal

---

## 📦 Recursos adicionales de implementación

El directorio `resources/` contiene implementaciones de seguridad listas para producción que complementan el protocolo RHC a nivel de configuración HTTP:

- [`resources/security-headers/wa_config2_headers.php`](../resources/security-headers/wa_config2_headers.php) — Implementación de encabezados de seguridad HTTP alineada con OWASP Secure Headers Project
- [`resources/security-headers/README.md`](../resources/security-headers/README.md) — Documentación del recurso

> Mientras RHC protege la **integridad del canal**, estos recursos fortalecen la **configuración de seguridad base** del servidor y navegador.

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
