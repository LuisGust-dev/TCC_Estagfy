@extends('admin.layout')

@section('title', 'Empresas | Admin EstagFy')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Empresas</h1>
        <p class="text-gray-600">Gestao das empresas cadastradas</p>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Empresa</th>
                        <th class="text-left px-6 py-3 font-semibold">CNPJ</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Telefone</th>
                        <th class="text-left px-6 py-3 font-semibold">Descricao</th>
                        <th class="text-left px-6 py-3 font-semibold">Vagas</th>
                        <th class="text-left px-6 py-3 font-semibold">Candidatos</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-right px-6 py-3 font-semibold">Acoes</th>
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
                                    <form method="POST" action="{{ route('admin.users.toggle', $company->user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-sm font-medium {{ $company->user->active ? 'text-red-600 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                            {{ $company->user->active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
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
