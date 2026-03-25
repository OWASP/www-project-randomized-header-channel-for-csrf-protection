# RHC – Ataques Conocidos y Alcance de Mitigación

## Visión General del Modelo de Amenazas

RHC está diseñado para mitigar **ataques basados en la predictibilidad**, no fallas en la lógica de la aplicación.

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