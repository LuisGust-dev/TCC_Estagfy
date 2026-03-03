@extends('admin.layout')

@section('title', 'Dashboard | Admin EstagFy')

@section('content')
    <div class="bg-white border rounded-3xl p-8 md:p-10 shadow-sm mb-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Painel Administrativo</p>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Dashboard do Admin</h1>
                <p class="text-gray-600 mt-2">Visao geral do sistema e indicadores principais</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-lg">
                    🛡️
                </div>
                <div class="text-sm text-gray-600">
                    <p class="font-medium text-gray-900">Controle total</p>
                    <p>Usuarios, empresas e alunos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="relative overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-white via-blue-50/60 to-blue-100/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-blue-200/40"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Indicador</p>
                    <p class="text-sm text-gray-600 mt-1">Total de usuarios</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-lg shadow-sm ring-1 ring-blue-100">👥</span>
            </div>
            <p class="relative mt-6 text-4xl font-black text-gray-900">{{ $totalUsers }}</p>
            <p class="relative mt-2 text-xs font-medium text-blue-800">Base completa do sistema</p>
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-emerald-100 bg-gradient-to-br from-white via-emerald-50/70 to-emerald-100/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-emerald-200/40"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Indicador</p>
                    <p class="text-sm text-gray-600 mt-1">Total de alunos</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-lg shadow-sm ring-1 ring-emerald-100">🎓</span>
            </div>
            <p class="relative mt-6 text-4xl font-black text-gray-900">{{ $totalStudents }}</p>
            <p class="relative mt-2 text-xs font-medium text-emerald-800">Perfis de estudantes ativos</p>
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-amber-100 bg-gradient-to-br from-white via-amber-50/70 to-amber-100/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-amber-200/40"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Indicador</p>
                    <p class="text-sm text-gray-600 mt-1">Total de empresas</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-lg shadow-sm ring-1 ring-amber-100">🏢</span>
            </div>
            <p class="relative mt-6 text-4xl font-black text-gray-900">{{ $totalCompanies }}</p>
            <p class="relative mt-2 text-xs font-medium text-amber-800">Parceiros cadastrados</p>
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-indigo-100 bg-gradient-to-br from-white via-indigo-50/70 to-indigo-100/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-indigo-200/40"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Indicador</p>
                    <p class="text-sm text-gray-600 mt-1">Vagas publicadas</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-lg shadow-sm ring-1 ring-indigo-100">📌</span>
            </div>
            <p class="relative mt-6 text-4xl font-black text-gray-900">{{ $totalJobs }}</p>
            <p class="relative mt-2 text-xs font-medium text-indigo-800">Oportunidades ativas</p>
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-br from-white via-rose-50/70 to-rose-100/70 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-rose-200/40"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-rose-700">Indicador</p>
                    <p class="text-sm text-gray-600 mt-1">Candidaturas</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-lg shadow-sm ring-1 ring-rose-100">📝</span>
            </div>
            <p class="relative mt-6 text-4xl font-black text-gray-900">{{ $totalApplications }}</p>
            <p class="relative mt-2 text-xs font-medium text-rose-800">Processos em andamento</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <div class="bg-white rounded-2xl border p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Distribuição por perfil</h2>
            <p class="text-sm text-gray-500 mt-1">Participação de usuários por papel no sistema</p>

            @php
                $totalRoleCount = collect($roleDistribution)->sum('count');
            @endphp

            <div class="mt-5 space-y-4">
                @foreach($roleDistribution as $item)
                    @php
                        $percent = $totalRoleCount > 0 ? round(($item['count'] / $totalRoleCount) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <p class="text-gray-700 font-medium">{{ $item['label'] }}</p>
                            <p class="text-gray-600">{{ $item['count'] }} ({{ $percent }}%)</p>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $item['color'] }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Status das candidaturas</h2>
            <p class="text-sm text-gray-500 mt-1">Volume por etapa do processo seletivo</p>

            @php
                $totalStatusCount = collect($applicationStatus)->sum('count');
            @endphp

            <div class="mt-5 space-y-4">
                @foreach($applicationStatus as $item)
                    @php
                        $percent = $totalStatusCount > 0 ? round(($item['count'] / $totalStatusCount) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <p class="text-gray-700 font-medium">{{ $item['label'] }}</p>
                            <p class="text-gray-600">{{ $item['count'] }} ({{ $percent }}%)</p>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $item['color'] }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6 shadow-sm mt-6">
        <h2 class="text-lg font-semibold text-gray-900">Novos usuários por mês (últimos 6 meses)</h2>
        <p class="text-sm text-gray-500 mt-1">Evolução de cadastros para acompanhamento gerencial</p>

        @php
            $maxValue = max($monthlyValues ?: [1]);
        @endphp

        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($monthlyValues as $index => $value)
                @php
                    $height = $maxValue > 0 ? max(12, round(($value / $maxValue) * 160)) : 12;
                @endphp
                <div class="rounded-xl border bg-gray-50 p-3">
                    <div class="h-44 flex items-end justify-center">
                        <div class="w-12 rounded-t-lg bg-blue-500" style="height: {{ $height }}px"></div>
                    </div>
                    <p class="text-xs text-center text-gray-500 mt-2">{{ $monthlyLabels[$index] }}</p>
                    <p class="text-center font-semibold text-gray-900">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
