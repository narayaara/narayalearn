<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Index untuk moderasi komentar admin
    public function index()
    {
        $comments = Comment::with(['user', 'material'])->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    // Delete comment (admin bisa hapus semua)
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
    }
}