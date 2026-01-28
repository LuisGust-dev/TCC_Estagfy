@extends('admin.layout')

@section('title', 'Usuarios | Admin EstagFy')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Usuarios</h1>
            <p class="text-gray-600">Gestao e status dos usuarios do sistema</p>
        </div>

        <div class="flex flex-wrap gap-2 text-sm">
            <a href="{{ route('admin.users.index') }}"
               class="px-3 py-2 rounded-lg border {{ empty($role) ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
                Todos
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'student']) }}"
               class="px-3 py-2 rounded-lg border {{ $role === 'student' ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                Alunos
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'company']) }}"
               class="px-3 py-2 rounded-lg border {{ $role === 'company' ? 'bg-emerald-600 text-white border-emerald-600' : 'text-gray-600 hover:bg-gray-100' }}">
                Empresas
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
               class="px-3 py-2 rounded-lg border {{ $role === 'admin' ? 'bg-indigo-600 text-white border-indigo-600' : 'text-gray-600 hover:bg-gray-100' }}">
                Admin
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Nome</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Perfil</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 font-semibold">Cadastro</th>
                        <th class="text-right px-6 py-3 font-semibold">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-600 capitalize">{{ $user->role }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $user->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->created_at?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-sm font-medium {{ $user->active ? 'text-red-600 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                        {{ $user->active ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                Nenhum usuario encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
