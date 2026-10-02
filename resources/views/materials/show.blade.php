@extends('layouts.app')

@section('title', $material->title . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1200px;">

    <!-- ===== HEADER — BACK + JUDUL INLINE ===== -->
    <div class="d-flex align-items-start gap-3 mb-4">
        <a href="{{ route('subjects.topic', [$material->subject, $material->title]) }}" 
           class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="flex-grow-1">
            @php
                $ext = $material->file_path ? strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION)) : null;
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isPdf = $ext === 'pdf';
                $isVideo = $material->type === 'video';
            @endphp

            <span class="material-type-badge mb-2">
                @if($isVideo)
                    <i class="fas fa-video me-1"></i> Video
                @elseif($isPdf)
                    <i class="fas fa-file-pdf me-1"></i> Materi PDF
                @elseif($isImage)
                    <i class="fas fa-image me-1"></i> Infografis
                @else
                    <i class="fas fa-file me-1"></i> Materi
                @endif
            </span>

            <h2 class="material-title mb-1">{{ $material->title }}</h2>
            <p class="material-meta">
                {{ $material->subject->name ?? '-' }} • 
                {{ ucfirst($material->type) }} • 
                {{ $material->created_at->diffForHumans() }}
            </p>
        </div>
    </div>

    <!-- ===== ACTION BUTTONS ===== -->
    <div class="d-flex gap-2 mb-4 flex-wrap align-items-center">
        @if($isVideo && $material->youtube_url)
            <a href="{{ $material->youtube_url }}" target="_blank" class="btn-material-action">
                <i class="fas fa-external-link-alt me-1"></i> Buka di YouTube
            </a>
        @elseif($material->file_path)
            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn-material-action">
                <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
            </a>
            <a href="{{ route('materials.download', $material) }}" class="btn-material-download">
                <i class="fas fa-download me-1"></i> Download
            </a>
        @endif

        @auth
            <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn-material-fav" title="Favoritkan">
                    <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart"></i>
                </button>
            </form>
        @endauth
    </div>

    <!-- ===== KONTEN ===== -->
    <div class="material-content-box">

        {{-- ===== VIDEO ===== --}}
        @if($isVideo)
            @if($material->youtube_url)
                @php
                    $embedUrl = $material->youtube_url;
                    if (str_contains($material->youtube_url, 'youtu.be/')) {
                        $videoId = substr(parse_url($material->youtube_url, PHP_URL_PATH), 1);
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    } elseif (str_contains($material->youtube_url, 'watch?v=')) {
                        $videoId = explode('watch?v=', $material->youtube_url)[1];
                        $videoId = explode('&', $videoId)[0];
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    }
                @endphp
                <div class="material-video-frame">
                    <iframe src="{{ $embedUrl }}" 
                            title="{{ $material->title }}" 
                            allowfullscreen></iframe>
                </div>
            @else
                <div class="material-empty-state">
                    <i class="fas fa-video-slash"></i>
                    <p>Video belum tersedia</p>
                </div>
            @endif

        {{-- ===== GAMBAR ===== --}}
        @elseif($isImage)
            <div class="material-image-frame" onclick="openLightbox()">
                <img src="{{ asset('storage/' . $material->file_path) }}" 
                     alt="{{ $material->title }}">
                <div class="material-image-hint">
                    <i class="fas fa-expand"></i> Ketuk untuk perbesar
                </div>
            </div>

            {{-- Lightbox --}}
            <div id="materialLightbox" class="material-lightbox" onclick="closeLightbox()">
                <button class="material-lightbox-close" onclick="closeLightbox()">
                    <i class="fas fa-xmark"></i>
                </button>
                <img src="{{ asset('storage/' . $material->file_path) }}" 
                     alt="{{ $material->title }}" 
                     onclick="event.stopPropagation()">
            </div>

        {{-- ===== PDF ===== --}}
        @elseif($isPdf)
            <div class="material-pdf-frame">
                <iframe src="{{ asset('storage/' . $material->file_path) }}#toolbar=0" 
                        title="{{ $material->title }}"></iframe>
            </div>

        {{-- ===== EMPTY ===== --}}
        @else
            <div class="material-empty-state">
                <i class="fas fa-file-circle-question"></i>
                <p>Dokumen belum tersedia</p>
            </div>
        @endif

    </div>

    <!-- ===== TIPS BANNER ===== -->
    <div class="tips-banner mt-4">
        <div class="tips-icon">
            <i class="fas fa-lightbulb"></i>
        </div>
        <div>
            <span class="tips-label">Tips Naraya</span>
            <p class="tips-text">
                Baca materi dengan teliti, catat poin penting, dan lanjut ke latihan soal!
            </p>
        </div>
    </div>

</div>

{{-- Script Lightbox --}}
<script>
function openLightbox() {
    document.getElementById('materialLightbox').classList.add('is-open');
    document.body.classList.add('lightbox-open');
}
function closeLightbox() {
    document.getElementById('materialLightbox').classList.remove('is-open');
    document.body.classList.remove('lightbox-open');
}
</script>
@endsection