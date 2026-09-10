@extends('layouts.inc.guest')

@section('title', 'Register - NarayaLearn')
@section('subtitle', 'Buat akun baru dan mulai belajar!')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">
            <i class="fas fa-user me-1" style="color: var(--pink-primary);"></i>
            Nama Lengkap
        </label>
        <input id="name" type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               name="name" value="{{ old('name') }}" 
               placeholder="Nama kamu" required autofocus>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="fas fa-envelope me-1" style="color: var(--pink-primary);"></i>
            Email
        </label>
        <input id="email" type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" 
               placeholder="nama@email.com" required>
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
               name="password" placeholder="Min. 8 karakter" required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password-confirm" class="form-label">
            <i class="fas fa-lock me-1" style="color: var(--pink-primary);"></i>
            Konfirmasi Password
        </label>
        <input id="password-confirm" type="password" 
               class="form-control" name="password_confirmation" 
               placeholder="Ulangi password" required>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-auth w-100 mb-3">
        <i class="fas fa-user-plus me-2"></i> Daftar
    </button>

    <!-- Links -->
    <div class="text-center">
        <p class="text-muted small mb-0">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
        </p>
    </div>
</form>
@endsection