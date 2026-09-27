@extends('layouts.app')

@section('content')
<div class="d-flex admin-shell">

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <div class="admin-sidebar-brand-text">
                <h6 class="mb-0">NarayaLearn</h6>
                <small>Dashboard Admin</small>
            </div>
        </div>

        <nav class="admin-sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="admin-nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> <span>Subjects</span>
            </a>
            <a href="{{ route('admin.materials.index') }}" class="admin-nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> <span>Materials</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Users</span>
            </a>

            <hr class="admin-sidebar-divider">

            <a href="{{ route('home') }}" class="admin-nav-link">
                <i class="fas fa-arrow-left"></i> <span>Back to Site</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="admin-nav-link admin-nav-logout">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="admin-main">
        @yield('admin-content')
    </main>
</div>
@endsection