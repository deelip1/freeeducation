# free-education.fun (AI Content + Tools + Utility SaaS)

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
   - `CACHE_STORE=redis`
   - `SESSION_DRIVER=redis`
   - `PDF_COMPRESSOR_DRIVER=ghostscript`
   - `DEMO_ADMIN_PASSWORD=...`
4. Run:
   - `php artisan migrate`
   - `php artisan db:seed`

## Security defaults
- Strict validation for all APIs/forms
- Eloquent query builder (SQLi-safe patterns)
- CSRF on web forms
- Aadhaar encryption for ITR profile data
- Content approval workflow for moderation
- Tool usage logging for abuse monitoring

## Implementation roadmap (recommended)
1. CMS + Blog moderation workflows
2. PDF tools (compress/merge/split pipeline jobs)
3. Social creator templates + render workers
4. Subscription, quotas, advanced analytics
