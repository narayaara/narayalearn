<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Avatar;
use App\Models\Favorite;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $favoriteMaterials = Favorite::with('material.subject')
            ->where('user_id', $user->id)
            ->where('type', 'material')
            ->latest()
            ->get();

        // ===== PROGRES PER SUBJECT =====
        $subjects = \App\Models\Subject::all()->map(function ($subject) use ($user) {
            $materialIds = $subject->materials()->pluck('id')->toArray();
            $total = count($materialIds);

            $completed = 0;
            if ($total > 0) {
                $completed = \App\Models\Progress::where('user_id', $user->id)
                    ->whereIn('material_id', $materialIds)
                    ->where('is_completed', true)
                    ->count();
            }

            $subject->progress_percent = $total > 0 
                ? round(($completed / $total) * 100) 
                : 0;
            $subject->total_materials = $total;
            $subject->completed_materials = $completed;

            return $subject;
        });

        return view('profile.index', compact(
            'user',
            'favoriteMaterials',
            'subjects'
        ));
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        $avatars = Avatar::latest()->get();

        return view('profile.edit', compact('user', 'avatars'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar_id' => 'nullable|exists:avatars,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->filled('avatar_id')) {
            $avatar = Avatar::find($request->avatar_id);
            $data['avatar'] = $avatar->filename;
        }

        $user->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profile successfully updated!');
    }
}