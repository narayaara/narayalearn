@extends('layouts.app')

@section('title', 'Home - NarayaLearn')

@section('content')
<div class="container py-5">

    <!-- ===== HERO SECTION ===== -->
    <div class="row align-items-center py-4">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold" style="color: #2D1B2E;">
                Belajar Jadi 
                <span style="color: #FF6B9D;">Lebih Seru</span>
            </h1>
            <p class="lead text-muted" style="font-size: 1.2rem;">
                Temukan materi, video pembahasan, dan latihan soal 
                interaktif di <strong>NarayaLearn</strong>.
            </p>
            <div class="mt-4 d-flex flex-wrap gap-3">
                <a href="{{ route('subjects.index') }}" class="btn btn-pink btn-lg">
                    <i class="fas fa-rocket me-2"></i> Mulai Belajar
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-user-plus me-2"></i> Daftar Gratis
                    </a>
                @endguest
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="p-4 rounded-4" style="background: var(--pink-soft);">
                <i class="fas fa-graduation-cap" style="font-size: 120px; color: var(--pink-primary);"></i>
            </div>
        </div>
    </div>

    <!-- ===== STATISTIK (DINAMIS) ===== -->
    <div class="row text-center mt-5 g-4">
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalSubjects }}</h3>
                <p class="text-muted mb-0">Mata Pelajaran</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalMaterials }}</h3>
                <p class="text-muted mb-0">Materi</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0">Pengguna</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalComments }}</h3>
                <p class="text-muted mb-0">Komentar</p>
            </div>
        </div>
    </div>

    <!-- ===== SUBJECT POPULER (DINAMIS) ===== -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color: #2D1B2E;">
                <i class="fas fa-book" style="color: var(--pink-primary);"></i> 
                Mata Pelajaran
            </h3>
            <a href="{{ route('subjects.index') }}" class="text-decoration-none" style="color: var(--pink-primary);">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($popularSubjects as $subject)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('subjects.show', $subject) }}" class="text-decoration-none">
                        <div class="card card-pink h-100 p-3 text-center">
                            <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book" style="font-size: 30px; color: var(--pink-primary);"></i>
                            </div>
                            <h6 class="mt-3 fw-bold" style="color: #2D1B2E;">{{ $subject->name }}</h6>
                            <small class="text-muted">{{ $subject->materials_count }} Materi</small>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <i class="fas fa-book-open" style="font-size: 48px; color: #ddd;"></i>
                    <p class="text-muted mt-3">Belum ada mata pelajaran</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ===== KONTEN TERBARU (DINAMIS) ===== -->
    @if($latestMaterials->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4" style="color: #2D1B2E;">
            <i class="fas fa-clock" style="color: var(--pink-primary);"></i> 
            Konten Terbaru
        </h3>
        <div class="row g-4">
            @foreach($latestMaterials as $material)
                <div class="col-md-4">
                    <a href="{{ route('materials.show', $material) }}" class="text-decoration-none">
                        <div class="card card-pink p-3">
                            <div class="card-body">
                                <span class="badge mb-2" style="background: var(--pink-light); color: var(--pink-primary);">
                                    @if($material->type == 'material')
                                        <i class="fas fa-file-alt me-1"></i> Materi
                                    @elseif($material->type == 'video')
                                        <i class="fas fa-video me-1"></i> Video
                                    @else
                                        <i class="fas fa-tasks me-1"></i> Latihan
                                    @endif
                                </span>
                                <h5 class="mt-2" style="color: #2D1B2E;">{{ $material->title }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-book me-1"></i> {{ $material->subject->name ?? 'No Subject' }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-clock me-1"></i> {{ $material->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===== CTA UNTUK GUEST ===== -->
    @guest
        <div class="mt-5 p-5 text-center rounded-4" style="background: var(--pink-soft);">
            <h3 style="color: #2D1B2E;">Siap Belajar?</h3>
            <p class="text-muted">Daftar sekarang dan mulai perjalanan belajarmu!</p>
            <a href="{{ route('register') }}" class="btn btn-pink btn-lg">
                <i class="fas fa-user-plus me-2"></i> Daftar Gratis
            </a>
        </div>
    @endguest
</div>
@endsection