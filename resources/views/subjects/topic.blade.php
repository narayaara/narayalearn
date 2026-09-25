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
            {{ $subject->name }} • NarayaLearn
        </p>
    </div>

    <!-- Tab Cards -->
    @php
        $material = $materials['material'] ?? null;
        $video = $materials['video'] ?? null;
        $exercise = $materials['exercise'] ?? null;
    @endphp

    <div class="row g-3">
        @foreach([
            ['data' => $material, 'icon' => 'fa-file-alt', 'label' => 'Materi', 'desc' => 'Baca materi pembelajaran'],
            ['data' => $video, 'icon' => 'fa-video', 'label' => 'Video', 'desc' => 'Tonton video pembahasan'],
            ['data' => $exercise, 'icon' => 'fa-pen', 'label' => 'Latihan', 'desc' => 'Kerjakan latihan soal'],
        ] as $card)
            <div class="col-md-4">
                @if($card['data'])
                    <a href="{{ route('materials.show', $card['data']) }}" class="text-decoration-none d-block h-100">
                        <div class="card-material card border-0 rounded-4 p-4 text-center h-100"
                            style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                                style="width: 70px; height: 70px; background: var(--pink-light);">
                                <i class="fas {{ $card['icon'] }}" style="color: var(--pink-primary); font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: var(--text-dark);">{{ $card['label'] }}</h5>
                            <p class="small mb-0" style="color: var(--text-gray);">{{ $card['desc'] }}</p>
                        </div>
                    </a>
                @else
                    <div class="card border-0 rounded-4 p-4 text-center h-100" style="background: var(--bg-card); opacity: 0.5;">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px; background: var(--pink-light);">
                            <i class="fas {{ $card['icon'] }}" style="color: var(--pink-primary); font-size: 28px;"></i>
                        </div>
                        <h5 class="fw-bold mb-1" style="color: var(--text-dark);">{{ $card['label'] }}</h5>
                        <p class="small mb-0" style="color: var(--text-gray);">Belum tersedia</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke {{ $subject->name }}
        </a>
    </div>

</div>
@endsection