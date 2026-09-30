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

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Avatar picker (admin tidak perlu avatar) --}}
            @if($user->role !== 'admin')
                <div class="mb-4">
                    <label class="form-label fw-semibold small d-block mb-2">Pilih Avatar</label>

                    @if($avatars->count() > 0)
                        <div class="avatar-picker-grid">
                            @foreach($avatars as $avatar)
                                <label class="avatar-picker-item">
                                    <input type="radio" name="avatar_id" value="{{ $avatar->id }}"
                                           {{ $user->avatar === $avatar->filename ? 'checked' : '' }}>
                                    <img src="{{ asset('storage/avatars/'.$avatar->filename) }}" alt="Avatar">
                                </label>
                            @endforeach
                        </div>
                        @error('avatar_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    @else
                        <p class="text-muted small mb-0">Belum ada avatar preset dari admin.</p>
                    @endif
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