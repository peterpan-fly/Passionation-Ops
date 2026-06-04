# Laravel Cloud Deployment Notes

This project is a Laravel 13 + Filament admin dashboard for Passionation Ops.

## Recommended Laravel Cloud Setup

- Repository: `peterpan-fly/Passionation-Ops`
- Branch: `main`
- PHP version: `8.5` if available, otherwise `8.4`
- Database: Managed Postgres or MySQL attached to the production environment
- Build command: Laravel Cloud default build is fine. If a field is required, use:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
```

- Deploy command:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Laravel Cloud automatically injects database credentials when a database is attached to the environment. Set `DB_CONNECTION` to `pgsql` for Postgres or `mysql` for MySQL.

## Required Environment Variables

```env
APP_NAME="Passionation Ops"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-generated-domain.laravel.cloud
DB_CONNECTION=pgsql
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=database
ADMIN_NAME="Passionation Admin"
ADMIN_EMAIL=admin@passionation.test
ADMIN_PASSWORD=change-this-before-public-sharing
```

Generate `APP_KEY` in Laravel Cloud's environment settings or run:

```bash
php artisan key:generate --show
```

## Initial Admin Login

The seeder creates or updates the admin user from:

- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

The local fallback is:

- Email: `admin@passionation.test`
- Password: `PassionationAdmin!2026`

Change `ADMIN_PASSWORD` in Laravel Cloud before sharing the application URL.
