> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# RHC – Ataques Conocidos y Alcance de Mitigación

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## Visión General del Modelo de Amenazas

RHC está diseñado para mitigar **ataques basados en la predictibilidad**, no fallas en la lógica de la aplicación.

---

## Aclaración del Modelo de Seguridad

> Esta sección responde directamente a una pregunta técnica frecuente al evaluar RHC:
> *"Los ataques CSRF no requieren que el atacante conozca el nombre del header — la política de mismo origen del navegador ya previene el descubrimiento cross-origin de headers. ¿Por qué entonces aporta valor RHC?"*

La respuesta es que **RHC no asume que el secreto del nombre del header sea la defensa**.

El modelo de seguridad de RHC opera sobre un principio distinto: **la imprevisibilidad del canal como costo operativo**.

Un atacante que observa el tráfico legítimo puede aprender el slot activo y el token en una solicitud capturada. La defensa de RHC no es impedir ese conocimiento puntual — es que ese conocimiento **no es reutilizable**:

- El slot activo cambia en cada solicitud o ciclo
- El token varía en longitud, codificación y valor
- En Nivel 4, existen headers señuelo que el atacante no puede distinguir del canal real sin acceso al estado interno del servidor

Esto incrementa el costo de los **ataques automatizados y a escala** — que son precisamente el vector donde los mecanismos de capa de aplicación (token fijo por sesión) tienen menor resistencia una vez que el flujo de autenticación ha sido comprometido o en sistemas donde múltiples clientes operan de forma autónoma.

> RHC no pretende ser la única defensa. Opera como capa complementaria (defense-in-depth) sobre los mecanismos de capa de aplicación existentes, incrementando el costo operativo del ataque sin reemplazar los controles fundamentales.

---

## Clases de Ataques Impactadas

### 1. Ataques a Nivel de Red
- Interceptación de tráfico
- Escucha pasiva
- Correlación de metadatos

**Impacto**: RHC reduce la reutilización y el valor operativo del tráfico capturado.

### 2. Ataques Man-in-the-Middle (MITM)
- Ataques de repetición (replay)
- Correlación de sesiones

**Impacto**: Rompe los supuestos deterministas de encabezados y tokens.

### 3. Ataques Automatizados
- Explotación mediante bots
- Credential stuffing (a nivel de canal)
- Fuerza bruta sobre APIs

**Impacto**: Incrementa el costo de la automatización.

### 4. Reconocimiento Persistente
- Fingerprinting
- Aprendizaje de patrones

**Impacto**: Introduce entropía que degrada los modelos del atacante.

> RHC incrementa el *costo del ataque*, no ofrece prevención absoluta.

## Alcance de aplicación

El modelo de amenazas descrito en este documento aplica a los flujos de comunicación dentro del alcance del protocolo RHC.

> Para la definición formal del alcance y las limitaciones técnicas conocidas ver: [`docs/scope-and-limitations.md`](../scope-and-limitations.md)

---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
