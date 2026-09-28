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
        $userId = auth()->id();

        $existing = Favorite::where('user_id', $userId)
            ->where('material_id', $material->id)
            ->where('type', 'material')
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()->with('success', 'Dihapus dari favorit!');
        }

        Favorite::create([
            'user_id' => $userId,
            'material_id' => $material->id,
            'type' => 'material',
        ]);

        return redirect()->back()->with('success', 'Ditambahkan ke favorit!');
    }

    public function toggleTopic(Request $request, Subject $subject)
    {
        $request->validate([
            'topic_name' => 'required|string',
        ]);

        $userId = auth()->id();
        $topicName = $request->topic_name;

        $existing = Favorite::where('user_id', $userId)
            ->where('subject_id', $subject->id)
            ->where('topic_name', $topicName)
            ->where('type', 'topic')
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()->with('success', 'Topic deleted from favorites!');
        }

        Favorite::create([
            'user_id' => $userId,
            'subject_id' => $subject->id,
            'topic_name' => $topicName,
            'type' => 'topic',
        ]);

        return redirect()->back()->with('success', 'Topic added to favorites!');
    }
}