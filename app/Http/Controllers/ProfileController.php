<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $favorites = $user->favorites()->with('material.subject')->latest()->get();
        $comments = $user->comments()->with('material')->latest()->get();

        return view('profile.index', compact('user', 'favorites', 'comments'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Ganti password kalo diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Upload avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $filename;
        }

        $user->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}