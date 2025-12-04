@extends('layouts.tailwind')

@section('title','Detalhes do Contato')

@section('content')
<div class="bg-white shadow rounded p-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold">{{ $contact->name }}</h2>
            <p class="text-sm text-gray-500">ID: {{ $contact->id }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('contacts.edit', $contact) }}" class="inline-block px-3 py-2 bg-yellow-400 rounded">Editar</a>
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Deseja excluir este contato?')" class="px-3 py-2 bg-red-500 text-white rounded">
                    Excluir
                </button>
            </form>
        </div>
    </div>

    <div class="mt-6 space-y-2">
        <p><strong>E-mail:</strong> {{ $contact->email }}</p>
        <p><strong>Telefone:</strong> {{ $contact->phone ?? '—' }}</p>
        <p><strong>Cadastrado em:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('contacts.index') }}" class="text-indigo-600 hover:underline">← Voltar</a>
    </div>
</div>
@endsection
