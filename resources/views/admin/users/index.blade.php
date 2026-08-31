@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-xl font-semibold mb-4">User Management</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="space-y-2">
        @foreach ($users as $user)
            <div class="flex justify-between items-center border rounded p-3">
                <div>
                    <span>{{ $user->name }}</span>
                    <span class="text-sm text-gray-500">{{ $user->email }}</span>
                </div>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection