# Deployment Guide (Production)

## 1) Infrastructure
- Nginx + PHP-FPM 8.3+
- MySQL 8.0+
- Redis 7+
- Object storage (S3 compatible)
- Queue workers managed by Supervisor/systemd

## 2) Environment
Set in `.env`:

- `DB_CONNECTION=mysql`
- `DB_HOST=...`
- `DB_PORT=3306`
- `DB_DATABASE=freeeducation`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`
- `QUEUE_CONNECTION=redis`
- `CACHE_STORE=redis`
- `SESSION_DRIVER=redis`
- `FILESYSTEM_DISK=s3`

## 3) Security hardening
- Force HTTPS and secure cookies
- Configure trusted proxies and HSTS
- Rotate `APP_KEY` only once before production go-live
- Enable rate limits for auth and AI routes
- Turn on activity logs for admin actions

## 4) Release process
1. `php artisan migrate --force`
2. `php artisan config:cache && php artisan route:cache`
3. `php artisan queue:restart`
4. Health-check `/` and API auth endpoints
