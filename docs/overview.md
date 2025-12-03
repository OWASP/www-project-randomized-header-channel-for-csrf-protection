# Overview — OWASP Randomized Header Channel for CSRF Protection


## What is RHC?
The **Randomized Header Channel (RHC)** is a security technique that increases unpredictability in token-based authentication by randomly distributing CSRF-sensitive tokens across multiple valid HTTP headers. Each request selects a header slot at random, increasing entropy and reducing exploitation feasibility.


## Problem Addressed
Traditional CSRF defenses assume predictable token placement (fixed header, fixed cookie, fixed field). Attackers can automate or intercept these predictable locations.

RHC disrupts this predictability.


## How RHC Works
1. Server generates a rotation table with valid header slots.
2. Client stores the table (session/local storage).
3. Each request selects a header at random.
4. Token is transmitted through that header.
5. Server validates token + slot consistency.


## Security Benefits
- Increased entropy in the delivery mechanism.
- Harder to predict or intercept transport channel.
- Prevents token-target automation.
- Resistant to replay attempts tied to specific header slots.
- Compatible with stateless systems and JWT.


## Use Cases
- Single-page applications (SPA)
- Mobile apps communicating via APIs
- Distributed microservices
- High-frequency token environments


## References

- Flores Alvarado, F. *Randomized Header Channel: A Practical Approach to CSRF Mitigation*. Medium, 2025.  
- OWASP Foundation. [CSRF Prevention Cheat Sheet](https://owasp.org/www-project-cheat-sheets/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)  
- PoC repository: [OWASP RHC GitHub](https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection)
