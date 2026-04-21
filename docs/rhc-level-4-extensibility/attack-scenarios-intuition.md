> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC — Escenarios de Ataque (Explicación Intuitiva)

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

**Tipo de documento:** Apoyo conceptual / explicación intuitiva  

---

## 🧠 Propósito

Este documento presenta una explicación simplificada e intuitiva de cómo el Protocolo RHC Nivel 4 responde ante escenarios de ataque comunes.

Está diseñado para:

- Comprensión rápida del comportamiento del sistema  
- Uso en presentaciones, demos y documentación introductoria  
- Explicar conceptos sin necesidad de formalismo matemático  

> Para el análisis formal y técnico, ver: `attack-scenarios.md`

---

## 🧪 Escenario 1 — Reproducción de flujo (FCHA básico)

### Contexto

Un atacante observa tráfico legítimo entre cliente y servidor.

- Headers válidos: H1, H2, H3  
- Token dinámico presente  
- Patrón observable en múltiples requests  

### Ataque

El atacante intenta:

1. Capturar múltiples requests  
2. Identificar patrón de headers  
3. Reproducir el flujo con los mismos valores  

### Resultado sin RHC

- El sistema acepta el request  
- El flujo parece válido  
- No hay verificación del canal  

### Resultado con RHC Nivel 4

- El header correcto no es determinista  
- Existen headers señuelo (decoys)  
- El token no es suficiente sin coherencia de canal  

📌 **Resultado:** El ataque falla por falta de consistencia estructural  

---

## 🧪 Escenario 2 — Análisis de tráfico (fingerprinting)

### Contexto

El atacante no modifica tráfico, solo observa:

- Frecuencia de headers  
- Longitud de tokens  
- Orden de aparición  

### Ataque

Construcción de modelo:

P(H | tráfico observado)

### Resultado sin RHC

- Se identifican patrones repetitivos  
- Se reduce el espacio de búsqueda  

### Resultado con RHC Nivel 4

- Distribución no uniforme  
- Tokens con longitud variable  
- Presencia de ruido (decoys)  

📌 **Resultado:** El modelo pierde precisión  

---

## 🧪 Escenario 3 — Automatización maliciosa

### Contexto

Un bot intenta ejecutar requests masivos.

### Ataque

Script automatizado:

for i in range(n):
    send_request()

### Resultado con RHC Nivel 4

- Alta tasa de fallos  
- Inconsistencia en selección de headers  
- Imposibilidad de sincronizar estado interno  

📌 **Resultado:** Incremento significativo en el costo computacional del ataque  

---

## 🧩 Intuición del modelo

El comportamiento del canal puede representarse de forma simplificada como:

C(x) = V(T(H(x)))

Donde:

- H(x): selección de header  
- T(x): transformación del token  
- V(x): validación del canal  

Un atacante intenta aproximar:

C'(x) ≈ C(x)

Pero sin acceso a:

- Estado interno del sistema (S)  
- Funciones reales del canal  
- Condiciones contextuales  

Entonces:

P(C'(x) = C(x)) → 0

---

## 🧷 Conclusión

RHC Nivel 4 no depende únicamente de ocultar valores, sino de romper la coherencia observable del canal.

El atacante puede ver el tráfico, pero no puede reconstruir su lógica interna.

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
