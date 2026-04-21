> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Nivel 4 — Dynamic Adaptive

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** Apache 2.0 (código) + CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

**Ruta:** `/PoC/level_4_dynamic_adaptive/`  
**Propósito:** Implementar un canal adaptativo no-determinista con encabezados válidos, decoys, entropía multifactor y filtrado contextual.

---

## 🧠 Descripción general

El **Nivel 4 — Dynamic Adaptive** es la versión más avanzada del RHC en esta serie de PoC.
Supera a los niveles previos mediante:  

- Rotación dinámica de encabezados válidos  
- Señuelos activos (decoys) con entropía estadística  
- Filtrado adaptativo según contexto  
- Canal RHC que muta bajo condiciones externas  
- Decisiones basadas en dispersión y ruido útil  
- Protección estadística contra correlación predictiva  

Es el primer nivel **realmente no-determinista**, lo que significa que **no puede ser resuelto mediante análisis estático o fuerza bruta tradicional**.  

El servidor utiliza **filtros adaptativos** que reconocen los encabezados correctos, ignorando los falsos o señuelos (decoys).  

### 🧬 Principio del Nivel 4

> **“El canal RHC ya no es un conjunto de encabezados: es un organismo.”**  
> Cambia, rota, responde y se adapta según el contexto y el comportamiento del cliente.

---

## ⚙️ Funcionamiento

El servidor utiliza **filtros adaptativos** que reconocen los encabezados correctos ignorando los señuelos. En cada ciclo:

1. De una lista total de headers, se activan **N** como válidos (configurable).
2. El resto actúa como **decoys** con valores estadísticamente plausibles.
3. El filtro adaptativo evalúa contexto para determinar qué headers aceptar.
4. Los tokens se generan con **entropía multifactor** (longitud, codificación, dispersión).
5. Una rotación periódica o gatillada invalida todo el estado anterior del canal.

---

# 🔥 Características clave del Nivel 4 — Dynamic Adaptive

### ✔ 1. Headers válidos dinámicos (N por ciclo)

De una lista total de headers, se pueden configurar **N** headers que son son válidos en cada ciclo.  

Los headers válidos pueden cambiar según:

 - **PoC (modo demostración):**
     - carga del servidor

 - **Implementación real (privada):**
     - tiempo
     - carga del servidor
     - intentos fallidos  
     - endpoint  
     - comportamiento previo del cliente  

---

### ✔ 2. Headers señuelo (Decoys) con ruido útil

No son basura: tienen valores estadísticamente plausibles que **parecen legítimos**.

- El atacante NO puede distinguirlos  
- El servidor sí  
- Pueden ser rotados o sustituidos  

---

### ✔ 3. Filtro adaptativo en el servidor

El servidor modifica su comportamiento según:

 - **PoC (modo demostración):**
      - Estado de carga  

 - **Implementación real (privada):**
      - La IP o fingerprint del cliente  
      - Número de fallos recientes  
      - Endpoint solicitado  
      - Nivel de seguridad del recurso  
      - Hora del día  
      - Estado de carga  

Esto permite que **el mismo cliente reciba distintos escenarios** en distintos ciclos.

---

### ✔ 4. Dynamic Channel Rotation (DCR)

Rotación periódica o gatillada por eventos:

 - **PoC (modo demostración):**:
      - Rotación random

 - **Implementación real (privada):**
      - Intentos fallidos  
      - Umbrales de ruido  
      - Métrica de entropía  
      - Tiempo configurable

Cada rotación invalida:

 - tokens  
 - headers válidos  
 - el arreglo interno del canal  

---

### ✔ 5. Entropía multifactor

| Factor | Origen |
|--------|--------|
| Encabezados válidos | Rotados dinámicamente |
| Tokens | Aleatorizados por longitud variable |
| Decoys | Ruido estadístico |
| Ruido útil | Basado en dispersión |
| Distribución | Protege contra correlación predictiva |
| Filtro adaptativo | Respuesta contextual |

Esto hace que, incluso con información parcial, el atacante **no pueda establecer correlación estable**.

---

