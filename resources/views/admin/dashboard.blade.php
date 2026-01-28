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
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Total de usuarios</p>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">👥</span>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mt-4">{{ $totalUsers }}</p>
            <p class="text-xs text-gray-500 mt-1">Base completa do sistema</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Total de alunos</p>
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">🎓</span>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mt-4">{{ $totalStudents }}</p>
            <p class="text-xs text-gray-500 mt-1">Perfis de estudantes ativos</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Total de empresas</p>
                <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">🏢</span>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mt-4">{{ $totalCompanies }}</p>
            <p class="text-xs text-gray-500 mt-1">Parceiros cadastrados</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Vagas publicadas</p>
                <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">📌</span>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mt-4">{{ $totalJobs }}</p>
            <p class="text-xs text-gray-500 mt-1">Oportunidades ativas</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Candidaturas</p>
                <span class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">📝</span>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mt-4">{{ $totalApplications }}</p>
            <p class="text-xs text-gray-500 mt-1">Processos em andamento</p>
        </div>
    </div>
@endsection
