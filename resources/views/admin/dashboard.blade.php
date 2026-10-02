@extends('layouts.admin')

@section('title', 'Dashboard - NarayaLearn Admin')
@section('breadcrumb', 'Dashboard')

@section('admin-content')

<!-- ===== PAGE HEADER ===== -->
<div class="admin-page-header">
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="admin-pill">
                    <i class="fas fa-shield-halved"></i> ADMIN PANEL
                </span>
                <span class="admin-live-badge">
                    <span class="dot-pulse"></span> Live Sync
                </span>
            </div>
            <h1 class="admin-page-title">Dashboard</h1>
            <p class="admin-page-subtitle mb-0">
                Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('home') }}" class="admin-btn-outline">
                <i class="fas fa-arrow-up-right-from-square"></i>
                Kembali ke Website
            </a>
            <a href="{{ route('admin.materials.create') }}" class="admin-btn-primary">
                <i class="fas fa-plus"></i>
                Materi Baru
            </a>
        </div>
    </div>
</div>

<!-- ===== STATISTIK 4 CARD ===== -->
<div class="row g-3 mb-4">
    <!-- Subject -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <span class="stat-card-trend">
                    <i class="fas fa-chart-line"></i> Aktif
                </span>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalSubjects ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">SUBJECT</div>
            <p class="stat-card-desc">Total mata pelajaran aktif</p>
        </div>
    </div>

    <!-- Materi -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-pink">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="stat-card-trend">
                    <i class="fas fa-bolt"></i> 3 Format
                </span>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalMaterials ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">MATERI</div>
            <p class="stat-card-desc">Modul PDF, video & latihan</p>
        </div>
    </div>

    <!-- User -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-rose">
                    <i class="fas fa-users"></i>
                </div>
                <span class="stat-card-trend">
                    <i class="fas fa-check-circle"></i> 100% Aktif
                </span>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalUsers ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">USER</div>
            <p class="stat-card-desc">Siswa & pengajar terdaftar</p>
        </div>
    </div>

    <!-- Avatar -->
    <div class="col-6 col-xl-3">
        <div class="admin-stat-card">
            <div class="stat-card-top">
                <div class="stat-card-icon stat-icon-soft">
                    <i class="fas fa-palette"></i>
                </div>
                <span class="stat-card-trend">
                    <i class="fas fa-star"></i> Koleksi
                </span>
            </div>
            <div class="stat-card-value">
                <h3>{{ $totalAvatars ?? 0 }}</h3>
            </div>
            <div class="stat-card-label-big">AVATAR</div>
            <p class="stat-card-desc">Koleksi avatar profil siswa</p>
        </div>
    </div>
</div>

<!-- ===== AKTIVITAS ===== -->
<div class="row g-4 mb-4">

    <!-- USER TERBARU -->
    <div class="col-lg-6">
        <div class="admin-activity-card">
            <div class="activity-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="activity-section-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="activity-title">User Terbaru</h5>
                        <p class="activity-subtitle">Pendaftar terbaru platform</p>
                    </div>
                </div>
                <span class="activity-count">{{ $latestUsers->count() }} akun</span>
            </div>

            <div class="d-flex flex-column gap-2">
                @forelse($latestUsers as $user)
                    <div class="activity-item">
                        <div class="d-flex align-items-center gap-3 min-width-0 flex-grow-1">
                            @if($user->avatar)
                                <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                                     class="activity-avatar" alt="{{ $user->name }}">
                            @else
                                <div class="activity-avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="min-width-0">
                                <div class="activity-name">{{ $user->name }}</div>
                                <small class="activity-email">{{ $user->email }}</small>
                            </div>
                        </div>
                        <span class="activity-badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                            {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        Belum ada user
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.users.index') }}" class="activity-link">
                Lihat semua user
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- MATERI TERBARU -->
    <div class="col-lg-6">
        <div class="admin-activity-card">
            <div class="activity-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="activity-section-icon stat-icon-pink">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <h5 class="activity-title">Materi Terbaru</h5>
                        <p class="activity-subtitle">Update kurikulum terakhir</p>
                    </div>
                </div>
                <span class="activity-count">Terpublikasi</span>
            </div>

            <div class="d-flex flex-column gap-2">
                @forelse($latestMaterials as $material)
                    <div class="activity-item">
                        <div class="d-flex align-items-center gap-3 min-width-0 flex-grow-1">
                            <div class="activity-icon-mini">
                                @if($material->type === 'video')
                                    <i class="fas fa-play"></i>
                                @elseif($material->type === 'exercise')
                                    <i class="fas fa-pen"></i>
                                @else
                                    <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div class="min-width-0">
                                <div class="activity-name">{{ $material->title }}</div>
                                <small class="activity-email">
                                    {{ $material->subject->name ?? '-' }} • 
                                    {{ ucfirst($material->type) }}
                                </small>
                            </div>
                        </div>
                        <span class="activity-badge badge-type">
                            {{ ucfirst($material->type) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        Belum ada materi
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.materials.index') }}" class="activity-link">
                Lihat semua materi
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

</div>

<!-- ===== AKSI CEPAT ===== -->
<div class="mb-4">
    <div class="mb-3">
        <h5 class="activity-title">Aksi Cepat</h5>
        <p class="activity-subtitle">Pintasan administrasi dan pengelolaan data</p>
    </div>

    <div class="row g-3">
        <!-- Kelola Subject -->
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.subjects.index') }}" class="admin-action-card">
                <div class="action-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h6 class="action-title">Kelola Subject</h6>
                <p class="action-desc">Tambah, edit kurikulum, dan atur jenjang mata pelajaran.</p>
                <div class="action-footer">
                    <span>Kelola</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Kelola Materi -->
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.materials.index') }}" class="admin-action-card">
                <div class="action-icon stat-icon-pink">
                    <i class="fas fa-file-circle-plus"></i>
                </div>
                <h6 class="action-title">Kelola Materi</h6>
                <p class="action-desc">Upload PDF, sematkan link YouTube, dan latihan soal.</p>
                <div class="action-footer">
                    <span>Kelola</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Kelola User -->
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.users.index') }}" class="admin-action-card">
                <div class="action-icon stat-icon-rose">
                    <i class="fas fa-user-cog"></i>
                </div>
                <h6 class="action-title">Kelola User</h6>
                <p class="action-desc">Verifikasi akun siswa, kelola hak akses dan peran admin.</p>
                <div class="action-footer">
                    <span>Kelola</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Kelola Avatar -->
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.avatars.index') }}" class="admin-action-card">
                <div class="action-icon stat-icon-soft">
                    <i class="fas fa-palette"></i>
                </div>
                <h6 class="action-title">Kelola Avatar</h6>
                <p class="action-desc">Atur katalog stiker & avatar profil yang dapat dipilih siswa.</p>
                <div class="action-footer">
                    <span>Kelola</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- ===== TIPS BANNER ===== -->
<div class="admin-tips-banner">
    <div class="tips-banner-icon">
        <i class="fas fa-lightbulb"></i>
    </div>
    <div class="flex-grow-1 min-width-0">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="tips-banner-label">TIPS ADMIN</span>
            <span class="tips-banner-tag">
                <span class="dot"></span> Sinkronisasi Otomatis
            </span>
        </div>
        <p class="tips-banner-text mb-0">
            Semua perubahan data akan langsung tampil <strong>real-time</strong> di aplikasi siswa tanpa perlu restart server.
        </p>
    </div>
</div>

@endsection