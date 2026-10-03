<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('favorites')->latest()->get();

        $totalStudents = User::where('role', 'user')->count();
        $activeUsers   = User::where('role', 'user')->count();
        $adminCount    = User::where('role', 'admin')->count();

        return view('admin.users.index', compact(
            'users',
            'totalStudents',
            'activeUsers',
            'adminCount'
        ));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus sesama admin!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}