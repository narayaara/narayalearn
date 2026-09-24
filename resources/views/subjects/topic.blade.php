@extends('layouts.app')

@section('title', $subject->name . ' - ' . $topic . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

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
                <a href="{{ route('subjects.show', $subject) }}" style="color: var(--pink-primary);">
                    {{ $subject->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $topic }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: var(--text-dark);">
            {{ $topic }}
        </h2>
        <p class="mb-0 small" style="color: var(--text-gray);">
            {{ $subject->name }} • Pilih tipe konten yang ingin dipelajari
        </p>
    </div>

    <!-- Tab Cards -->
    <div class="row g-3">
        <!-- Materi -->
        <div class="col-md-4">
            <a href="#" class="text-decoration-none d-block h-100">
                <div class="card-material card border-0 rounded-4 p-4 text-center h-100"
                     style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                         style="width: 70px; height: 70px; background: var(--pink-light);">
                        <i class="fas fa-file-alt" style="color: var(--pink-primary); font-size: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--text-dark);">Materi</h5>
                    <p class="small mb-0" style="color: var(--text-gray);">
                        Baca materi pembelajaran
                    </p>
                </div>
            </a>
        </div>

        <!-- Video -->
        <div class="col-md-4">
            <a href="#" class="text-decoration-none d-block h-100">
                <div class="card-material card border-0 rounded-4 p-4 text-center h-100"
                     style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                         style="width: 70px; height: 70px; background: var(--pink-light);">
                        <i class="fas fa-video" style="color: var(--pink-primary); font-size: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--text-dark);">Video</h5>
                    <p class="small mb-0" style="color: var(--text-gray);">
                        Tonton video pembahasan
                    </p>
                </div>
            </a>
        </div>

        <!-- Latihan -->
        <div class="col-md-4">
            <a href="#" class="text-decoration-none d-block h-100">
                <div class="card-material card border-0 rounded-4 p-4 text-center h-100"
                     style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                         style="width: 70px; height: 70px; background: var(--pink-light);">
                        <i class="fas fa-pen" style="color: var(--pink-primary); font-size: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--text-dark);">Latihan</h5>
                    <p class="small mb-0" style="color: var(--text-gray);">
                        Kerjakan latihan soal
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke {{ $subject->name }}
        </a>
    </div>

</div>
@endsection