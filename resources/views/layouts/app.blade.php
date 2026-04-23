<!doctype html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('freeeducation.seo.default_title', 'free-education.fun'))</title>
    <meta name="description" content="@yield('meta_description', 'AI-powered education, news, vacancies and digital tools platform.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('head')
    <style>
        /* ✅ UPDATED: Bootstrap-first premium glass theme */
        body { background: radial-gradient(circle at top, #e0f2fe, #f8fafc 45%, #eef2ff); min-height: 100vh; }
        .glass-card { background: rgba(255, 255, 255, 0.72); border: 1px solid rgba(255, 255, 255, 0.48); backdrop-filter: blur(10px); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">free-education.fun</a>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="theme-toggle">Dark/Light</button>
    </div>
</nav>

<main class="container py-4">
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        const html = document.documentElement;
        html.setAttribute('data-bs-theme', html.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light');
    });
</script>
@yield('scripts')
</body>
</html>
