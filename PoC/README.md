> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# 🧪 Pruebas de Concepto — Protocolo RHC  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## 🧠 Propósito

Esta carpeta contiene las **implementaciones de referencia del Protocolo RHC (Randomized Header Channel)**, organizadas en **niveles de evolución técnica** que reflejan la madurez y profundidad del modelo de dispersión de encabezados.  

Cada nivel demuestra cómo la técnica **Controlled Chaos** evoluciona gradualmente, aumentando la **entropía**, la **complejidad adaptativa** y la **robustez contra ataques CSRF, replay e inyección**.

> “Cada nivel del protocolo no reemplaza al anterior, lo expande.”  
> — *Fernando Flores Alvarado*

---

> ⚠️Estos PoC deben interpretarse como implementaciones demostrativas.
> La adopción en entornos reales debe considerar su integración con estándares como OWASP, NIST y modelos de riesgo existentes.

---

## 🧩 Objetivo general de los PoC

Los PoC (Proof of Concept) tienen tres objetivos principales:

1. **Demostración técnica:** mostrar la funcionalidad y escalabilidad del protocolo.  
2. **Documentación de evolución:** evidenciar cómo crece la entropía y la adaptabilidad nivel a nivel.  
3. **Referencia académica:** servir como base reproducible para investigación o auditoría.  

Cada implementación está documentada en su propio `README.md`,  
incluyendo estructura de carpetas, scripts de ejemplo y descripción del flujo de autenticación.

---

## Niveles disponibles

| Nivel | Nombre | Encabezados | Tokens | Característica principal |
|-------|--------|-------------|--------|--------------------------|
| 1 | Basic | 3 fijos | 1 compartido | Dispersión mínima funcional |
| 2 | Intermediate | 3 aleatorios | 3 (fijo o aleatorio) | Entropía dual |
| 3 | Advanced | N rotables | Longitud variable | Entropía variable multiformato |
| 4 | Dynamic Adaptive | N + decoys | Multifactor | Canal no-determinista adaptativo |

> Se recomienda comenzar por el Nivel 1 y avanzar secuencialmente.

---

## Estructura

```text
PoC/
├── NOTA-X-HEADERS.md              → Nota técnica compartida: uso del prefijo X- en demos vs. producción
├── level_1_basic/
│   └── README.md                  → Descripción, estructura y objetivo del Nivel 1
├── level_2_intermediate/
│   └── README.md                  → Descripción, estructura y objetivo del Nivel 2
├── level_3_advanced/
│   └── README.md                  → Descripción, estructura y objetivo del Nivel 3
├── level_4_dynamic_adaptive/
│   └── README.md                  → Descripción, estructura y objetivo del Nivel 4
└── README.md                      → Este documento
```

---

## Instrucciones de instalación y ejecución

Ver: [`/docs/installation.md`](../docs/installation.md)

Incluye requisitos previos, configuración por nivel, URLs de acceso y observaciones de seguridad.

---

### 📁 Convención de nombres — referencia oficial

Para mantener una estructura coherente, legible y estandarizada, todos los archivos, clases y funciones del Protocolo RHC siguen las normas definidas en el documento técnico interno:  

[RHC-NS-01 — Naming Standard Specification](../docs/rhc-ns-01_naming_standard.md)

> Este documento debe consultarse para cualquier implementación o contribución al núcleo del proyecto.

---

## 📚 Documentación del código

Todos los archivos fuente de los **Proof of Concept (PoC)** utilizan el formato **DocBlock**, basado en los estándares **PHPDoc** (para PHP) y **JSDoc** (para JavaScript).

Este formato permite documentar archivos completos, funciones, clases y constantes de forma estructurada y legible, siendo reconocido por los principales entornos de desarrollo (VS Code, PhpStorm, NetBeans) y por herramientas automáticas de generación de documentación, como **phpDocumentor** o **Doxygen**.  
Admite etiquetas especializadas como `@author`, `@version`, `@param`, `@return`, `@see`, entre otras, lo que facilita la comprensión, trazabilidad y mantenimiento del código a nivel profesional.

---

## 🔗 Alineación con estándares de verificación OWASP (Conceptual)

RHC y el modelo FCHA pueden alinearse conceptualmente con los estándares de verificación OWASP al introducir la **integridad del flujo de comunicación** como una capa de seguridad complementaria.

| Estándar | Relación con los PoC |
|---|---|
| **ASVS** | Extiende las consideraciones de gestión de sesiones, seguridad en comunicaciones y arquitectura segura, abordando la continuidad del flujo como capa adicional |
| **MASVS** | Identifica el riesgo de patrones de comunicación predecibles en interacciones móvil–backend, especialmente relevante en los niveles con mayor entropía |
| **AIVSS** | Introduce consideraciones de integridad del canal en sistemas asistidos por IA y arquitecturas multi-agente, donde ocurre comunicación autónoma en múltiples pasos |

> ⚠️ **Nota de alcance:** Esta alineación es conceptual y no implica cobertura formal por parte de los controles existentes en estos estándares. Posiciona RHC como una capa complementaria dentro de los marcos de verificación existentes.

> 📄 Análisis detallado por estándar: [`/docs/adoption/ecosystem-alignment.md`](../docs/adoption/ecosystem-alignment.md)

---

## 📝 Nota técnica (aplica a todos los niveles de los PoC)

# ⚠️ Nota sobre encabezados con prefijo `X-`
### (Recomendación OWASP / Entornos de producción)

Esta Proof of Concept utiliza encabezados personalizados con el prefijo **`X-`**, por ejemplo:

 - X-Server-Certified
 - X-Server-Sig
 - X-Server-Flag

Este uso es **solo demostrativo** y **no debe utilizarse en producción real**.

> Ver nota completa sobre encabezados: [`NOTA-X-HEADERS.md`](./NOTA-X-HEADERS.md)

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
