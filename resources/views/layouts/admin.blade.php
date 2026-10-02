<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - NarayaLearn')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=sora:400,600,700,800|inter:400,500,600,700|plus-jakarta-sans:600,700,800" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts (Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Theme Init -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    @stack('styles')
</head>
<body class="admin-body">

    <div class="d-flex admin-shell">

        <!-- ===== SIDEBAR ===== -->
        <aside class="admin-sidebar">
            <!-- Brand -->
            <div class="admin-sidebar-brand">
                <div class="admin-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="admin-sidebar-brand-text">
                    <h6 class="mb-0">NarayaLearn</h6>
                    <small>Admin Panel</small>
                </div>
            </div>

            <!-- Menu -->
            <div class="admin-sidebar-section">
                <span class="admin-sidebar-label">MENU</span>
            </div>

            <nav class="admin-sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.subjects.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <span>Kelola Subject</span>
                </a>
                <a href="{{ route('admin.materials.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>Kelola Materi</span>
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Kelola User</span>
                </a>
                <a href="{{ route('admin.avatars.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.avatars.*') ? 'active' : '' }}">
                    <i class="fas fa-palette"></i> <span>Kelola Avatar</span>
                </a>
            </nav>

            <!-- Akun -->
            <div class="admin-sidebar-section">
                <span class="admin-sidebar-label">AKUN</span>
            </div>

            <nav class="admin-sidebar-nav">
                <a href="{{ route('home') }}" class="admin-nav-link">
                    <i class="fas fa-arrow-up-right-from-square"></i> <span>Lihat Website</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="admin-nav-link admin-nav-logout w-100">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- ===== MAIN WRAPPER ===== -->
        <div class="admin-main-wrapper">

            <!-- ===== TOP HEADER ===== -->
            <header class="admin-header">
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Breadcrumb -->
                    <div class="admin-breadcrumb">
                        <i class="fas fa-home"></i>
                        <span class="mx-2">/</span>
                        <span class="admin-breadcrumb-current">@yield('breadcrumb', 'Dashboard')</span>
                    </div>

                    <!-- Right Actions -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Theme Toggle -->
                        <button type="button" class="admin-header-btn" id="themeToggleAdmin" title="Ganti Tema">
                            <i class="fas fa-moon" id="themeIconAdmin"></i>
                        </button>

                        <!-- User Info -->
                        <div class="d-flex align-items-center gap-2 ms-2 ps-3" style="border-left: 1px solid var(--border-light);">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" 
                                     class="admin-header-avatar" alt="Avatar">
                            @else
                                <div class="admin-header-avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <div class="d-none d-md-block">
                                <div class="admin-header-name">{{ Auth::user()->name }}</div>
                                <div class="admin-header-email">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="admin-main">
                @yield('admin-content')
            </main>

        </div>
    </div>

    <!-- ===== THEME TOGGLE SCRIPT ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            const toggle = document.getElementById('themeToggleAdmin');
            const icon = document.getElementById('themeIconAdmin');

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

            if (toggle) {
                toggle.addEventListener('click', function() {
                    const current = html.getAttribute('data-theme') || 'light';
                    const next = current === 'dark' ? 'light' : 'dark';
                    html.setAttribute('data-theme', next);
                    localStorage.setItem('theme', next);
                    updateIcon();
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>