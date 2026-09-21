<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'NarayaLearn'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts (Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- ===== THEME INIT (HARUS DI HEAD, SEBELUM RENDER) ===== -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- ===== HEADER ===== -->
        @include('layouts.inc.header')

        <!-- ===== MAIN CONTENT ===== -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- ===== FOOTER ===== -->
        @include('layouts.inc.footer')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ===== THEME TOGGLE SCRIPT ===== -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const html = document.documentElement;
        const toggle = document.getElementById('themeToggle');
        const icon = document.getElementById('themeIcon');

        // Update icon sesuai tema saat ini
        function updateIcon() {
            const current = html.getAttribute('data-theme');
            if (icon) {
                if (current === 'dark') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        }
        updateIcon();

        // Klik toggle
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const current = html.getAttribute('data-theme') || 'light';
                const next = current === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                updateIcon();
                
                console.log('✅ Theme changed to:', next);
            });
        } else {
            console.log('❌ Tombol toggle #themeToggle tidak ditemukan!');
        }
    });
    </script>

    @stack('scripts')
</body>
</html>