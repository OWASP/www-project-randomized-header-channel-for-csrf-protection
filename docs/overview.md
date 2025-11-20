# Overview

The Randomized Header Channel (RHC) technique is a mitigation method for Cross-Site Request Forgery (CSRF) attacks. RHC dynamically selects one header from a predefined pool to carry the CSRF token per request, breaking deterministic traffic patterns and making automated replay or interception attacks more difficult.

## Motivation

CSRF attacks exploit predictable token delivery. RHC introduces randomness in token placement to reduce the risk of automated attacks and replay attempts.

## Threat Model

- **Adversary**: Can send crafted requests from third-party origins but cannot access server-side secrets.  
- **Goal**: Perform unauthorized actions by predicting token location.  
- **Limitations**: RHC mitigates but does not fully prevent CSRF attacks; best combined with standard protections.

## Goals

- Increase unpredictability of CSRF token delivery.
- Maintain compatibility with common web frameworks.
- Provide a clear, concise summary for reviewers and contributors.

## References

- Flores Alvarado, F. *Randomized Header Channel: A Practical Approach to CSRF Mitigation*. Medium, 2025.  
- OWASP Foundation. [CSRF Prevention Cheat Sheet](https://owasp.org/www-project-cheat-sheets/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)  
- PoC repository: [OWASP RHC GitHub](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)
