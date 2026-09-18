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
            'reply_to_id' => 'nullable|exists:comments,id',   // ⬅️ GANTI
        ]);

        $material->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'reply_to_id' => $request->reply_to_id,            // ⬅️ GANTI
            'is_admin_comment' => auth()->user()->role === 'admin',
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        if (auth()->user()->role === 'admin' || auth()->id() === $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
    }
}