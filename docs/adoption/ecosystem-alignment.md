
# RHC – Mapeo con Marcos de Seguridad

## Visión General
El **Randomized Header Channel (RHC)** es un **mecanismo proactivo de endurecimiento en la capa de comunicación**.
**No reemplaza** la autenticación, autorización, el cifrado ni las prácticas de codificación segura.
En su lugar, **reduce la predictibilidad y la automatización**, incrementando el costo operativo para el atacante.

---

## 1. OWASP Top 10 & OWASP API Top 10

### Posicionamiento
RHC **complementa** los controles de OWASP mediante:
- El incremento de la entropía en el canal de solicitudes
- La interrupción de ataques por repetición, correlación y automatización de bots
- La reducción de la viabilidad económica de la explotación masiva

### Idea Clave
> OWASP se enfoca en *qué está roto*
> RHC se enfoca en *qué tan fácil es explotarlo a gran escala*

---

## 2. Mapeo con el Marco de Ciberseguridad de NIST

RHC se alinea principalmente con la función **PROTEGER (PROTECT)**.

| **Categoría NIST** | **Significado**              | **Contribución de RHC**                                |
| -------------- | ------------------------ | -------------------------------------------------- |
| PR.DS          | Seguridad de los Datos   | Reduce la exposición útil de los datos en tránsito |
| PR.PT          | Tecnología de Protección | Añade entropía estructural                         |
| PR.AC          | Control de Acceso        | Complementa la protección de sesiones              |

RHC es **un mecanismo preventivo**, no detectivo ni reactivo.

---

## 3. Mapeo con MITRE ATT&CK

MITRE describe **cómo operan los atacantes**.

RHC incrementa la complejidad de los ataques y disminuye la capacidad de escalar la explotación automatizada:

- Intercepción y análisis de tráfico de red
- Abuso a nivel de aplicación
- Explotación automatizada mediante bots
- Ataques de repetición y correlación

> MITRE pregunta: *¿Qué tan fácil es para el atacante?*
> RHC responde: *Más difícil, más ruidoso y más costoso*.

---

## 4. Declaración Profesional de Posicionamiento

**Redacción correcta:**  
RHC complementa a OWASP, NIST y MITRE al reducir la predictibilidad de las comunicaciones y limitar la explotación automatizada.

**Evitar afirmar:**  
Que RHC reemplaza el cifrado, la autenticación o el OWASP Top 10.

---

## 5. Glosario (Lenguaje Claro)

**OWASP** – Comunidad que define los riesgos más comunes en aplicaciones web y APIs.
**NIST** – Marco estadounidense para la gestión del riesgo en ciberseguridad.
**MITRE ATT&CK** – Base de conocimiento de técnicas reales utilizadas por atacantes.
**PR.DS** – Protección de datos en tránsito y en reposo.
**PR.PT** – Tecnologías de seguridad que reducen activamente el riesgo.
**PR.AC** – Mecanismos de control de acceso.

---

## Reflexión Final

RHC no construye muros.
Cambia el terreno.
