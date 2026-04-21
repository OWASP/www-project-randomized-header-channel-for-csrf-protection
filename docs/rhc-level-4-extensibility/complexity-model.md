> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC — Modelo de Complejidad del Canal
**Escenarios progresivos de dispersión dinámica**

**Autor:** Fernando Flores Alvarado
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)
**Licencia:** CC BY 4.0 (documentación)
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Propósito de este documento

Este documento es una extensión de [`formal-model-overview.md`](./formal-model-overview.md).

Su objetivo es mostrar cómo el espacio de búsqueda del atacante (`Ω`) crece de forma progresiva y no lineal a medida que se activan capas adicionales del protocolo RHC.

Cada nivel introduce una o más variables nuevas. Los niveles no son mutuamente excluyentes — pueden componerse. Esa composición es precisamente donde reside el poder del protocolo.

> Este documento **no expone implementaciones completas**. Muestra el comportamiento observable del canal y el impacto matemático de cada capa. El código de referencia existe en entorno local y será publicado en etapas posteriores del proyecto.

---

## Punto de partida — El ejemplo base

Antes de ver los niveles de complejidad, es importante tener claro el concepto fundamental. El siguiente ejemplo es intencionalmente simple: un solo header válido, tokens de longitud uniforme, dos ciclos consecutivos.

**Escenario:** 3 headers válidos disponibles (`H-A`, `H-B`, `H-C`) + 4 decoys (`H-D1`, `H-D2`, `H-D3`, `H-D4`). Solo 1 header válido activo por ciclo.

---

**Ciclo 1** — el sistema selecciona `H-B`, estado de entropía E2 (token de 16 bytes):

```http
POST /v1/transfer
H-D2: aX3k                          ← decoy, token corto
H-B:  mQ9rTz4wLp2sK8vN              ← válido (16 bytes)
H-D4: Rn7j                          ← decoy, token corto
H-A:  kP2x                          ← decoy este ciclo
H-D1: Yw5m                          ← decoy
H-C:  Bs4q                          ← decoy este ciclo
H-D3: Xc8n                          ← decoy
```

El servidor conoce su estado interno `S`: sabe que este ciclo `H-B` es el válido. Descarta los 6 restantes, valida el token de `H-B`. ✅

---

**Ciclo 2** — el sistema selecciona `H-C`, estado E3 (token de 32 bytes):

```http
POST /v1/transfer
H-A:  Jd6p                          ← decoy este ciclo
H-D1: Wv3m                          ← decoy
H-C:  hF7qP2sLmK9rTz4wNvX8cBn3Ry   ← válido (32 bytes)
H-D3: Yk8x                          ← decoy
H-B:  Qn5j                          ← decoy este ciclo
H-D2: Cm2r                          ← decoy
H-D4: Tp4w                          ← decoy
```

---

**Lo que ve el atacante** al observar ambos ciclos:

- 7 headers por ciclo, todos con tokens
- Nombres de headers idénticos en ambos ciclos
- Longitudes de token distintas entre ciclos
- Posición del header válido diferente en cada ciclo
- Sin patrón estático observable

El atacante no puede determinar cuál header es válido por nombre, longitud de token ni posición.

**Cálculo de Ω para este escenario base:**

```
Ω = |H| × |T| × |E|
  =  7   ×  4  ×  4  =  112 combinaciones posibles por ciclo
```

> Este es el punto de partida. A partir de aquí, cada nivel agrega una capa que multiplica — o transforma cualitativamente — el espacio de búsqueda del atacante.

---

## Índice de niveles

