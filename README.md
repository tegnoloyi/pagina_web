# Escorpion

Escorpion es una tienda online de ropa urbana y de entrenamiento para hombre, desarrollada con Laravel 12, PHP 8.2, Blade, Tailwind 4 y Vite.

## Stack

- Laravel 12
- PHP 8.2
- SQLite para desarrollo
- Blade + Tailwind 4
- Vite para assets frontend

## Requisitos

- Composer
- Node.js + npm
- PHP 8.2

## Instalación

1. Clona el proyecto.
2. Instala dependencias de PHP:
   ```bash
   composer install
   ```
3. Instala dependencias front-end:
   ```bash
   npm install
   ```
4. Copia el ejemplo de entorno:
   ```bash
   cp .env.example .env
   ```
5. Genera la clave de la app:
   ```bash
   php artisan key:generate
   ```
6. Ejecuta migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
7. Compila los assets:
   ```bash
   npm run build
   ```
8. Levanta el proyecto:
   ```bash
   php artisan serve
   ```

## Acceso al admin

La zona administrativa está protegida con el guard web y se accede en:

- http://localhost:8000/admin/login

Credenciales por defecto en desarrollo (desde .env):

- Email por defecto: `admin@vestir.test` (o customízalo con `ADMIN_SEED_EMAIL`)
- Contraseña: `ADMIN_SEED_PASSWORD`

> El login del admin usa el mismo flujo de autenticación con throttling que ya viene configurado.

## Scripts útiles

```bash
php artisan test
npm run build
```
