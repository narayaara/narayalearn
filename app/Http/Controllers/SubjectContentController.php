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
        $subjects = Subject::all()->map(function ($subject) {
            $subject->topics_count = $subject->materials()
                ->distinct()
                ->pluck('title')
                ->count();
            return $subject;
        });

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Halaman detail subject — tampilkan daftar topik.
     */
    public function show(Subject $subject)
    {
        $grouped = $subject->materials()->get()->groupBy('title');

        // Tiap topik diwakilin 1 material (prioritas: "material")
        $topics = $grouped->map(function ($group) {
            return $group->firstWhere('type', 'material') ?? $group->first();
        });

        $favoriteIds = auth()->check()
            ? Favorite::where('user_id', auth()->id())->pluck('material_id')->toArray()
            : [];

        return view('subjects.show', compact('subject', 'topics', 'favoriteIds'));
    }

    /**
     * Halaman detail topik — tampilkan materi, video, latihan.
     */
    public function showTopic(Subject $subject, $topic)
    {
        $materials = $subject->materials()
            ->where('title', $topic)
            ->get()
            ->keyBy('type');

        $favoriteIds = auth()->check()
            ? Favorite::where('user_id', auth()->id())
                ->where('type', 'material')
                ->pluck('material_id')
                ->toArray()
            : [];

        $isTopicFavorited = auth()->check()
            ? Favorite::where('user_id', auth()->id())
                ->where('subject_id', $subject->id)
                ->where('topic_name', $topic)
                ->where('type', 'topic')
                ->exists()
            : false;

        return view('subjects.topic', compact(
            'subject',
            'topic',
            'materials',
            'favoriteIds',
            'isTopicFavorited'
        ));
    }

    /**
     * Halaman detail material (PDF, video, gambar).
     */
    public function showMaterial(Material $material)
    {
        $material->load('subject');

        $isFavorited = auth()->check()
            ? Favorite::where('user_id', auth()->id())
                ->where('material_id', $material->id)
                ->where('type', 'material')
                ->exists()
            : false;

        return view('materials.show', compact('material', 'isFavorited'));
    }

    /**
     * Download file material.
     */
    public function download($material)
    {
        $material = Material::findOrFail($material);

        if (!$material->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $material->file_path,
            $material->title . '.pdf'
        );
    }
}