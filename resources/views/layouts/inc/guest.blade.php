<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NarayaLearn'))</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|plus-jakarta-sans:400,500,600,700|quicksand:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <div class="auth-container">
        <!-- Logo -->
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                <h2 class="fw-bold mb-1" style="color: #fff; font-family: 'Quicksand', sans-serif;">
                    <i class="fas fa-graduation-cap me-2"></i> NarayaLearn
                </h2>
            </a>
            <p class="small mb-0" style="color: rgba(255,255,255,0.85);">
                @yield('subtitle', 'Selamat datang kembali!')
            </p>
        </div>

        <!-- Card -->
        <div class="auth-card">
            @yield('content')
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-decoration-none small" style="color: rgba(255,255,255,0.85);">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Home
            </a>
        </div>
    </div>

    <script>
    // ==============================================
    // THEME TOGGLE (Light / Dark Mode)
    // ==============================================
    (function() {
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
        html.setAttribute('data-theme', initialTheme);
    })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>