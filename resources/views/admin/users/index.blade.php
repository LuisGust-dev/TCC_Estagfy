@extends('admin.layout')

@section('title', 'Usuários | Admin EstagFy')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Usuários</h1>
            <p class="text-gray-600">Gestão e status dos usuários do sistema</p>
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
            <a href="{{ route('admin.users.index', ['role' => 'coordinator']) }}"
               class="px-3 py-2 rounded-lg border {{ $role === 'coordinator' ? 'bg-amber-600 text-white border-amber-600' : 'text-gray-600 hover:bg-gray-100' }}">
                Coordenadores
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-visible">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Nome</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Perfil</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 font-semibold">Cadastro</th>
                        <th class="text-right px-6 py-3 font-semibold">Ações</th>
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
                                <details class="relative inline-block text-left">
                                    <summary class="list-none cursor-pointer px-4 py-2 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-200">
                                            <span class="inline-flex items-center gap-1">Ações
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                                            </span>
                                        </summary>
                                    <div class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg">
                                        <a href="{{ route('admin.users.edit', ['user' => $user, 'redirect_to' => request()->fullUrl()]) }}"
                                           class="block rounded-md px-3 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <button type="submit"
                                                    class="block w-full rounded-md px-3 py-2 text-left text-sm {{ $user->active ? 'text-amber-700' : 'text-emerald-700' }} hover:bg-gray-100">
                                                {{ $user->active ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <button type="submit"
                                                    class="block w-full rounded-md px-3 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                Nenhum usuário encontrado.
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
