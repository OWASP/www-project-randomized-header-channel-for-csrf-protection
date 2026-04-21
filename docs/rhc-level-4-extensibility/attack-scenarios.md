> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC — Escenarios de Ataque y Análisis de Comportamiento del Canal

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Propósito de este documento

Este documento ilustra el comportamiento del canal RHC Nivel 4 ante cinco clases de ataque representativas.

Para cada escenario se describe el contexto, el mecanismo del ataque, el resultado en un sistema sin RHC y el resultado con RHC Nivel 4 activo. El objetivo es demostrar que las propiedades formales del protocolo — definidas en [`formal-model.md`](formal-model.md) — tienen consecuencias concretas y verificables ante amenazas reales.

Este documento no es una prueba de seguridad formal. Es un análisis de comportamiento orientado a revisores técnicos y evaluadores del protocolo.

---

## Escenario 1 — Flow Channel Hijacking (FCHA)

### Contexto

Un atacante con capacidad de observación prolongada analiza tráfico entre servicios en un entorno distribuido.

El sistema objetivo utiliza autenticación válida (JWT o sesión activa), mantiene APIs internas entre microservicios y presenta patrones consistentes en sus headers de comunicación.

### Mecanismo del ataque

El atacante ejecuta las siguientes acciones:

1. Captura múltiples secuencias de requests válidos a lo largo del tiempo.
2. Identifica patrones en headers utilizados, orden de aparición y estructura del token.
3. Reconstruye un flujo completo que aparenta ser legítimo.
4. Reproduce ese flujo contra el sistema objetivo.

El supuesto del atacante es que si el formato, los tokens y la secuencia coinciden con lo observado, el sistema aceptará el flujo como válido.

### Resultado sin RHC

El flujo reproducido es aceptado. El sistema no dispone de mecanismo para verificar la coherencia del canal más allá de la validez del token. El atacante ejecuta acciones dentro del contexto de un flujo clonado.

**Resultado: compromiso exitoso del flujo (FCHA).**

### Resultado con RHC Nivel 4

La selección de headers es dinámica y depende del estado interno del sistema. Los headers señuelo son indistinguibles externamente de los headers válidos. La relación entre token y header depende de un estado que el atacante no puede observar.

El flujo reproducido falla la validación interna porque la coherencia del canal no puede reconstruirse desde el exterior.

**Resultado: el ataque falla por inconsistencia estructural del canal reproducido.**

---

## Escenario 2 — Modelado estadístico del canal

### Contexto

El atacante no interactúa activamente con el sistema. Realiza análisis pasivo prolongado para construir un modelo probabilístico del canal que le permita predecir configuraciones válidas.

### Mecanismo del ataque

El atacante construye el siguiente modelo a partir del tráfico observado:

- Frecuencia de aparición de headers: `P(H)`
- Distribución de longitudes de tokens: `P(T)`
- Correlación entre headers y tokens: `P(H, T)`

El objetivo es reducir la incertidumbre del canal hasta un punto donde sea posible predecir configuraciones válidas con suficiente precisión.

### Resultado sin RHC

Las distribuciones son estables a lo largo del tiempo. La correlación entre elementos es alta y consistente. El espacio de búsqueda se reduce progresivamente con cada observación adicional.

**Resultado: modelo predictivo viable con suficiente volumen de tráfico.**

### Resultado con RHC Nivel 4

Las distribuciones no son estacionarias: la entropía varía en tiempo de ejecución y las configuraciones cambian con el contexto operativo. Los headers señuelo introducen ruido estructural que contamina el modelo estadístico.

Formalmente:

```
P( H, T | observación externa ) → distribución no predecible
```

El modelo no converge o converge a una aproximación con error demasiado alto para ser operacionalmente útil.

**Resultado: el canal no es modelable de forma confiable desde observación externa.**

---

## Escenario 3 — Automatización adaptativa

### Contexto

El atacante implementa un bot que ajusta su comportamiento en función de las respuestas del sistema. No se limita a reproducir tráfico observado — intenta aprender activamente la lógica interna del canal.

### Mecanismo del ataque

El bot ejecuta el siguiente ciclo:

1. Envía requests con variaciones sistemáticas de headers y tokens.
2. Analiza las respuestas del sistema para inferir qué configuraciones son aceptadas.
3. Ajusta su estrategia en función de los resultados acumulados.
4. Intenta converger a una función que aproxime el comportamiento del canal.

