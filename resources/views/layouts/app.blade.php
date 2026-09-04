<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'NarayaLearn'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700|Quicksand:400,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Style untuk Pink Theme -->
    <style>
        :root {
            --pink-primary: #FF6B9D;
            --pink-light: #FFE0EB;
            --pink-dark: #E0558A;
            --pink-soft: #FFF5F8;
            --text-dark: #2D1B2E;
            --text-gray: #6B5B6D;
        }

        .navbar-pink {
            background: linear-gradient(135deg, #FF6B9D 0%, #FF8FB5 100%) !important;
            box-shadow: 0 4px 20px rgba(255, 107, 157, 0.25);
        }

        .navbar-pink .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-family: 'Quicksand', sans-serif;
            font-size: 1.4rem;
        }

        .navbar-pink .navbar-brand i {
            font-size: 1.6rem;
        }

        .navbar-pink .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px;
        }

        .navbar-pink .nav-link:hover,
        .navbar-pink .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.2);
        }

        .navbar-pink .nav-link i {
            margin-right: 6px;
        }

        .navbar-pink .dropdown-toggle {
            color: #fff !important;
        }

        .navbar-pink .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
        }

        .navbar-pink .dropdown-item {
            border-radius: 8px;
            padding: 8px 16px;
            color: var(--text-dark);
            transition: all 0.2s;
        }

        .navbar-pink .dropdown-item:hover {
            background: var(--pink-light);
            color: var(--pink-dark);
        }

        .navbar-pink .dropdown-item i {
            width: 20px;
            color: var(--pink-primary);
        }

        .btn-pink {
            background: var(--pink-primary);
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-pink:hover {
            background: var(--pink-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.4);
        }

        .btn-pink-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 6px 18px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-pink-outline:hover {
            background: #fff;
            color: var(--pink-primary);
            border-color: #fff;
        }

        /* Badge admin */
        .badge-admin {
            background: var(--pink-primary);
            color: #fff;
            font-size: 0.65rem;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Card dengan sentuhan pink */
        .card-pink {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(255, 107, 157, 0.08);
            transition: all 0.3s ease;
        }

        .card-pink:hover {
            box-shadow: 0 8px 35px rgba(255, 107, 157, 0.15);
            transform: translateY(-4px);
        }

        .card-pink .card-header {
            background: transparent;
            border-bottom: 2px solid var(--pink-light);
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Avatar di navbar */
        .avatar-nav {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- ===== NAVBAR ===== -->
        <nav class="navbar navbar-expand-md navbar-pink">
            <div class="container">
                <!-- Brand / Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-graduation-cap"></i>
                    {{ config('app.name', 'NarayaLearn') }}
                </a>

                <!-- Toggler Mobile -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" 
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side - Menu Utama -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                               href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" 
                               href="{{ route('subjects.index') }}">
                                <i class="fas fa-book"></i> Subjects
                            </a>
                        </li>

                        <!-- Admin Dropdown (hanya untuk admin) -->
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" 
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-crown"></i> Admin
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-tachometer-alt"></i> Dashboard
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.subjects.index') }}">
                                                <i class="fas fa-list"></i> Kelola Subject
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.materials.index') }}">
                                                <i class="fas fa-file-alt"></i> Kelola Konten
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                                <i class="fas fa-users"></i> Kelola User
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.comments.index') }}">
                                                <i class="fas fa-comments"></i> Moderasi Komentar
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side - Auth -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-pink-outline" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> {{ __('Register') }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                                   href="#" role="button" data-bs-toggle="dropdown">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" 
                                             class="avatar-nav" alt="Avatar">
                                    @else
                                        <i class="fas fa-user-circle" style="font-size: 28px; color: rgba(255,255,255,0.9);"></i>
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                    @if(Auth::user()->role === 'admin')
                                        <span class="badge-admin ms-1">Admin</span>
                                    @endif
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    {{-- <li>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="fas fa-user"></i> My Account
                                        </a>
                                    </li> --}}
                                    <li>
                                        {{-- <a class="dropdown-item" href="{{ route('profile.favorites') }}"> --}}
                                            <i class="fas fa-heart" style="color: var(--pink-primary);"></i> Favorites
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- ===== MAIN CONTENT ===== -->
        <main>
            @yield('content')
        </main>

        <!-- ===== FOOTER ===== -->
        <footer class="bg-white py-4 mt-5" style="border-top: 2px solid var(--pink-light);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <span style="color: var(--text-gray); font-weight: 500;">
                            <i class="fas fa-graduation-cap" style="color: var(--pink-primary);"></i>
                            {{ config('app.name', 'NarayaLearn') }} &copy; {{ date('Y') }}
                        </span>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <span style="color: var(--text-gray); font-size: 0.9rem;">
                            Made with <i class="fas fa-heart" style="color: var(--pink-primary);"></i> for learning
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>