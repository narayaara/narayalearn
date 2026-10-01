@extends('layouts.admin')

@section('admin-content')
<div class="mx-auto" style="max-width: 600px;">
    <h2 class="fw-bold mb-4" style="color: #2D1B2E;">Add Material</h2>
    <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data" id="materialForm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" id="subjectSelect" class="form-select rounded-3">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
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
            <label class="form-label">Topik</label>
            <select id="topicSelect" class="form-select rounded-3 mb-2"></select>
            <input type="text" name="title" id="titleInput"
                   class="form-control rounded-3 @error('title') is-invalid @enderror"
                   placeholder="Nama topik baru" value="{{ old('title') }}">
            @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
            <small class="text-muted">Pilih topik yang sudah ada, atau pilih "+ Buat topik baru" kalau ini topik baru.</small>
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
    const topicsBySubject = @json($topicsBySubject);
    const oldTitle = @json(old('title'));

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

    populateTopics(oldTitle || null);

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