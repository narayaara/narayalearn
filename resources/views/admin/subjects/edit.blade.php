@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h1 class="text-xl font-semibold mb-4">Edit Subject</h1>
    <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        <label class="block mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $subject->name) }}" class="w-full border rounded p-2 mb-2">
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">Save changes</button>
    </form>
</div>
@endsection