### ✔ 6. Reacción autónoma (Defense Reflex)

El sistema puede:

 - **PoC (modo demostración):**:
      - decoys fijos
      - longitudes de los tokens dinamicas
      - headers válidos fijos
      - dispersión actual fija

 - **Implementación real (privada):**
      - aumentar decoys ante comportamiento sospechoso  
      - modificar longitudes de los tokens finamicamente
      - reducir los headers válidos  
      - aumentar la dispersión  

 - Posible mejora:
      - “cerrar” temporalmente el canal  

---

### ✔ 7. Compatibilidad con entornos reales
Incluye escenarios:

- Producción  
- Desarrollo  
- Localhost  
- Balanceadores  
- Subdominios API  

---

## Validación de encabezados en el PoC

El PoC valida los encabezados HTTP esperados definidos en `RHC_HEADERS`.

- **Encabezado no registrado:** Si se agrega un encabezado nuevo que no está en `RHC_HEADERS`, la API devuelve un error.  
- **Comportamiento en localhost:** El error se muestra claramente en la respuesta JSON.  
- **Comportamiento en dominio local (con CORS):** El navegador puede bloquear la respuesta debido a CORS, por lo que no se ve el mensaje en pantalla; revisar logs del servidor.  

**Nota importante:** Esto es intencional para ilustrar el mecanismo de seguridad del RHC. En un entorno real, todos los encabezados deben estar registrados, y la política CORS debe configurarse adecuadamente.

---

## 🔒 Seguridad mínima aplicada

Para garantizar la protección básica del entorno sin requerir configuraciones adicionales, este nivel incorpora un archivo **`.htaccess`** ubicado en el directorio raiz.  
Su propósito es **evitar el listado de archivos  de los directorios internos** que contienen lógica crítica (middleware, rutas y utilidades internas), sin afectar la ejecución del sistema en un entorno local o de demostración.

---

## ⚖️ Implementación demostrativa vs. integración en producción

> En este PoC, así como entorno de producción, la validación del Protocolo RHC se implementa correctamente mediante el middleware:  

> `api/middleware/rhc_dynamic_adaptive.php`

 - El uso del middleware garantiza:
   - **separación de responsabilidades**
   - **modularidad completa**
   - **arquitectura alineada con el modelo de seguridad adaptativa del protocolo RHC**  

 - En modo demostrativo, la aplicación expone los valores seleccionados (header, token) para fines educativos.
   - En producción, esta información **no debe exponerse**.

---

## 🧩 Estructura sugerida

```text
level_4_dynamic_adaptive/
│
├── api/
│   ├── include/
│   │   ├── endpoint_protector.php      → Protección mínima contra ejecución directa o acceso no autorizado.
│   │   ├── response.php                → Estandarización uniforme de respuestas en formato JSON.
│   │   └── validator.php               → Validaciones para la configuración y encabezados del Protocolo RHC.
│   ├── middleware/
│   │   ├── cors.php                    → Configuración de CORS (Cross-Origin Resource Sharing).
│   │   └── rhc_dynamic_adaptive.php    → Verifica y valida el Protocolo RHC (Randomized Header Channel), nivel adaptativo dinámico.
│   ├── routes/
│   │   └── productos.php               → Gestiona la asignación de rutas y métodos HTTP.
│   ├── index.php                       → Punto de entrada de la API.
│   └── router.php                      → Gestor de rutas internas hacia los endpoints.
│
├── back-end/
│   ├── controllers/
│   │   └── controlador_productos.php   → Controlador de productos (capa de negocio).
│   ├── core/
│   │   └── config.php                  → Configuraciones globales internas.
│   └── models/
│       └── modelo_productos.php        → Modelo de productos (capa de datos).
│
├── public_html/
│   ├── entropy/
│   │   ├── css/
│   │   │   └── style.css               → Estilos visuales.
│   │   ├── include/
│   │   │   ├── entropy_analyzer.php    → API interna del módulo para calcular la entropía.
│   │   │   └── entropy_lib.php         → Biblioteca central; implementa el cálculo matemático de entropía (Shannon).
│   │   ├── js/
│   │   │   ├── analyzer.js             → Lógica de análisis de tokens y fetch
│   │   │   ├── chart.js                → Renderizado de Chart.js
│   │   │   └── ui_control.js           → Funciones parea la Interfaz (mensajes, ocultar/mostrar elementos, etc.)
│   │   ├── entropy_viewer.php          → Interfaz principal del laboratorio de entropía (Entropy Lab).
│   │   └── index.php                   → Redirección automática hacia entropy_viewer.php.
│   │
│   ├── css/
│   │   └── style.css                   → Estilos visuales.
│   ├── js/
│   │   ├── entropy_analyzer.js         → Módulo interno de análisis matemático y generación de gráficas PNG para auditoría del Protocolo RHC.
│   │   ├── main.js                     → Módulo principal del cliente.
│   │   ├── requests.js                 → Gestión de peticiones HTTP.
│   │   ├── rhc_dynamic_adaptive.js     → Módulo RHC nivel adaptativo dinámico.
│   │   └── ui_controls.js              → Control visual y eventos de UI.
│   └── index.php                       → Interfaz para pruebas.
│
├── .htaccess                           → Protección mínima (deshabilita listado de directorios).
└── README.md                           → Documentación oficial del nivel.
```

