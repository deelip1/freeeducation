<!doctype html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'free-education.fun') }}</title>
    <style>
        :root { color-scheme: light dark; }
        body { font-family: Inter, system-ui, sans-serif; margin: 0; background: linear-gradient(120deg,#eef2ff,#ecfeff); }
        .glass { background: rgba(255,255,255,.55); backdrop-filter: blur(10px); border-radius: 18px; padding: 1.25rem; box-shadow: 0 8px 30px rgba(0,0,0,.08); }
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1>free-education.fun</h1>
        <button id="theme-toggle" type="button">🌓 Toggle</button>
    </div>
    <main class="glass">
        @yield('content')
    </main>
</div>
<script>
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        const html = document.documentElement;
        html.dataset.theme = html.dataset.theme === 'light' ? 'dark' : 'light';
    });
</script>
</body>
</html>
