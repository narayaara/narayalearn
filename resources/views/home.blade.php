@extends('layouts.app')

@section('title', 'Home - NarayaLearn')

@section('content')
<div class="home-wrapper">

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-section">
        <div class="hero-bg-decor">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>

        <div class="container position-relative">
            <div class="row align-items-center g-4 g-lg-5">

                <!-- KIRI: Text -->
                <div class="col-lg-7">
                    <div class="hero-pill">
                        <span class="dot-pulse"></span>
                        <span>Revolusi Belajar Digital</span>
                        <i class="fas fa-sparkles"></i>
                    </div>

                    <h1 class="hero-title">
                        Belajar Jadi Lebih
                        <span class="text-gradient">Seru!</span>
                    </h1>

                    <p class="hero-subtitle">
                        Temukan cara seru menaklukkan pelajaran sekolah dengan materi interaktif yang dirancang khusus untukmu.
                    </p>

                    <div class="hero-cta">
                        <a href="{{ route('subjects.index') }}" class="btn btn-pink-gradient">
                            MULAI BELAJAR SEKARANG
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-soft">
                                Daftar Gratis
                            </a>
                        @endguest
                    </div>
                </div>

                <!-- KANAN: Maskot -->
                <div class="col-lg-5 text-center">
                    <div class="hero-mascot">
                        <img src="{{ asset('images/hero-student.png') }}"
                            alt="Ilustrasi Belajar"
                            class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATISTIK DINAMIS ===== -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-2 g-md-4">
                <!-- Subjects -->
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalSubjects }}</h3>
                            <span class="stat-label">SUBJECT</span>
                            <small>Kurikulum Terakreditasi</small>
                        </div>
                    </div>
                </div>

                <!-- Topics -->
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalTopics }}</h3>
                            <span class="stat-label">TOPIK</span>
                            <small>Disusun Sistematis</small>
                        </div>
                    </div>
                </div>

                <!-- Materials -->
                <div class="col-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-photo-video"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalMaterials }}</h3>
                            <span class="stat-label">KONTEN</span>
                            <small>Video, PDF & Kuis</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SUBJECT SECTION ===== -->
    <section class="subjects-section">
        <div class="container">
            <div class="subjects-wrapper">
                <!-- Header -->
                <div class="text-center mb-4 mb-lg-5">
                    <div class="section-pill">
                        <i class="fas fa-compass"></i>
                        <span>Katalog Belajar</span>
                    </div>
                    <h2 class="section-title">Pilih Mata Pelajaran</h2>
                    <p class="section-subtitle">Mau jago di bidang apa hari ini?</p>
                </div>

                <!-- Grid Subject -->
                <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
                    @forelse($subjects as $subject)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('subjects.show', $subject) }}" class="text-decoration-none">
                                <div class="subject-card">
                                    <div class="subject-card-top">
                                        <div class="subject-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    </div>
                                    <h3 class="subject-name">{{ $subject->name }}</h3>
                                    <p class="subject-desc">
                                        Materi lengkap dengan video, PDF, dan latihan soal interaktif.
                                    </p>
                                    <div class="subject-badges">
                                        <span class="badge-soft">
                                            <i class="fas fa-file-alt"></i>
                                            {{ $subject->materials_count }} Materi
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-book-open" style="font-size: 60px; color: var(--text-muted);"></i>
                            <h5 class="mt-3" style="color: var(--text-dark);">Belum Ada Subject</h5>
                            <p class="text-muted">Subject akan muncul di sini setelah admin menambahkannya.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tombol Lihat Semua -->
                <div class="text-center">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-pink">
                        Lihat Semua Pelajaran
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection