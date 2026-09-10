@extends('layouts.inc.guest')

@section('title', 'Login - NarayaLearn')
@section('subtitle', 'Selamat datang kembali! Silakan login.')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="fas fa-envelope me-1" style="color: var(--pink-primary);"></i>
            Email
        </label>
        <input id="email" type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" 
               placeholder="nama@email.com" required autofocus>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="fas fa-lock me-1" style="color: var(--pink-primary);"></i>
            Password
        </label>
        <input id="password" type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               name="password" placeholder="••••••••" required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Remember -->
    <div class="mb-4 form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" 
               {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label small text-muted" for="remember">
            Ingat saya
        </label>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-auth w-100 mb-3">
        <i class="fas fa-sign-in-alt me-2"></i> Login
    </button>

    <!-- Links -->
    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="auth-link small d-block mb-3" href="{{ route('password.request') }}">
                Lupa password?
            </a>
        @endif
        <p class="text-muted small mb-0">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </p>
    </div>
</form>
@endsection