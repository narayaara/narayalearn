@extends('layouts.inc.guest')

@section('title', 'Register - NarayaLearn')
@section('subtitle', 'Create new account!')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Avatar -->
    @if($avatars->count() > 0)
        <div class="mb-3">
            <label class="form-label">
                <i class="fas fa-user-circle me-1" style="color: var(--pink-primary);"></i>
                Choose Avatar <span class="text-muted">(optional)</span>
            </label>
            <div class="avatar-picker-grid">
                @foreach($avatars as $avatar)
                    <label class="avatar-picker-item">
                        <input type="radio" name="avatar_id" value="{{ $avatar->id }}"
                               {{ old('avatar_id') == $avatar->id ? 'checked' : '' }}>
                        <img src="{{ asset('storage/avatars/'.$avatar->filename) }}" alt="Avatar">
                    </label>
                @endforeach
            </div>
            @error('avatar_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>
    @endif

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">
            <i class="fas fa-user me-1" style="color: var(--pink-primary);"></i>
            Full Name
        </label>
        <input id="name" type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               name="name" value="{{ old('name') }}" 
               placeholder="Your Name" required autofocus>
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
               name="password" placeholder="Min. 8 characters" required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password-confirm" class="form-label">
            <i class="fas fa-lock me-1" style="color: var(--pink-primary);"></i>
            Confirm Password
        </label>
        <input id="password-confirm" type="password" 
               class="form-control" name="password_confirmation" 
               placeholder="Repeat password" required>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-auth w-100 mb-3">
        <i class="fas fa-user-plus me-2"></i> Register
    </button>

    <!-- Links -->
    <div class="text-center">
        <p class="text-muted small mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="auth-link">Login here</a>
        </p>
    </div>
</form>
@endsection