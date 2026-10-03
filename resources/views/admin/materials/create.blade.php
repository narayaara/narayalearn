@extends('layouts.admin')

@section('title', 'Tambah Materi - NarayaLearn Admin')
@section('breadcrumb', 'Tambah Materi')

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

    <h1 class="admin-page-title">Tambah Materi</h1>
    <p class="admin-page-subtitle mb-0">
        Tambahkan materi, video, atau latihan soal baru
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

    <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Subject -->
        <div class="mb-4">
            <label for="subject_id" class="form-label fw-bold">
                <i class="fas fa-book me-1" style="color: var(--pink-deep);"></i>
                Mata Pelajaran <span class="text-danger">*</span>
            </label>
            <select name="subject_id" id="subject_id"
                    class="form-select admin-form-input @error('subject_id') is-invalid @enderror" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                           {{ old('type', 'material') == 'material' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-file-pdf"></i>
                        <span>Materi PDF</span>
                    </div>
                </label>
                <label class="admin-type-option">
                    <input type="radio" name="type" value="video"
                           {{ old('type') == 'video' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-play-circle"></i>
                        <span>Video</span>
                    </div>
                </label>
                <label class="admin-type-option">
                    <input type="radio" name="type" value="exercise"
                           {{ old('type') == 'exercise' ? 'checked' : '' }}>
                    <div class="admin-type-box">
                        <i class="fas fa-pen"></i>
                        <span>Latihan</span>
                    </div>
                </label>
            </div>
            @error('type') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        </div>

        <!-- Judul -->
        <div class="mb-4">
            <label for="title" class="form-label fw-bold">
                <i class="fas fa-heading me-1" style="color: var(--pink-deep);"></i>
                Judul Materi <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title"
                   class="form-control admin-form-input @error('title') is-invalid @enderror"
                   value="{{ old('title') }}"
                   placeholder="Contoh: Konsep & Sifat Dasar Eksponen" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="text-muted d-block mt-2">
                Judul ini juga menjadi nama topik di halaman user.
            </small>
        </div>

        {{-- File Upload (PDF) --}}
        <div class="mb-4" id="file-field">
            <label for="file" class="form-label fw-bold">
                <i class="fas fa-file-upload me-1" style="color: var(--pink-deep);"></i>
                Upload File PDF
            </label>
            <input type="file" name="file" id="file"
                class="form-control admin-form-input @error('file') is-invalid @enderror"
                accept="application/pdf">
            @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="text-muted d-block mt-2">
                Format PDF. Maksimal 5 MB.
            </small>
        </div>

        {{-- YouTube URL (Video) --}}
        <div class="mb-4 d-none" id="youtube-field">
            <label for="youtube_url" class="form-label fw-bold">
                <i class="fab fa-youtube me-1" style="color: var(--pink-deep);"></i>
                YouTube URL
            </label>
            <input type="url" name="youtube_url" id="youtube_url"
                class="form-control admin-form-input @error('youtube_url') is-invalid @enderror"
                value="{{ old('youtube_url') }}"
                placeholder="https://www.youtube.com/watch?v=xxxxx">
            @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="text-muted d-block mt-2">
                Bisa pakai link <strong>youtube.com/watch?v=</strong> atau <strong>youtu.be/</strong>
            </small>
        </div>

        <input type="hidden" name="source_type" id="source_type" value="{{ old('source_type', 'file') }}">

        <!-- Info Box -->
        <div class="admin-info-box mb-4">
            <div class="admin-info-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div>
                <div class="admin-info-title">Tips</div>
                <p class="admin-info-text mb-0">
                    Materi dengan judul sama akan dikelompokkan menjadi <strong>1 topik</strong>.
                    Pastikan judul konsisten agar rapi di halaman user.
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.materials.index') }}" class="admin-btn-outline">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="admin-btn-primary">
                <i class="fas fa-save"></i> Simpan Materi
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeRadios   = document.querySelectorAll('input[name="type"]');
    const fileField    = document.getElementById('file-field');
    const youtubeField = document.getElementById('youtube-field');
    const sourceType   = document.getElementById('source_type');

    function toggleFields() {
        const selected = document.querySelector('input[name="type"]:checked').value;

        if (selected === 'video') {
            // Video → sembunyikan file, tampilkan YouTube
            fileField.classList.add('d-none');
            youtubeField.classList.remove('d-none');
            sourceType.value = 'link';          // ⭐ INI KUNCINYA
        } else {
            // PDF / Latihan → tampilkan file, sembunyikan YouTube
            fileField.classList.remove('d-none');
            youtubeField.classList.add('d-none');
            sourceType.value = 'file';          // ⭐ INI KUNCINYA
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