@php $isAdminComment = $comment->is_admin_comment; @endphp

<div class="card border-0 rounded-4 p-3 mb-2" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                 style="width: 32px; height: 32px;">
                <i class="fas fa-user" style="color: #999; font-size: 14px;"></i>
            </div>
            <span class="fw-semibold small">{{ $comment->user->name ?? 'Unknown' }}</span>
            @if($isAdminComment)
                <span class="badge-admin">Admin</span>
            @endif
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </div>

        @auth
            @if(Auth::id() === $comment->user_id || Auth::user()->role === 'admin')
                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" 
                            style="font-size: 0.7rem;"
                            onclick="return confirm('Delete this comment?')">
                        Delete
                    </button>
                </form>
            @endif
        @endauth
    </div>

    <p class="mt-2 mb-2 small" style="color: #2D1B2E;">{{ $comment->content }}</p>

    {{-- Tombol Reply --}}
    @auth
        <button class="btn btn-link btn-sm p-0 small text-decoration-none" 
                style="color: var(--pink-primary);"
                onclick="toggleReplyForm({{ $comment->id }})">
            <i class="fas fa-reply me-1"></i> Reply
        </button>
    @endauth

    {{-- Form Reply (hidden) --}}
    @auth
        <div id="reply-form-{{ $comment->id }}" class="d-none mt-2">
            <form action="{{ route('comments.store', $material) }}" method="POST">
                @csrf
                <input type="hidden" name="reply_to_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" 
                          class="form-control form-control-sm mb-2" 
                          placeholder="Balas komentar..." required></textarea>
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                            onclick="toggleReplyForm({{ $comment->id }})">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-outline-dark">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    @endauth

    {{-- Replies (balasan-balasan) --}}
    @if($comment->replies->count() > 0)
        <div class="mt-2">
            <button class="btn btn-link btn-sm p-0 small text-decoration-none" 
                    style="color: #666;"
                    onclick="toggleReplies({{ $comment->id }})">
                <i class="fas fa-chevron-down me-1" id="reply-chevron-{{ $comment->id }}"></i>
                Lihat {{ $comment->replies->count() }} balasan
            </button>

            <div id="replies-{{ $comment->id }}" class="d-none mt-2 ps-4" 
                 style="border-left: 2px solid #eee;">
                @foreach($comment->replies as $reply)
                    @include('materials.partials.comment', ['comment' => $reply, 'material' => $material])
                @endforeach
            </div>
        </div>
    @endif
</div>