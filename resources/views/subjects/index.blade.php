@extends('layouts.app')

@section('title', 'Mata Pelajaran - NarayaLearn')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: #2D1B2E;">
            <i class="fas fa-book-open" style="color: #FF6B9D;"></i> 
            Mata Pelajaran
        </h1>
        <p class="text-muted">Pilih mata pelajaran yang ingin kamu pelajari</p>
    </div>

    <!-- Daftar Subject -->
    <div class="row g-4">
        @forelse($subjects as $subject)
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('subjects.show', $subject) }}" class="text-decoration-none">
                    <div class="card card-pink h-100 text-center p-4">
                        <!-- Icon -->
                        <div class="p-3 rounded-circle mx-auto" style="background: var(--pink-light); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book" style="font-size: 30px; color: var(--pink-primary);"></i>
                        </div>
                        <h5 class="mt-3 fw-bold" style="color: #2D1B2E;">{{ $subject->name }}</h5>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-file-alt me-1"></i> 
                            {{ $subject->materials_count ?? 0 }} Materi
                        </p>
                        <span class="btn btn-pink btn-sm mt-3">
                            Lihat Konten <i class="fas fa-arrow-right ms-1"></i>
                        </span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-book-open" style="font-size: 48px; color: #ddd;"></i>
                <p class="text-muted mt-3">Belum ada mata pelajaran tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Home
        </a>
    </div>
</div>
@endsection