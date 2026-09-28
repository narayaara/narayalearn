<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Material $material)
    {
        $existing = Favorite::where('user_id', auth()->id())
            ->where('type', 'material')
            ->where('material_id', $material->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'type' => 'material',
                'material_id' => $material->id,
            ]);
            $message = 'Added to favorites.';
        }

        return back()->with('success', $message);
    }

    public function toggleTopic(Request $request, Subject $subject)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
        ]);

        $existing = Favorite::where('user_id', auth()->id())
            ->where('type', 'topic')
            ->where('subject_id', $subject->id)
            ->where('topic_name', $request->topic_name)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'type' => 'topic',
                'subject_id' => $subject->id,
                'topic_name' => $request->topic_name,
            ]);
            $message = 'Added to favorites.';
        }

        return back()->with('success', $message);
    }
}