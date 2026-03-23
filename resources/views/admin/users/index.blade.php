@extends('admin.layout')

@section('title', 'Usuários | Admin EstagFy')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Usuários</h1>
            <p class="text-gray-600">Gestão e status dos usuários do sistema</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 text-sm">
            <a href="{{ route('admin.users.create', ['redirect_to' => request()->fullUrl()]) }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                Novo usuário
            </a>
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

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
        @if(!empty($role))
            <input type="hidden" name="role" value="{{ $role }}">
        @endif
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $search ?? '' }}"
                   placeholder="Pesquisar por nome ou e-mail..."
                   class="w-full sm:max-w-md rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('admin.users.index', array_filter(['role' => $role])) }}"
               class="px-4 py-2 rounded-lg border text-sm font-medium text-gray-700 hover:bg-gray-100">
                Limpar
            </a>
        </div>
    </form>

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
                                <div class="relative inline-flex justify-end text-left" data-admin-actions>
                                    <button type="button"
                                            class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                                            data-admin-actions-button>
                                        Ações
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                                    </button>
                                    <div class="absolute right-0 top-full z-20 mt-2 hidden w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg"
                                         data-admin-actions-menu>
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
                                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdowns = document.querySelectorAll('[data-admin-actions]');

            const closeAll = () => {
                dropdowns.forEach((dropdown) => {
                    dropdown.querySelector('[data-admin-actions-menu]')?.classList.add('hidden');
                });
            };

            dropdowns.forEach((dropdown) => {
                const button = dropdown.querySelector('[data-admin-actions-button]');
                const menu = dropdown.querySelector('[data-admin-actions-menu]');

                if (!button || !menu) return;

                button.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const willOpen = menu.classList.contains('hidden');
                    closeAll();
                    menu.classList.toggle('hidden', !willOpen);
                });
            });

            document.addEventListener('click', closeAll);
        });
    </script>
@endsection
