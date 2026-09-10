@extends('layouts.app')

@section('title', $subject->name . ' - NarayaLearn')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--pink-primary);">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}" style="color: var(--pink-primary);">Subjects</a></li>
            <li class="breadcrumb-item active">{{ $subject->name }}</li>
        </ol>
    </nav>

    <!-- Header Subject -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="p-3 rounded-circle" style="background: var(--pink-light); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-book" style="font-size: 28px; color: var(--pink-primary);"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $subject->name }}</h2>
            <p class="text-muted mb-0">{{ $subject->materials->count() }} materi tersedia</p>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs border-0 gap-2 mb-4" id="contentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi" type="button" role="tab">
                <i class="fas fa-file-alt me-1"></i> Materi
                <span class="badge bg-secondary ms-1">{{ isset($materials['material']) ? $materials['material']->count() : 0 }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">
                <i class="fas fa-video me-1"></i> Video
                <span class="badge bg-secondary ms-1">{{ isset($materials['video']) ? $materials['video']->count() : 0 }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="latihan-tab" data-bs-toggle="tab" data-bs-target="#latihan" type="button" role="tab">
                <i class="fas fa-tasks me-1"></i> Latihan Soal
                <span class="badge bg-secondary ms-1">{{ isset($materials['exercise']) ? $materials['exercise']->count() : 0 }}</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- TAB MATERI -->
        <div class="tab-pane fade show active" id="materi" role="tabpanel">
            @if(isset($materials['material']) && $materials['material']->count() > 0)
                <div class="row g-3">
                    @foreach($materials['material'] as $material)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('materials.show', $material) }}" class="text-decoration-none">
                                <div class="card card-pink p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 rounded-circle" style="background: var(--pink-light);">
                                            <i class="fas fa-file-pdf" style="color: var(--pink-primary); font-size: 20px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $material->title }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-download me-1"></i> Tersedia
                                            </small>
                                        </div>
                                        <i class="fas fa-chevron-right" style="color: #ddd;"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt" style="font-size: 48px; color: #ddd;"></i>
                    <p class="text-muted mt-3">Belum ada materi untuk mata pelajaran ini</p>
                </div>
            @endif
        </div>

        <!-- TAB VIDEO -->
        <div class="tab-pane fade" id="video" role="tabpanel">
            @if(isset($materials['video']) && $materials['video']->count() > 0)
                <div class="row g-3">
                    @foreach($materials['video'] as $material)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('materials.show', $material) }}" class="text-decoration-none">
                                <div class="card card-pink p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 rounded-circle" style="background: var(--pink-light);">
                                            <i class="fas fa-play" style="color: var(--pink-primary); font-size: 20px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $material->title }}</h6>
                                            <small class="text-muted">
                                                <i class="fab fa-youtube me-1"></i> Video
                                            </small>
                                        </div>
                                        <i class="fas fa-chevron-right" style="color: #ddd;"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-video" style="font-size: 48px; color: #ddd;"></i>
                    <p class="text-muted mt-3">Belum ada video untuk mata pelajaran ini</p>
                </div>
            @endif
        </div>

        <!-- TAB LATIHAN -->
        <div class="tab-pane fade" id="latihan" role="tabpanel">
            @if(isset($materials['exercise']) && $materials['exercise']->count() > 0)
                <div class="row g-3">
                    @foreach($materials['exercise'] as $material)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('materials.show', $material) }}" class="text-decoration-none">
                                <div class="card card-pink p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2 rounded-circle" style="background: var(--pink-light);">
                                            <i class="fas fa-tasks" style="color: var(--pink-primary); font-size: 20px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $material->title }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-download me-1"></i> Tersedia
                                            </small>
                                        </div>
                                        <i class="fas fa-chevron-right" style="color: #ddd;"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tasks" style="font-size: 48px; color: #ddd;"></i>
                    <p class="text-muted mt-3">Belum ada latihan soal untuk mata pelajaran ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Subject
        </a>
    </div>
</div>
@endsection