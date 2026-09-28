@extends('layouts.app')

@section('title', 'Edit Profile - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 600px;">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('profile.index') }}" style="color: var(--pink-primary);">My Account</a>
            </li>
            <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
    </nav>

    <div class="card border-0 rounded-4 p-4">
        <h4 class="fw-bold mb-4">Edit Profile</h4>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar (admin tidak perlu avatar) --}}
            @if($user->role !== 'admin')
                <div class="d-flex align-items-center gap-3 mb-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="profile-avatar" alt="{{ $user->name }}">
                    @else
                        <div class="profile-avatar profile-avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif

                    <div class="flex-grow-1">
                        <label class="form-label fw-semibold small mb-1">Foto Profil</label>
                        <input type="file" name="avatar"
                               class="form-control form-control-sm @error('avatar') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png">
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">JPG/PNG, maks. 2MB</small>
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nama</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4">

            <p class="fw-semibold small mb-3">Ganti Password <span class="text-muted fw-normal">(opsional)</span></p>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Password Baru</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Kosongkan jika tidak ingin ganti">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control" placeholder="Ulangi password baru">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-3">Batal</a>
                <button type="submit" class="btn btn-pink rounded-3">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection