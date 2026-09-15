@extends('layouts.app')

@section('title', 'Material Management - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #2D1B2E;">
            <i class="fas fa-file-alt" style="color: #FF6B9D;"></i> Material Management
        </h2>
        <a href="{{ route('admin.materials.create') }}" class="btn" style="background:#FF6B9D;color:#fff;">
            <i class="fas fa-plus"></i> Add Material
        </a>
    </div>

    @forelse ($materials as $material)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold" style="color:#2D1B2E;">{{ $material->title }}</span>
                    <span class="badge bg-light text-muted ms-2">{{ $material->subject->name ?? '-' }}</span>
                    <span class="badge ms-1" style="background:#FFE0EB; color:#FF6B9D;">
                        @if($material->type == 'material') Material
                        @elseif($material->type == 'video') Video
                        @else Exercise
                        @endif
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger" 
                            onclick="actionDestroy('{{ route('admin.materials.destroy', $material) }}', '{{ $material->title }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">No materials found.</p>
    @endforelse
</div>

{{-- Form & Script di luar loop --}}
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