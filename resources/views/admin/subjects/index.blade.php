@extends('layouts.app')

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

    @if (session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

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
                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Delete this subject?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Belum ada subject.</p>
    @endforelse
</div>
@endsection