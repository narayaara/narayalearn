@extends('layouts.app')

@section('title', 'User Management - Admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">
        <i class="fas fa-users" style="color: #FF6B9D;"></i> User Management
    </h2>

    @forelse ($users as $user)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                             class="rounded-circle" width="40" height="40">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 40px; height: 40px; background: #FFE0EB;">
                            <i class="fas fa-user" style="color: #FF6B9D;"></i>
                        </div>
                    @endif
                    <div>
                        <span class="fw-bold" style="color:#2D1B2E;">
                            {{ $user->name }}
                            @if($user->role === 'admin')
                                <span class="badge-admin ms-1">Admin</span>
                            @endif
                        </span>
                        <br>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
                @if($user->id !== Auth::id())
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger" 
                            onclick="actionDestroy('{{ route('admin.users.destroy', $user) }}', '{{ $user->name }}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                @else
                    <span class="badge bg-light text-muted">Your Account</span>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted text-center">No users found.</p>
    @endforelse
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