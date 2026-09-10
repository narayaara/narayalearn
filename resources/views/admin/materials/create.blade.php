@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 480px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">Add Material</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-select rounded-3">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <select name="type" id="type" class="form-select rounded-3">
            <option value="material">Materials</option>
            <option value="video">Video</option>
            <option value="exercise">Exercises</option>
        </select>

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control rounded-3">
            @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3" id="file-field">
            <label class="form-label">File (PDF)</label>
            <input type="file" name="file" class="form-control rounded-3">
        </div>

        <div class="mb-3 d-none" id="youtube-field">
            <label class="form-label">YouTube URL</label>
            <input type="text" name="youtube_url" value="{{ old('youtube_url') }}" class="form-control rounded-3">
        </div>

        <button type="submit" class="btn" style="background:#FF6B9D;color:#fff;">Save</button>
        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const fileField = document.getElementById('file-field');
    const youtubeField = document.getElementById('youtube-field');
    function toggleFields() {
        if (typeSelect.value === 'video') {
            fileField.classList.add('d-none');
            youtubeField.classList.remove('d-none');
        } else {
            fileField.classList.remove('d-none');
            youtubeField.classList.add('d-none');
        }
    }
    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endsection