@extends('layouts.admin')

@section('title', 'Edit Materi - NarayaLearn Admin')
@section('breadcrumb', 'Edit Materi')

@section('admin-content')

<!-- ===== PAGE HEADER — BACK + JUDUL ===== -->
<div class="admin-page-header">
    <div class="d-flex align-items-center gap-3 mb-3">
        <a href="{{ route('admin.materials.index') }}" class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span class="admin-pill">
            <i class="fas fa-shield-halved"></i> ADMIN PANEL
        </span>
    </div>

    <h1 class="admin-page-title">Edit Materi</h1>
    <p class="admin-page-subtitle mb-0">
        Perbarui informasi materi <strong>{{ $material->title }}</strong>
    </p>
</div>

<!-- ===== FORM CARD ===== -->
<div class="admin-form-card" style="max-width: 800px;">

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

    <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Preview -->
        <div class="admin-form-preview mb-4">
            <div class="admin-row-icon admin-row-icon-lg {{ $material->type === 'video' ? 'stat-icon-rose' : ($material->type === 'exercise' ? 'stat-icon-soft' : '') }}">
                @if($material->type === 'video')
                    <i class="fas fa-video"></i>
                @elseif($material->type === 'exercise')
                    <i class="fas fa-pen"></i>
                @else
                    <i class="fas fa-file-pdf"></i>
                @endif
            </div>
            <div class="min-width-0">
                <div class="admin-form-preview-label">
                    {{ $material->subject->name ?? '-' }} • 
                    {{ ucfirst($material->type) }}
                </div>
                <div class="admin-form-preview-title">{{ $material->title }}</div>
                <small class="text-muted">
                    Dibuat {{ $material->created_at->format('d M Y') }}
                </small>
            </div>
        </div>

        <hr class="admin-form-divider">

        <!-- Subject -->
        <div class="mb-4">
            <label for="subject_id" class="form-label fw-bold">
                <i class="fas fa-book me-1" style="color: var(--pink-deep);"></i>
                Mata Pelajaran <span class="text-danger">*</span>
            </label>
            <select name="subject_id" id="subject_id"
                    class="form-select admin-form-input @error('subject_id') is-invalid @enderror" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" 
                        {{ old('subject_id', $material->subject_id) == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            @error('subject_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Tipe Konten -->
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-tag me-1" style="color: var(--pink-deep);"></i>
                Tipe Konten <span class="text-danger">*</span>
            </label>
            <div class="admin-type-picker">
                <label class="admin-type-option">
                    <input type="radio" name="type" value="material" 
                           {{ old('type', $material->type) == 'material' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-file-pdf"></i>
                        <span>Materi PDF</span>
                    </div>
                </label>
                <label class="admin-type-option">
                    <input type="radio" name="type" value="video"
                           {{ old('type', $material->type) == 'video' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-play-circle"></i>
                        <span>Video</span>
                    </div>
                </label>
                <label class="admin-type-option">
                    <input type="radio" name="type" value="exercise"
                           {{ old('type', $material->type) == 'exercise' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-pen"></i>
                        <span>Latihan</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Judul -->
        <div class="mb-4">
            <label for="title" class="form-label fw-bold">
                <i class="fas fa-heading me-1" style="color: var(--pink-deep);"></i>
                Judul Materi <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title"
                   class="form-control admin-form-input @error('title') is-invalid @enderror"
                   value="{{ old('title', $material->title) }}"
                   placeholder="Contoh: Konsep & Sifat Dasar Eksponen" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- File Upload -->
        <div class="mb-4" id="file-field">
            <label for="file" class="form-label fw-bold">
                <i class="fas fa-file-upload me-1" style="color: var(--pink-deep);"></i>
                Upload File PDF Baru (Opsional)
            </label>

            @if($material->file_path)
                <div class="admin-file-preview mb-2">
                    <i class="fas fa-file-pdf"></i>
                    <span>{{ basename($material->file_path) }}</span>
                    <a href="{{ asset('storage/' . $material->file_path) }}" 
                       target="_blank" 
                       class="admin-file-preview-link">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            @endif

            <input type="file" name="file" id="file"
                   class="form-control admin-form-input @error('file') is-invalid @enderror"
                   accept="application/pdf">
            @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="text-muted d-block mt-2">
                Kosongkan jika tidak ingin mengganti file. Maks 5 MB.
            </small>
        </div>

        <!-- YouTube URL -->
        <div class="mb-4 d-none" id="youtube-field">
            <label for="youtube_url" class="form-label fw-bold">
                <i class="fab fa-youtube me-1" style="color: var(--pink-deep);"></i>
                YouTube URL
            </label>
            <input type="url" name="youtube_url" id="youtube_url"
                   class="form-control admin-form-input @error('youtube_url') is-invalid @enderror"
                   value="{{ old('youtube_url', $material->youtube_url) }}"
                   placeholder="https://www.youtube.com/watch?v=xxxxx">
            @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <input type="hidden" name="source_type" id="source_type" 
            value="{{ old('source_type', $material->file_path ? 'file' : 'link') }}">

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.materials.index') }}" class="admin-btn-outline">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="admin-btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const fileField = document.getElementById('file-field');
    const youtubeField = document.getElementById('youtube-field');

    function toggleFields() {
        const selected = document.querySelector('input[name="type"]:checked').value;
        if (selected === 'video') {
            fileField.classList.add('d-none');
            youtubeField.classList.remove('d-none');
        } else {
            fileField.classList.remove('d-none');
            youtubeField.classList.add('d-none');
        }
    }

    typeRadios.forEach(function (radio) {
        radio.addEventListener('change', toggleFields);
    });

    toggleFields();
});
</script>
@endpush

@endsection