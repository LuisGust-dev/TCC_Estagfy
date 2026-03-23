@extends('admin.layout')

@section('title', 'Relatórios | Admin EstagFy')

@section('content')
    @php
        $roleLabels = [
            'student' => 'Aluno',
            'company' => 'Empresa',
            'admin' => 'Administrador',
            'coordinator' => 'Coordenador',
        ];
    @endphp
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Relatórios</h1>
            <p class="text-gray-600">Filtros gerenciais e exportação em CSV</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.reports.index') }}" class="bg-white border rounded-2xl p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">De</label>
                <input type="date" name="from" value="{{ $filters['from_input'] }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Até</label>
                <input type="date" name="to" value="{{ $filters['to_input'] }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Perfil</label>
                <select name="role" class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="student" @selected($filters['role'] === 'student')>Aluno</option>
                    <option value="company" @selected($filters['role'] === 'company')>Empresa</option>
                    <option value="admin" @selected($filters['role'] === 'admin')>Administrador</option>
                    <option value="coordinator" @selected($filters['role'] === 'coordinator')>Coordenador</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Status candidatura</label>
                <select name="status" class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="em_analise" @selected($filters['status'] === 'em_analise')>Em análise</option>
                    <option value="aprovado" @selected($filters['status'] === 'aprovado')>Aprovado</option>
                    <option value="recusado" @selected($filters['status'] === 'recusado')>Recusado</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Status usuário</label>
                <select name="active" class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="1" @selected($filters['active'] === true)>Ativo</option>
                    <option value="0" @selected($filters['active'] === false)>Inativo</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-2">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Aplicar filtros
            </button>
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded-lg border text-sm font-medium text-gray-700 hover:bg-gray-100">
                Limpar
            </a>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Usuários filtrados</p>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $summary['users'] }}</p>
        </div>
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Empresas filtradas</p>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $summary['companies'] }}</p>
        </div>
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Candidaturas filtradas</p>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $summary['applications'] }}</p>
        </div>
    </div>

    <div class="bg-white border rounded-2xl p-5 mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Exportação</h2>
        <p class="text-sm text-gray-600 mt-1">Os arquivos respeitam os filtros aplicados.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.reports.users.csv', request()->query()) }}"
               class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800">
                Exportar usuários (CSV)
            </a>
            <a href="{{ route('admin.reports.companies.csv', request()->query()) }}"
               class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">
                Exportar empresas (CSV)
            </a>
            <a href="{{ route('admin.reports.applications.csv', request()->query()) }}"
               class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                Exportar candidaturas (CSV)
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="font-semibold text-gray-900">Últimos usuários</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-semibold">Nome</th>
                            <th class="text-left px-4 py-2 font-semibold">Perfil</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $roleLabels[$user->role] ?? ucfirst($user->role) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-4 text-gray-500">Sem dados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="font-semibold text-gray-900">Últimas empresas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-semibold">Empresa</th>
                            <th class="text-left px-4 py-2 font-semibold">Vagas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($companies as $company)
                            <tr>
                                <td class="px-4 py-2">{{ data_get($company, 'user.name', 'Empresa') }}</td>
                                <td class="px-4 py-2">{{ $company->jobs_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-4 text-gray-500">Sem dados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="font-semibold text-gray-900">Últimas candidaturas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-semibold">Aluno</th>
                            <th class="text-left px-4 py-2 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($applications as $application)
                            <tr>
                                <td class="px-4 py-2">{{ data_get($application, 'student.name', 'Aluno') }}</td>
                                <td class="px-4 py-2">{{ $application->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-4 py-4 text-gray-500">Sem dados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
