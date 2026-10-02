@extends('layouts.app')

@section('title', $subject->name . ' - ' . $topic . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-2">
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

    <!-- Back link -->
    <a href="{{ route('subjects.show', $subject) }}" class="back-link mb-3">
        <i class="fas fa-arrow-left"></i> Back to {{ $subject->name }}
    </a>

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: var(--text-dark);">
            {{ $topic }}
        </h2>
        <p class="mb-0 small" style="color: var(--text-gray);">
            {{ $subject->name }} • Choose topic 
        </p>
    </div>

    @php
        $cards = [
            ['data' => $materials['material'] ?? null, 'icon' => 'fa-file-alt', 'label' => 'Materi',  'desc' => 'Read learning material'],
            ['data' => $materials['video'] ?? null,    'icon' => 'fa-video',    'label' => 'Video',    'desc' => 'Watch explanation videos'],
            ['data' => $materials['exercise'] ?? null, 'icon' => 'fa-pen',      'label' => 'Exercise',  'desc' => 'Complete practice exercises'],
        ];
    @endphp

    <!-- Tab Cards -->
    <div class="row g-3">
        @foreach($cards as $card)
            <div class="col-md-4">
                <div class="card-material-wrapper position-relative h-100">
                    @if($card['data'])
                        <div class="card-material card border-0 rounded-4 p-4 text-center h-100"
                             style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                            <a href="{{ route('materials.show', $card['data']) }}" class="stretched-link text-decoration-none"></a>
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px; background: var(--pink-light);">
                                <i class="fas {{ $card['icon'] }}" style="color: var(--pink-primary); font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: var(--text-dark);">{{ $card['label'] }}</h5>
                            <p class="small mb-0" style="color: var(--text-gray);">
                                {{ $card['desc'] }}
                            </p>
                        </div>

                        @auth
                            <form action="{{ route('favorites.toggle', $card['data']) }}" method="POST" class="favorite-btn-form">
                                @csrf
                                <button type="submit" class="favorite-btn {{ in_array($card['data']->id, $favoriteIds) ? 'is-favorited' : '' }}"
                                        aria-label="Favorite">
                                    <i class="fa{{ in_array($card['data']->id, $favoriteIds) ? 's' : 'r' }} fa-heart"></i>
                                </button>
                            </form>
                        @endauth
                    @else
                        <div class="card border-0 rounded-4 p-4 text-center h-100"
                             style="background: var(--bg-card); box-shadow: var(--shadow-card); opacity: 0.5;">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px; background: var(--pink-light);">
                                <i class="fas {{ $card['icon'] }}" style="color: var(--pink-primary); font-size: 28px;"></i>
                            </div>
                            <h5 class="fw-bold mb-1" style="color: var(--text-dark);">{{ $card['label'] }}</h5>
                            <p class="small mb-0" style="color: var(--text-gray);">
                                Not empty
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection