<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggle(Material $material)
    {
        $existing = Favorite::where('user_id', auth()->id())
            ->where('material_id', $material->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'material_id' => $material->id,
            ]);
            $message = 'Added to favorites.';
        }

        return back()->with('success', $message);
    }
}
