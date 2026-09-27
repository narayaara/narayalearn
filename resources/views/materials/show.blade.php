@extends('layouts.app')

@section('title', $material->title . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 900px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: var(--pink-primary);">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('subjects.index') }}" style="color: var(--pink-primary);">Subjects</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('subjects.show', $material->subject) }}" style="color: var(--pink-primary);">
                    {{ $material->subject->name }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('subjects.topic', [$material->subject, $material->title]) }}" style="color: var(--pink-primary);">
                    {{ $material->title }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $material->type_label }}</li>
        </ol>
    </nav>

    @php
        $ext = $material->file_path ? strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION)) : null;
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $fileUrl = $material->file_path ? Storage::url($material->file_path) : null;
        $isVideo = $material->type === 'video';
    @endphp

    <!-- Toolbar: badge + judul + aksi -->
    <div class="material-toolbar mb-3">
        <div class="material-toolbar-info">
            <span class="badge rounded-pill material-type-badge">
                <i class="fas {{ $isVideo ? 'fa-video' : ($material->type === 'exercise' ? 'fa-pen' : 'fa-file-alt') }} me-1"></i>
                {{ $material->type_label }}
            </span>
            <h3 class="fw-bold mb-0 mt-2" style="color: var(--text-dark);">
                {{ $material->title }}
            </h3>
        </div>

        <div class="material-toolbar-actions">
            {{-- ===== TOMBOL FAVORITE ===== --}}
            @auth
                <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" 
                            class="btn btn-sm rounded-3 {{ ($isFavorited ?? false) ? 'btn-pink' : 'btn-outline-secondary' }}">
                        <i class="{{ ($isFavorited ?? false) ? 'fas' : 'far' }} fa-heart me-1"></i>
                        {{ ($isFavorited ?? false) ? 'Favorited' : 'Favorite' }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-3">
                    <i class="far fa-heart me-1"></i> Favorite
                </a>
            @endauth

            {{-- Tombol Video YouTube --}}
            @if($isVideo && $material->youtube_link)
                <a href="{{ $material->youtube_link }}" target="_blank" rel="noopener"
                   class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="fab fa-youtube me-1"></i> Buka di YouTube
                </a>
            @elseif($fileUrl)
                {{-- Tombol File (PDF/Gambar) --}}
                <a href="{{ $fileUrl }}" target="_blank" rel="noopener"
                   class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="fas fa-up-right-from-square me-1"></i> Buka di Tab Baru
                </a>
                <a href="{{ route('materials.download', $material) }}" class="btn btn-sm rounded-3 material-download-btn">
                    <i class="fas fa-download me-1"></i> Download
                </a>
            @endif
        </div>
    </div>

    <!-- Konten -->
    @if($isVideo)
        @if($material->youtube_embed_url)
            <div class="material-video-frame">
                <iframe src="{{ $material->youtube_embed_url }}"
                        title="{{ $material->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        @else
            <div class="material-empty-state">
                <i class="fas fa-video-slash"></i>
                <p class="mb-0">Video belum tersedia.</p>
            </div>
        @endif
    @elseif($fileUrl && $isImage)
        <div class="material-image-frame" onclick="openMaterialLightbox()">
            <img src="{{ $fileUrl }}" alt="{{ $material->title }}">
            <div class="material-image-hint">
                <i class="fas fa-expand"></i> Ketuk untuk perbesar
            </div>
        </div>

        <!-- Lightbox -->
        <div id="materialLightbox" class="material-lightbox" onclick="closeMaterialLightbox()">
            <button type="button" class="material-lightbox-close" aria-label="Tutup" onclick="closeMaterialLightbox()">
                <i class="fas fa-xmark"></i>
            </button>
            <img src="{{ $fileUrl }}" alt="{{ $material->title }}" onclick="event.stopPropagation()">
        </div>

        <script>
            function openMaterialLightbox() {
                document.getElementById('materialLightbox').classList.add('is-open');
                document.body.classList.add('lightbox-open');
            }
            function closeMaterialLightbox() {
                document.getElementById('materialLightbox').classList.remove('is-open');
                document.body.classList.remove('lightbox-open');
            }
        </script>
    @elseif($fileUrl)
        <div class="material-pdf-frame">
            <iframe src="{{ $fileUrl }}#toolbar=0" title="{{ $material->title }}"></iframe>
        </div>
    @else
        <div class="material-empty-state">
            <i class="fas fa-file-circle-question"></i>
            <p class="mb-0">Dokumen belum tersedia.</p>
        </div>
    @endif

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.topic', [$material->subject, $material->title]) }}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke {{ $material->title }}
        </a>
    </div>

</div>
@endsection