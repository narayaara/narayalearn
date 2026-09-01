<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class SubjectContentController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount('materials')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
        $materials = $subject->materials()->get()->groupBy('type');
        return view('subjects.show', compact('subject', 'materials'));
    }

    public function showMaterial(Material $material)
    {
        $material->load(['comments.user', 'subject']);
        $isFavorited = auth()->check()
            ? $material->favoritedBy()->where('user_id', auth()->id())->exists()
            : false;

        return view('materials.show', compact('material', 'isFavorited'));
    }

    public function download(Material $material)
    {
        if (!$material->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($material->file_path, $material->title . '.pdf');
    }
}