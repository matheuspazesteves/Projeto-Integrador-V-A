@extends('layouts.tailwind')

@section('title','Contacts')

@section('content')
<div class="bg-white shadow rounded p-4">
    @if($contacts->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 px-3">ID</th>
                        <th class="py-2 px-3">Name</th>
                        <th class="py-2 px-3">Email</th>
                        <th class="py-2 px-3">Phone</th>
                        <th class="py-2 px-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">{{ $contact->id }}</td>
                            <td class="py-2 px-3">{{ $contact->name }}</td>
                            <td class="py-2 px-3">{{ $contact->email }}</td>
                            <td class="py-2 px-3">{{ $contact->phone }}</td>
                            <td class="py-2 px-3">
                                <a href="{{ route('contacts.show', $contact) }}" class="text-indigo-600 hover:underline">View</a>
                                <span class="text-gray-400 mx-1">|</span>
                                <a href="{{ route('contacts.edit', $contact) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <span class="text-gray-400 mx-1">|</span>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this contact?')" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    @else
        <p class="text-center py-8">No contacts found. <a href="{{ route('contacts.create') }}" class="text-indigo-600 hover:underline">Create one</a>.</p>
    @endif
</div>
@endsection
