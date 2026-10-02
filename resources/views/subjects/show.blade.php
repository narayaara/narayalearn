@extends('layouts.app')

@section('title', $subject->name . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1200px;">

    <!-- ===== TOP ACTION BAR ===== -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('subjects.index') }}" class="back-icon-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>

        <span class="topik-badge">
            <span class="dot-pulse"></span>
            {{ $topics->count() }} TOPIK AKTIF
        </span>
    </div>

    <!-- ===== HEADER BANNER ===== -->
    <div class="subject-banner mb-4">
        <div class="banner-ornament-circle"></div>
        <div class="banner-ornament-dot"></div>

        <div class="relative-content">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="banner-icon">
                    <i class="fas fa-book"></i>
                </div>
                <span class="banner-level">SMA/SMK/MA • Kurikulum Merdeka</span>
            </div>

            <h2 class="banner-title">{{ $subject->name }}</h2>
            <p class="banner-subtitle">Pilih topik untuk mulai belajar</p>

            {{-- Progress Belajar — DINAMIS --}}
            @auth
                @php
                    $topicTitles = $subject->materials()->distinct()->pluck('title')->toArray();
                    $totalTopics = count($topicTitles);

                    $completedTopics = 0;
                    foreach ($topicTitles as $title) {
                        $materialIds = $subject->materials()
                            ->where('title', $title)
                            ->pluck('id')
                            ->toArray();

                        $totalInTopic = count($materialIds);
                        if ($totalInTopic > 0) {
                            $completedInTopic = \App\Models\Progress::where('user_id', auth()->id())
                                ->whereIn('material_id', $materialIds)
                                ->where('is_completed', true)
                                ->count();

                            // Topik dianggap "selesai" kalo SEMUA material di dalamnya udah completed
                            if ($completedInTopic === $totalInTopic) {
                                $completedTopics++;
                            }
                        }
                    }

                    $subjectProgress = $totalTopics > 0 
                        ? round(($completedTopics / $totalTopics) * 100) 
                        : 0;
                @endphp

                <div class="banner-progress mt-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-chart-line" style="color: var(--pink-deep); font-size: 14px;"></i>
                            <span class="progress-text">Progres Belajar: {{ $subjectProgress }}%</span>
                        </div>
                        <span class="progress-meta">
                            {{ $completedTopics }}/{{ $totalTopics }} Topik
                        </span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-bar-fill" style="width: {{ $subjectProgress }}%;"></div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- ===== DAFTAR TOPIK ===== -->
    @if($topics->count() > 0)

        <div class="d-flex justify-content-between align-items-center px-2 mb-3">
            <h3 class="topic-section-title">Daftar Topik</h3>
        </div>

        <div class="d-flex flex-column gap-3">
            @foreach($topics as $title => $material)
                @php
                    $topicMaterials = $subject->materials()->where('title', $title)->get();
                    $materialCount = $topicMaterials->count();
                    $isFavorited = in_array($material->id, $favoriteIds ?? []);
                @endphp

<div class="topic-card position-relative">
    {{-- Stretched link biar seluruh card bisa diklik --}}
    <a href="{{ route('subjects.topic', [$subject, $title]) }}"
       class="stretched-link"
       title="Buka {{ $title }}"></a>

    <div class="d-flex align-items-start justify-content-between gap-3">

        {{-- Kiri: Icon + Info --}}
        <div class="d-flex align-items-start gap-3 flex-grow-1 min-width-0">
            <div class="topic-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>

            <div class="flex-grow-1 min-width-0">
                <div class="topic-meta">
                    TOPIK {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    • {{ $materialCount }} Materi
                </div>
                <h4 class="topic-title">{{ $title }}</h4>
                <p class="topic-desc">
                    Klik untuk melihat materi, video, dan latihan soal.
                </p>
            </div>
        </div>

        {{-- Kanan: Cuma arrow --}}
        <div class="topic-actions">
            <span class="topic-arrow">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
    </div>
</div>
            @endforeach
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h5>Belum Ada Topik</h5>
            <p>Topik untuk mata pelajaran ini belum tersedia.</p>
        </div>
    @endif

    <!-- ===== TIPS BANNER ===== -->
    <div class="tips-banner mt-4">
        <div class="tips-icon">
            <i class="fas fa-lightbulb"></i>
        </div>
        <div>
            <span class="tips-label">Tips Naraya</span>
            <p class="tips-text">
                Selesaikan latihan 15 menit setiap hari untuk memperkuat fundamental!
            </p>
        </div>
    </div>

</div>
@endsection