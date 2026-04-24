# Deployment Guide (Production)

## Infrastructure
## 1) Infrastructure
- Nginx + PHP-FPM 8.3+
- MySQL 8.0+
- Redis 7+
- S3-compatible object storage
- Queue workers via Supervisor/systemd

## Environment essentials
- `DB_CONNECTION=mysql`
- `QUEUE_CONNECTION=redis`
- `AI_PROVIDER=openai` or `gemini`
- `PDF_COMPRESSOR_DRIVER=ghostscript`
- `TOOLS_MAX_UPLOAD_MB=20`
- Engine toggles:
  - `ENGINE_CMS_ENABLED=true`
  - `ENGINE_TOOLS_ENABLED=true`
  - `ENGINE_AI_ENABLED=true`
  - `ENGINE_ITR_ENABLED=true`

## Security hardening
- Enforce HTTPS + secure cookies
- File upload validation and storage separation for tools
- Rate-limit AI/tool endpoints
- Encrypt sensitive tax identifiers
- Protect admin controls with role policies

## Release checks
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
- `ITR_DEFAULT_ASSESSMENT_YEAR=2026-27`

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
- Encrypt PAN/Aadhaar-adjacent PII fields before persistent storage where required

## 4) Release process
1. `php artisan migrate --force`
2. `php artisan db:seed --class=DemoContentSeeder --force`
3. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. `php artisan queue:restart`
5. Validate:
   - `/`
   - `/blog`, `/blog/{category}/{slug}`
   - `/blog/editor`
   - `/api/ai/blog/generate`
   - `/api/tools/pdf/compress`
   - `/` (hero + featured + category sections)
   - `/blog` and `/blog/{slug}`
   - `/itr/wizard`
   - `/api/tools/pdf/compress`
   - `/api/tools/social/generate`
5. Verify `/`, `/itr/wizard`, `/sitemap.xml`, admin user table responsive view, `/api/itr/profile`, and `/api/itr/compute`.
