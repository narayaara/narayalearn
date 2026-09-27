@extends('layouts.app')

@section('title', 'My Account - NarayaLearn')

@section('content')
<div class="container-fluid py-4 px-4 px-lg-5" 

    <!-- ===== HEADER PROFIL ===== -->
    <div class="card border-0 rounded-4 p-4 mb-4" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
        <div class="d-flex align-items-center gap-3">
            <!-- Avatar -->
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                     class="rounded-circle" 
                     style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 60px; height: 60px; background: #F5F5F5;">
                    <i class="fas fa-user" style="font-size: 24px; color: #999;"></i>
                </div>
            @endif

            <!-- Info -->
            <div class="flex-grow-1">
                <h5 class="fw-bold mb-0" style="color: #2D1B2E;">
                    {{ $user->name }}
                    @if($user->role === 'admin')
                        <span class="badge-admin ms-2">Admin</span>
                    @endif
                </h5>
                <small class="text-muted">{{ $user->email }}</small>
            </div>

            <!-- Edit Button -->
            <button class="btn btn-outline-secondary btn-sm rounded-3" 
                    data-bs-toggle="collapse" data-bs-target="#editProfileForm">
                <i class="fas fa-pen me-1"></i> Edit Profile
            </button>
        </div>

        <!-- ===== FORM EDIT (Collapse) ===== -->
        <div class="collapse mt-4" id="editProfileForm">
            <hr>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nama</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Foto Profil</label>
                    <input type="file" name="avatar" 
                           class="form-control @error('avatar') is-invalid @enderror"
                           accept="image/*">
                    @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Password Baru (Opsional)</label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin ganti">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" 
                           class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" 
                            data-bs-toggle="collapse" data-bs-target="#editProfileForm">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-pink btn-sm rounded-3">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Topik Favorit -->
    <h5 class="fw-bold mb-3" style="color: var(--text-dark);">
        <i class="fas fa-bookmark me-2" style="color: var(--pink-primary);"></i>
        Topik Favorit
    </h5>

    @if($favoriteTopics->count() > 0)
        <div class="row g-2 mb-4">
            @foreach($favoriteTopics as $fav)
                <div class="col-md-6">
                    <a href="{{ route('subjects.topic', [$fav->subject, $fav->topic_name]) }}" 
                    class="text-decoration-none">
                        <div class="card border-0 rounded-3 p-3" style="background: var(--bg-soft);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-bookmark" style="color: var(--pink-primary);"></i>
                                <span class="fw-semibold" style="color: var(--text-dark);">{{ $fav->topic_name }}</span>
                                <small style="color: var(--text-muted);">• {{ $fav->subject->name ?? '-' }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small mb-4">Belum ada topik yang difavoritkan.</p>
    @endif

    <!-- Materi Favorit -->
    <h5 class="fw-bold mb-3" style="color: var(--text-dark);">
        <i class="fas fa-heart me-2" style="color: var(--pink-primary);"></i>
        Materi Favorit
    </h5>

    @if($favoriteMaterials->count() > 0)
        <div class="row g-2">
            @foreach($favoriteMaterials as $fav)
                <div class="col-md-6">
                    <a href="{{ route('materials.show', $fav->material) }}" class="text-decoration-none">
                        <div class="card border-0 rounded-3 p-3" style="background: var(--bg-soft);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-alt" style="color: var(--pink-primary);"></i>
                                <span class="fw-semibold" style="color: var(--text-dark);">{{ $fav->material->title ?? '-' }}</span>
                                <small style="color: var(--text-muted);">• {{ $fav->material->subject->name ?? '-' }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small">Belum ada materi yang difavoritkan.</p>
    @endif

    <!-- ===== COMMENTS ===== -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3" style="color: #2D1B2E;">My Comments</h6>
        <div class="card border-0 rounded-4 p-3" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
            @forelse ($comments as $comment)
                <div class="p-3 rounded-3 mb-2" style="background: #FAFAFA;">
                    <p class="mb-1 small" style="color: #2D1B2E;">{{ $comment->content }}</p>
                    <small class="text-muted">
                        On 
                        <a href="{{ route('materials.show', $comment->material) }}" 
                           style="color: var(--pink-primary); text-decoration: none;">
                            {{ $comment->material->title ?? 'Unknown' }}
                        </a>
                        - {{ $comment->material->subject->name ?? '-' }}
                    </small>
                </div>
            @empty
                <p class="text-muted small mb-0 text-center py-3">
                    Belum ada comment.
                </p>
            @endforelse
        </div>
    </div>
</div>
@endsection