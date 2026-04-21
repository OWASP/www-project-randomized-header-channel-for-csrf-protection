> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# 📘 RHC-NS-01 — Naming Standard Specification  
**Estándar de Nomenclatura para Archivos, Clases y Funciones del Protocolo RHC**

## 🧾 Especificación Detallada — RHC-NS-01


**Nombre:** Convención de Nombres de Archivos — Protocolo RHC  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

**Distribución:** Pública (OWASP / Referencia académica)

---

### 🎯 Propósito

Definir una convención clara y uniforme para el nombrado de los archivos de implementación del *Protocolo RHC (Randomized Header Channel)*, asegurando coherencia, trazabilidad y compatibilidad entre niveles de desarrollo.

---

### 🧩 Formato General

`rhc_[nivel].php`


- El prefijo `rhc_` identifica el componente como parte del núcleo del protocolo.  
- El sufijo `[nivel]` describe la etapa técnica o grado de evolución del modelo.  
- La extensión `.php` especifica el lenguaje base de implementación.

---

### 🧱 Denominaciones Oficiales

| Nivel | Nombre del archivo | Descripción técnica |
|:------|:-------------------|:--------------------|
| **1 — Basic** | `rhc_basic.php` | Implementación mínima y funcional del protocolo. |
| **2 — Intermediate** | `rhc_intermediate.php` | Entropía dual: selección aleatoria de encabezado y token. |
| **3 — Advanced** | `rhc_advanced.php` | Tokens de longitud variable y rotación dinámica de headers. |
| **4 — Dynamic Adaptive** | `rhc_dynamic_adaptive.php` | Dispersión adaptativa con dispersión dinámica, encabezados señuelo y filtrado contextual. |

---

### 🧮 Convención de Nombres para Clases (lado del servidor)

Las clases del lado del servidor siguen la convención **`RHC_[Nivel]`**,  
usando *PascalCase* (inicial mayúscula por palabra) y el prefijo `RHC_`  
para mantener una asociación directa con el protocolo.

| Nivel | Nombre de la clase | Descripción |
|:------|:--------------------|:------------|
| **1 — Basic** | `class RHC_Basic` | Middleware básico: valida un único header CSRF activo. |
| **2 — Intermediate** | `class RHC_Intermediate` | Middleware con entropía dual (header + token). |
| **3 — Advanced** | `class RHC_Advanced` | Middleware avanzado con rotación de headers y tokens variables. |
| **4 — Dynamic Adaptive** | `class RHC_DynamicAdaptive` | Middleware adaptativo con dispersión dinámica, encabezados señuelo y filtrado contextual. |

> **Nota:**  
> Todas las clases se encapsulan bajo el *namespace*:
> ```php
> namespace Middleware\RHC;
> ```

---

### 💻 Convención de Nombres para Funciones (lado del cliente)

Las funciones implementadas en el cliente (por ejemplo, en `index.php` o scripts front-end)  
siguen la convención **`rhc_selectHeader_[Nivel]()`**, usando *camelCase*  
y el prefijo `rhc_` para mantener coherencia con la nomenclatura del núcleo.

| Nivel | Nombre de la función | Descripción |
|:------|:----------------------|:-------------|
| **1 — Basic** | `rhc_selectHeader_Basic()` | Selecciona aleatoriamente uno de los tres encabezados definidos (Nivel 1). |
| **2 — Intermediate** | `rhc_selectHeader_Intermediate()` | Selecciona encabezado y token de forma aleatoria y dual (Nivel 2). |
| **3 — Advanced** | `rhc_selectHeader_Advanced()` | Selecciona encabezado con token de longitud variable (Nivel 3). |
| **4 — Dynamic Adaptive** | `rhc_selectHeader_DynamicAdaptive()` | Selecciona encabezado válido entre opciones dinámicas y señuelos (Nivel 4). |

---

### 📜 Observaciones Finales

- Estas convenciones forman parte del documento normativo interno **RHC-NS-01 — File, Class & Function Naming Standard** y debe mantenerse sin modificaciones en todas las implementaciones y PoC oficiales.  
- Todo componente nuevo del *RHC Protocol Core* deberá adherirse a esta estructura de nombres.  
- Los nombres fueron diseñados para ser **autoexplicativos, consistentes y escalables**,  
  facilitando la identificación inmediata del **nivel técnico**, **rol funcional** y **ubicación lógica** dentro del protocolo.  

---

### 🗂️ Control de Revisión

| Versión | Fecha | Autor | Descripción |
|:--------|:------|:-------|:-------------|
| **1.0** | Noviembre 2025 | Fernando Flores Alvarado | Versión inicial del estándar de nomenclatura para archivos, clases y funciones del Protocolo RHC. |

---

> **Referencia:** Documento técnico interno **RHC-NS-01 — File, Class & Function Naming Standard**  
> (Revisión 1.0 — Noviembre 2025)

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
