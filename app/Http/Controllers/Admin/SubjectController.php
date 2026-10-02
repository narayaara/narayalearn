<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Material;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount('materials')->latest()->get();

        // Statistik
        $totalSubjects = $subjects->count();
        $totalTopics = Material::distinct()->pluck('title')->count();
        $totalMaterials = Material::count();

        return view('admin.subjects.index', compact(
            'subjects',
            'totalSubjects',
            'totalTopics',
            'totalMaterials'
        ));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:128|unique:subjects,name',
        ], [
            'name.unique' => 'Mata pelajaran ini sudah ada.',
            'name.required' => 'Nama mata pelajaran wajib diisi.',
            'name.max' => 'Nama maksimal 128 karakter.',
        ]);

        Subject::create($request->only('name'));

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject berhasil ditambahkan!');
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:128|unique:subjects,name,' . $subject->id,
        ], [
            'name.unique' => 'Nama mata pelajaran ini sudah dipakai.',
            'name.required' => 'Nama mata pelajaran wajib diisi.',
            'name.max' => 'Nama maksimal 128 karakter.',
        ]);

        $subject->update($request->only('name'));

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject berhasil diperbarui!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject berhasil dihapus!');
    }
}