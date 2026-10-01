@extends('layouts.admin')

@section('admin-content')
<div class="mx-auto" style="max-width: 600px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">Edit Material</h2>
    <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" id="subjectSelect" class="form-select rounded-3">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $material->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" id="type" class="form-select rounded-3">
                <option value="material" {{ $material->type == 'material' ? 'selected' : '' }}>Materials</option>
                <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>Video</option>
                <option value="exercise" {{ $material->type == 'exercise' ? 'selected' : '' }}>Exercises</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Topik</label>
            <select id="topicSelect" class="form-select rounded-3 mb-2"></select>
            <input type="text" name="title" id="titleInput"
                   class="form-control rounded-3 @error('title') is-invalid @enderror"
                   placeholder="Nama topik baru" value="{{ old('title', $material->title) }}">
            @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
            <small class="text-muted">Pilih topik yang sudah ada, atau pilih "+ Buat topik baru" kalau ini topik baru.</small>
        </div>

        <!-- Sumber Konten -->
        <div class="mb-3">
            <label class="form-label">Sumber Konten</label>
            <div class="d-flex gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="source_type"
                           id="source_file" value="file" {{ !$material->youtube_link ? 'checked' : '' }}>
                    <label class="form-check-label" for="source_file">
                        <i class="fas fa-upload"></i> Upload File
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="source_type"
                           id="source_link" value="link" {{ $material->youtube_link ? 'checked' : '' }}>
                    <label class="form-check-label" for="source_link">
                        <i class="fas fa-link"></i> Link URL
                    </label>
                </div>
            </div>
        </div>

        <!-- Field Upload File -->
        <div class="mb-3" id="file-field">
            <label class="form-label">File — kosongkan kalau tidak diganti</label>
            <input type="file" name="file" class="form-control rounded-3" accept=".pdf,.jpg,.jpeg,.png">
            @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
            @if($material->file_path)
                <small class="text-muted d-block mt-1">File saat ini: {{ basename($material->file_path) }}</small>
            @endif
        </div>

        <!-- Field Link URL -->
        <div class="mb-3 d-none" id="link-field">
            <label class="form-label">Link URL</label>
            <input type="text" name="youtube_url" value="{{ old('youtube_url', $material->youtube_link) }}"
                   class="form-control rounded-3"
                   placeholder="https://www.youtube.com/watch?v=... atau https://i.imgur.com/...">
            @error('youtube_url') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn" style="background:#FF6B9D;color:#fff;">Save changes</button>
        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>

<script>
    const topicsBySubject = @json($topicsBySubject);
    const currentTitle = @json(old('title', $material->title));

    const subjectSelect = document.getElementById('subjectSelect');
    const topicSelect = document.getElementById('topicSelect');
    const titleInput = document.getElementById('titleInput');

    const NEW_TOPIC_VALUE = '__new__';

    function populateTopics(preselectTitle) {
        const subjectId = subjectSelect.value;
        const topics = topicsBySubject[subjectId] || [];

        topicSelect.innerHTML = '';

        const placeholder = new Option('— Pilih topik yang sudah ada —', '');
        topicSelect.add(placeholder);

        topics.forEach(function (topic) {
            topicSelect.add(new Option(topic, topic));
        });

        topicSelect.add(new Option('+ Buat topik baru', NEW_TOPIC_VALUE));

        if (preselectTitle && topics.includes(preselectTitle)) {
            topicSelect.value = preselectTitle;
            titleInput.value = preselectTitle;
            titleInput.classList.add('d-none');
        } else if (preselectTitle) {
            topicSelect.value = NEW_TOPIC_VALUE;
            titleInput.value = preselectTitle;
            titleInput.classList.remove('d-none');
        } else {
            topicSelect.value = '';
            titleInput.value = '';
            titleInput.classList.add('d-none');
        }
    }

    topicSelect.addEventListener('change', function () {
        if (topicSelect.value === NEW_TOPIC_VALUE) {
            titleInput.value = '';
            titleInput.classList.remove('d-none');
            titleInput.focus();
        } else if (topicSelect.value === '') {
            titleInput.value = '';
            titleInput.classList.add('d-none');
        } else {
            titleInput.value = topicSelect.value;
            titleInput.classList.add('d-none');
        }
    });

    subjectSelect.addEventListener('change', function () {
        populateTopics(null);
    });

    populateTopics(currentTitle || null);

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