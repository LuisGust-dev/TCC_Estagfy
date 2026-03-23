@extends('admin.layout')

@section('title', 'Usuários | Admin EstagFy')

@section('content')
    @php
        $roleLabels = [
            'student' => 'Aluno',
            'company' => 'Empresa',
            'admin' => 'Administrador',
            'coordinator' => 'Coordenador',
        ];
        $roleAccentClasses = [
            'student' => [
                'iconWrap' => 'bg-blue-50 text-blue-600',
                'active' => 'bg-blue-50/70',
                'ring' => 'ring-1 ring-blue-100',
                'count' => 'bg-blue-100 text-blue-700',
            ],
            'company' => [
                'iconWrap' => 'bg-emerald-50 text-emerald-600',
                'active' => 'bg-emerald-50/70',
                'ring' => 'ring-1 ring-emerald-100',
                'count' => 'bg-emerald-100 text-emerald-700',
            ],
            'admin' => [
                'iconWrap' => 'bg-indigo-50 text-indigo-600',
                'active' => 'bg-indigo-50/70',
                'ring' => 'ring-1 ring-indigo-100',
                'count' => 'bg-indigo-100 text-indigo-700',
            ],
            'coordinator' => [
                'iconWrap' => 'bg-amber-50 text-amber-600',
                'active' => 'bg-amber-50/70',
                'ring' => 'ring-1 ring-amber-100',
                'count' => 'bg-amber-100 text-amber-700',
            ],
        ];
    @endphp
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Usuários</h1>
            <p class="text-gray-600">Organize a gestão por categoria de perfil</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 text-sm">
            <a href="{{ route('admin.users.index') }}"
               class="px-3 py-2 rounded-lg border {{ empty($role) ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
                Categorias
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

    <div class="mb-6 rounded-2xl border bg-white shadow-sm">
        <div class="grid grid-cols-1 divide-y sm:grid-cols-2 sm:divide-y-0 sm:divide-x lg:grid-cols-4">
            @foreach($roleLabels as $roleKey => $label)
                @php
                    $accent = $roleAccentClasses[$roleKey];
                @endphp
                <a href="{{ route('admin.users.index', ['role' => $roleKey]) }}"
                   class="group flex items-center justify-between gap-4 px-5 py-4 transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-slate-50 {{ $role === $roleKey ? $accent['active'] . ' ' . $accent['ring'] : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl transition-transform duration-200 group-hover:scale-105 {{ $accent['iconWrap'] }}">
                            @if($roleKey === 'student')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14 3 9l9-5 9 5-9 5Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V15c0 .8 2.2 2 5 2s5-1.2 5-2v-3.5"/>
                                </svg>
                            @elseif($roleKey === 'company')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h16"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 20V7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v13"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 10h2m2 0h2M9 14h2m2 0h2"/>
                                </svg>
                            @elseif($roleKey === 'admin')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-3 7.6-7 9-4-1.4-7-4.5-7-9V7l7-4Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12 11 13.5 14.5 10"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8h3m-1.5-1.5v3"/>
                                </svg>
                            @endif
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                            <p class="text-xs text-gray-500 transition-colors duration-200 group-hover:text-gray-700">Abrir categoria</p>
                        </div>
                    </div>
                    <span class="inline-flex min-w-10 justify-center rounded-full px-3 py-1 text-xs font-semibold transition-transform duration-200 group-hover:scale-105 {{ $role === $roleKey ? $accent['count'] : 'bg-gray-100 text-gray-700' }}">
                        {{ $categoryCounts[$roleKey] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    @if($role)
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="q" value="{{ $search ?? '' }}"
                       placeholder="Pesquisar por nome ou e-mail..."
                       class="w-full sm:max-w-md rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                    Buscar
                </button>
                <a href="{{ route('admin.users.index', ['role' => $role]) }}"
                   class="px-4 py-2 rounded-lg border text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Limpar
                </a>
            </div>
        </form>

        <div class="bg-white rounded-2xl border shadow-sm overflow-visible">
            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">{{ $roleLabels[$role] }}</h2>
            </div>
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
                                <td class="px-6 py-4 text-gray-600">{{ $roleLabels[$user->role] ?? ucfirst($user->role) }}</td>
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
                                    Nenhum usuário encontrado nesta categoria.
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
    @else
        <div class="rounded-2xl border bg-white px-6 py-8 text-center text-sm text-gray-600 shadow-sm">
            Selecione uma categoria acima para visualizar os usuários de forma organizada.
        </div>
    @endif

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
