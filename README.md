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
Production-oriented Laravel blueprint for a modular, scalable platform combining CMS, tools marketplace, and ITR utility.

## ✅ UPDATED Vision Architecture
- CMS Engine: WordPress-like blog (categories/subcategories, tags, featured posts, SEO metadata)
- Tools Engine: PDF Compressor + Social Media Creator + ITR workflows
- AI Engine: bilingual content generation/rewrite + social caption/quote/hashtags + tax-saving hints
- User System: role-ready auth with Google OAuth scaffold and approval gates
- Admin Panel: module builder, user moderation, tax-rule management

## ✅ UPDATED Delivered in this phase
- Premium homepage layout with hero + featured slider + category sections
- CMS API (`/api/cms/posts`) with approval-aware publishing and SEO meta/schema generation
- Tools APIs:
  - `POST /api/tools/pdf/compress`
  - `POST /api/tools/social/generate`
- Tools telemetry tables (`tools`, `tool_usages`, `designs`, `ai_logs`)
- Blog taxonomy upgrades (subcategory support + tags pivot)
- Existing ITR module retained and integrated

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
   - `CACHE_STORE=redis`
   - `SESSION_DRIVER=redis`
   - Google OAuth keys (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)
   - `ITR_DEFAULT_ASSESSMENT_YEAR=2026-27`
4. Run:
   - `php artisan migrate`
   - `php artisan db:seed`

## Security defaults
- Validated file uploads for tool APIs (mime + max size)
- Aadhaar encryption in ITR profile storage
- Eloquent query builder usage for SQLi-safe patterns
- Approval workflow for publish-sensitive content
- AI and tools usage telemetry for abuse visibility
- Validation applied on API/admin mutations
- CSRF middleware on blade forms
- Eloquent-based query builder (SQL injection protection)
- Sanitized content ingestion for AI rewrite pipeline
- Approval workflow for user/content publishing gates
- PAN format validation + Aadhaar encryption for ITR profiles

## Notes
- This repo is a scaffold and intentionally provider-agnostic for OpenAI/Gemini final integration.
- For production, add queue jobs for OCR/Form-16 parsing, OTP gateway integration, and strict role policies.
