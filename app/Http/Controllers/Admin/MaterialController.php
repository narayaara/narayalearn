<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('subject')->latest()->get();
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.materials.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:128',
            'type' => 'required|in:materi,video,latihan',
            'file' => 'required_if:type,materi,latihan|file|mimes:pdf|max:5120',
            'youtube_url' => 'required_if:type,video|nullable|url',
        ]);

        $data = $request->only('subject_id', 'title', 'type', 'youtube_url');

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        Material::create($data);

        return redirect()->route('admin.materials.index')->with('success', 'Material berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        $subjects = Subject::all();
        return view('admin.materials.edit', compact('material', 'subjects'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:128',
            'type' => 'required|in:materi,video,latihan',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'youtube_url' => 'nullable|url',
        ]);

        $data = $request->only('subject_id', 'title', 'type', 'youtube_url');

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update($data);

        return redirect()->route('admin.materials.index')->with('success', 'Material berhasil diubah.');
    }

    public function destroy(Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Material berhasil dihapus.');
    }
}