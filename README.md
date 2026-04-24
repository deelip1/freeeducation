# free-education.fun (AI Content + Tools + Utility SaaS)

Production-oriented Laravel blueprint for a modular platform ecosystem.

## ✅ UPDATED Engine-First Architecture
- `app/Modules/CMS` → WordPress-like content engine
- `app/Modules/Tools` → utility tools engine (PDF/Image/Social)
- `app/Modules/AI` → AI orchestration engine
- `app/Modules/ITR` → tax workflow engine
- `app/Modules/Users` + `app/Modules/Admin` → identity/control engines

## ✅ UPDATED Phase Focus Delivered
- WordPress-like CMS base:
  - nested categories + tags
  - featured posts
  - `/blog/{category}/{slug}` URL structure
  - CKEditor integration view
  - AI blog draft endpoint (`/api/ai/blog/generate`)
- One production-starter tool:
  - secure PDF compressor API with file validation + usage logs
- Existing ITR and admin workflows preserved

## Setup (Laravel 12+)
1. Create Laravel app, then copy this scaffold.
2. Install packages:
   - `laravel/sanctum`
   - `laravel/socialite`
   - `spatie/laravel-permission`
   - `spatie/laravel-activitylog`
   - `predis/predis`
3. Configure `.env`:
   - `DB_CONNECTION=mysql`
   - `QUEUE_CONNECTION=redis`
   - `PDF_COMPRESSOR_DRIVER=ghostscript`
   - `TOOLS_MAX_UPLOAD_MB=20`
   - `DEMO_ADMIN_PASSWORD=...`
4. Run:
   - `php artisan migrate`
   - `php artisan db:seed`

## Security defaults
- Validated file uploads for tool APIs (mime + max size)
- Aadhaar encryption in ITR profile storage
- Eloquent query builder usage for SQLi-safe patterns
- Approval workflow for publish-sensitive content
- AI and tools usage telemetry for abuse visibility
