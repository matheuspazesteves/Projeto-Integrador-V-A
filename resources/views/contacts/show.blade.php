@extends('layouts.tailwind')

@section('title','Contact Details')

@section('content')
<div class="bg-white shadow rounded p-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold">{{ $contact->name }}</h2>
            <p class="text-sm text-gray-500">ID: {{ $contact->id }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('contacts.edit', $contact) }}" class="inline-block px-3 py-2 bg-yellow-400 rounded">Edit</a>
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete this contact?')" class="px-3 py-2 bg-red-500 text-white rounded">Delete</button>
            </form>
        </div>
    </div>

    <div class="mt-6 space-y-2">
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Phone:</strong> {{ $contact->phone ?? '—' }}</p>
        <p><strong>Created:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('contacts.index') }}" class="text-indigo-600 hover:underline">← Back to list</a>
    </div>
</div>
@endsection
