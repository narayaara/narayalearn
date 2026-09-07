@extends('layouts.app')

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

    @if (session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @forelse ($materials as $material)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold" style="color:#2D1B2E;">{{ $material->title }}</span>
                    <span class="badge" style="background:#FFE0EB;color:#FF6B9D;">{{ ucfirst($material->type) }}</span>
                    <span class="text-muted small">{{ $material->subject->name }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Delete this material?')">
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
        <p class="text-muted text-center">Belum ada material.</p>
    @endforelse
</div>
@endsection