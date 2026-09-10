<nav class="navbar navbar-expand-md navbar-pink shadow-sm sticky-top">
    <div class="container-fluid px-4 px-lg-5">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
            <i class="fas fa-graduation-cap"></i>
            <span>NarayaLearn</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto ms-md-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" 
                       href="{{ route('subjects.index') }}">
                        <i class="fas fa-book me-2"></i> Subjects
                    </a>
                </li>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-crown me-2"></i> Admin Panel
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.subjects.index') }}">
                                        <i class="fas fa-list me-2"></i> Kelola Subject
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.materials.index') }}">
                                        <i class="fas fa-file-alt me-2"></i> Kelola Materi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users me-2"></i> Kelola User
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.comments.index') }}">
                                        <i class="fas fa-comments me-2"></i> Moderasi Komentar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto align-items-md-center gap-2 mt-3 mt-md-0">
                @guest
                    <li class="nav-item">
                        <a class="btn btn-auth-nav w-100 w-md-auto" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-auth-nav-outline w-100 w-md-auto" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <div class="avatar-nav-wrapper">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" 
                                         class="avatar-nav" alt="Avatar">
                                @else
                                    <i class="fas fa-user-circle" style="font-size: 28px;"></i>
                                @endif
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <span class="badge-admin ms-1">Admin</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i> My Account
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-heart me-2"></i> Favorites
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
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