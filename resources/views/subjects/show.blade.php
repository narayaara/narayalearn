@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8" x-data="{ tab: 'materi' }">
    <h1 class="text-xl font-semibold mb-4">{{ $subject->name }}</h1>

    <div class="flex gap-4 border-b mb-4">
        <button @click="tab = 'materi'" :class="tab === 'materi' ? 'border-b-2 border-indigo-600 text-indigo-600' : ''" class="pb-2">Materials</button>
        <button @click="tab = 'video'" :class="tab === 'video' ? 'border-b-2 border-indigo-600 text-indigo-600' : ''" class="pb-2">Video</button>
        <button @click="tab = 'latihan'" :class="tab === 'latihan' ? 'border-b-2 border-indigo-600 text-indigo-600' : ''" class="pb-2">Exercises</button>
    </div>

    @foreach (['materi', 'video', 'latihan'] as $type)
        <div x-show="tab === '{{ $type }}'" class="space-y-2">
            @forelse ($materials->get($type, []) as $material)
                <a href="{{ route('materials.show', $material) }}" class="block border rounded p-3 hover:bg-gray-50">
                    {{ $material->title }}
                </a>
            @empty
                <p class="text-sm text-gray-500">No content yet.</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection