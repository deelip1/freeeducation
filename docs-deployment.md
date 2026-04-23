# Deployment Guide (Production)

## 1) Infrastructure
- Nginx + PHP-FPM 8.3+
- MySQL 8.0+ (primary relational store)
- Redis 7+ (queue/cache/session)
- Object storage (S3 compatible)
- Queue workers managed by Supervisor/systemd

## 2) Environment essentials
Set in `.env`:
- `APP_ENV=production`
- `DB_CONNECTION=mysql`
- `QUEUE_CONNECTION=redis`
- `CACHE_STORE=redis`
- `SESSION_DRIVER=redis`
- `FILESYSTEM_DISK=s3`
- `AI_PROVIDER=openai` (or gemini)
- `AI_DEFAULT_LANGUAGE=hi`
- `FEATURE_CONTENT_APPROVAL_REQUIRED=true`

Google OAuth:
- `GOOGLE_CLIENT_ID=...`
- `GOOGLE_CLIENT_SECRET=...`
- `GOOGLE_REDIRECT_URI=...`

## 3) Security hardening
- Force HTTPS, secure cookies, same-site strict policy
- Configure WAF/rate limiting for auth + AI endpoints
- Keep APP_DEBUG disabled in production
- Admin-only approval routes behind role permissions
- Sanitize and length-limit all ingested source content

## 4) Release process
1. `php artisan migrate --force`
2. `php artisan db:seed --class=DemoContentSeeder --force`
3. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. `php artisan queue:restart`
5. Verify `/`, `/sitemap.xml`, admin user table responsive view, and authenticated API routes.
