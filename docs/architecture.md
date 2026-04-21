> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Arquitectura y Modelo Conceptual — Randomized Header Channel (RHC)  

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../VERSION.md).

---

## Diagrama Conceptual
```text
Cliente → [Selección de Slot Aleatorio] → Solicitud HTTP → Servidor

Headers: H1 | H2 | H3 | … | Hn
Solo un header contiene el token válido.
```
 
---

## Componentes

### **1. Tabla de Rotación**
Una lista definida de headers válidos autorizados para transportar el token de seguridad.

### **2. Algoritmo de Selección de Slot**
Un algoritmo impulsado por aleatoriedad que selecciona un header de entre `n` canales disponibles en cada solicitud.

### **3. Transporte del Token**
El token se incrusta en el header seleccionado, garantizando:
- 🔒 Impredecibilidad
- 🛡 Reducción de la exposición a ataques dirigidos al token
- ⚙ Compatibilidad con sistemas sin estado (stateless) y distribuidos

### **4. Capa de Validación**
El servidor valida la solicitud verificando:
- ✔ Que el header seleccionado exista
- ✔ Que el índice del header pertenezca a la tabla de rotación
- ✔ Firma, estructura e integridad del token
- ✔ Expiración, marcas de tiempo y requisitos de frescura

---

## 📊 Modelo de Entropía
```
entropía ≈ log2(n)
+ calidad de aleatoriedad (PRNG / CSPRNG)
+ frecuencia de solicitudes
```

➡ Incrementar `n` aumenta la impredecibilidad y fortalece la resistencia contra ataques de replay, automatización e interceptación.

---

## Diagrama de Despliegue
```text
Aplicación Cliente
        ↓
Librería Cliente RHC
        ↓
API Gateway / Middleware (PSR-15)
        ↓
Capa de Validación RHC
        ↓
Servicios de la Aplicación
```

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
