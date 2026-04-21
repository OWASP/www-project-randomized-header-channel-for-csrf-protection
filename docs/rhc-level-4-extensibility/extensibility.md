> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC Level 4 — Extensibilidad y Evolución del Protocolo

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Propósito de este documento

Este documento describe la arquitectura extensible del Nivel 4 del protocolo RHC, los principios que gobiernan su evolución, y los límites técnicos que cualquier extensión debe respetar para preservar las propiedades de seguridad del sistema.

Para la formalización matemática de los conceptos aquí descritos, ver [`formal-model.md`](formal-model.md).  
Para el análisis de comportamiento del canal ante ataques concretos, ver [`attack-scenarios.md`](attack-scenarios.md).

---

## El Nivel 4 como base extensible

El Nivel 4 no representa un límite funcional del protocolo, sino una **base arquitectónica** sobre la cual es posible construir mecanismos avanzados de integridad del canal.

Su capa de dispersión dinámica está diseñada como una **capa de abstracción intercambiable**: los métodos de selección y estructuración del canal — headers válidos, tokens, señuelos y las relaciones entre ellos — pueden definirse, combinarse o sustituirse sin alterar el principio operativo central del protocolo.

Esto permite que una implementación concreta:

- Incorpore distintos algoritmos de selección (deterministas, probabilísticos o híbridos)
- Ajuste dinámicamente su comportamiento según el contexto operativo en tiempo de ejecución
- Evolucione mediante reglas internas sin modificar la interfaz externa del sistema

Como resultado, el comportamiento del canal deja de ser una propiedad fija del protocolo base y se convierte en una **propiedad emergente de la implementación específica**.

---

## Mutación estructural del canal

Cuando dos métodos matemáticos distintos operan simultáneamente dentro de la misma capa de dispersión, su interacción no produce una suma de comportamientos independientes: produce un **tercer comportamiento que no existía en ninguno de los dos por separado**.

Este fenómeno se denomina en este documento **mutación estructural del canal** — término propuesto en el contexto de este protocolo para describir la propiedad por la cual la composición de dos funciones de selección genera un espacio de comportamiento cualitativamente nuevo, no derivable mediante el análisis aislado de ninguno de sus componentes.

Las consecuencias de seguridad de esta propiedad son concretas:

- Un atacante que conozca ambos métodos de selección por separado **no puede inferir el comportamiento del canal combinado** sin acceso al estado interno del sistema en ejecución.
- Dos sistemas que adopten RHC Nivel 4 pueden compartir la misma especificación base, pero **generar canales estructuralmente distintos**, con su propia mutación, limitando directamente la reutilización de patrones de ataque entre entornos.

Esta propiedad es la que hace que el canal resultante sea **no transferible entre implementaciones**, aunque ambas compartan el mismo protocolo de base.

> **Nota técnica:** La mutación estructural del canal no es aleatoriedad arbitraria. Es una propiedad determinista dentro del contexto del sistema: reproducible internamente, opaca externamente.

---

## Extensibilidad controlada y restricciones del modelo

La arquitectura del Nivel 4 permite incrementar la complejidad del canal de forma controlada. Sin embargo, cualquier extensión del modelo debe respetar tres restricciones fundamentales para preservar las propiedades de seguridad del protocolo:

**1. Coherencia verificable entre emisor y receptor**  
El canal debe poder validarse internamente. Una extensión que introduzca comportamiento no verificable por el receptor rompe la integridad del protocolo.

**2. Reproducibilidad determinista dentro del contexto del sistema**  
El canal debe ser reproducible de forma consistente dentro de su propio entorno de ejecución. Sin esta propiedad, el sistema no puede distinguir errores de canal de intentos de manipulación externa.

**3. Independencia del estado observable externamente**  
El comportamiento del canal no debe poder inferirse desde el exterior del sistema, independientemente del volumen de tráfico capturado.

Bajo estas restricciones, el modelo puede extenderse legítimamente para integrar:

- Estrategias adaptativas basadas en contexto (carga del sistema, tipo de operación, nivel de criticidad)
- Mecanismos de variación de entropía en tiempo de ejecución
- Lógicas de selección influenciadas por señales internas del sistema

---

## Integración con sistemas de inteligencia artificial

En escenarios avanzados, la capa de dispersión del Nivel 4 puede interactuar con modelos de inteligencia artificial para ajustar dinámicamente el comportamiento del canal en función de patrones operativos o señales de contexto.

Esta integración está sujeta a restricciones explícitas de diseño:

- La IA actúa exclusivamente como **mecanismo auxiliar de ajuste de parámetros**, no como componente de decisión sobre la validez del canal.
- Toda decisión que afecte a la integridad del flujo debe permanecer bajo la lógica verificable del protocolo, no bajo inferencia del modelo.
- El comportamiento del canal debe mantenerse auditable: los ajustes introducidos por el componente de IA deben registrarse y ser reproducibles bajo las mismas condiciones de entrada.

> Estas restricciones no son opcionales. Su violación introduce un vector de ataque que no existe en implementaciones sin componente de IA: la manipulación del comportamiento del canal mediante la influencia indirecta del modelo auxiliar.

---

## Consideraciones de seguridad y alcance de la extensibilidad

El objetivo de la extensibilidad no es maximizar la complejidad del canal de forma arbitraria, sino **incrementar el costo de inferencia y reproducción del canal desde una perspectiva externa**, sin comprometer la estabilidad operativa ni la verificabilidad interna del sistema.

RHC Nivel 4 no busca generar canales impredecibles en sentido absoluto. Busca generar canales **no transferibles y contextualmente dependientes** — canales cuyo patrón de comportamiento no pueda reutilizarse en otro entorno aunque el atacante tenga conocimiento completo de la especificación base.

Esta propiedad — la **mutación estructural del canal** — establece el equilibrio central del protocolo:

| Propiedad | Objetivo |
|---|---|
| Variabilidad del canal | Degradar la capacidad de modelado externo del atacante |
| Verificabilidad interna | Permitir validación confiable dentro del sistema |
| No transferibilidad | Invalidar la reutilización de patrones de ataque entre entornos |
| Determinismo contextual | Distinguir errores legítimos de intentos de manipulación |

---

## Relación con los niveles anteriores

Este documento describe propiedades que solo emergen en el Nivel 4. Los Niveles 1 a 3 establecen el andamiaje conceptual necesario para comprender por qué estas propiedades existen y qué problema resuelven.

Evaluar la extensibilidad del Nivel 4 sin haber comprendido la progresión de los niveles anteriores puede llevar a conclusiones erróneas sobre el alcance del protocolo.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
