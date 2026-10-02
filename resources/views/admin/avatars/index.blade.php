@extends('layouts.admin')

@section('title', 'Kelola Avatar - Admin NarayaLearn')

@section('admin-content')

{{-- ==================== PAGE HEADER ==================== --}}
<div class="avatar-page-header">
    <div class="avatar-page-title-wrap">
        <div class="avatar-page-eyebrow">
            <span class="dot"></span>
            ADMIN PANEL
        </div>
        <h1 class="avatar-page-title">Kelola Avatar</h1>
        <p class="avatar-page-subtitle">
            Kelola koleksi avatar kustom yang digunakan siswa.
        </p>
    </div>

    <div class="avatar-page-actions">
        <button type="button" class="avatar-btn-upload" onclick="openUploadModal()">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Upload Avatar</span>
        </button>
    </div>
</div>

{{-- ==================== FILTER TOOLBAR ==================== --}}
<div class="avatar-toolbar">
    <div class="avatar-search">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="avatarSearchInput"
               placeholder="Cari avatar berdasarkan nama file...">
    </div>

    <div class="avatar-toolbar-right">
        <div class="avatar-counter-badge">
            <i class="fas fa-face-smile"></i>
            <span id="activeCounter">{{ $avatars->count() }} Koleksi Avatar Aktif</span>
        </div>
    </div>
</div>

{{-- ==================== AVATAR GRID ==================== --}}
@if($avatars->count() > 0)
    <div class="avatar-grid" id="avatarGrid">
        @foreach($avatars as $avatar)
            <div class="avatar-card">
                <button type="button" class="avatar-card-delete"
                        onclick="openDeleteModal('{{ route('admin.avatars.destroy', $avatar) }}', '{{ $avatar->filename }}')"
                        title="Hapus avatar">
                    <i class="fas fa-trash"></i>
                </button>

                <div class="avatar-card-image">
                    <img src="{{ asset('storage/avatars/'.$avatar->filename) }}"
                         alt="{{ $avatar->filename }}">
                </div>

                <span class="avatar-card-name" title="{{ $avatar->filename }}">
                    {{ $avatar->filename }}
                </span>

                <span class="avatar-card-tag">Preset Avatar</span>

                <span class="avatar-card-meta">
                    {{ $avatar->created_at->format('d M Y') }}
                </span>
            </div>
        @endforeach
    </div>
@else
    {{-- ==================== EMPTY STATE ==================== --}}
    <div class="avatar-empty-state">
        <div class="empty-icon">
            <i class="fas fa-image"></i>
        </div>
        <h5>Belum ada avatar preset</h5>
        <p>Semua avatar yang Anda tambahkan akan muncul di pilihan personalisasi profil murid di platform NarayaLearn.</p>
        <button type="button" class="avatar-btn-upload" onclick="openUploadModal()">
            <i class="fas fa-plus-circle"></i>
            <span>Upload Avatar</span>
        </button>
    </div>
@endif

{{-- ==================== DELETE MODAL ==================== --}}
<div class="avatar-modal-backdrop" id="deleteModalBackdrop">
    <div class="avatar-modal">
        <button type="button" class="avatar-modal-close" onclick="closeDeleteModal()">
            <i class="fas fa-times"></i>
        </button>

        <div class="avatar-modal-icon avatar-modal-icon-danger">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h2 class="avatar-modal-title">Hapus Avatar Ini?</h2>

        <p class="avatar-modal-text">
            Apakah Anda yakin ingin menghapus
            <strong id="modalTargetFilename">"avatar.jpg"</strong>?
            Siswa yang sedang menggunakan avatar ini akan dialihkan ke avatar default.
        </p>

        <div class="avatar-modal-actions">
            <button type="button" class="avatar-modal-btn-cancel" onclick="closeDeleteModal()">
                Batal
            </button>
            <button type="button" class="avatar-modal-btn-confirm" onclick="confirmDelete()">
                Ya, Hapus!
            </button>
        </div>
    </div>
</div>

{{-- ==================== UPLOAD MODAL ==================== --}}
<div class="avatar-modal-backdrop" id="uploadModalBackdrop">
    <div class="avatar-modal">
        <button type="button" class="avatar-modal-close" onclick="closeUploadModal()">
            <i class="fas fa-times"></i>
        </button>

        <div class="avatar-modal-icon avatar-modal-icon-info">
            <i class="fas fa-cloud-upload-alt"></i>
        </div>

        <h2 class="avatar-modal-title">Upload Avatar Baru</h2>

        <p class="avatar-modal-text">
            Pilih satu atau beberapa file avatar.
            Format: <strong>JPG/PNG/WEBP</strong>, maks <strong>1MB</strong> per file.
        </p>

        <form action="{{ route('admin.avatars.store') }}" method="POST"
              enctype="multipart/form-data" class="avatar-upload-form">
            @csrf

            <div class="avatar-form-group">
                <label for="avatarFiles">Pilih File Avatar</label>
                <input type="file" name="files[]" id="avatarFiles"
                       accept=".jpg,.jpeg,.png,.webp" multiple required>
                <small>Bisa pilih beberapa file sekaligus.</small>
            </div>

            @error('files')     <div class="avatar-form-error">{{ $message }}</div> @enderror
            @error('files.*')   <div class="avatar-form-error">{{ $message }}</div> @enderror

            <div class="avatar-modal-actions">
                <button type="button" class="avatar-modal-btn-cancel" onclick="closeUploadModal()">
                    Batal
                </button>
                <button type="submit" class="avatar-modal-btn-confirm">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden Delete Form --}}
<form action="" id="form-destroy" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
// ==================== DELETE ====================
let currentDeleteUrl = '';

function openDeleteModal(url, filename) {
    currentDeleteUrl = url;
    document.getElementById('modalTargetFilename').textContent = `"${filename}"`;
    document.getElementById('deleteModalBackdrop').classList.add('is-open');
    document.body.classList.add('modal-open');
}

function closeDeleteModal() {
    document.getElementById('deleteModalBackdrop').classList.remove('is-open');
    document.body.classList.remove('modal-open');
}

function confirmDelete() {
    const form = document.getElementById('form-destroy');
    form.setAttribute('action', currentDeleteUrl);
    form.submit();
}

// ==================== UPLOAD ====================
function openUploadModal() {
    document.getElementById('uploadModalBackdrop').classList.add('is-open');
    document.body.classList.add('modal-open');
}

function closeUploadModal() {
    document.getElementById('uploadModalBackdrop').classList.remove('is-open');
    document.body.classList.remove('modal-open');
}

// ==================== SEARCH FILTER ====================
document.getElementById('avatarSearchInput')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('#avatarGrid > .avatar-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const counter = document.getElementById('activeCounter');
    if (counter) counter.textContent = `${visibleCount} Koleksi Avatar Aktif`;
});

// Klik backdrop untuk close
document.getElementById('deleteModalBackdrop')?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

document.getElementById('uploadModalBackdrop')?.addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

@if($errors->any())
    openUploadModal();
@endif
</script>
@endpush