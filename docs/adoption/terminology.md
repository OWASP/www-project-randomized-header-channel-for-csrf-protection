> ℹ️ **Note:** This document is written in Spanish. You can use your browser to translate it into English.
> The Spanish version is preserved intentionally as part of the project's authorship and intellectual identity.

# Terminología de Seguridad

**Autor:** Fernando Flores Alvarado  
**Proyecto Original:** RHC Protocol Core — (Randomized Header Channel)  
**Proyecto OWASP:** Randomized Header Channel for CSRF Protection (RHC)  
**Licencia:** CC BY 4.0 (documentación)  
Información detallada sobre versiones, fechas, estado y metadatos completos, consulta [`VERSION.md`](../../VERSION.md).

---

## OWASP
Open Web Application Security Project (OWASP), es una organización internacional sin fines de lucro.
Se enfoca en identificar y mitigar vulnerabilidades comunes en aplicaciones web y APIs.

## Marco de Ciberseguridad del NIST (NIST CSF)

Un marco basado en riesgos desarrollado por el **National Institute of Standards and Technology (NIST)** para gestionar y reducir el riesgo de ciberseguridad.

Define cinco funciones:
- Identificar
- Proteger
- Detectar
- Responder
- Recuperar

### PR.DS – Seguridad de los Datos
Se refiere a la protección de los datos en tránsito y en reposo para garantizar la confidencialidad e integridad.

### PR.PT – Tecnología de Protección
Salvaguardas y controles técnicos diseñados para limitar o contener el impacto de los incidentes de ciberseguridad.

### PR.AC – Control de Acceso
Mecanismos que gestionan y hacen cumplir quién puede acceder a sistemas, recursos y datos, y bajo qué condiciones.

## MITRE ATT&CK
Una base de conocimiento de acceso público que modela el **comportamiento real de los atacantes, incluyendo tácticas, técnicas y procedimientos (TTPs)**.
Se enfoca en cómo operan los adversarios, en lugar de centrarse en controles defensivos

## HMAC
*Hash-based Message Authentication Code*. Mecanismo criptográfico que combina una función hash (como SHA-256) con una clave secreta compartida para verificar simultáneamente la **integridad** y la **autenticidad** de un mensaje o token.

A diferencia de un hash simple, HMAC no puede ser replicado sin conocer la clave secreta, lo que lo hace resistente a falsificación incluso si el atacante conoce el formato del token.

> En el contexto del RHC, se recomienda HMAC para la firma de tokens en entornos productivos.

## WAF
*Web Application Firewall*. Capa de seguridad que se interpone entre el cliente y la aplicación web, analizando el tráfico HTTP/HTTPS en busca de patrones maliciosos o no autorizados.

Puede operar como dispositivo físico, servicio en la nube (Cloudflare, AWS WAF) o módulo de software. Un **falso positivo** ocurre cuando el WAF bloquea tráfico legítimo por considerarlo sospechoso, lo que puede ocurrir con encabezados no estándar como los de prefijo `X-`.

> El protocolo RHC debe validarse contra la configuración WAF del entorno destino antes de desplegarse en producción.



> Los frameworks explican *dónde* encaja RHC, no qué reemplaza.

## Ω (Omega)

Letra del alfabeto griego (mayúscula). En matemáticas se utiliza convencionalmente para representar un **espacio total de posibilidades** — el universo completo de combinaciones posibles dentro de un sistema.

En el contexto del protocolo RHC, `Ω` representa el **espacio de búsqueda del atacante**: el conjunto total de combinaciones que tendría que explorar para reproducir el canal sin acceso al estado interno del sistema.

```
Ω = |H| × |T| × |E|
```

Cuanto mayor sea `Ω`, mayor es el costo computacional y temporal del ataque.

> Ver: [`docs/rhc-level-4-extensibility/formal-model-overview.md`](../rhc-level-4-extensibility/formal-model-overview.md)


---
**© 2025 Fernando Flores Alvarado — RHC Protocol Core**  
Publicado bajo [Creative Commons BY 4.0](../../LICENSE_CC.md).

> *“Compartir con responsabilidad es inspirar para construir el futuro.”*
