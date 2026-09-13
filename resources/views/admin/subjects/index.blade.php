@extends('layouts.app')

@section('title', 'Kelola Subject - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #2D1B2E;">
            <i class="fas fa-book" style="color: #FF6B9D;"></i> Subject Management
        </h2>
        <a href="{{ route('admin.subjects.create') }}" class="btn" style="background:#FF6B9D;color:#fff;">
            <i class="fas fa-plus"></i> Add Subject
        </a>
    </div>

    @forelse ($subjects as $subject)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold" style="color:#2D1B2E;">{{ $subject->name }}</span>
                    <span class="badge bg-light text-muted ms-2">{{ $subject->materials_count }} contents</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger" 
                            onclick="actionDestroy('{{ route('admin.subjects.destroy', $subject) }}', '{{ $subject->name }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Belum ada subject.</p>
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
// ===== KONFIRMASI HAPUS =====
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

// ===== NOTIFIKASI SUKSES (TOAST) =====
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

// ===== NOTIFIKASI ERROR =====
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