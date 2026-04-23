# free-education.fun (Laravel SaaS Blueprint)

Production-oriented Laravel blueprint for an AI-powered education and utilities SaaS platform.

## ✅ UPDATED Scope delivered
- Dynamic Module Builder foundation (module/form fields/records)
- Admin user CRUD + approval workflow scaffold
- AI bilingual content generation + rewrite ingestion pipeline (Hindi-first)
- SEO essentials: dynamic meta strategy + sitemap endpoint scaffold
- Bootstrap 5.3 responsive UI baseline with mobile-friendly data tables
- MySQL-ready migrations with indexing and categorized content models

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
4. Run:
   - `php artisan migrate`
   - `php artisan db:seed`

## Security defaults
- Validation applied on API/admin mutations
- CSRF middleware on blade forms
- Eloquent-based query builder (SQL injection protection)
- Sanitized content ingestion for AI rewrite pipeline
- Approval workflow for user/content publishing gates

## Notes
- This repo is a scaffold and intentionally provider-agnostic for OpenAI/Gemini final integration.
- For production, add queue jobs for scraping/AI generation, rate limits per plan, and observability.
