<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Proteksi: gak bisa hapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // Proteksi: gak bisa hapus sesama admin
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus sesama admin!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}