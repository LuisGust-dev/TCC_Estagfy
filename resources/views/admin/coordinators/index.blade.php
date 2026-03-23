@extends('admin.layout')

@section('title', 'Coordenadores | Admin EstagFy')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Coordenadores</h1>
            <p class="text-gray-600">Gestão dos coordenadores cadastrados</p>
        </div>
        <a href="{{ route('admin.users.create', ['role' => 'coordinator', 'redirect_to' => request()->fullUrl()]) }}"
           class="inline-flex items-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700">
            Novo coordenador
        </a>
    </div>

    <form method="GET" action="{{ route('admin.coordinators.index') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $search ?? '' }}"
                   placeholder="Pesquisar por nome ou e-mail..."
                   class="w-full sm:max-w-md rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('admin.coordinators.index') }}"
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
                    @forelse($coordinators as $coordinator)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $coordinator->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $coordinator->email }}</td>
                            <td class="px-6 py-4 text-gray-600">Coordenador</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $coordinator->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $coordinator->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $coordinator->created_at?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative inline-flex justify-end text-left" data-admin-actions>
                                    <button type="button"
                                            class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                                            data-admin-actions-button>
                                        Ações
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                                    </button>
                                    <div class="fixed z-[60] hidden w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg"
                                         data-admin-actions-menu>
                                        <a href="{{ route('admin.users.edit', ['user' => $coordinator, 'redirect_to' => request()->fullUrl()]) }}"
                                           class="block rounded-md px-3 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.toggle', $coordinator) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <button type="submit"
                                                    class="block w-full rounded-md px-3 py-2 text-left text-sm {{ $coordinator->active ? 'text-amber-700' : 'text-emerald-700' }} hover:bg-gray-100">
                                                {{ $coordinator->active ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $coordinator) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este coordenador?');">
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
                                Nenhum coordenador encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $coordinators->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdowns = document.querySelectorAll('[data-admin-actions]');

            const closeAll = () => {
                dropdowns.forEach((dropdown) => {
                    const menu = dropdown.querySelector('[data-admin-actions-menu]');
                    if (!menu) return;
                    menu.classList.add('hidden');
                    menu.style.top = '';
                    menu.style.left = '';
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
                    if (!willOpen) return;

                    menu.classList.remove('hidden');
                    menu.style.visibility = 'hidden';

                    const buttonRect = button.getBoundingClientRect();
                    const menuRect = menu.getBoundingClientRect();
                    const spacing = 8;
                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    let left = buttonRect.right - menuRect.width;
                    left = Math.max(12, Math.min(left, viewportWidth - menuRect.width - 12));

                    let top = buttonRect.bottom + spacing;
                    if (top + menuRect.height > viewportHeight - 12) {
                        top = buttonRect.top - menuRect.height - spacing;
                    }
                    top = Math.max(12, top);

                    menu.style.left = `${left}px`;
                    menu.style.top = `${top}px`;
                    menu.style.visibility = '';
                });
            });

            document.addEventListener('click', closeAll);
            window.addEventListener('resize', closeAll);
            window.addEventListener('scroll', closeAll, true);
        });
    </script>
@endsection
