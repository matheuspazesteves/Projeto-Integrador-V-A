@extends('layouts.tailwind')

@section('title','Editar Contato')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-lg font-semibold mb-4">Editar Contato</h2>

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
            <label class="block text-sm font-medium">Nome</label>
            <input type="text" name="name" value="{{ old('name', $contact->name) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium">E-mail</label>
            <input type="email" name="email" value="{{ old('email', $contact->email) }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium">Telefone</label>
            <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="flex items-center space-x-2">
            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Atualizar</button>
            <a href="{{ route('contacts.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
