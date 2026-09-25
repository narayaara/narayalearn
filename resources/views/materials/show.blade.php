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

    <!-- Header -->
    <div class="mb-4">
        <span class="badge rounded-pill mb-2" style="background: var(--pink-light); color: var(--pink-primary);">
            {{ $material->type_label }}
        </span>
        <h3 class="fw-bold mb-0" style="color: var(--text-dark);">
            {{ $material->title }}
        </h3>
    </div>

    <!-- Konten -->
    <div class="card border-0 rounded-4 p-3 mb-3" style="background: var(--bg-card); box-shadow: var(--shadow-card);">
        @if($material->type === 'video')
            @if($material->youtube_embed_url)
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                    <iframe src="{{ $material->youtube_embed_url }}"
                            title="{{ $material->title }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            @else
                <p class="text-muted text-center my-4 mb-0">Video belum tersedia.</p>
            @endif
        @else
            {{-- type: material atau exercise, sama-sama dokumen PDF --}}
            @if($material->file_path)
                <div class="rounded-3 overflow-hidden mb-3" style="border: 1px solid rgba(0,0,0,0.08); height: 75vh;">
                    <iframe src="{{ Storage::url($material->file_path) }}" width="100%" height="100%" style="border: none;"></iframe>
                </div>
                <a href="{{ route('materials.download', $material) }}" class="btn text-white rounded-3"
                   style="background: var(--pink-primary);">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            @else
                <p class="text-muted text-center my-4 mb-0">Dokumen belum tersedia.</p>
            @endif
        @endif
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.topic', [$material->subject, $material->title]) }}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke {{ $material->title }}
        </a>
    </div>

</div>
@endsection