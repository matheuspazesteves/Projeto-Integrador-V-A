@extends('layouts.tailwind')

@section('title','Edit Contact')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-lg font-semibold mb-4">Edit Contact</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contacts.update', $contact) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $contact->name) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $contact->email) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="flex items-center space-x-2">
            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update</button>
            <a href="{{ route('contacts.index') }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
