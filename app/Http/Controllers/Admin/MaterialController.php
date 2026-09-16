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
            'type' => 'required|in:material,video,exercise',
            'source_type' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'youtube_url' => 'nullable|url',
        ]);

        $data = $request->only('subject_id', 'title', 'type');

        // Kalo pilih file
        if ($request->source_type === 'file' && $request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        // Kalo pilih link
        if ($request->source_type === 'link' && $request->filled('youtube_url')) {
            $data['youtube_url'] = $request->youtube_url;
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
            'type' => 'required|in:material,video,exercise',
            'source_type' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'youtube_url' => 'nullable|url',
        ]);

        $data = $request->only('subject_id', 'title', 'type');

        if ($request->source_type === 'file' && $request->hasFile('file')) {
            // Hapus file lama
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
            $data['youtube_url'] = null;
        }

        if ($request->source_type === 'link' && $request->filled('youtube_url')) {
            // Hapus file lama kalo ada
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['youtube_url'] = $request->youtube_url;
            $data['file_path'] = null;
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