| Nivel | Nombre | Estado | Ω aproximado |
|-------|--------|--------|--------------|
| [Nivel 0](#nivel-0--pool-unificado-selección-random) | Pool unificado, selección random | ✅ Implementado | ~112–336 |
| [Nivel 1](#nivel-1--listas-separadas--tokens-de-longitud-variable) | Listas separadas + tokens variables | 📐 Diseñado | ~10,000+ |
| [Nivel 2](#nivel-2--selección-matemática-determinista) | Selección matemática determinista | 📐 Diseñado | No calculable externamente |
| [Nivel 3](#nivel-3--función-de-mezcla--composición-de-métodos) | Función de mezcla + composición de métodos | 📐 Diseñado | Crecimiento no lineal |
| [Nivel N](#nivel-n--extensión-abierta) | Extensión abierta | 🔭 Futuro | Ilimitado |

> **Nota sobre el Ω del Nivel 2:** cuando el método de selección depende de parámetros internos no observables (userId, key derivada), el espacio de búsqueda deja de ser numerable desde afuera. El atacante no puede hacer fuerza bruta sin primero comprometer el estado interno del sistema — eso cambia cualitativamente la naturaleza del ataque.

---

## Nivel 0 — Pool unificado, selección random

**Estado:** ✅ Implementado y validado en entorno local (noviembre 2025)

### Descripción

El sistema opera con un único pool de headers. Todos los headers del pool reciben un token generado con el mismo patrón y longitud. En cada ciclo, el sistema selecciona aleatoriamente 1 o 2 headers como válidos. Los restantes actúan como decoys con tokens de la misma estructura.

**Características:**
- Pool único: válidos y decoys comparten el mismo espacio de nombres
- Tokens de longitud uniforme (`TOK_` + 12 caracteres hex)
- Selección: `rand(1,2)` headers válidos + `shuffle()` del pool
- Validación conjunta cuando se seleccionan 2 headers válidos

### Evidencia de validación real

Los siguientes ciclos fueron registrados en telemetría durante pruebas locales:

| runId (parcial) | Headers válidos activos | Resultado |
|-----------------|------------------------|-----------|
| `1acfa2fd...` | `X-RHC-D` (1 válido) | ✅ validated |
| `f1a8d093...` | `X-RHC-B` + `X-RHC-C` (2 válidos conjuntos) | ✅ validated |
| `6f8b2b97...` | `X-RHC-E` + `X-RHC-A` (2 válidos conjuntos) | ✅ validated |

La validación conjunta de 2 headers está funcionando: el servidor rechaza la solicitud si cualquiera de los dos headers válidos falta o tiene token incorrecto.

### Cálculo de Ω

**Con 1 header válido activo:**
```
Ω = C(7,1) × |T| × |E|
  =    7    ×  4  ×  4  =  112 combinaciones posibles por ciclo
```

**Con 2 headers válidos activos (validación conjunta):**
```
Ω = C(7,2) × |T|² × |E|
  =   21   ×  16  ×  4  =  1,344 combinaciones posibles por ciclo
```

El sistema alterna entre ambos modos aleatoriamente — el atacante no sabe de antemano cuántos headers válidos tendrá que encontrar.

### ¿Cómo se calcula C(n, k)?

`C(n, k)` es la fórmula de **combinaciones** — responde a la pregunta: *"de N elementos, ¿de cuántas formas distintas puedo elegir K, sin importar el orden?"*

```
C(n, k) = n! / (k! × (n-k)!)
```

#### ¿Qué significa el símbolo `!`?

El signo `!` se llama **factorial**. Significa multiplicar ese número por todos los enteros anteriores hasta llegar a 1:

```
1! = 1
2! = 2 × 1 = 2
3! = 3 × 2 × 1 = 6
4! = 4 × 3 × 2 × 1 = 24
5! = 5 × 4 × 3 × 2 × 1 = 120
6! = 6 × 5 × 4 × 3 × 2 × 1 = 720
7! = 7 × 6 × 5 × 4 × 3 × 2 × 1 = 5040
```

Con eso en mente, los cálculos se pueden seguir paso a paso:

**C(7, 1):** de 7 headers, elige 1
```
C(7,1) = 7! / (1! × 6!) = 5040 / (1 × 720) = 7
```

**C(7, 2):** de 7 headers, elige 2
```
C(7,2) = 7! / (2! × 5!) = 5040 / (2 × 120) = 5040 / 240 = 21
```

La razón por la que el resultado es 21 y no 42 (7×6) es que el par `(X-RHC-A, X-RHC-B)` es el mismo que `(X-RHC-B, X-RHC-A)` — el orden no importa, solo cuáles dos son los válidos. La combinatoria elimina los duplicados automáticamente.

---

## Nivel 1 — Listas separadas + tokens de longitud variable

**Estado:** 📐 Diseñado — pendiente de implementación

### Descripción

En lugar de un pool unificado, el sistema opera con dos listas independientes:

- **Lista V (válidos):** headers que pueden ser seleccionados como válidos activos
- **Lista D (decoys):** headers que siempre son señuelo

Cada header en ambas listas tiene su propia longitud de token asignada. Los tokens de los decoys ya no son uniformes — cada uno tiene una longitud diferente, eliminando la longitud como señal de identificación.

**Características:**
- Lista V: 8 headers disponibles
- Lista D: 10 headers disponibles
- Selección de N headers de Lista V (N variable, ej. 2–5)
- Selección de M headers de Lista D (M variable, ej. 4–8)
- Longitud de token distinta por header en ambas listas
- Mezcla de posiciones tras la selección

### Ejemplo visual — un ciclo

**Configuración:** Lista V = 8 headers, Lista D = 10 headers. Este ciclo: 3 válidos activos + 6 decoys seleccionados.

```http
POST /v1/transfer
X-V-C:  Kp2x                                    ← decoy este ciclo (Lista V, no seleccionado)
X-D-03: mQ9rTz4w                                ← decoy (Lista D, token 8 bytes)
X-V-A:  hF7qP2sLmK9rTz4wNvX8cBn3RyQj2p         ← válido (32 bytes) ✓
X-D-07: Xc8n                                    ← decoy (Lista D, token 4 bytes)
X-V-F:  aB5k                                    ← decoy este ciclo (Lista V, no seleccionado)
X-D-01: Yw5mRn7j                                ← decoy (Lista D, token 8 bytes)
X-V-B:  Lz3qTs9w                                ← válido (8 bytes) ✓
X-D-09: Cm2rTp4wJd6p                            ← decoy (Lista D, token 12 bytes)
X-V-H:  Qn5jWv3mYk8x                            ← válido (12 bytes) ✓
X-D-05: Bs4q                                    ← decoy (Lista D, token 4 bytes)
```

**Lo que ve el atacante:**
- 10 headers en total, longitudes de token todas distintas
- No puede distinguir Lista V de Lista D por nombre ni por longitud de token
- No puede saber cuántos son válidos activos este ciclo
- Los headers de Lista V que no fueron seleccionados aparecen como decoys con tokens propios

### Cálculo de Ω

```
Lista V: C(8, 3) = 56 combinaciones de selección
Lista D: C(10, 6) = 210 combinaciones de selección
Longitudes variables: cada header tiene su propio espacio de token

Ω_base = C(8,3) × C(10,6) × |T_var|³ × |E|
        =   56  ×   210   ×    16    ×  4
        =  752,640 combinaciones posibles por ciclo
```

> El crecimiento respecto al Nivel 0 es de ~560x. Y esto es antes de agregar métodos de selección no random.

---

## Nivel 2 — Selección matemática determinista

**Estado:** 📐 Diseñado — pendiente de implementación

### Descripción

La selección aleatoria es reemplazada — o complementada — por un método matemático determinista que usa parámetros internos no observables como punto de referencia.

**Parámetros de referencia posibles:**
- `userId` del usuario autenticado en la sesión
- Una `key` derivada internamente (no expuesta al cliente)
- Combinación de ambos

**Métodos de selección posibles:**
- Serie de Fibonacci modulada por `userId % pool_size`
- Hash derivado de `userId + key + timestamp_truncado`
- Función de permutación determinista basada en la key de sesión

**Característica clave:** el resultado es reproducible internamente (el servidor puede verificar) pero no inferible externamente (el atacante no tiene acceso a `userId` interno ni a la `key`).

### Impacto en Ω

El Nivel 2 no simplemente agranda Ω numéricamente — lo hace **no enumerable desde afuera**.

```
Ω_nivel2 = f(userId, key, método)
```

El atacante que intente fuerza bruta sobre el canal primero tendría que:

1. Comprometer la sesión del usuario (conocer `userId`)
2. Comprometer la key interna del servidor
3. Conocer el método matemático utilizado
4. Ejecutar todo eso dentro de la ventana de validez del ciclo

Cada uno de esos pasos es independientemente un ataque completo. La combinación los hace compuestos.

> Cuando el espacio de búsqueda depende de estado interno no observable, `Ω` deja de ser una cifra y se convierte en una propiedad del sistema completo.

---

## Nivel 3 — Función de mezcla + composición de métodos

**Estado:** 📐 Diseñado — pendiente de implementación

### Descripción

Los niveles anteriores definen cómo se seleccionan los headers de cada lista. El Nivel 3 agrega una función que actúa sobre el resultado combinado de ambas listas tras la selección.

**Función de mezcla F_mix:**

Dado un conjunto de headers válidos seleccionados `V_sel` y decoys seleccionados `D_sel`:

```
F_mix(V_sel, D_sel) → orden_de_presentación
```

Esta función puede ser:
- Intercalado por posición par/impar
- Orden derivado de un hash del `runId`
- Permutación basada en el método del Nivel 2

**Composición de métodos:**

Diferentes endpoints o niveles de riesgo pueden usar métodos distintos activos simultáneamente:

| Endpoint | Método selección V | Método selección D | Función mezcla |
|----------|-------------------|-------------------|----------------|
| `/login` | Random | Random | Intercalado hash |
| `/transfer` | Fibonacci(userId) | Random | Permutación key |
| `/admin` | Hash(userId+key) | Fibonacci(key) | Determinista por runId |

El atacante que caracterizó el patrón de `/login` no puede aplicarlo a `/transfer`.

### Mutación estructural entre ciclos

Cuando el método de selección cambia entre ciclos (mutación estructural), el atacante que invirtió recursos en caracterizar el Ciclo N se encuentra con que el Ciclo N+K usa un método diferente.

```
Ω_efectivo = Ω_nivel2 × número_de_métodos_activos × variantes_de_mezcla
```

Este crecimiento es no lineal porque cada dimensión nueva no suma — multiplica.

---

## Nivel N — Extensión abierta

**Estado:** 🔭 Futuro

El modelo de extensibilidad del protocolo RHC (documentado en [`extensibility.md`](./extensibility.md)) permite sustituir cualquiera de las funciones del canal sin romper la estructura general:

```
C(x) = V(T(H(x)))
```

Cada función puede ser reemplazada por una implementación más compleja. Cada reemplazo agrega una dimensión nueva a Ω.

Las capas futuras pueden incluir:

- Headers con TTL individual (token expira antes que el ciclo)
- Rotación de la Lista V basada en comportamiento previo del cliente
- Integración con funciones adaptativas externas (señal de carga, hora, geolocalización)
- Composición de dos instancias RHC en paralelo para endpoints críticos

> El límite de Ω no es tecnológico — es el ingenio del diseñador del sistema.

---

## Resumen comparativo

| Nivel | Variables activas | Ω aproximado | Naturaleza del espacio |
|-------|------------------|--------------|----------------------|
| Base  | H, T, E (1 válido) | 112 | Numerable |
| 0     | H, T, E (1–2 válidos, conjuntos) | 112 – 1,344 | Numerable |
| 1     | H_v, H_d, T_var, E, N, M | 750,000+ | Numerable pero muy grande |
| 2     | + userId, key, método | No calculable externamente | No enumerable desde afuera |
| 3     | + F_mix, composición | Crecimiento no lineal | Computacionalmente irreducible dentro de la ventana del ciclo |

> **Sobre "computacionalmente irreducible":** no significa que Ω sea infinito en sentido matemático.
> Significa que el tiempo requerido para enumerarlo supera el tiempo de vida del ciclo de validación.
> Aunque una computadora cuántica pudiera calcular el siguiente estado, el canal ya cambió antes de que termine ese cálculo.
> Para fines prácticos de seguridad, el resultado es equivalente a infinito.

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core
> *"Compartir con responsabilidad es inspirar para construir el futuro."*
