@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">Add Material</h2>
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

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" id="type" class="form-select rounded-3">
                <option value="material">Materials</option>
                <option value="video">Video</option>
                <option value="exercise">Exercises</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control rounded-3">
            @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <!-- Sumber Konten -->
        <div class="mb-3">
            <label class="form-label">Sumber Konten</label>
            <div class="d-flex gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="source_type" 
                           id="source_file" value="file" checked>
                    <label class="form-check-label" for="source_file">
                        <i class="fas fa-upload"></i> Upload File
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="source_type" 
                           id="source_link" value="link">
                    <label class="form-check-label" for="source_link">
                        <i class="fas fa-link"></i> Link URL
                    </label>
                </div>
            </div>
        </div>

        <!-- Field Upload File -->
        <div class="mb-3" id="file-field">
            <label class="form-label">File</label>
            <input type="file" name="file" class="form-control rounded-3" 
                   accept=".pdf,.jpg,.jpeg,.png">
            @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
            <small class="text-muted">PDF, JPG, PNG. Max: 5MB</small>
        </div>

        <!-- Field Link URL -->
        <div class="mb-3 d-none" id="link-field">
            <label class="form-label">Link URL</label>
            <input type="text" name="youtube_url" value="{{ old('youtube_url') }}" 
                   class="form-control rounded-3" 
                   placeholder="https://www.youtube.com/watch?v=... atau https://i.imgur.com/...">
            @error('youtube_url') <div class="text-danger small">{{ $message }}</div> @enderror
            <small class="text-muted">Bisa YouTube, link gambar, Google Drive, dll.</small>
        </div>

        <button type="submit" class="btn" style="background:#FF6B9D;color:#fff;">Save</button>
        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>

<script>
    const sourceFile = document.getElementById('source_file');
    const sourceLink = document.getElementById('source_link');
    const fileField = document.getElementById('file-field');
    const linkField = document.getElementById('link-field');

    function toggleSource() {
        if (sourceFile.checked) {
            fileField.classList.remove('d-none');
            linkField.classList.add('d-none');
        } else {
            fileField.classList.add('d-none');
            linkField.classList.remove('d-none');
        }
    }

    sourceFile.addEventListener('change', toggleSource);
    sourceLink.addEventListener('change', toggleSource);
    toggleSource();
</script>
@endsection