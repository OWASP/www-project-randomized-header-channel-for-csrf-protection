## Audiencia objetivo

Este documento está dirigido a los revisores de OWASP que evalúan el proyecto RHC en cuanto a su madurez, alcance y alineación con los principios de seguridad.

## ¿Qué problema resuelve RHC?
RHC aborda **canales de comunicación predecibles** que permiten automatización, ataques de repetición y abuso a gran escala.

## ¿Qué NO resuelve RHC?
- Inyección SQL
- XSS
- Lógica de autenticación
- Fallas de autorización

## ¿Por qué es valioso?
La mayoría de los ataques modernos dependen de la **escala y la predictibilidad**.
RHC reduce ambas.

## Alineación con Principios OWASP
- Defensa en Profundidad
- Secure by Design (Seguridad desde el diseño)
- Definición honesta del alcance

> RHC es una defensa complementaria a nivel de protocolo, está diseñado para operar dentro de las arquitecturas de seguridad existentes, no como un reemplazo.”