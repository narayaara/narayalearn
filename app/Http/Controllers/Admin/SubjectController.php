<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::withCount('materials')->latest()->get();
        return view('admin.subjects.index', compact('subjects'));
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

        return redirect()->route('admin.subjects.index')->with('success', 'Subject successfully added.');
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
            'name.unique' => 'This subject name is already taken.',
            'name.required' => 'Subject name is required.',
            'name.max' => 'Subject name may not be greater than 128 characters.',
        ]);

        $subject->update($request->only('name'));

        return redirect()->route('admin.subjects.index')->with('success', 'Subject successfully updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Subject successfully deleted.');
    }
}