@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-semibold">{{ $material->title }}</h1>
            <p class="text-sm text-gray-500">{{ $material->subject->name }} · {{ $material->type }}</p>
        </div>
        <div class="space-x-2">
            <form action="{{ route('favorites.toggle', $material) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="border px-3 py-1 rounded">
                    {{ $isFavorited ? '★ Favorited' : '☆ Favorite' }}
                </button>
            </form>
            @if ($material->file_path)
                <a href="{{ route('materials.download', $material) }}" class="border px-3 py-1 rounded">Download</a>
            @endif
        </div>
    </div>

    @if ($material->type === 'video' && $material->youtube_url)
        <div class="aspect-video mb-4">
            <iframe class="w-full h-full" src="{{ str_replace('watch?v=', 'embed/', $material->youtube_url) }}" allowfullscreen></iframe>
        </div>
    @endif

    <h2 class="font-medium mb-2">Comments</h2>
    <div class="space-y-3 mb-4">
        @foreach ($material->comments as $comment)
            <div class="border rounded p-3">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-sm font-medium">{{ $comment->user->name }}</span>
                    @if ($comment->is_admin_comment)
                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded">Admin</span>
                    @endif
                </div>
                <p class="text-sm">{{ $comment->content }}</p>
                @if (auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $comment->user_id))
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-1" onsubmit="return confirm('Delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    @auth
        <form action="{{ route('comments.store', $material) }}" method="POST">
            @csrf
            <textarea name="content" rows="3" class="w-full border rounded p-2 mb-2" placeholder="Write a comment"></textarea>
            @error('content') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Post comment</button>
        </form>
    @else
        <p class="text-sm text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600">log in</a> to comment.</p>
    @endauth
</div>
@endsection