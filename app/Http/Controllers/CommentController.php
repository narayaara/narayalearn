<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store comment (user)
    public function store(Request $request, Material $material)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $material->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Delete comment (user hanya bisa hapus milik sendiri)
    public function destroy(Comment $comment)
    {
        // Cek apakah user adalah pemilik komentar atau admin
        if (auth()->user()->role === 'admin' || auth()->id() === $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
    }
}