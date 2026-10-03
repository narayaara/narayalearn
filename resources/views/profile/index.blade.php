@extends('layouts.app')

@section('title', 'My Account - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1000px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===== PROFILE HEADER CARD ===== --}}
    <div class="profile-header-card mb-4">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                {{-- Avatar --}}
                <div class="profile-avatar-wrapper">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                             alt="{{ $user->name }}" 
                             class="profile-avatar-img">
                    @else
                        <div class="profile-avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span class="profile-status-dot"></span>
                </div>

                {{-- Info --}}
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h5 class="profile-name mb-0">{{ $user->name }}</h5>
                        @if($user->role === 'admin')
                            <span class="profile-badge-admin">Admin</span>
                        @else
                            <span class="profile-badge-user">Siswa</span>
                        @endif
                    </div>
                    <p class="profile-email mb-0">{{ $user->email }}</p>
                </div>
            </div>

            {{-- Edit Button --}}
            <a href="{{ route('profile.edit') }}" class="profile-edit-btn">
                <i class="fas fa-pen"></i> Edit Profile
            </a>
        </div>
    </div>

    {{-- ===== MATERI FAVORIT ===== --}}
    <div class="profile-section mb-4">
        <div class="profile-section-header">
            <div class="d-flex align-items-center gap-2">
                <div class="section-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h5 class="section-title mb-0">Materi Favorit</h5>
                <span class="section-count-badge">{{ $favoriteMaterials->count() }}</span>
            </div>
        </div>

        @php
            $typeIcons = ['material' => 'fa-file-alt', 'video' => 'fa-video', 'exercise' => 'fa-pen'];
        @endphp

        @if($favoriteMaterials->count() > 0)
            <div class="row g-3">
                @foreach($favoriteMaterials as $fav)
                    @php $material = $fav->material; @endphp
                    @if($material)
                        <div class="col-md-6">
                            <div class="fav-card">
                                <a href="{{ route('materials.show', $material) }}" 
                                   class="d-flex align-items-center gap-3 flex-grow-1 text-decoration-none min-width-0">
                                    <div class="fav-icon">
                                        <i class="fas {{ $typeIcons[$material->type] ?? 'fa-file-alt' }}"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="fav-meta">
                                            {{ $material->subject->name ?? '-' }} • 
                                            {{ ucfirst($material->type) }}
                                        </div>
                                        <h6 class="fav-title">{{ $material->title }}</h6>
                                    </div>
                                </a>

                                <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="fav-remove-btn" title="Hapus dari favorit">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="profile-empty-state">
                <i class="fas fa-heart-broken"></i>
                <p>Belum ada materi yang difavoritkan.</p>
            </div>
        @endif
    </div>

</div>
@endsection