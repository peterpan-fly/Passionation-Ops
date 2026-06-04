# Passionation Ops

Laravel 13 + Filament admin dashboard for managing Passionation creator applications, affiliate links, campaigns, conversions, payouts, and review tasks.

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8000
```

Open:

```text
http://127.0.0.1:8000/admin
```

Default local login:

```text
admin@passionation.test
PassionationAdmin!2026
```

## Laravel Cloud

See [docs/laravel-cloud.md](docs/laravel-cloud.md).

Recommended deploy command:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set these environment variables in Laravel Cloud:

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
ADMIN_PASSWORD=change-this-before-sharing
```