---

# 📈 Beneficios del Nivel 4

- Alta entropía efectiva  
- Protección contra correlación temporal  
- Minimiza riesgo de fingerprint del canal  
- Dificulta extracción por fuerza bruta  
- Evade automatización predictiva  
- Imita un canal criptográfico sin llave tradicional  
- Representa un concepto demostrable ante OWASP  

---

## Objetivo técnico

- Implementar el primer nivel **realmente no-determinista** del protocolo RHC.  
- Demostrar que RHC puede comportarse como un **canal adaptativo vivo**.  
- Establecer la base para implementaciones Zero Trust y entornos distribuidos.  
- Servir como referencia ante OWASP para casos de uso de alto riesgo.  

---

# 📚 Casos de uso reales simulados

- APIs de alto riesgo  
- Identidad digital  
- Transacciones críticas  
- Sistemas antifraude  
- Reducción de superficie de ataque en endpoints expuestos  

---

## 🧪 Modo demostración — UI incluida

La interfaz permite:

- Ver la rotación de headers en tiempo real
- Mostrar historial de ciclos
- Distinguir headers válidos vs. decoys
- Medir entropía del ciclo actual
- Activar modos avanzados: ruido alto, tokens dinámicos, rotaciones rápidas

El **Entropy Lab** (`public_html/entropy/`) corresponde a la **Fase 1** del Analizador de entropía RHC: muestra entropía Shannon por header, por token y entropía total de la solicitud actual.

> 📋 Para el alcance completo del analizador y sus fases de desarrollo, ver: [`docs/entropy-analyzer-roadmap.md`](../../docs/entropy-analyzer-roadmap.md)

---

# 🏁 Conclusión

El Nivel 4 es el primer punto donde el RHC deja de ser:

> un simple mecanismo de headers

y se convierte en:

> **un canal adaptativo, vivo, no-determinista y estadísticamente distribuido.**

---

## 📌 Referencias

- Instalación y ejecución: [`/docs/installation.md`](../../docs/installation.md)
- Arquitectura extendida del Nivel 4: [`/docs/rhc-level-4-extensibility/`](../../docs/rhc-level-4-extensibility/)
- Nota sobre prefijo `X-`: [`NOTA-X-HEADERS.md`](../NOTA-X-HEADERS.md)
- Nomenclatura: [`RHC-NS-01`](../../docs/rhc-ns-01_naming_standard.md)

---

> “El caos deja de ser amenaza cuando se vuelve lenguaje entre dos inteligencias.”

---

## 📜 Licencia

- **Código fuente y scripts:** [Apache License 2.0](../../LICENSE.md)
- **Documentación y diagramas:** [Creative Commons BY 4.0](../../LICENSE_CC.md)

> © 2025 Fernando Flores Alvarado — RHC Protocol Core  
> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