El supuesto del atacante es que el sistema responde de forma suficientemente consistente ante inputs similares como para que el aprendizaje converja.

### Resultado sin RHC

El sistema presenta comportamiento determinista observable desde el exterior. El bot converge progresivamente hacia una estrategia válida.

**Resultado: automatización exitosa con suficientes iteraciones.**

### Resultado con RHC Nivel 4

El canal depende de un estado interno que no es observable desde el exterior. La respuesta del sistema no depende únicamente del input externo sino del contexto completo del sistema en ese momento. Los cambios de entropía rompen la consistencia que el bot necesita para converger.

Formalmente, no existe función `f` tal que:

```
f(x) ≈ C(x)  para todo x relevante
```

...sin acceso al estado interno `S` del sistema.

**Resultado: el aprendizaje del bot no converge.**

---

## Escenario 4 — Suplantación de agente en pipeline de IA

### Contexto

El sistema está compuesto por múltiples agentes de inteligencia artificial que interactúan entre sí mediante APIs internas. Un agente genera requests, otro ejecuta acciones de alto impacto. El atacante intenta introducir un agente falso en el pipeline.

### Mecanismo del ataque

El atacante construye un agente que:

1. Replica el comportamiento sintáctico de un agente legítimo.
2. Genera requests válidos en formato y estructura.
3. Intenta integrarse en el pipeline en un punto donde pueda influir en las acciones ejecutadas por agentes downstream.

### Resultado sin RHC

El sistema valida la identidad del agente mediante token o API key. No existe validación de coherencia del canal. El agente falso participa en el flujo porque sus credenciales son formalmente correctas.

**Resultado: el agente falso se integra exitosamente en el pipeline.**

### Resultado con RHC Nivel 4

La validación no se limita a la identidad — incluye la coherencia temporal y estructural del canal. El estado compartido entre agentes legítimos no puede ser replicado por un agente que no haya participado en el flujo desde su origen. La secuencia completa del canal no es reproducible sin acceso al estado interno acumulado.

**Resultado: el agente falso es rechazado por inconsistencia en la coherencia del canal.**

---

## Escenario 5 — Transferencia de conocimiento entre implementaciones

### Contexto

El atacante ha comprometido o analizado en profundidad un sistema que usa RHC Nivel 4. Intenta reutilizar ese conocimiento para atacar un segundo sistema que también implementa el mismo protocolo.

### Mecanismo del ataque

1. El atacante analiza la implementación A y caracteriza su comportamiento de canal.
2. Extrae los patrones de dispersión observados.
3. Aplica el mismo modelo de ataque contra la implementación B.

El supuesto es que dos sistemas que usan el mismo protocolo base tienen comportamientos de canal suficientemente similares como para que el conocimiento sea transferible.

### Resultado sin variabilidad estructural

Los dos sistemas presentan comportamientos similares. Los patrones de ataque desarrollados contra A son parcialmente efectivos contra B.

**Resultado: reutilización parcial o total del ataque.**

### Resultado con RHC Nivel 4

Cada implementación define su propia composición de funciones: `H(x)`, `T(x)` y `V(x)` pueden diferir en algoritmo, nivel de entropía o reglas internas. La mutación estructural de cada canal es distinta aunque ambas implementaciones compartan la especificación base.

Formalmente:

```
C₁(x) ≠ C₂(x)
```

El conocimiento adquirido sobre `C₁` no es transferible a `C₂` porque los canales son estructuralmente distintos.

**Resultado: el ataque no es transferible entre implementaciones.**

---

## Conclusión

Los cinco escenarios ilustran una propiedad central del Nivel 4: el atacante puede observar el canal, pero no puede reconstruirlo sin acceso al estado interno del sistema.

Esto transforma el problema de seguridad de validar identidad a **validar la coherencia del comportamiento a través del tiempo**.

RHC no elimina los ataques — incrementa su costo operativo hasta el punto en que se vuelven inviables en la práctica bajo condiciones reales de despliegue.

---

## Referencias internas

- [`extensibility.md`](extensibility.md) — base arquitectónica del modelo
- [`formal-model.md`](formal-model.md) — formalización matemática de las propiedades

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
