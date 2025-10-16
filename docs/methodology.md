# Methodology

## Overview

The Randomized Header Channel (RHC) technique is a mitigation strategy for Cross-Site Request Forgery (CSRF) attacks. It dynamically selects a single header from a predefined pool to carry the CSRF token per request, breaking deterministic traffic patterns and making automated replay or interception attacks more difficult.

This document outlines the motivation, threat model, design principles, and goals of RHC, along with references to relevant research and the proof-of-concept (PoC) implementation.

---

## Motivation

Traditional CSRF defenses often rely on static headers or cookies to carry tokens, which can be predictable and exploited by automated attack tools. RHC introduces randomness in header selection to:

- Reduce the predictability of CSRF token delivery.
- Break deterministic traffic patterns that can be exploited in automated replay attacks.
- Provide a practical approach that can be implemented with minimal backend changes.

---

## Threat Model

The following assumptions define the threat model for RHC:

- **Adversary Capabilities**: The attacker can craft malicious web requests from a third-party origin but does not have access to server-side secrets.
- **Attack Goals**: Exploit predictable token delivery to perform unauthorized actions on behalf of an authenticated user.
- **Limitations**: RHC does not prevent all CSRF attacks. It is intended as a mitigation layer, ideally combined with other standard defenses such as SameSite cookies and anti-CSRF tokens.

---

## Design Principles

RHC is designed with the following principles:

1. **Randomization**: Each request carries the CSRF token in one randomly selected header from a predefined pool.
2. **Transparency**: Minimal changes are required in the backend API to support dynamic header selection.
3. **Compatibility**: Works with existing CSRF token mechanisms and frontend frameworks.
4. **Ease of Verification**: Developers can test token delivery using the included PoC.

---

## Goals

- Mitigate automated CSRF attacks by increasing unpredictability in request headers.
- Maintain compatibility with common web frameworks and development workflows.
- Provide a clear, reproducible PoC to facilitate adoption and review.
- Encourage community-driven testing and validation under OWASP guidelines.

---

## References

- Flores Alvarado, F. *Randomized Header Channel: A Practical Approach to CSRF Mitigation*. Medium, 2025.
- OWASP Foundation. [CSRF Prevention Cheat Sheet](https://owasp.org/www-project-cheat-sheets/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)
- PoC repository: [OWASP RHC GitHub](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)


---

## Mini-diagram of RHC Flow

+-------------------+       +-------------------+       +-------------------+
|   Client          |       |   Server          |       |  JWT / CSRF Token |
+-------------------+       +-------------------+       +-------------------+
         |                            |                          |
         |--- Generates token ------->|                          |
         |                            |                          |
         |--- Selects header  --------|                          |
         |     X-Server-Certified     |                          |
         |     X-Server-Sig           |                          |
         |     X-Server-Flag          |                          |
         |                            |                          |
         |--- Sends fetch  ---------->| Verifies header & token  |
         |                            |                          |
         |<---  Response OK  ---------|                          |

