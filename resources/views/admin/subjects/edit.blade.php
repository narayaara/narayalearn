@extends('layouts.admin')

@section('title', 'Edit Subject - NarayaLearn Admin')
@section('breadcrumb', 'Edit Subject')

@section('admin-content')

<!-- ===== PAGE HEADER — BACK + JUDUL ===== -->
<div class="admin-page-header">
    <div class="d-flex align-items-center gap-3 mb-3">
        <a href="{{ route('admin.subjects.index') }}" class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span class="admin-pill">
            <i class="fas fa-shield-halved"></i> ADMIN PANEL
        </span>
    </div>

    <h1 class="admin-page-title">Edit Subject</h1>
    <p class="admin-page-subtitle mb-0">
        Perbarui informasi mata pelajaran <strong>{{ $subject->name }}</strong>
    </p>
</div>

<!-- ===== FORM CARD ===== -->
<div class="admin-form-card">

    {{-- Error Alert --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Subject Info Preview -->
        <div class="admin-form-preview mb-4">
            <div class="admin-row-icon admin-row-icon-lg">
                <i class="fas fa-book"></i>
            </div>
            <div class="min-width-0">
                <div class="admin-form-preview-label">Mata Pelajaran</div>
                <div class="admin-form-preview-title">{{ $subject->name }}</div>
                <small class="text-muted">
                    Dibuat {{ $subject->created_at->format('d M Y') }}
                </small>
            </div>
        </div>

        <hr class="admin-form-divider">

        <!-- Input Nama -->
        <div class="mb-4">
            <label for="name" class="form-label fw-bold">
                <i class="fas fa-tag me-1" style="color: var(--pink-deep);"></i>
                Nama Mata Pelajaran
                <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control admin-form-input @error('name') is-invalid @enderror"
                   value="{{ old('name', $subject->name) }}"
                   placeholder="Contoh: Matematika, Fisika, Bahasa Inggris"
                   required
                   autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-2">
                Nama mata pelajaran harus unik dan maksimal 128 karakter.
            </small>
        </div>

        <!-- Info Box -->
        <div class="admin-info-box mb-4">
            <div class="admin-info-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <div class="admin-info-title">Informasi</div>
                <p class="admin-info-text mb-0">
                    Mata pelajaran ini memiliki
                    <strong>{{ $subject->materials()->distinct()->pluck('title')->count() }} topik</strong> dan
                    <strong>{{ $subject->materials()->count() }} materi</strong>.
                    Mengubah nama tidak akan menghapus data di dalamnya.
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.subjects.index') }}" class="admin-btn-outline">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="admin-btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@endsection