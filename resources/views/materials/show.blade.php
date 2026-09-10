@extends('layouts.app')

@section('title', $material->title . ' - NarayaLearn')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--pink-primary);">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}" style="color: var(--pink-primary);">Subjects</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('subjects.show', $material->subject) }}" style="color: var(--pink-primary);">
                    {{ $material->subject->name ?? 'Subject' }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($material->title, 30) }}</li>
        </ol>
    </nav>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- ===== KONTEN UTAMA ===== -->
        <div class="col-lg-8">
            <div class="card card-pink p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge mb-2" style="background: var(--pink-light); color: var(--pink-primary);">
                            @if($material->type == 'material')
                                <i class="fas fa-file-alt me-1"></i> Materi
                            @elseif($material->type == 'video')
                                <i class="fas fa-video me-1"></i> Video
                            @else
                                <i class="fas fa-tasks me-1"></i> Latihan Soal
                            @endif
                        </span>
                        <h2 class="fw-bold mb-1" style="color: #2D1B2E;">{{ $material->title }}</h2>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-book me-1"></i> {{ $material->subject->name ?? 'No Subject' }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-clock me-1"></i> {{ $material->created_at->diffForHumans() }}
                        </p>
                    </div>

                    @auth
                        <form action="{{ route('favorites.toggle', $material) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ $isFavorited ? 'btn-pink' : 'btn-outline-secondary' }} btn-sm">
                                <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart"></i>
                                {{ $isFavorited ? 'Favorited' : 'Favorite' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="far fa-heart"></i> Favorite
                        </a>
                    @endauth
                </div>

                <hr>

                <!-- Isi Konten -->
                <div class="content-body">
                    @if($material->type == 'video' && $material->youtube_url)
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="{{ str_replace('watch?v=', 'embed/', $material->youtube_url) }}" 
                                    title="{{ $material->title }}" allowfullscreen></iframe>
                        </div>
                    @elseif($material->file_path)
                        <div class="text-center p-5 rounded" style="background: var(--pink-soft);">
                            <i class="fas fa-file-pdf" style="font-size: 60px; color: var(--pink-primary);"></i>
                            <h5 class="mt-3" style="color: #2D1B2E;">File Tersedia</h5>
                            <p class="text-muted">Klik tombol di bawah untuk mengunduh file</p>
                            <a href="{{ route('materials.download', $material) }}" class="btn btn-pink">
                                <i class="fas fa-download me-1"></i> Download File
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Konten belum tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- ===== SIDEBAR ===== -->
        <div class="col-lg-4">
            <div class="card card-pink p-3 mb-3">
                <h5 class="fw-bold mb-3" style="color: #2D1B2E;">
                    <i class="fas fa-info-circle me-2" style="color: var(--pink-primary);"></i> Informasi
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <small class="text-muted">Tipe Konten</small>
                        <div class="fw-bold">{{ ucfirst($material->type) }}</div>
                    </li>
                    <li class="mb-2">
                        <small class="text-muted">Mata Pelajaran</small>
                        <div class="fw-bold">{{ $material->subject->name ?? '-' }}</div>
                    </li>
                    <li class="mb-2">
                        <small class="text-muted">Total Komentar</small>
                        <div class="fw-bold">{{ $material->comments->count() }} komentar</div>
                    </li>
                    <li>
                        <small class="text-muted">Dipublikasikan</small>
                        <div class="fw-bold">{{ $material->created_at->format('d M Y') }}</div>
                    </li>
                </ul>
            </div>

            @if($material->file_path)
            <div class="card card-pink p-3 mb-3">
                <h5 class="fw-bold mb-3" style="color: #2D1B2E;">
                    <i class="fas fa-download me-2" style="color: var(--pink-primary);"></i> Download
                </h5>
                <a href="{{ route('materials.download', $material) }}" class="btn btn-pink w-100">
                    <i class="fas fa-file-download me-1"></i> Unduh File
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- ===== KOMENTAR SECTION ===== -->
    <div class="card card-pink p-4 mt-4">
        <h4 class="fw-bold mb-4" style="color: #2D1B2E;">
            <i class="fas fa-comments me-2" style="color: var(--pink-primary);"></i> 
            Diskusi ({{ $material->comments->count() }})
        </h4>

        <!-- Form Komentar -->
        @auth
            <form action="{{ route('comments.store', $material) }}" method="POST" class="mb-4">
                @csrf
                <div class="d-flex gap-3">
                    <div class="rounded-circle bg-white p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid var(--pink-light); flex-shrink: 0;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" class="rounded-circle" width="36" height="36">
                        @else
                            <i class="fas fa-user" style="color: var(--pink-primary); font-size: 20px;"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        @if(Auth::user()->role === 'admin')
                            <div class="mb-2">
                                <span class="badge-admin">
                                    <i class="fas fa-crown me-1"></i> Anda berkomentar sebagai Admin
                                </span>
                            </div>
                        @endif
                        <textarea name="content" rows="3" class="form-control mb-2 @error('content') is-invalid @enderror" 
                                  placeholder="Tulis komentar atau pertanyaanmu..." required>{{ old('content') }}</textarea>
                        @error('content') <p class="text-danger small">{{ $message }}</p> @enderror
                        <div class="text-end">
                            <button type="submit" class="btn btn-pink btn-sm">
                                <i class="fas fa-paper-plane me-1"></i> Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="alert" style="background: var(--pink-soft); border: none;">
                <i class="fas fa-info-circle me-2" style="color: var(--pink-primary);"></i>
                <a href="{{ route('login') }}" style="color: var(--pink-primary); font-weight: 600;">Login</a> 
                untuk menambahkan komentar
            </div>
        @endauth

        <hr>

        <!-- Daftar Komentar -->
        @forelse($material->comments()->latest()->get() as $comment)
            @php
                $isAdminComment = $comment->is_admin_comment;
            @endphp
            
            <div class="d-flex gap-3 mb-3 p-3 rounded position-relative" 
                 style="background: {{ $isAdminComment ? 'linear-gradient(135deg, #FFF5F8 0%, #FFE0EB 100%)' : 'var(--pink-soft)' }}; 
                        border-left: 4px solid {{ $isAdminComment ? '#FF6B9D' : 'transparent' }};">
                
                <!-- Avatar -->
                <div class="rounded-circle bg-white p-2 position-relative" 
                     style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; 
                            border: 2px solid {{ $isAdminComment ? '#FF6B9D' : 'var(--pink-light)' }}; flex-shrink: 0;">
                    @if($comment->user && $comment->user->avatar)
                        <img src="{{ asset('storage/avatars/'.$comment->user->avatar) }}" class="rounded-circle" width="36" height="36">
                    @else
                        <i class="fas fa-user" style="color: var(--pink-primary); font-size: 20px;"></i>
                    @endif
                    
                    @if($isAdminComment)
                        <span class="position-absolute" 
                              style="bottom: -6px; right: -6px; background: #FF6B9D; color: #fff; width: 22px; height: 22px; 
                                     border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                     border: 2px solid #fff; box-shadow: 0 2px 5px rgba(255,107,157,0.4);">
                            <i class="fas fa-crown" style="font-size: 9px;"></i>
                        </span>
                    @endif
                </div>
                
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-bold" style="color: #2D1B2E;">
                                {{ $comment->user->name ?? 'Unknown' }}
                            </span>
                            
                            @if($isAdminComment)
                                <span class="badge-admin ms-2">
                                    <i class="fas fa-crown me-1"></i> Admin
                                </span>
                            @endif
                            
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        @auth
                            @if(Auth::id() === $comment->user_id || Auth::user()->role === 'admin')
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" 
                                            onclick="return confirm('Hapus komentar ini?')"
                                            title="Hapus komentar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    
                    <p class="mt-2 mb-0" style="color: #2D1B2E; {{ $isAdminComment ? 'font-weight: 500;' : '' }}">
                        {{ $comment->content }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="fas fa-comment-slash" style="font-size: 40px; color: #ddd;"></i>
                <p class="text-muted mt-2">Belum ada komentar. Jadilah yang pertama!</p>
            </div>
        @endforelse
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="{{ route('subjects.show', $material->subject) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke {{ $material->subject->name ?? 'Subject' }}
        </a>
    </div>
</div>
@endsection