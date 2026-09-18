@extends('layouts.app')

@section('title', $material->title . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <a href="{{ route('subjects.show', $material->subject) }}" 
                   class="text-decoration-none d-inline-flex align-items-center gap-2 mb-2"
                   style="color: #2D1B2E;">
                    <i class="fas fa-chevron-left"></i>
                    <h4 class="fw-bold mb-0">{{ $material->title }}</h4>
                </a>
                <p class="text-muted small mb-0 ms-4">
                    {{ $material->subject->name ?? '-' }} - 
                    @if($material->type == 'material') Materials
                    @elseif($material->type == 'video') Video
                    @else Exercise
                    @endif
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                @auth
                    <form action="{{ route('favorites.toggle', $material) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $isFavorited ? 'btn-pink' : 'btn-outline-dark' }}">
                            {{ $isFavorited ? 'Favorited' : 'favorite' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark">favorite</a>
                @endauth

                @if($material->file_path)
                    <a href="{{ route('materials.download', $material) }}" class="btn btn-sm btn-outline-dark">
                        Download
                    </a>
                @endif
            </div>
        </div>
    </div>

    @php
        $hasFile = !empty($material->file_path);
        $hasLink = !empty($material->youtube_url);
        
        $fileExt = $hasFile ? strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION)) : null;
        $isImage = $hasFile && in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $isPdf = $hasFile && $fileExt === 'pdf';
        
        $isYoutube = $hasLink && (str_contains($material->youtube_url, 'youtube.com') || str_contains($material->youtube_url, 'youtu.be'));
        $isDirectImage = $hasLink && preg_match('/\.(jpg|jpeg|png|gif|webp)(\?.*)?$/i', $material->youtube_url);
    @endphp

    <!-- Kotak Konten -->
    <div class="card border-0 rounded-4 p-4 mb-4" 
         style="box-shadow: 0 2px 12px rgba(0,0,0,0.06); min-height: 400px;">
        
        {{-- VIDEO YOUTUBE --}}
        @if($isYoutube)
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
            <div class="ratio ratio-16x9">
                <iframe src="{{ $embedUrl }}" title="{{ $material->title }}" allowfullscreen></iframe>
            </div>
        @endif

        {{-- GAMBAR UPLOAD --}}
        @if($isImage)
            <div class="text-center">
                <img src="{{ asset('storage/' . $material->file_path) }}" 
                     alt="{{ $material->title }}" 
                     class="img-fluid rounded-3" 
                     style="max-height: 250px; width: auto;">
            </div>
        @endif

        {{-- GAMBAR DARI LINK --}}
        @if($isDirectImage)
            <div class="text-center">
                <img src="{{ $material->youtube_url }}" 
                     alt="{{ $material->title }}" 
                     class="img-fluid rounded-3" 
                     style="max-height: 250px; width: auto;">
            </div>
        @endif

        {{-- PDF --}}
        @if($isPdf)
            <div class="pdf-wrapper">
                <embed 
                    src="{{ asset('storage/' . $material->file_path) }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH" 
                    type="application/pdf" 
                    class="pdf-embed">
            </div>
        @endif

        {{-- PLACEHOLDER --}}
        @if($hasFile && !$isPdf && !$isImage)
            <div class="text-center py-5">
                <i class="far fa-file" style="font-size: 60px; color: #ccc;"></i>
                <p class="text-muted mt-3 mb-0">{{ pathinfo($material->file_path, PATHINFO_FILENAME) }}</p>
            </div>
        @endif

        @if(!$hasFile && !$hasLink)
            <div class="text-center py-5">
                <i class="far fa-file" style="font-size: 60px; color: #ccc;"></i>
                <p class="text-muted mt-3 mb-0">{{ $material->title }}-material-detail</p>
            </div>
        @endif

        @if($hasLink && !$isYoutube && !$isDirectImage)
            <div class="text-center py-5">
                <i class="fas fa-link" style="font-size: 48px; color: #ccc;"></i>
                <p class="text-muted mt-3 mb-3">Konten tersedia di link eksternal</p>
                <a href="{{ $material->youtube_url }}" target="_blank" class="btn btn-outline-dark btn-sm">
                    Buka Link
                </a>
            </div>
        @endif
    </div>

    <!-- ===== KOMENTAR ===== -->
    <h5 class="fw-bold mb-3" style="color: #2D1B2E;">Comments</h5>

    {{-- Form Komentar Utama --}}
    @auth
        <form action="{{ route('comments.store', $material) }}" method="POST" class="mb-4">
            @csrf
            <div class="card border-0 rounded-4 p-3" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                         style="width: 32px; height: 32px;">
                        <i class="fas fa-user" style="color: #999; font-size: 14px;"></i>
                    </div>
                    <span class="fw-semibold small">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->role === 'admin')
                        <span class="badge-admin">Admin</span>
                    @endif
                </div>
                <textarea name="content" rows="2" 
                          class="form-control border-0 bg-light mb-2 @error('content') is-invalid @enderror" 
                          placeholder="Write a comment..." required>{{ old('content') }}</textarea>
                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="text-end">
                    <button type="submit" class="btn btn-sm btn-outline-dark">
                        Post comment
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="card border-0 rounded-4 p-3 mb-4" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
            <p class="text-muted small mb-0">
                Please <a href="{{ route('login') }}" style="color: var(--pink-primary);">log in</a> to comment.
            </p>
        </div>
    @endauth

    {{-- Daftar Komentar Utama (cuma yang reply_to_id = null) --}}
    @php
        $mainComments = $material->comments()->whereNull('reply_to_id')->latest()->get();
    @endphp

    @forelse($mainComments as $comment)
        @include('materials.partials.comment', ['comment' => $comment, 'material' => $material])
    @empty
        <div class="card border-0 rounded-4 p-3 text-center" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
            <p class="text-muted small mb-0">Belum ada komentar. Jadilah yang pertama!</p>
        </div>
    @endforelse
</div>

{{-- Script Toggle Reply & Replies --}}
<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) form.classList.toggle('d-none');
}

function toggleReplies(commentId) {
    const replies = document.getElementById('replies-' + commentId);
    const chevron = document.getElementById('reply-chevron-' + commentId);
    
    if (replies) {
        replies.classList.toggle('d-none');
        if (replies.classList.contains('d-none')) {
            chevron.classList.remove('fa-chevron-up');
            chevron.classList.add('fa-chevron-down');
        } else {
            chevron.classList.remove('fa-chevron-down');
            chevron.classList.add('fa-chevron-up');
        }
    }
}
</script>
@endsection