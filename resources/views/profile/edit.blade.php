@extends('layouts.app')

@section('title', 'Edit Profile - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 700px;">

    <!-- ===== HEADER — BACK + JUDUL ===== -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('profile.index') }}" class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="profile-edit-title mb-0">Edit Profile</h2>
            <p class="profile-edit-desc mb-0">Perbarui informasi akun kamu</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ===== FORM ===== -->
    <div class="profile-section">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ===== AVATAR PICKER (USER ONLY) ===== --}}
            @if($user->role !== 'admin')
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user-circle me-1" style="color: var(--pink-deep);"></i>
                        Pilih Avatar
                    </label>

                    @if($avatars->count() > 0)
                        <div class="avatar-picker-grid mt-2">
                            @foreach($avatars as $avatar)
                                <label class="avatar-picker-item">
                                    <input type="radio" name="avatar_id" value="{{ $avatar->id }}"
                                           {{ $user->avatar === $avatar->filename ? 'checked' : '' }}>
                                    <img src="{{ asset('storage/avatars/'.$avatar->filename) }}" 
                                         alt="Avatar">
                                    <span class="avatar-check">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('avatar_id') 
                            <div class="text-danger small mt-2">{{ $message }}</div> 
                        @enderror
                    @else
                        <div class="profile-empty-state py-3">
                            <i class="fas fa-user-circle"></i>
                            <p class="mb-0">Belum ada avatar preset dari admin.</p>
                        </div>
                    @endif
                </div>

                <hr class="my-4">
            @endif

            {{-- ===== NAMA ===== --}}
            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-user me-1" style="color: var(--pink-deep);"></i>
                    Nama Lengkap
                </label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" 
                       placeholder="Nama kamu" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- ===== EMAIL ===== --}}
            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-envelope me-1" style="color: var(--pink-deep);"></i>
                    Email
                </label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" 
                       placeholder="nama@email.com" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4">

            {{-- ===== GANTI PASSWORD ===== --}}
            <h6 class="fw-bold mb-3" style="color: var(--text-dark);">
                <i class="fas fa-lock me-2" style="color: var(--pink-deep);"></i>
                Ganti Password 
                <span class="text-muted fw-normal small">(opsional)</span>
            </h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin ganti">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control" 
                           placeholder="Ulangi password baru">
                </div>
            </div>

            {{-- ===== ACTIONS ===== --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-3">
                    Batal
                </a>
                <button type="submit" class="btn btn-pink rounded-3">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection