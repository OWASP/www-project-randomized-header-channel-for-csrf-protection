> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.  
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Roadmap — Analizador de entropía RHC  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## Descripción general

El **Analizador de entropía RHC** es una herramienta de análisis y visualización desarrollada específicamente para el Protocolo RHC.  
Su propósito es inspeccionar estructuralmente las solicitudes HTTP generadas por el protocolo, utilizando entropía como señal heurística para detectar patrones, anomalías y comportamiento del canal a lo largo del tiempo.

Este documento define las **fases oficiales de desarrollo** del analizador, su estado actual y la visión a futuro.

---

## 📊 Estado actual

| Fase | Nombre | Estado |
|------|--------|--------|
| Phase 1 | Entropy Lab — Básico | ✅ Publicado (integrado en Nivel 4 PoC) |
| Phase 2 | Entropy Analyzer — Pro | 🔬 En desarrollo (laboratorio) |
| Phase 3 | Por definir | 🔜 Futura |

---

## 🔷 Phase 1 — Entropy Lab (Básico)

**Estado:** ✅ Publicado  
**Ubicación en el repo:** `PoC/level_4_dynamic_adaptive/public_html/entropy/`

### Descripción

Primera implementación pública del analizador, integrada directamente en el Nivel 4 del PoC.  
Proporciona una vista de entropía por solicitud individual.

### Capacidades

- Cálculo de entropía Shannon por header individual
- Cálculo de entropía Shannon por token individual
- Entropía total agregada de la solicitud
- Visualización básica mediante Chart.js
- Análisis limitado a la solicitud actual (sin historial)

### Limitaciones conocidas

- Sin análisis histórico ni comparativo entre solicitudes
- Sin correlación posicional entre headers y tokens
- Sin detección de anomalías automatizada
- Sin soporte para MegaCadenas

---

## 🔷 Phase 2 — Entropy Analyzer Pro

**Estado:** 🔬 En desarrollo — fase laboratorio  
**Disponibilidad pública:** Pendiente de completar

### Descripción

Versión avanzada del analizador, actualmente en desarrollo activo.  
Amplía significativamente las capacidades analíticas con un enfoque modular y profesional.

### Capacidades planificadas / en desarrollo

**Grupo: Componentes**
- Distribución de entropía por componentes (Headers / Tokens / MegaCadenas)
- Separación semántica Header / Token
- Análisis por categoría funcional

**Grupo: Pares (PHTP — Positional Header–Token Pairing)**
- Correlación posicional entre headers y tokens emparejados
- Entropía promedio por par Header–Token
- Superposición avanzada
- Detección de MegaCadenas fuera de PHTP

**Sistema de análisis**
- Detección de anomalías automatizada
- Tabla de patrones repetitivos
- Análisis de secuencias (MegaCadena)
- Líneas de referencia dinámicas por umbral de entropía

**Infraestructura**
- Arquitectura modular (JS separado por responsabilidad)
- Tooltips inteligentes con contexto semántico
- Sistema de refresco con animaciones
- Control inteligente por selección de solicitud

### Tecnologías

- Chart.js v3+ con plugins personalizados (`ChartReferenceLines`, `ChartRequestOverlay`)
- JavaScript ES6+ modular
- PHP backend (análisis matemático)
- Renderizado dinámico por reglas declarativas

---

## 🔷 Phase 3 — Por definir

**Estado:** 🔜 Futura  

La Phase 3 será definida una vez que la Phase 2 esté completa y publicada.  
Su alcance dependerá de los resultados, hallazgos y necesidades identificadas durante el desarrollo y uso de la Phase 2.

---

## 📌 Referencias

- Implementación Phase 1: [`PoC/level_4_dynamic_adaptive/public_html/entropy/`](../PoC/level_4_dynamic_adaptive/public_html/entropy/)
- Arquitectura del protocolo: [`docs/architecture.md`](./architecture.md)
- Documentación del Nivel 4: [`PoC/level_4_dynamic_adaptive/README.md`](../PoC/level_4_dynamic_adaptive/README.md)
- Nomenclatura: [`docs/rhc-ns-01_naming_standard.md`](./rhc-ns-01_naming_standard.md)

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *"Compartir con responsabilidad es inspirar para construir el futuro."*
