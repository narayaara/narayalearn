<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function index()
    {
        $avatars = Avatar::latest()->get();
        return view('admin.avatars.index', compact('avatars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');

            Avatar::create(['filename' => $filename]);
        }

        return redirect()->route('admin.avatars.index')->with('success', 'Avatar berhasil ditambahkan.');
    }

    public function destroy(Avatar $avatar)
    {
        Storage::disk('public')->delete('avatars/' . $avatar->filename);

        User::where('avatar', $avatar->filename)->update(['avatar' => null]);

        $avatar->delete();

        return redirect()->route('admin.avatars.index')->with('success', 'Avatar berhasil dihapus.');
    }
}