@extends('layouts.app')

@section('title', 'Home - NarayaLearn')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
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

    <!-- Statistik -->
    <div class="row text-center mt-5 g-4">
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">50+</h3>
                <p class="text-muted mb-0">Materi</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">30+</h3>
                <p class="text-muted mb-0">Video</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">100+</h3>
                <p class="text-muted mb-0">Latihan Soal</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="p-3 rounded-4" style="background: var(--pink-soft);">
                <h3 class="fw-bold" style="color: var(--pink-primary);">500+</h3>
                <p class="text-muted mb-0">Siswa Aktif</p>
            </div>
        </div>
    </div>

    <!-- Mata Pelajaran Populer -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color: #2D1B2E;">
                <i class="fas fa-book" style="color: var(--pink-primary);"></i> 
                Mata Pelajaran Populer
            </h3>
            <a href="{{ route('subjects.index') }}" class="text-decoration-none" style="color: var(--pink-primary);">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <!-- Card Subject 1 -->
            <div class="col-md-3 col-6">
                <div class="card-pink card h-100 p-3 text-center">
                    <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px;">
                        <i class="fas fa-calculator" style="font-size: 30px; color: var(--pink-primary);"></i>
                    </div>
                    <h6 class="mt-2 fw-bold">Matematika</h6>
                    <small class="text-muted">12 Materi</small>
                </div>
            </div>
            <!-- Card Subject 2 -->
            <div class="col-md-3 col-6">
                <div class="card-pink card h-100 p-3 text-center">
                    <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px;">
                        <i class="fas fa-microscope" style="font-size: 30px; color: var(--pink-primary);"></i>
                    </div>
                    <h6 class="mt-2 fw-bold">Fisika</h6>
                    <small class="text-muted">8 Materi</small>
                </div>
            </div>
            <!-- Card Subject 3 -->
            <div class="col-md-3 col-6">
                <div class="card-pink card h-100 p-3 text-center">
                    <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px;">
                        <i class="fas fa-flask" style="font-size: 30px; color: var(--pink-primary);"></i>
                    </div>
                    <h6 class="mt-2 fw-bold">Kimia</h6>
                    <small class="text-muted">10 Materi</small>
                </div>
            </div>
            <!-- Card Subject 4 -->
            <div class="col-md-3 col-6">
                <div class="card-pink card h-100 p-3 text-center">
                    <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px;">
                        <i class="fas fa-dna" style="font-size: 30px; color: var(--pink-primary);"></i>
                    </div>
                    <h6 class="mt-2 fw-bold">Biologi</h6>
                    <small class="text-muted">9 Materi</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Terbaru -->
    <div class="mt-5">
        <h3 class="fw-bold" style="color: #2D1B2E;">
            <i class="fas fa-clock" style="color: var(--pink-primary);"></i> 
            Konten Terbaru
        </h3>
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="card-pink card">
                    <div class="card-body">
                        <span class="badge bg-primary" style="background: var(--pink-primary) !important;">Materi</span>
                        <h5 class="mt-2">Persamaan Kuadrat</h5>
                        <p class="text-muted small">Matematika • 2 hari lalu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-pink card">
                    <div class="card-body">
                        <span class="badge bg-danger" style="background: #FF6B6B !important;">Video</span>
                        <h5 class="mt-2">Hukum Newton</h5>
                        <p class="text-muted small">Fisika • 3 hari lalu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-pink card">
                    <div class="card-body">
                        <span class="badge bg-success" style="background: #51CF66 !important;">Latihan</span>
                        <h5 class="mt-2">Stoikiometri</h5>
                        <p class="text-muted small">Kimia • 5 hari lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA untuk Guest -->
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