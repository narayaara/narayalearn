@extends('layouts.app')

@section('title', 'My Account - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">
        <i class="fas fa-user" style="color: #FF6B9D;"></i> My Account
    </h2>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success rounded-4">Profile updated successfully.</div>
    @endif

    <!-- Edit Profile -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3" style="color: #2D1B2E;">Profile</h5>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control rounded-3">
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control rounded-3">
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn" style="background:#FF6B9D;color:#fff;">Save changes</button>
        </form>
    </div>

    <!-- My Favorites -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3" style="color: #2D1B2E;">My Favorites</h5>
        @forelse ($favorites as $material)
            <a href="{{ route('materials.show', $material) }}" class="d-flex justify-content-between align-items-center p-2 rounded-3 mb-1 text-decoration-none" style="background:#FFF5F8;">
                <span style="color:#2D1B2E;">{{ $material->title }}</span>
                <small class="text-muted">{{ $material->subject->name }}</small>
            </a>
        @empty
            <p class="text-muted small mb-0">Belum ada favorite.</p>
        @endforelse
    </div>

    <!-- My Comments -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3" style="color: #2D1B2E;">My Comments</h5>
        @forelse ($comments as $comment)
            <div class="p-2 rounded-3 mb-1" style="background:#FFF5F8;">
                <p class="mb-1 small">{{ $comment->content }}</p>
                <small class="text-muted">on {{ $comment->material->title }}</small>
            </div>
        @empty
            <p class="text-muted small mb-0">Belum ada comment.</p>
        @endforelse
    </div>
</div>
@endsection