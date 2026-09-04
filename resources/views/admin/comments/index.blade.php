@extends('layouts.app')

@section('title', 'Moderasi Komentar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #2D1B2E;">
            <i class="fas fa-comments" style="color: #FF6B9D;"></i> 
            Moderasi Komentar
        </h2>
        <span class="badge" style="background: #FFE0EB; color: #FF6B9D; padding: 8px 16px;">
            Total: {{ $comments->total() }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            @forelse($comments as $comment)
                <div class="d-flex align-items-start gap-3 p-3 border-bottom">
                    <div class="rounded-circle bg-white p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #FFE0EB;">
                        <i class="fas fa-user" style="color: #FF6B9D; font-size: 20px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold" style="color: #2D1B2E;">
                                    {{ $comment->user->name ?? 'Unknown User' }}
                                    @if($comment->user && $comment->user->role === 'admin')
                                        <span class="badge-admin ms-2">Admin</span>
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-file-alt me-1"></i> 
                                    {{ $comment->material->title ?? 'Unknown Material' }}
                                    <span class="mx-2">•</span>
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Yakin ingin menghapus komentar ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                        <p class="mt-2 mb-0" style="color: #2D1B2E;">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-4">Belum ada komentar</p>
            @endforelse

            <div class="mt-3">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection