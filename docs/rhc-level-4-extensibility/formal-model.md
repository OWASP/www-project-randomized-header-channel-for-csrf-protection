> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC Level 4 — Modelo Formal del Canal

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Propósito de este documento

Este documento formaliza matemáticamente los conceptos descritos en [`extensibility.md`](extensibility.md).

Su objetivo es expresar con precisión las propiedades del canal RHC Nivel 4 de forma que puedan ser analizadas, verificadas o extendidas por revisores técnicos con formación en criptografía, teoría de la información o seguridad formal.

Este documento no reemplaza la especificación conceptual — la complementa. Se recomienda leer primero el documento de extensibilidad antes de abordar este.

---

## 1. Definición del canal

El canal de comunicación RHC Nivel 4 se define como una composición de tres funciones:

```
C(x) = V( T( H(x) ) )
```

Donde:

- `H(x)` — Función de selección de headers: determina qué header válido transporta el flujo en cada solicitud.
- `T(x)` — Función de asignación de tokens: determina qué token se asocia al header seleccionado y con qué estructura.
- `V(x)` — Función de validación interna: verifica que la relación entre header y token sea coherente con el estado interno del sistema.

Cada función puede ser sustituida o extendida de forma independiente sin alterar la estructura general del canal, siempre que se respeten las restricciones definidas en la sección 3.

---

## 2. Propiedades formales del sistema

Para que una implementación sea considerada válida dentro del modelo RHC, debe cumplir las siguientes tres propiedades:

### 2.1 Coherencia interna

```
V( T( H(x) ) ) = válido  ←→  el canal está en estado consistente
```

El receptor debe poder verificar que la combinación de header y token recibida corresponde al estado interno esperado del sistema. Una implementación que no garantice esta propiedad no puede distinguir un flujo legítimo de uno manipulado.

### 2.2 Determinismo contextual

```
Dado un estado interno S:
C(x | S) es reproducible dentro del mismo entorno
```

El canal no es aleatorio en sentido absoluto — es determinista dentro de su contexto. Esto es lo que permite la validación interna: dado el mismo estado del sistema, el canal produce el mismo resultado. Desde fuera, sin acceso a `S`, el comportamiento aparece no determinista.

### 2.3 No inferibilidad externa

```
P( C(x) | observación externa ) ≈ distribución no predecible
```

Un atacante con acceso ilimitado al tráfico observable no puede inferir el comportamiento futuro del canal con precisión suficiente para reproducirlo. Esta propiedad es consecuencia de la combinación de entropía variable, headers señuelo y la dependencia del estado interno `S`.

---

## 3. Extensibilidad formal

La extensibilidad del modelo se define como la capacidad de sustituir cualquiera de las funciones componentes manteniendo la validez del canal:

```
H(x) → H'(x)
T(x) → T'(x)
V(x) → V'(x)
```

La implementación extendida es válida si:

```
C'(x) = V'( T'( H'(x) ) )
```

...cumple las tres propiedades de la sección 2.

Esto implica que la interfaz del canal permanece estable aunque su implementación interna cambie completamente.

---

## 4. Mutación estructural del canal

Cuando se componen dos funciones de selección distintas dentro de la misma capa de dispersión, el canal resultante exhibe una propiedad que no estaba presente en ninguna de las dos funciones por separado.

Formalmente, si `H₁(x)` y `H₂(x)` son dos funciones de selección con espacios de comportamiento `B₁` y `B₂`:

```
H_compuesta(x) = f( H₁(x), H₂(x) )
```

El espacio de comportamiento resultante `B_c` no es la unión ni la intersección de `B₁` y `B₂`:

```
B_c ≠ B₁ ∪ B₂
B_c ≠ B₁ ∩ B₂
```

Este espacio cualitativamente nuevo es lo que este protocolo denomina **mutación estructural del canal**.

La consecuencia práctica es que un atacante que haya caracterizado completamente `H₁` y `H₂` por separado no dispone de información suficiente para predecir el comportamiento de `H_compuesta`.

---

## 5. Espacio de búsqueda del atacante

El costo computacional de reproducir el canal puede expresarse como el tamaño del espacio de búsqueda que el atacante debe explorar:

```
Ω = |H| × |T| × |E|
```

Donde:

- `|H|` — número de configuraciones posibles de headers válidos y señuelos
- `|T|` — número de configuraciones posibles de tokens (incluyendo variaciones de longitud y estructura)
- `|E|` — variaciones de nivel de entropía activo en el sistema

El objetivo del protocolo es maximizar `Ω` bajo restricciones operativas, sin comprometer la verificabilidad interna del sistema.

La introducción de mutación estructural expande `Ω` de forma no lineal: al componer dos funciones de selección, el espacio resultante crece más rápido que la suma de los espacios individuales.

---

## 6. Integración de sistemas adaptativos

Sea `A(x)` una función adaptativa externa — por ejemplo, un modelo de inteligencia artificial que ajusta parámetros del canal:

```
C(x) = V( T( H(x, A) ) )
```

Donde `A` influye en la configuración de `H` o `T`, pero no en `V`.

Esta restricción es formal, no solo de diseño: permitir que `A` influya en `V` introduce una dependencia entre la función de validación y una señal externa no verificable, lo que rompe la propiedad 2.3 y convierte a `A` en un vector de ataque potencial.

---

## 7. No transferibilidad entre implementaciones

Sean dos implementaciones independientes del protocolo RHC Nivel 4:

```
C₁(x) = V₁( T₁( H₁(x) ) )
C₂(x) = V₂( T₂( H₂(x) ) )
```

Si las funciones componentes difieren en al menos una dimensión — algoritmo de selección, nivel de entropía, reglas de validación interna — entonces:

```
C₁(x) ≠ C₂(x)  para todo x relevante
```

Esto implica que el conocimiento adquirido por un atacante al analizar `C₁` no es transferible directamente a `C₂`. Los patrones de ataque exitosos contra una implementación no son reutilizables en otra.

Esta propiedad es una consecuencia directa de la mutación estructural: cada implementación genera su propia variante del canal, estructuralmente distinta de las demás aunque compartan la misma especificación base.

---

## 8. Relación con este documento y los demás

Este documento formaliza conceptos introducidos en:

- [`extensibility.md`](extensibility.md) — descripción conceptual y arquitectónica
- [`attack-scenarios.md`](attack-scenarios.md) — comportamiento del canal ante ataques concretos

Las propiedades formales definidas aquí (sección 2) son las mismas restricciones de diseño descritas en el documento de extensibilidad, expresadas en notación matemática.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
