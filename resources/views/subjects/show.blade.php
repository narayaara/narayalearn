@extends('layouts.app')

@section('title', $subject->name . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

    <!-- Header Subject -->
    <div class="mb-4 p-4 rounded-4" 
         style="background: var(--pink-soft); box-shadow: var(--shadow-card);">
        <h2 class="fw-bold mb-1" style="color: var(--text-dark);">
            <i class="fas fa-book me-2" style="color: var(--pink-primary);"></i> 
            {{ $subject->name }}
        </h2>
        <p class="mb-0 small" style="color: var(--text-gray);">
            Pilih topik untuk mulai belajar
        </p>
    </div>

    <!-- Daftar Topik -->
    @if(isset($topics) && count($topics) > 0)
        <div class="row g-3">
            @foreach ($topics as $topic)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('subjects.topic', [$subject, $topic]) }}" 
                       class="text-decoration-none d-block h-100">
                        <div class="card-material card border-0 rounded-4 p-3 h-100"
                             style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Icon -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 45px; height: 45px; background: var(--pink-light);">
                                    <i class="fas fa-graduation-cap" style="color: var(--pink-primary); font-size: 18px;"></i>
                                </div>

                                <!-- Title -->
                                <div class="flex-grow-1 min-width-0">
                                    <span class="fw-bold d-block text-truncate" style="color: var(--text-dark);">
                                        {{ $topic }}
                                    </span>
                                </div>

                                <!-- Chevron -->
                                <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 rounded-4 p-5 text-center"
             style="background: var(--bg-card); box-shadow: var(--shadow-card);">
            <i class="fas fa-book-open" style="font-size: 60px; color: var(--text-muted);"></i>
            <h5 class="mt-3 mb-2" style="color: var(--text-dark);">Belum Ada Topik</h5>
            <p class="small mb-0" style="color: var(--text-gray);">
                Topik untuk mata pelajaran ini belum tersedia.
            </p>
        </div>
    @endif

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Subject
        </a>
    </div>

</div>
@endsection