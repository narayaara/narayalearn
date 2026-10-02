@extends('layouts.admin')

@section('title', 'Kelola Subject - NarayaLearn Admin')
@section('breadcrumb', 'Kelola Subject')

@section('admin-content')

<!-- ===== PAGE HEADER ===== -->
<div class="admin-page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <span class="admin-pill mb-2">
                <i class="fas fa-shield-halved"></i> ADMIN PANEL
            </span>
            <h1 class="admin-page-title">Kelola Subject</h1>
            <p class="admin-page-subtitle mb-0">
                Kelola semua mata pelajaran yang tersedia di kurikulum NarayaLearn
            </p>
        </div>

        <a href="{{ route('admin.subjects.create') }}" class="admin-btn-primary">
            <i class="fas fa-plus"></i> Tambah Subject
        </a>
    </div>
</div>

<!-- ===== STATISTIK 4 CARD ===== -->
<div class="row g-3 mb-4">
    <!-- Total Subject -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalSubjects ?? $subjects->count() }}</h3>
            </div>
            <div class="stat-card-label-big">TOTAL SUBJECT</div>
            <p class="stat-card-desc">{{ $subjects->count() }} Pelajaran</p>
        </div>
    </div>

    <!-- Total Topik -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-pink">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalTopics ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">TOTAL TOPIK</div>
            <p class="stat-card-desc">Bab Pembelajaran</p>
        </div>
    </div>

    <!-- Total Materi -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-rose">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalMaterials ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">MODUL & VIDEO</div>
            <p class="stat-card-desc">Materi & Latihan</p>
        </div>
    </div>

    <!-- Status -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-soft">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value">
                <h3>100%</h3>
            </div>
            <div class="stat-card-label-big">STATUS AKTIF</div>
            <p class="stat-card-desc">Semua Siap</p>
        </div>
    </div>
</div>

<!-- ===== SEARCH & FILTER ===== -->
<div class="admin-filter-card mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <div class="search-wrapper w-100" style="max-width: 100%;">
                <i class="fas fa-search search-icon"></i>
                <input type="text"
                       class="search-input"
                       id="subjectSearch"
                       placeholder="Cari nama mata pelajaran..."
                       autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 text-md-end">
            <span class="admin-live-badge">
                <span class="dot-pulse"></span>
                {{ $subjects->count() }} Mata Pelajaran Aktif
            </span>
        </div>
    </div>
</div>

<!-- ===== TABLE SUBJECT ===== -->
<div class="admin-table-card">
    @if($subjects->count() > 0)
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th>MATA PELAJARAN</th>
                        <th>JUMLAH TOPIK</th>
                        <th>TOTAL MATERI</th>
                        <th>TANGGAL DIBUAT</th>
                        <th>STATUS</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        @php
                            $topicCount = $subject->materials()
                                ->distinct()
                                ->pluck('title')
                                ->count();
                            $materialCount = $subject->materials()->count();
                        @endphp

                        <tr class="subject-row" data-name="{{ strtolower($subject->name) }}">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="admin-row-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="min-width-0">
                                        <div class="admin-row-title">{{ $subject->name }}</div>
                                        <small class="admin-row-subtitle">Kurikulum Merdeka</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="admin-chip">
                                    <i class="fas fa-layer-group"></i>
                                    {{ $topicCount }} Topik
                                </span>
                            </td>
                            <td>
                                <span class="admin-row-text">{{ $materialCount }} Modul</span>
                            </td>
                            <td>
                                <span class="admin-row-date">{{ $subject->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <span class="admin-status-badge">
                                    <span class="dot"></span> Aktif
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                                       class="admin-row-btn"
                                       title="Ubah Subject">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <button type="button"
                                            class="admin-row-btn admin-row-btn-danger"
                                            title="Hapus Subject"
                                            onclick="actionDestroy('{{ route('admin.subjects.destroy', $subject) }}', '{{ $subject->name }}')">
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
        <div id="subjectSearchEmpty" class="text-center py-5 d-none">
            <i class="fas fa-search" style="font-size: 48px; color: var(--text-muted); opacity: 0.5;"></i>
            <p class="text-muted mt-3 mb-0">Mata pelajaran tidak ditemukan.</p>
        </div>

    @else
        <!-- Empty State (No Data) -->
        <div class="admin-empty-state">
            <div class="empty-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h5>Belum Ada Subject</h5>
            <p>Mulai tambahkan mata pelajaran baru untuk kurikulum siswa.</p>
            <a href="{{ route('admin.subjects.create') }}" class="admin-btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Subject
            </a>
        </div>
    @endif
</div>

{{-- ===== FORM DELETE + SCRIPT ===== --}}
<form action="" id="form-destroy" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== SEARCH =====
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('subjectSearch');
    const rows = document.querySelectorAll('.subject-row');
    const emptyState = document.getElementById('subjectSearchEmpty');

    if (input) {
        input.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            rows.forEach(function (row) {
                const matches = !query || row.dataset.name.includes(query);
                row.classList.toggle('d-none', !matches);
                if (matches) visibleCount++;
            });

            if (emptyState) {
                emptyState.classList.toggle('d-none', visibleCount !== 0);
            }
        });
    }
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