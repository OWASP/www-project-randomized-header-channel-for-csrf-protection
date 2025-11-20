# Randomized Header Channel for CSRF Protection


**Project lead:** Fernando Flores Alvarado


**Short description:**
Randomized Header Channel is a CSRF mitigation technique that dynamically selects one header from a predefined pool to carry the CSRF token per request, breaking deterministic traffic patterns and making automated replay/interception harder.


**Status:** Approved project — OWASP Foundation


## Contents
- `PoC/` — Proof-of-concept demo (simple PHP + static frontend)
- `docs/` — Design and methodology documents
- `LICENSE` — Apache License 2.0 (code)
- `NOTICE` — Attribution notice


## Quick start (local)
1. Clone or fork the repository.
2. Copy `PoC/` to your local webserver (Laragon, XAMPP, etc.).
3. Serve the `public_html` folder and update the `apiURL` in `public_html/index.php` to point to your local API endpoint (e.g., `http://localhost/midominio/api/`).
4. Test by running the frontend and clicking "Petición Fetch" or "Petición AJAX".


## What to include when contributing
- Clear description of the change.
- Tests or reproducible steps for PoC changes.
- Respect the `CODE_OF_CONDUCT.md` and `CONTRIBUTING.md`.


## Licensing summary
- Code: Apache-2.0 (see `LICENSE`)
- Documentation / site content: CC BY-SA 4.0 (OWASP site policy)
- Personal Medium articles: CC BY 4.0 (author retained)


## Links
- OWASP project webpage: https://owasp.org/www-project-randomized-header-channel-for-csrf-protection
- GitHub repo: https://github.com/OWASP/www-project-randomized-header-channel-for-csrf-protection


---