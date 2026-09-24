<?php

namespace App\Http\Controllers;

use App\Models\Subject;
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
        // Ambil daftar topik unik (title yang sama dipakai 3x: materi/video/latihan)
        $topics = $subject->materials()->select('title')->distinct()->pluck('title');
        return view('subjects.show', compact('subject', 'topics'));
    }

    public function showTopic(Subject $subject, $topic)
    {
        $materials = $subject->materials()->where('title', $topic)->get()->keyBy('type');
        return view('subjects.topic', compact('subject', 'topic', 'materials'));
    }

    public function download($material)
    {
        $material = \App\Models\Material::findOrFail($material);
        if (!$material->file_path) {
            abort(404);
        }
        return Storage::disk('public')->download($material->file_path, $material->title . '.pdf');
    }
}