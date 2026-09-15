@extends('layouts.app')

@section('title', 'Comment Moderation - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #2D1B2E;">
            <i class="fas fa-comments" style="color: #FF6B9D;"></i> Comment Moderation
        </h2>
        <span class="badge" style="background: #FFE0EB; color: #FF6B9D; padding: 8px 16px;">
            Total: {{ $comments->total() }}
        </span>
    </div>

    @forelse ($comments as $comment)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-user-circle" style="color: #FF6B9D; font-size: 20px;"></i>
                        <span class="fw-bold" style="color:#2D1B2E;">
                            {{ $comment->user->name ?? 'Unknown' }}
                        </span>
                        @if($comment->user && $comment->user->role === 'admin')
                            <span class="badge-admin">Admin</span>
                        @endif
                        <small class="text-muted">
                            • pada {{ $comment->material->title ?? 'Unknown' }}
                            • {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <p class="mb-0" style="color: #2D1B2E;">{{ $comment->content }}</p>
                </div>
                <button type="button" 
                        class="btn btn-sm btn-outline-danger ms-3" 
                        onclick="actionDestroy('{{ route('admin.comments.destroy', $comment) }}', 'this comment')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">No comments found.</p>
    @endforelse

    <div class="mt-3">
        {{ $comments->links() }}
    </div>
</div>

<form action="" id="form-destroy" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.26.25/sweetalert2.all.min.js"></script>

<script>
function actionDestroy(url, itemName = 'item ini') {
    Swal.fire({
        title: 'Are you sure?',
        html: `<strong>${itemName}</strong> will be deleted permanently!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF6B9D',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Yes, Delete!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-destroy').attr('action', url);
            $('#form-destroy').submit();
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

    Toast.fire({
        icon: 'success',
        title: '{{ Session::get('success') }}'
    });
@endif

@if (Session::has('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ Session::get('error') }}',
        confirmButtonColor: '#FF6B9D'
    });
@endif
</script>
@endsection