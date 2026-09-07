<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $favorites = $user->favorites()->with('subject')->get();
        $comments = $user->comments()->with('material')->latest()->get();

        return view('profile.index', compact('user', 'favorites', 'comments'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}
