# Deployment Guide (Production)

## 1) Infrastructure
- Nginx + PHP-FPM 8.3+
- MySQL 8.0+
- Redis 7+
- S3-compatible object storage
- Queue workers via Supervisor/systemd

## 2) Environment essentials
- `APP_ENV=production`
- `DB_CONNECTION=mysql`
- `QUEUE_CONNECTION=redis`
- `SESSION_DRIVER=redis`
- `AI_PROVIDER=openai` or `gemini`
- `PDF_COMPRESSOR_DRIVER=ghostscript`
- `FEATURE_CONTENT_APPROVAL_REQUIRED=true`
- `ITR_DEFAULT_ASSESSMENT_YEAR=2026-27`
- Google OAuth credentials (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)

## 3) Security hardening
- Enforce HTTPS + secure cookies
- Upload validation (mime/size) for tool endpoints
- Rate-limit AI/tool endpoints
- Encrypt sensitive identifiers (Aadhaar)
- Keep admin controls behind role policies

## 4) Release checks
1. `php artisan migrate --force`
2. `php artisan db:seed --class=DemoContentSeeder --force`
3. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. `php artisan queue:restart`
5. Validate:
   - `/` (hero + featured + category sections)
   - `/blog` and `/blog/{slug}`
   - `/itr/wizard`
   - `/api/tools/pdf/compress`
   - `/api/tools/social/generate`
