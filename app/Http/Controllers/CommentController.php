<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Material $material)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $material->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_admin_comment' => auth()->user()->role === 'admin',
        ]);

        return redirect()->route('materials.show', $material)->with('success', 'Comment berhasil ditambahkan.');
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $comment->user_id !== $user->id) {
            abort(403, 'You are not allowed to delete this comment.');
        }

        $material = $comment->material;
        $comment->delete();

        return redirect()->route('materials.show', $material)->with('success', 'Comment berhasil dihapus.');
    }
}