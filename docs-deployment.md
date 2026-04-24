# Deployment Guide (Production)

## Infrastructure
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
