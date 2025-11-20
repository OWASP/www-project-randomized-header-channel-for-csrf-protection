# PoC — Randomized Header Channel (demo)


## Estructura
- `api/index.php` — API intermedia que valida un único encabezado CSRF y reenvía al back-end.
- `back-end/productos.php` — End-point privado simulado.
- `public_html/index.php` — Front-end estático demo con JS que selecciona headers al azar.


## Instrucciones de ejecución (Laragon / XAMPP)
1. Copia la carpeta `PoC/` dentro de tu `www` o `htdocs`.

2. Asegúrate de que la ruta de `apiURL` en `public_html/index.php` apunte a la ruta correcta de tu API
    - por ejemplo: 
        1.- (`http://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/api/`)
        2.- (`https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/api/`)

3. Abre `public_html/index.php` desde el navegador.
    - por ejemplo: 
        1.- (`http://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/public_html/`)
        2.- (`https://localhost/www-project-randomized-header-channel-for-csrf-protection/PoC/public_html/`)

4. Prueba las peticiones con "Petición Fetch" o "Petición AJAX".


## Observaciones de seguridad en el PoC
- El PoC es una demostración educativa, NO apta para producción tal cual.
- Asegúrate de usar HTTPS y cabeceras de seguridad reales en entornos productivos.
- El manejo real de tokens debe incluir verificación criptográfica (firmas, expiración, asociación con sesión/JWT).