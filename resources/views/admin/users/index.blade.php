@extends('layouts.admin')

@section('title', 'Kelola User - Admin NarayaLearn')

@section('admin-content')

{{-- ==================== PAGE HEADER ==================== --}}
<div class="user-page-header">
    <div class="user-page-title-wrap">
        <div class="user-page-eyebrow">
            <span class="dot"></span>
            ADMIN PANEL
        </div>
        <h1 class="user-page-title">Kelola User</h1>
        <p class="user-page-subtitle">
            Kelola semua user terdaftar, pantau progres belajar, serta data materi favorit.
        </p>
    </div>

    <form method="GET" action="{{ route('admin.users.index') }}" class="user-filter-bar">
        <div class="user-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama, email, atau sekolah...">
        </div>

        <div class="user-select-wrap">
            <select name="role">
                <option value="all">Semua Peran</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <i class="fas fa-chevron-down select-icon"></i>
        </div>

        <button type="submit" class="user-btn-search">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>
</div>

{{-- ==================== KPI CARDS ==================== --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="user-kpi-card">
            <div class="kpi-text">
                <span class="kpi-label">TOTAL SISWA</span>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $totalStudents ?? $users->count() }}</span>
                    <span class="kpi-unit">Terdaftar</span>
                </div>
            </div>
            <div class="kpi-icon kpi-icon-pink">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="user-kpi-card">
            <div class="kpi-text">
                <span class="kpi-label">AKUN AKTIF</span>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $activeUsers ?? $users->count() }}</span>
                    <span class="kpi-unit">Siswa</span>
                </div>
            </div>
            <div class="kpi-icon kpi-icon-soft">
                <i class="fas fa-circle-check"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="user-kpi-card">
            <div class="kpi-text">
                <span class="kpi-label">SUPER ADMIN</span>
                <div class="kpi-value-row">
                    <span class="kpi-value">{{ $adminCount ?? 1 }}</span>
                    <span class="kpi-unit">Admin</span>
                </div>
            </div>
            <div class="kpi-icon kpi-icon-rose">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>
</div>

{{-- ==================== TABLE CARD ==================== --}}
<div class="user-table-card">
    <div class="user-table-header">
        <div class="header-left">
            <span class="header-title">Daftar Pengguna Aktif</span>
            <span class="header-count">{{ $users->count() }} Ditampilkan</span>
        </div>
        <div class="header-right">
            <i class="fas fa-circle-info"></i>
            <span>Klik baris untuk melihat detail progres & materi favorit</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="user-table">
            <thead>
                <tr>
                    <th class="col-num">#</th>
                    <th class="col-avatar">Avatar</th>
                    <th>Nama & Email</th>
                    <th>Role</th>
                    <th class="text-center">Favorit</th>
                    <th>Terdaftar</th>
                    <th class="col-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    @php
                        $isSelf   = $user->id === auth()->id();
                        $isAdmin  = $user->role === 'admin';
                        $initials = collect(explode(' ', $user->name))
                            ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                            ->take(2)->join('');
                        $favorites = $user->favorites_count ?? 0;
                    @endphp

                    <tr class="{{ $isSelf ? 'is-self' : '' }}">
                        <td class="col-num">{{ $index + 1 }}</td>

                        {{-- Avatar --}}
                        <td class="col-avatar">
                            @if($user->avatar)
                                <div class="user-avatar">
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}"
                                         alt="{{ $user->name }}">
                                </div>
                            @else
                                <div class="user-avatar {{ $isAdmin ? 'avatar-admin' : 'avatar-user' }}">
                                    {{ $initials }}
                                </div>
                            @endif
                        </td>

                        {{-- Nama & Email --}}
                        <td>
                            <div class="user-row-name">{{ $user->name }}</div>
                            <div class="user-row-email">{{ $user->email }}</div>
                        </td>

                        {{-- Role --}}
                        <td>
                            @if($isAdmin)
                                <span class="user-role-admin">
                                    <i class="fas fa-user-shield"></i> Admin
                                </span>
                            @else
                                <span class="user-role-user">User</span>
                            @endif
                        </td>

                        {{-- Favorit --}}
                        <td class="text-center">
                            <span class="user-fav-badge">
                                <strong>{{ $favorites }}</strong>
                                <span class="heart">❤️</span>
                            </span>
                        </td>

                        {{-- Terdaftar --}}
                        <td class="admin-row-date">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="col-actions">
                            @if($isSelf)
                                <button type="button" class="user-btn-locked" disabled title="Akun Anda">
                                    <i class="fas fa-lock"></i> Akun Anda
                                </button>
                            @else
                                <button type="button" class="user-btn-delete"
                                        onclick="actionDestroy('{{ route('admin.users.destroy', $user) }}', '{{ $user->name }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-0">
                            <div class="user-empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <h5>Belum Ada User Terdaftar</h5>
                                <p>Tampilan apabila filter pencarian tidak menemukan kecocokan atau belum ada user terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->count() > 0)
        <div class="user-pagination-wrapper">
            <span class="user-pagination-info">
                Menampilkan <strong>{{ $users->count() }}</strong> pengguna
            </span>
        </div>
    @endif
</div>

{{-- Hidden Form Delete --}}
<form action="" id="form-destroy" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function actionDestroy(url, itemName = 'item ini') {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        html: `<strong>${itemName}</strong> akan dihapus secara permanen!`,
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

@if (Session::has('success'))
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({ icon: 'success', title: '{{ Session::get('success') }}' });
@endif

@if (Session::has('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ Session::get('error') }}',
        confirmButtonColor: '#EC407A'
    });
@endif
</script>
@endpush