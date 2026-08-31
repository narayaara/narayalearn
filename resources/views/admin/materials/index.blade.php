@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Material Management</h1>
        <a href="{{ route('admin.materials.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Material</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="space-y-2">
        @foreach ($materials as $material)
            <div class="flex justify-between items-center border rounded p-3">
                <div>
                    <span>{{ $material->title }}</span>
                    <span class="text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $material->type }}</span>
                    <span class="text-sm text-gray-500">{{ $material->subject->name }}</span>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('admin.materials.edit', $material) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Delete this material?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection