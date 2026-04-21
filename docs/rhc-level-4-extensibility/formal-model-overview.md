> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC Level 4 — Extensibility Model
**Extensibilidad de la capa de integridad del canal (CIL)**

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## 1. Propósito

Este documento define el modelo de extensibilidad del Nivel 4 del protocolo RHC.

Su objetivo es describir cómo la capa de dispersión dinámica puede ser extendida, adaptada o compuesta sin alterar los principios base del protocolo: coherencia del canal, verificabilidad interna y no-replicabilidad.

---

## 2. Modelo Formal del Canal

Definimos el canal de comunicación como una composición de funciones:

C(x) = V(T(H(x)))

Donde:

- H(x): Función de selección de headers
- T(x): Función de asignación de tokens
- V(x): Función de validación interna

Cada función puede ser reemplazada o extendida, manteniendo la estructura general del canal.

---

## 3. Propiedades del Sistema

Para que una implementación sea válida, debe cumplir:

1. Coherencia interna:
   V(T(H(x))) = válido dentro del sistema

2. Determinismo contextual:
   Dado un estado interno S,
   C(x | S) es reproducible

3. No inferibilidad externa:
   P(C(x) | observación externa) ≈ aleatorio

---

## 4. Extensibilidad del Modelo

La extensibilidad se define como la capacidad de sustituir:

H(x) → H'(x)
T(x) → T'(x)
V(x) → V'(x)

Sin romper:

C'(x) = V'(T'(H'(x)))

---

## 5. Complejidad del Canal

El espacio de búsqueda del atacante puede representarse como:

```
Ω = |H| × |T| × |E|
```

Donde:

- `|H|` = número de posibles configuraciones de headers (válidos + decoys)
- `|T|` = número de posibles configuraciones de tokens
- `|E|` = variaciones del nivel de entropía activo en el sistema

### Estados de entropía `|E|`

El sistema no opera siempre con la misma intensidad de entropía. Puede estar en distintos estados según carga, endpoint, intentos fallidos u hora del día — eso es el filtro adaptativo:

| Estado | Longitud de tokens válidos | Comportamiento |
|--------|---------------------------|----------------|
| E1     | 8 bytes                   | Entropía mínima |
| E2     | 16 bytes                  | Entropía media  |
| E3     | 32 bytes                  | Entropía alta   |
| E4     | 64 bytes                  | Entropía máxima |

### Ejemplo visual — dos ciclos consecutivos

**Escenario:** 3 headers válidos (`H-A`, `H-B`, `H-C`) + 4 decoys (`H-D1`, `H-D2`, `H-D3`, `H-D4`).

---

**Ciclo 1** — el sistema selecciona `H-B` como header válido activo, estado de entropía E2 (token de 16 bytes):

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

**Ciclo 2** — mismo método de selección, siguiente solicitud. El sistema selecciona `H-C`, estado E3 (token de 32 bytes):

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

---

### Cálculo de Ω para este escenario

```
Ω = |H| × |T| × |E|
  =  7   ×  4  ×  4  =  112 combinaciones posibles por ciclo
```

Este es el escenario base. Cuando se activa la **mutación estructural** — composición de dos métodos de selección distintos — `Ω` crece de forma no lineal: el atacante que caracterizó el patrón del Ciclo 1 no puede aplicarlo al Ciclo 3 porque el método de selección ya cambió.

> El objetivo de RHC es maximizar `Ω` bajo restricciones operativas, sin comprometer la verificabilidad interna del sistema.

---

## 6. Integración con Sistemas Adaptativos

Sea A(x) una función adaptativa (ej. IA):

C(x) = V(T(H(x, A)))

Donde A influye en la selección sin romper:

- coherencia
- validación interna

---

## 7. Consideraciones de Seguridad

El modelo busca:

Maximizar:
Costo_de_reproducción(C)

Minimizar:
Complejidad_operativa

---

## 8. Conclusión

El Nivel 4 establece un modelo donde:

El canal no es estático,
sino una función dinámica dependiente del contexto.

Esto permite construir implementaciones únicas,
no transferibles entre entornos.

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
