@extends('layouts.admin')

@section('title', 'Avatar Management - Admin')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #2D1B2E;">
            <i class="fas fa-user-circle" style="color: #FF6B9D;"></i> Avatar Management
        </h2>
    </div>

    <!-- Upload -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('admin.avatars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="form-label fw-semibold small">Upload Avatar Baru</label>
            <div class="d-flex flex-wrap gap-2">
                <input type="file" name="files[]" class="form-control rounded-3" style="max-width: 400px;"
                       accept=".jpg,.jpeg,.png,.webp" multiple required>
                <button type="submit" class="btn rounded-3" style="background:#FF6B9D;color:#fff;">
                    <i class="fas fa-upload me-1"></i> Upload
                </button>
            </div>
            @error('files') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            @error('files.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            <small class="text-muted d-block mt-1">JPG/PNG/WEBP, maks 1MB per file. Bisa pilih beberapa sekaligus.</small>
        </form>
    </div>

    <!-- Grid avatar -->
    @if($avatars->count() > 0)
        <div class="avatar-admin-grid">
            @foreach($avatars as $avatar)
                <div class="avatar-admin-item">
                    <img src="{{ asset('storage/avatars/'.$avatar->filename) }}" alt="Avatar">
                    <form action="{{ route('admin.avatars.destroy', $avatar) }}" method="POST"
                          onsubmit="return confirm('Hapus avatar ini? User yang lagi pakai akan balik ke ikon default.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="avatar-admin-delete" aria-label="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted text-center py-4">Belum ada avatar preset. Upload dulu di atas.</p>
    @endif
@endsection