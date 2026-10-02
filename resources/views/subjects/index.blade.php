@extends('layouts.app')

@section('title', 'Mata Pelajaran - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

    <!-- ===== HEADER ===== -->
    <div class="subjects-header mb-5">

        <!-- Back + Pill INLINE -->
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('home') }}" class="back-btn" title="Kembali ke Home">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="section-pill mb-0">
                <i class="fas fa-graduation-cap"></i>
                <span>Pilih Mata Pelajaranmu</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="subjects-title mb-2">Mata Pelajaran</h1>
        <p class="subjects-desc mb-4">
            Eksplorasi materi, video pembahasan, dan latihan soal dari mata pelajaran yang tersedia.
        </p>

        <!-- Search Bar -->
        @if($subjects->count() > 0)
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text"
                       class="search-input"
                       id="subjectSearch"
                       placeholder="Cari mata pelajaran..."
                       autocomplete="off">
            </div>
        @endif
    </div>

    <!-- ===== GRID SUBJECT ===== -->
    @if($subjects->count() > 0)

        <div class="row g-4" id="subjectCardsContainer">
            @foreach($subjects as $subject)
                <div class="col-md-6 col-lg-4 subject-card-col"
                     data-name="{{ strtolower($subject->name) }}">
                    <a href="{{ route('subjects.show', $subject) }}"
                       class="text-decoration-none d-block h-100">
                        <div class="subject-card">

                            <div class="subject-icon-wrapper">
                                <i class="fas fa-book"></i>
                            </div>

                            <h3 class="subject-name">{{ $subject->name }}</h3>

                            <p class="subject-desc-card">
                                Pelajari materi, video pembahasan, dan latihan soal {{ $subject->name }}.
                            </p>

                            <div class="subject-footer">
                                <span class="subject-count">
                                    <i class="fas fa-file-alt"></i>
                                    {{ $subject->topics_count ?? 0 }} Topik
                                </span>
                                <i class="fas fa-arrow-right subject-arrow"></i>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Empty state pencarian -->
        <div id="subjectSearchEmpty" class="d-none text-center py-5">
            <i class="fas fa-book-open" style="font-size: 48px; color: var(--text-muted); opacity: 0.5;"></i>
            <p class="text-muted mt-3">Mata pelajaran tidak ditemukan.</p>
        </div>

    @else
        <!-- ===== BELUM ADA SUBJECT ===== -->
        <div class="text-center py-5">
            <i class="fas fa-book-open" style="font-size: 60px; color: var(--text-muted); opacity: 0.5;"></i>
            <h5 class="mt-3" style="color: var(--text-dark);">Belum Ada Mata Pelajaran</h5>
            <p class="text-muted">Mata pelajaran akan muncul di sini setelah admin menambahkannya.</p>
        </div>
    @endif

</div>

{{-- ===== SCRIPT SEARCH ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('subjectSearch');
    const cols = document.querySelectorAll('.subject-card-col');
    const emptyState = document.getElementById('subjectSearchEmpty');

    if (input) {
        input.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            cols.forEach(function (col) {
                const matches = !query || col.dataset.name.includes(query);
                col.classList.toggle('d-none', !matches);
                if (matches) visibleCount++;
            });

            if (emptyState) {
                emptyState.classList.toggle('d-none', visibleCount !== 0);
            }
        });
    }
});
</script>
@endsection