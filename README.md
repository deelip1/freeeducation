# free-education.fun (Laravel SaaS Blueprint)

Production-oriented Laravel blueprint for an AI-powered education and utilities SaaS platform.

## Included in this repository

- Modular architecture scaffold (module builder + dynamic entities)
- Core migrations for users, roles, profiles, modules, blog, vacancies, government orders, educational resources
- Service layer + repository pattern examples
- REST API route scaffold, admin route scaffold
- AI integration hooks (OpenAI-ready abstraction)
- Security defaults checklist and operational guide

## Quick Start (inside a real Laravel app)

1. Copy this scaffold into a fresh Laravel 12+ project.
2. Install required packages:
   - `laravel/sanctum`
   - `laravel/socialite`
   - `spatie/laravel-permission`
   - `spatie/laravel-activitylog`
   - `predis/predis`
3. Configure `.env` for MySQL and Redis.
4. Run migrations and seeders.
5. Build frontend with Vite.

## Security principles

- Strict validation on all mutable endpoints
- Policies + role/permission gates
- File uploads validated by MIME and size
- Rate limiting for auth and AI endpoints
- Personally sensitive data encrypted at rest

## Future-ready extension points

- GraphQL can be layered on existing service classes
- Queue-backed workloads (poster generation, compression, recommendation jobs)
- Tenant support can be introduced via tenant_id columns and scoped repositories
