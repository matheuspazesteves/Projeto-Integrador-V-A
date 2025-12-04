@extends('layouts.tailwind')

@section('title','Lista de Contatos')

@section('content')
<div class="bg-white shadow rounded p-4">
    @if($contacts->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 px-3">ID</th>
                        <th class="py-2 px-3">Nome</th>
                        <th class="py-2 px-3">E-mail</th>
                        <th class="py-2 px-3">Telefone</th>
                        <th class="py-2 px-3">Ações</th>
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
                                <a href="{{ route('contacts.show', $contact) }}" class="text-indigo-600 hover:underline">Ver</a>
                                <span class="text-gray-400 mx-1">|</span>
                                <a href="{{ route('contacts.edit', $contact) }}" class="text-yellow-600 hover:underline">Editar</a>
                                <span class="text-gray-400 mx-1">|</span>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Deseja excluir este contato?')" class="text-red-600 hover:underline">
                                        Excluir
                                    </button>
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
        <p class="text-center py-8">
            Nenhum contato encontrado.
            <a href="{{ route('contacts.create') }}" class="text-indigo-600 hover:underline">Criar novo</a>.
        </p>
    @endif
</div>
@endsection
