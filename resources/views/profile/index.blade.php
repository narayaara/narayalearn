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

    {{-- HEADER PROFIL --}}
    <div class="card border-0 rounded-4 p-4 mb-4">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="profile-avatar" alt="{{ $user->name }}">
            @else
                <div class="profile-avatar profile-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif

            <div class="flex-grow-1">
                <h5 class="fw-bold mb-0">
                    {{ $user->name }}
                    @if($user->role === 'admin')
                        <span class="profile-role-badge ms-2">Admin</span>
                    @endif
                </h5>
                <small class="text-muted">{{ $user->email }}</small>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="fas fa-pen me-1"></i> Edit Profile
            </a>
        </div>
    </div>

    {{-- TOPIK FAVORIT --}}
    <h5 class="profile-section-title">
        <i class="fas fa-bookmark"></i> Topik Favorit
    </h5>

    @if($favoriteTopics->count() > 0)
        <div class="row g-2 mb-4">
            @foreach($favoriteTopics as $fav)
                <div class="col-md-6">
                    <div class="fav-item card border-0 rounded-3 position-relative">
                        <div class="d-flex align-items-center gap-3 p-3">
                            <div class="fav-item-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <a href="{{ route('subjects.topic', [$fav->subject, $fav->topic_name]) }}"
                                   class="stretched-link text-decoration-none fw-semibold d-block text-truncate">
                                    {{ $fav->topic_name }}
                                </a>
                                <small class="text-muted">{{ $fav->subject->name }}</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 12px;"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small mb-4">Belum ada topik yang difavoritkan.</p>
    @endif

    {{-- MATERI FAVORIT --}}
    <h5 class="profile-section-title">
        <i class="fas fa-heart"></i> Materi Favorit
    </h5>

    @php
        $typeIcons = ['material' => 'fa-file-alt', 'video' => 'fa-video', 'exercise' => 'fa-pen'];
    @endphp

    @if($favoriteMaterials->count() > 0)
        <div class="row g-2">
            @foreach($favoriteMaterials as $fav)
                @php $material = $fav->material; @endphp
                <div class="col-md-6">
                    <div class="fav-item card border-0 rounded-3 position-relative">
                        <div class="d-flex align-items-center gap-3 p-3">
                            <div class="fav-item-icon">
                                <i class="fas {{ $typeIcons[$material->type] ?? 'fa-file-alt' }}"></i>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <a href="{{ route('materials.show', $material) }}"
                                   class="stretched-link text-decoration-none fw-semibold d-block text-truncate">
                                    {{ $material->title }}
                                </a>
                                <small class="text-muted">{{ $material->subject->name ?? '-' }}</small>
                            </div>
                            <span class="fav-type-badge">{{ $material->type_label }}</span>

                            <!-- Hapus dari favorit -->
                            <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="fav-item-remove" aria-label="Hapus dari favorit">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small">Belum ada materi yang difavoritkan.</p>
    @endif

</div>
@endsection