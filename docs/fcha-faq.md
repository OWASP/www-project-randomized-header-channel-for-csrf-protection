> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# FCHA — Preguntas Frecuentes y Aclaraciones Técnicas

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## Sobre este documento

> Este documento recopila preguntas comunes, objeciones y aclaraciones  
> sobre el modelo de Flow Channel Hijacking Attack (FCHA) y su relación  
> con los marcos de seguridad existentes.  
> 
> El objetivo no es solo responder preguntas, sino clarificar el  
> posicionamiento, alcance y nivel de abstracción dentro del ecosistema  
> más amplio de ciberseguridad.  

---

## 1. ¿FCHA es simplemente resultado de un mal aislamiento o contención (por ejemplo, fallas en sandbox de IA)?

FCHA no intenta explicar las causas raíz a nivel de infraestructura, como fallas de contención, debilidades en sandboxing o problemas de aislamiento de entornos.

En cambio, FCHA opera en una capa distinta: cómo los sistemas establecen y mantienen confianza en flujos de comunicación multi-etapa a través de componentes distribuidos.

Incluso en entornos correctamente aislados, si los sistemas validan interacciones únicamente a nivel de solicitud individual —sin verificar la continuidad, el contexto y la integridad conductual del flujo completo— aún pueden aceptar flujos reconstruidos o fuera de contexto como legítimos.

Por lo tanto, FCHA complementa los modelos de contención al abordar cómo se acumula la confianza a lo largo de secuencias de comunicación, no solo cómo se aísla la ejecución.

---

## 2. ¿FCHA ya está cubierto por STRIDE, movimiento lateral o modelos de integridad de sesión?

Modelos existentes como STRIDE, movimiento lateral e integridad de sesión describen comportamientos específicos de ataque dentro o entre componentes del sistema.

Por ejemplo:
- STRIDE (Tampering) se enfoca en modificación no autorizada de datos
- Movimiento lateral se enfoca en la progresión del atacante entre sistemas
- Integridad de sesión se enfoca en mantener el estado válido de una sesión

FCHA opera en un nivel de abstracción distinto.

Se enfoca en la continuidad y coherencia conductual del flujo de comunicación a lo largo del tiempo —no solo en acciones dentro de un componente o transiciones entre componentes.

Más que reemplazar estos modelos, FCHA puede entenderse como una perspectiva unificadora que expone una brecha común:
la ausencia de verificación de integridad a nivel de flujo en interacciones distribuidas de múltiples pasos.

---

## 3. ¿En qué se diferencia FCHA del "misuse of valid functionality" (por ejemplo, OWASP Automated Threats)?

Los modelos de misuse describen cómo la funcionalidad legítima de una aplicación puede ser abusada una vez que el canal de comunicación ya ha sido establecido y considerado confiable.

FCHA aborda una etapa anterior del proceso:

Cuestiona si el flujo de comunicación en sí debería ser confiable desde el inicio.

En otras palabras:
- Los modelos de misuse preguntan: *¿qué está haciendo la entidad dentro del sistema?*
- FCHA pregunta: *¿el flujo que conecta a esa entidad con el sistema es coherente, continuo y contextualmente válido en el tiempo?*

Esta distinción se vuelve crítica en sistemas distribuidos y arquitecturas agentic, donde la confianza se propaga implícitamente a través de múltiples pasos.

---

## 4. ¿FCHA es simplemente una forma de ataque de replay?

FCHA incluye el replay como una de sus variantes (Flow Replay), pero no se limita a él.

Los ataques tradicionales de replay se enfocan en reutilizar solicitudes previamente capturadas.

FCHA va más allá al considerar:
- Reconstrucción de flujos completos de múltiples pasos
- Mimicry conductual de secuencias legítimas
- Inserción o modificación de pasos dentro de flujos activos
- Cambio de contexto (ejecución de flujos válidos fuera de su intención original)

La característica definitoria no es la reutilización de datos, sino la reproducción o manipulación de la *estructura del flujo*.

---

## 5. ¿FCHA requiere atacantes avanzados o capacidades de IA?

No.

Aunque los sistemas de IA (especialmente los agentic) hacen estos escenarios más visibles y escalables, el problema subyacente es arquitectónico.

Cualquier sistema que:
- Dependa de comunicación en múltiples pasos
- Valide solicitudes de forma individual
- No verifique la continuidad del flujo

puede ser susceptible a ataques tipo FCHA.

La IA incrementa la velocidad, adaptabilidad y autonomía de estos ataques, pero no es un requisito.

---

## 6. ¿RHC es una solución completa para FCHA?

No.

RHC (Randomized Header Channel) se presenta como un enfoque conceptual y en etapa temprana para explorar mecanismos de mitigación contra ataques de integridad a nivel de flujo.

Introduce entropía controlada a nivel del canal de comunicación para reducir la reproducibilidad de los flujos.

Sin embargo:
- No es una solución completa ni definitiva
- Requiere validación empírica adicional
- Debe entenderse como parte de una línea de investigación más amplia

FCHA define el espacio del problema; RHC es una exploración inicial de posibles defensas.

---

## 7. ¿FCHA reemplaza modelos o frameworks de seguridad existentes?

No.

FCHA no reemplaza modelos existentes como TLS, OAuth, JWT ni frameworks de modelado de amenazas establecidos.

En cambio, resalta una dimensión de la seguridad de comunicaciones que no está explícitamente cubierta:

la continuidad, integridad conductual y coherencia contextual de los flujos de comunicación en sistemas distribuidos.

FCHA debe entenderse como una capa analítica complementaria.

---

## 8. ¿Por qué definir FCHA como una clase de ataque separada?

FCHA se propone como una clase independiente porque su capa objetivo es distinta.

La mayoría de los modelos de ataque existentes operan en uno de los siguientes niveles:
- Transporte (intercepción de red)
- Identidad (robo de credenciales)
- Payload (manipulación de datos)

FCHA opera en la capa de flujo:
la estructura, secuencia y continuidad conductual de la comunicación a lo largo del tiempo.

Esta distinción se vuelve especialmente relevante en:
- Arquitecturas de microservicios
- Sistemas dirigidos por eventos
- Pipelines de agentes de IA
- Flujos de automatización distribuida

---

## 9. ¿Cuál es el nivel de madurez actual de FCHA?

FCHA es actualmente un modelo conceptual respaldado por:
- Observaciones empíricas en desarrollo de sistemas reales
- Correspondencia estructural con comportamientos documentados en sistemas de IA

La validación experimental formal en diversas arquitecturas sigue siendo un área abierta de investigación.

El modelo continúa evolucionando mediante discusión comunitaria, retroalimentación y análisis continuo.

--- 

## 10. ¿Cómo puede contribuir la comunidad?

Se invita activamente a la retroalimentación, crítica y discusión.

Áreas relevantes de contribución incluyen:
- Identificación de solapamientos con modelos existentes
- Propuesta de mecanismos de detección o mitigación
- Desarrollo de pruebas de concepto (PoC)
- Mapeo de FCHA a estándares existentes (por ejemplo, OWASP ASVS, MASVS, AIVSS)
- Cuestionamiento de supuestos y refinamiento del modelo

Este documento evolucionará conforme surjan nuevos aportes.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
