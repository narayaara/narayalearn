@extends('layouts.app')

@section('title', $subject->name . ' - ' . $topic . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1200px;">

    <!-- ===== HEADER — BACK + JUDUL INLINE ===== -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('subjects.show', $subject) }}" class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="topic-page-title mb-0">{{ $topic }}</h1>
            <p class="topic-page-desc mb-0">{{ $subject->name }} • Pilih tipe konten yang ingin dipelajari</p>
        </div>
    </div>

    <!-- ===== CARD LIST ===== -->
    <div class="row g-4">

        @php
            $cardConfig = [
                'material' => [
                    'icon' => 'fa-book-open',
                    'title' => 'Materi Belajar',
                    'badge' => 'PDF Modul',
                    'desc' => 'Ringkasan konsep, sifat-sifat, dan contoh soal lengkap dalam bentuk PDF.',
                    'meta_icon' => 'fa-file-pdf',
                    'meta_text' => 'Baca materi',
                    'btn_text' => 'Buka Materi',
                ],
                'video' => [
                    'icon' => 'fa-play-circle',
                    'title' => 'Video Pembahasan',
                    'badge' => 'Video',
                    'desc' => 'Penjelasan dalam format video pembahasan.',
                    'meta_icon' => 'fa-clock',
                    'meta_text' => 'Tonton video',
                    'btn_text' => 'Tonton Video',
                ],
                'exercise' => [
                    'icon' => 'fa-pen-to-square',
                    'title' => 'Latihan Soal',
                    'badge' => 'Latihan',
                    'desc' => 'Kerjakan latihan soal untuk menguji pemahamanmu.',
                    'meta_icon' => 'fa-tasks',
                    'meta_text' => 'Kerjakan',
                    'btn_text' => 'Mulai Latihan',
                ],
            ];
        @endphp

        @foreach($cardConfig as $type => $config)
            @php
                $data = $materials[$type] ?? null;
            @endphp

            <div class="col-md-6 col-lg-4">
                @if($data)
                    {{-- ===== CARD AKTIF ===== --}}
                    <div class="position-relative h-100">
                        <a href="{{ route('materials.show', $data) }}" class="text-decoration-none d-block h-100">
                            <div class="topic-content-card">
                                <div class="card-top">
                                    <div class="card-icon">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                    </div>
                                </div>

                                <div class="card-body-custom">
                                    <h5 class="card-title-custom">{{ $config['title'] }}</h5>
                                    <span class="card-badge d-inline-block">{{ $config['badge'] }}</span>
                                    <p class="card-desc">{{ $config['desc'] }}</p>
                                </div>

                                <div class="card-footer-custom">
                                    <span class="card-meta">
                                        <i class="fas {{ $config['meta_icon'] }}"></i>
                                        {{ $config['meta_text'] }}
                                    </span>
                                    <span class="card-action-btn">
                                        {{ $config['btn_text'] }}
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </a>

                        @auth
                            <form action="{{ route('favorites.toggle', $data) }}" method="POST" class="favorite-btn-form">
                                @csrf
                                <button type="submit" class="favorite-btn {{ in_array($data->id, $favoriteIds) ? 'is-favorited' : '' }}"
                                        aria-label="Favorite">
                                    <i class="fa{{ in_array($data->id, $favoriteIds) ? 's' : 'r' }} fa-heart"></i>
                                </button>
                            </form>
                        @endauth
                    </div>

                @else
                    {{-- ===== CARD DISABLED ===== --}}
                    <div class="topic-content-card disabled h-100">
                        <div class="card-top">
                            <div class="card-icon">
                                <i class="fas {{ $config['icon'] }}"></i>
                            </div>
                            <span class="card-coming-soon">Segera Hadir</span>
                        </div>

                        <div class="card-body-custom">
                            <h5 class="card-title-custom">{{ $config['title'] }}</h5>
                            <p class="card-desc">Belum tersedia</p>
                        </div>

                        <div class="card-footer-custom">
                            <span class="card-meta">
                                <i class="fas fa-lock"></i>
                                Sedang disiapkan
                            </span>
                            <span class="card-locked-btn">Terkunci</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- ===== TIPS BANNER ===== -->
    <div class="tips-banner mt-4">
        <div class="tips-icon">
            <i class="fas fa-lightbulb"></i>
        </div>
        <div>
            <span class="tips-label">Tips Naraya</span>
            <p class="tips-text">
                Selesaikan materi dulu, baru tonton video, lalu kerjakan latihan soal!
            </p>
        </div>
    </div>

</div>
@endsection