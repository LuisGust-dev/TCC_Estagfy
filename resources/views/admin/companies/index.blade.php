@extends('admin.layout')

@section('title', 'Empresas | Admin EstagFy')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Empresas</h1>
        <p class="text-gray-600">Gestão das empresas cadastradas</p>
    </div>

    <form method="GET" action="{{ route('admin.companies.index') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="{{ $search ?? '' }}"
                   placeholder="Pesquisar por empresa, e-mail, CNPJ ou telefone..."
                   class="w-full sm:max-w-md rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('admin.companies.index') }}"
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
                        <th class="text-left px-6 py-3 font-semibold">Empresa</th>
                        <th class="text-left px-6 py-3 font-semibold">CNPJ</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Telefone</th>
                        <th class="text-left px-6 py-3 font-semibold">Descrição</th>
                        <th class="text-left px-6 py-3 font-semibold">Vagas</th>
                        <th class="text-left px-6 py-3 font-semibold">Candidatos</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-right px-6 py-3 font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($companies as $company)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $company->user?->name ?? 'Empresa' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->cnpj ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->user?->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->description ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->jobs_count }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->applications_count }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $company->user?->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $company->user?->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($company->user)
                                    <details class="relative inline-block text-left">
                                        <summary class="list-none cursor-pointer px-4 py-2 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-200">
                                            <span class="inline-flex items-center gap-1">Ações
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                                            </span>
                                        </summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg">
                                            <a href="{{ route('admin.users.edit', ['user' => $company->user, 'redirect_to' => request()->fullUrl()]) }}"
                                               class="block rounded-md px-3 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.toggle', $company->user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                                <button type="submit"
                                                        class="block w-full rounded-md px-3 py-2 text-left text-sm {{ $company->user->active ? 'text-amber-700' : 'text-emerald-700' }} hover:bg-gray-100">
                                                    {{ $company->user->active ? 'Desativar' : 'Ativar' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.destroy', $company->user) }}"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta empresa?');">
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
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-6 text-center text-gray-500">
                                Nenhuma empresa encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $companies->links() }}
    </div>
@endsection
