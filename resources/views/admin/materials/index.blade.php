@extends('layouts.admin')

@section('title', 'Kelola Materi - NarayaLearn Admin')
@section('breadcrumb', 'Kelola Materi')

@section('admin-content')

<!-- ===== PAGE HEADER ===== -->
<div class="admin-page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                <span class="admin-pill">
                    <i class="fas fa-shield-halved"></i> ADMIN PANEL
                </span>
                <span class="admin-live-badge">
                    <span class="dot-pulse"></span> Katalog Kurikulum
                </span>
            </div>
            <h1 class="admin-page-title">Kelola Materi</h1>
            <p class="admin-page-subtitle mb-0">
                Kelola semua materi, video pembahasan, dan latihan soal kurikulum terpadu
            </p>
        </div>

        <a href="{{ route('admin.materials.create') }}" class="admin-btn-primary">
            <i class="fas fa-plus"></i> Tambah Materi
        </a>
    </div>
</div>

<!-- ===== STATISTIK 4 CARD ===== -->
<div class="row g-3 mb-4">
    <!-- Total Materi -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-card-label">TOTAL MATERI</span>
                    <div class="stat-card-value">
                        <h3>{{ $totalMaterials ?? 0 }}</h3>
                    </div>
                    <p class="stat-card-desc">
                        <span style="color: var(--pink-deep); font-weight: 700;">
                            {{ $thisMonthMaterials ?? 0 }} diterbitkan bulan ini
                        </span>
                    </p>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-card-label">DOKUMEN PDF</span>
                    <div class="stat-card-value">
                        <h3>{{ $totalPdf ?? 0 }}</h3>
                    </div>
                    <p class="stat-card-desc">
                        {{ $totalMaterials > 0 ? round(($totalPdf / $totalMaterials) * 100) : 0 }}% dari total pustaka
                    </p>
                </div>
                <div class="stat-card-icon stat-icon-pink">
                    <i class="fas fa-file-pdf"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Video -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-card-label">VIDEO INTERAKTIF</span>
                    <div class="stat-card-value">
                        <h3>{{ $totalVideo ?? 0 }}</h3>
                    </div>
                    <p class="stat-card-desc">
                        <span style="color: var(--pink-deep); font-weight: 700;">
                            {{ $thisWeekVideos ?? 0 }} rilis pekan ini
                        </span>
                    </p>
                </div>
                <div class="stat-card-icon stat-icon-rose">
                    <i class="fas fa-play-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Latihan -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="stat-card-label">LATIHAN SOAL</span>
                    <div class="stat-card-value">
                        <h3>{{ $totalExercise ?? 0 }}</h3>
                    </div>
                    <p class="stat-card-desc">Latihan soal interaktif</p>
                </div>
                <div class="stat-card-icon stat-icon-soft">
                    <i class="fas fa-pen-to-square"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== FILTER & SEARCH ===== -->
<div class="admin-filter-card mb-4">
    <div class="row g-3 align-items-center">
        <!-- Search -->
        <div class="col-lg-5">
            <div class="search-wrapper w-100" style="max-width: 100%;">
                <i class="fas fa-search search-icon"></i>
                <input type="text"
                       class="search-input"
                       id="materialSearch"
                       placeholder="Cari judul materi, topik, atau kata kunci..."
                       autocomplete="off">
            </div>
        </div>

        <!-- Filter Subject -->
        <div class="col-lg-3">
            <select class="admin-select" id="filterSubject">
                <option value="all">Semua Subject</option>
                @foreach($subjects ?? [] as $subject)
                    <option value="{{ strtolower($subject->name) }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filter Type -->
        <div class="col-lg-2">
            <select class="admin-select" id="filterType">
                <option value="all">Semua Tipe</option>
                <option value="material">Materi PDF</option>
                <option value="video">Video</option>
                <option value="exercise">Latihan</option>
            </select>
        </div>

        <!-- Count Badge -->
        <div class="col-lg-2 text-lg-end">
            <span class="admin-live-badge">
                <span class="dot-pulse"></span>
                {{ $materials->total() }} Materi
            </span>
        </div>
    </div>
</div>

