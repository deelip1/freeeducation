# free-education.fun (Laravel SaaS Blueprint)

Production-oriented Laravel blueprint for an AI-powered education and utilities SaaS platform.

## ✅ UPDATED Scope delivered
- Dynamic Module Builder foundation (module/form fields/records)
- Admin user CRUD + approval workflow scaffold
- AI bilingual content generation + rewrite ingestion pipeline (Hindi-first)
- SEO essentials: dynamic meta strategy + sitemap endpoint scaffold
- Bootstrap 5.3 responsive UI baseline with mobile-friendly data tables
- MySQL-ready migrations with indexing and categorized content models
- ✅ Advanced ITR module scaffold (profile, rules, computations, filing drafts)

## ITR module highlights
- PAN-based profile + optional Aadhaar linking (encrypted at rest)
- Income/deduction/credit payload capture for Indian ITR flow
- Old vs New regime comparison with slab-tax, rebate 87A, cess, and interest inputs
- ITR form suggestion (ITR-1 / ITR-2 / ITR-3 / ITR-4)
- Output packs for computation sheet, form-16-like summary, and ITR draft JSON
- Admin-manageable tax rules by Assessment Year + Regime

## Setup (Laravel 12+)
1. Create Laravel app (outside restricted network if needed), then copy this scaffold.
2. Install packages:
   - `laravel/sanctum`
   - `laravel/socialite` (Google OAuth)
   - `spatie/laravel-permission`
   - `spatie/laravel-activitylog`
   - `predis/predis`
3. Configure `.env`:
   - `DB_CONNECTION=mysql`
   - `QUEUE_CONNECTION=redis`
   - `CACHE_STORE=redis`
   - `SESSION_DRIVER=redis`
   - Google OAuth keys (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)
   - `ITR_DEFAULT_ASSESSMENT_YEAR=2026-27`
4. Run:
   - `php artisan migrate`
   - `php artisan db:seed`

## Security defaults
- Validation applied on API/admin mutations
- CSRF middleware on blade forms
- Eloquent-based query builder (SQL injection protection)
- Sanitized content ingestion for AI rewrite pipeline
- Approval workflow for user/content publishing gates
- PAN format validation + Aadhaar encryption for ITR profiles

## Notes
- This repo is a scaffold and intentionally provider-agnostic for OpenAI/Gemini final integration.
- For production, add queue jobs for OCR/Form-16 parsing, OTP gateway integration, and strict role policies.
