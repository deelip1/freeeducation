<!doctype html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('freeeducation.seo.default_title', 'free-education.fun'))</title>
    <meta name="description" content="@yield('meta_description', 'Premium AI-powered education, cyber awareness, and digital tools platform.')">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @yield('head')
    <style>
        /* ✅ HIGHLIGHT: Premium SaaS Layout Customization */
        :root {
            --sidebar-width: 260px;
            --brand-primary: #4f46e5;
            --brand-hover: #4338ca;
        }
        body { 
            background: #f1f5f9; 
            min-height: 100vh;
            display: flex;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            z-index: 900;
        }
        .glass-card { 
            background: #ffffff; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease;
        }
        .nav-link.active {
            background: #eef2ff;
            color: var(--brand-primary);
            border-radius: 8px;
            font-weight: 600;
        }
        .cyber-alert {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
        }
        
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<aside class="sidebar py-3 d-flex flex-column" id="sidebarMenu">
    <div class="px-4 mb-4 d-flex align-items-center justify-content-between">
        <a class="navbar-brand fw-bold fs-5 text-dark text-decoration-none" href="{{ route('home') }}">
            <i class="bi bi-mortarboard-fill text-primary me-2"></i>EduSaaS PRO
        </a>
        <button class="btn btn-sm d-lg-none" onclick="document.getElementById('sidebarMenu').classList.toggle('show')">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <ul class="nav flex-column px-3 gap-1">
        <li class="nav-item">
            <a class="nav-link text-secondary {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary {{ request()->routeIs('itr.wizard') ? 'active' : '' }}" href="{{ route('itr.wizard') }}">
                <i class="bi bi-calculator me-2"></i> ITR AI Wizard
            </a>
        </li>
        <hr class="my-2 text-muted">
        <li class="nav-item">
            <a class="nav-link text-secondary" href="{{ route('admin.modules.index') }}">
                <i class="bi bi-grid me-2"></i> Dynamic Modules
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people me-2"></i> User Management
            </a>
        </li>
    </ul>

    <div class="mt-auto px-3">
        <div class="p-3 rounded-3 cyber-alert text-dark mt-4">
            <h6 class="fw-bold mb-1"><i class="bi bi-shield-lock-fill text-warning me-1"></i> Digital Literacy</h6>
            <p class="small mb-0 text-muted">Always verify OTP sources and prevent task fraud interactions.</p>
        </div>
    </div>
</aside>

<div class="main-content">
    <nav class="navbar topbar px-4 py-3 sticky-top">
        <div class="d-flex align-items-center w-100">
            <button class="btn btn-light d-lg-none me-3 border" onclick="document.getElementById('sidebarMenu').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <form class="d-none d-md-flex me-auto" style="max-width: 300px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Search resources...">
                </div>
            </form>
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2 lh-1" id="theme-toggle">
                    <i class="bi bi-moon-stars"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> Account
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="p-4 flex-grow-1">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success text-white" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById('theme-toggle')?.addEventListener('click', function() {
        const html = document.documentElement;
        const isLight = html.getAttribute('data-bs-theme') === 'light';
        html.setAttribute('data-bs-theme', isLight ? 'dark' : 'light');
        this.innerHTML = isLight ? '<i class="bi bi-sun-fill"></i>' : '<i class="bi bi-moon-stars"></i>';
    });
</script>
@yield('scripts')
</body>
</html>