<!-- ===== TABLE MATERIAL ===== -->
<div class="admin-table-card">
    @if($materials->count() > 0)
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th>MATERI / KONTEN</th>
                        <th>SUBJECT & TOPIK</th>
                        <th>TIPE KONTEN</th>
                        <th>TANGGAL DIBUAT</th>
                        <th>STATUS</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                        <tr class="material-row"
                            data-title="{{ strtolower($material->title) }}"
                            data-subject="{{ strtolower($material->subject->name ?? '') }}"
                            data-type="{{ $material->type }}">

                            <!-- Materi / Konten -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="admin-row-icon {{ $material->type === 'video' ? 'stat-icon-rose' : ($material->type === 'exercise' ? 'stat-icon-soft' : '') }}">
                                        @if($material->type === 'video')
                                            <i class="fas fa-video"></i>
                                        @elseif($material->type === 'exercise')
                                            <i class="fas fa-pen"></i>
                                        @else
                                            <i class="fas fa-file-pdf"></i>
                                        @endif
                                    </div>
                                    <div class="min-width-0">
                                        <div class="admin-row-title">{{ $material->title }}</div>
                                        <small class="admin-row-subtitle">
                                            @if($material->file_path)
                                                {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }} • 
                                                File tersedia
                                            @elseif($material->youtube_url)
                                                YouTube • Video
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <!-- Subject & Topik -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="admin-chip">
                                        {{ $material->subject->name ?? '-' }}
                                    </span>
                                    <small class="admin-row-subtitle">{{ $material->title }}</small>
                                </div>
                            </td>

                            <!-- Tipe -->
                            <td>
                                @if($material->type === 'material')
                                    <span class="admin-chip">
                                        <i class="fas fa-file-pdf"></i> Materi PDF
                                    </span>
                                @elseif($material->type === 'video')
                                    <span class="admin-chip">
                                        <i class="fas fa-play-circle"></i> Video
                                    </span>
                                @else
                                    <span class="admin-chip">
                                        <i class="fas fa-pen"></i> Latihan
                                    </span>
                                @endif
                            </td>

                            <!-- Tanggal -->
                            <td>
                                <span class="admin-row-date">
                                    {{ $material->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="admin-status-badge">
                                    <span class="dot"></span> Publik
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.materials.edit', $material) }}"
                                       class="admin-row-btn"
                                       title="Edit Materi">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <button type="button"
                                            class="admin-row-btn admin-row-btn-danger"
                                            title="Hapus Materi"
                                            onclick="actionDestroy('{{ route('admin.materials.destroy', $material) }}', '{{ $material->title }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State (Search) -->
        <div id="materialSearchEmpty" class="text-center py-5 d-none">
            <i class="fas fa-search" style="font-size: 48px; color: var(--text-muted); opacity: 0.5;"></i>
            <p class="text-muted mt-3 mb-0">Materi tidak ditemukan.</p>
        </div>

        <!-- Pagination -->
        <div class="admin-pagination-wrapper">
            <span class="admin-pagination-info">
                Menampilkan <strong>{{ $materials->firstItem() }}-{{ $materials->lastItem() }}</strong>
                dari <strong>{{ $materials->total() }}</strong> materi
            </span>
            <div>
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        </div>

    @else
        <!-- Empty State (No Data) -->
        <div class="admin-empty-state">
            <div class="empty-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h5>Belum Ada Materi</h5>
            <p>Koleksi materi masih kosong. Silakan tambahkan file PDF, modul video, atau latihan soal pertama.</p>
            <a href="{{ route('admin.materials.create') }}" class="admin-btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Materi
            </a>
        </div>
    @endif
</div>

{{-- ===== FORM DELETE ===== --}}
<form action="" id="form-destroy" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== SEARCH & FILTER =====
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('materialSearch');
    const filterSubject = document.getElementById('filterSubject');
    const filterType = document.getElementById('filterType');
    const rows = document.querySelectorAll('.material-row');
    const emptyState = document.getElementById('materialSearchEmpty');

    function applyFilters() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const subject = filterSubject ? filterSubject.value.toLowerCase() : 'all';
        const type = filterType ? filterType.value : 'all';
        let visibleCount = 0;

        rows.forEach(function (row) {
            const titleMatch = !query || row.dataset.title.includes(query);
            const subjectMatch = subject === 'all' || row.dataset.subject.includes(subject);
            const typeMatch = type === 'all' || row.dataset.type === type;

            const matches = titleMatch && subjectMatch && typeMatch;
            row.classList.toggle('d-none', !matches);
            if (matches) visibleCount++;
        });

        if (emptyState) {
            emptyState.classList.toggle('d-none', visibleCount !== 0);
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (filterSubject) filterSubject.addEventListener('change', applyFilters);
    if (filterType) filterType.addEventListener('change', applyFilters);
});

// ===== DELETE CONFIRM =====
function actionDestroy(url, itemName) {
    Swal.fire({
        title: 'Yakin hapus?',
        html: `<strong>${itemName}</strong> akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EC407A',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-destroy').setAttribute('action', url);
            document.getElementById('form-destroy').submit();
        }
    });
}

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false,
        timerProgressBar: true,
        toast: true,
        position: 'top-end'
    });
@endif
</script>
@endpush

@endsection