@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-xl font-semibold mb-4">Subjects</h1>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($subjects as $subject)
            <a href="{{ route('subjects.show', $subject) }}" class="border rounded p-4 hover:bg-gray-50">
                <p class="font-medium">{{ $subject->name }}</p>
                <p class="text-sm text-gray-500">{{ $subject->materials_count }} contents</p>
            </a>
        @endforeach
    </div>
</div>
@endsection