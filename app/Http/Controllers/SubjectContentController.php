<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;

class SubjectContentController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount(['materials as topics_count' => function ($q) {
            $q->select(\DB::raw('count(distinct title)'));
        }])->get();

        return view('subjects.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
        // Group semua material di subject ini berdasarkan title (= topik)
        $grouped = $subject->materials()->get()->groupBy('title');

        // Tiap topik diwakilin 1 Material: prioritas tipe "material",
        // kalau belum ada pake yang pertama tersedia (video/exercise)
        $topics = $grouped->map(function ($group) {
            return $group->firstWhere('type', 'material') ?? $group->first();
        });

        // Berapa jenis konten (dari 3: materi/video/latihan) yang udah keisi per topik — data real, bukan karangan
        $topicContentCounts = $grouped->map(fn ($group) => $group->count())->toArray();

        // Topik mana aja yang udah difavoritkan user ini (favorite tipe "topic", bukan "material")
        $favoriteTopicNames = Favorite::where('user_id', auth()->id())
            ->where('type', 'topic')
            ->where('subject_id', $subject->id)
            ->pluck('topic_name')
            ->toArray();

        return view('subjects.show', compact('subject', 'topics', 'topicContentCounts', 'favoriteTopicNames'));
    }

    public function showTopic(Subject $subject, $topic)
    {
        $materials = $subject->materials()->where('title', $topic)->get()->keyBy('type');

        // Favorite tipe "material" — dipake di card Materi/Video/Latihan
        $favoriteIds = Favorite::where('user_id', auth()->id())
            ->where('type', 'material')
            ->pluck('material_id')
            ->toArray();

        return view('subjects.topic', compact('subject', 'topic', 'materials', 'favoriteIds'));
    }

    public function showMaterial(Material $material)
    {
        $isFavorited = false;

        if (auth()->check()) {
            $isFavorited = \DB::table('favorites')
                ->where('user_id', auth()->id())
                ->where('material_id', $material->id)
                ->exists();
        }

        return view('materials.show', compact('material', 'isFavorited'));
    }

    public function download($material)
    {
        $material = Material::findOrFail($material);
        if (!$material->file_path) {
            abort(404);
        }
        return Storage::disk('public')->download($material->file_path, $material->title . '.pdf');
    }
}