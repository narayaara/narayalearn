@extends('layouts.app')

@section('title', 'Admin Dashboard - NarayaLearn')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: #2D1B2E;">
                <i class="fas fa-tachometer-alt" style="color: #FF6B9D;"></i> 
                Admin Dashboard
            </h2>
            <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! 👋</p>
        </div>
        <div>
            <span class="badge" style="background: #FF6B9D; padding: 8px 16px; font-size: 0.9rem;">
                <i class="fas fa-crown me-2"></i> Administrator
            </span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3" style="border-left: 4px solid #FF6B9D;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Subject</small>
                        <h3 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $totalSubjects }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #FFE0EB;">
                        <i class="fas fa-book" style="color: #FF6B9D; font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3" style="border-left: 4px solid #FF8FB5;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Materi</small>
                        <h3 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $totalMaterials }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #FFE0EB;">
                        <i class="fas fa-file-alt" style="color: #FF6B9D; font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3" style="border-left: 4px solid #FFA8C5;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total User</small>
                        <h3 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $totalUsers }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #FFE0EB;">
                        <i class="fas fa-users" style="color: #FF6B9D; font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3" style="border-left: 4px solid #FFB8CF;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Komentar</small>
                        <h3 class="fw-bold mb-0" style="color: #2D1B2E;">{{ $totalComments }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #FFE0EB;">
                        <i class="fas fa-comments" style="color: #FF6B9D; font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row g-4">
        <!-- User Terbaru -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold mb-0" style="color: #2D1B2E;">
                        <i class="fas fa-user-plus" style="color: #FF6B9D;"></i> User Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($latestUsers as $user)
                        <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background: #FFF5F8;">
                            <div class="rounded-circle bg-white p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 2px solid #FFE0EB;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="rounded-circle" width="36" height="36">
                                @else
                                    <i class="fas fa-user" style="color: #FF6B9D; font-size: 18px;"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="color: #2D1B2E; font-size: 0.9rem;">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <span class="badge bg-light text-muted">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada user</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Materi Terbaru -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold mb-0" style="color: #2D1B2E;">
                        <i class="fas fa-file-upload" style="color: #FF6B9D;"></i> Materi Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($latestMaterials as $material)
                        <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background: #FFF5F8;">
                            <div class="rounded-circle bg-white p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 2px solid #FFE0EB;">
                                <i class="fas fa-file" style="color: #FF6B9D; font-size: 18px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="color: #2D1B2E; font-size: 0.9rem;">{{ $material->title }}</div>
                                <small class="text-muted">{{ $material->subject->name ?? 'No Subject' }}</small>
                            </div>
                            <span class="badge" style="background: #FFE0EB; color: #FF6B9D;">
                                {{ ucfirst($material->type) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada materi</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Komentar Terbaru -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="fw-bold mb-0" style="color: #2D1B2E;">
                        <i class="fas fa-comment-dots" style="color: #FF6B9D;"></i> Komentar Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($latestComments as $comment)
                        <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background: #FFF5F8;">
                            <div class="rounded-circle bg-white p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 2px solid #FFE0EB;">
                                <i class="fas fa-user" style="color: #FF6B9D; font-size: 18px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="color: #2D1B2E; font-size: 0.9rem;">{{ $comment->user->name ?? 'Unknown' }}</div>
                                <small class="text-muted">{{ Str::limit($comment->body, 30) }}</small>
                            </div>
                            <span class="badge bg-light text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada komentar</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mt-4">
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.subjects.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4" style="transition: all 0.3s; background: linear-gradient(135deg, #FFF5F8, #FFE0EB);">
                    <i class="fas fa-book" style="font-size: 32px; color: #FF6B9D;"></i>
                    <h6 class="mt-2 fw-bold" style="color: #2D1B2E;">Kelola Subject</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.materials.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4" style="transition: all 0.3s; background: linear-gradient(135deg, #FFF5F8, #FFE0EB);">
                    <i class="fas fa-file-alt" style="font-size: 32px; color: #FF6B9D;"></i>
                    <h6 class="mt-2 fw-bold" style="color: #2D1B2E;">Kelola Materi</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4" style="transition: all 0.3s; background: linear-gradient(135deg, #FFF5F8, #FFE0EB);">
                    <i class="fas fa-users" style="font-size: 32px; color: #FF6B9D;"></i>
                    <h6 class="mt-2 fw-bold" style="color: #2D1B2E;">Kelola User</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.comments.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4" style="transition: all 0.3s; background: linear-gradient(135deg, #FFF5F8, #FFE0EB);">
                    <i class="fas fa-comments" style="font-size: 32px; color: #FF6B9D;"></i>
                    <h6 class="mt-2 fw-bold" style="color: #2D1B2E;">Moderasi Komentar</h6>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(255, 107, 157, 0.15) !important;
    }
</style>
@endsection