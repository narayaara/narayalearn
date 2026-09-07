@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">
        <i class="fas fa-users" style="color: #FF6B9D;"></i> User Management
    </h2>

    @if (session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @forelse ($users as $user)
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white p-2" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:2px solid #FFE0EB;">
                        <i class="fas fa-user" style="color:#FF6B9D;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color:#2D1B2E;">{{ $user->name }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Belum ada user.</p>
    @endforelse
</div>
@endsection