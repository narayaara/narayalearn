@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h1 class="text-xl font-semibold mb-4">Edit Material</h1>
    <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label class="block mb-1">Subject</label>
        <select name="subject_id" class="w-full border rounded p-2 mb-2">
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $material->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        </select>

        <label class="block mb-1">Type</label>
        <select name="type" id="type" class="w-full border rounded p-2 mb-2">
            <option value="materi" {{ $material->type == 'materi' ? 'selected' : '' }}>Materials</option>
            <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>Video</option>
            <option value="latihan" {{ $material->type == 'latihan' ? 'selected' : '' }}>Exercises</option>
        </select>

        <label class="block mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $material->title) }}" class="w-full border rounded p-2 mb-2">
        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

        <div id="file-field">
            <label class="block mb-1">File (PDF) — leave empty to keep current file</label>
            <input type="file" name="file" class="w-full border rounded p-2 mb-2">
        </div>

        <div id="youtube-field" class="hidden">
            <label class="block mb-1">YouTube URL</label>
            <input type="text" name="youtube_url" value="{{ old('youtube_url', $material->youtube_url) }}" class="w-full border rounded p-2 mb-2">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">Save changes</button>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const fileField = document.getElementById('file-field');
    const youtubeField = document.getElementById('youtube-field');
    function toggleFields() {
        if (typeSelect.value === 'video') {
            fileField.classList.add('hidden');
            youtubeField.classList.remove('hidden');
        } else {
            fileField.classList.remove('hidden');
            youtubeField.classList.add('hidden');
        }
    }
    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endsection