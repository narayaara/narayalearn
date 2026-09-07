@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 480px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">Add Subject</h2>
    <form action="{{ route('admin.subjects.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-3">
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn" style="background:#FF6B9D;color:#fff;">Save</button>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>
@endsection