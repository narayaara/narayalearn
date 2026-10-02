@extends('layouts.app')

@section('title', $subject->name . ' - NarayaLearn')

@section('content')
<div class="container py-4" style="max-width: 1100px;">

    <!-- Back link -->
    <a href="{{ route('subjects.index') }}" class="back-link mb-3">
        <i class="fas fa-arrow-left"></i> Back to Subjects
    </a>

    <!-- Header Subject -->
    <div class="mb-4 p-4 rounded-4"
         style="background: var(--pink-soft); box-shadow: var(--shadow-card);">
        <h2 class="fw-bold mb-1" style="color: var(--text-dark);">
            <i class="fas fa-book me-2" style="color: var(--pink-primary);"></i>
            {{ $subject->name }}
        </h2>
        <p class="mb-0 small" style="color: var(--text-gray);">
            Choose topic to learn
        </p>
    </div>

    <!-- Daftar Topik -->
    @if(isset($topics) && count($topics) > 0)
        <div class="row g-3">
            @foreach ($topics as $title => $material)
                <div class="col-md-6 col-lg-4">
                    <div class="card-material-wrapper position-relative h-100">
                        <div class="card-material card border-0 rounded-4 p-3 h-100"
                             style="background: var(--bg-card); box-shadow: var(--shadow-card);">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Icon -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 45px; height: 45px; background: var(--pink-light);">
                                    <i class="fas fa-graduation-cap" style="color: var(--pink-primary); font-size: 18px;"></i>
                                </div>

                                <!-- Title -->
                                <div class="flex-grow-1 min-width-0">
                                    <a href="{{ route('subjects.topic', [$subject, $title]) }}" class="stretched-link text-decoration-none">
                                        <span class="fw-bold d-block text-truncate" style="color: var(--text-dark);">
                                            {{ $title }}
                                        </span>
                                    </a>
                                </div>

                                <!-- Chevron -->
                                <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
                            </div>
                        </div>

                        @auth
                            <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="favorite-btn-form">
                                @csrf
                                <button type="submit" class="favorite-btn {{ in_array($material->id, $favoriteIds) ? 'is-favorited' : '' }}"
                                        aria-label="Favorite">
                                    <i class="fa{{ in_array($material->id, $favoriteIds) ? 's' : 'r' }} fa-heart"></i>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 rounded-4 p-5 text-center"
             style="background: var(--bg-card); box-shadow: var(--shadow-card);">
            <i class="fas fa-book-open" style="font-size: 60px; color: var(--text-muted);"></i>
            <h5 class="mt-3 mb-2" style="color: var(--text-dark);">No Topics Available</h5>
            <p class="small mb-0" style="color: var(--text-gray);">
                Topics for this subject are not available yet.
            </p>
        </div>
    @endif

</div>
@endsection