@extends('company.layout')

@section('title', 'Dashboard')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Área da Empresa</p>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Gerencie vagas, candidatos e contratações</p>
    </div>

    <a href="{{ route('company.jobs.create') }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-green-700">
        <span class="text-base">➕</span>
        Nova Vaga
    </a>
</div>

{{-- CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

    <a href="{{ route('company.jobs.index') }}"
       class="group bg-white rounded-2xl p-6 border flex items-center gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-green-100 hover:border-green-200 hover:ring-1 hover:ring-green-200">
        <div class="bg-green-100 text-green-700 p-3 rounded-xl">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M9 6h6a2 2 0 0 1 2 2v2H7V8a2 2 0 0 1 2-2Z"/>
                <path d="M6 10h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2Z"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-bold">{{ $vagasAtivas }}</p>
            <p class="text-sm text-gray-500">Vagas Ativas</p>
        </div>
    </a>

    <a href="{{ route('company.candidates.index') }}"
       class="group bg-white rounded-2xl p-6 border flex items-center gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-100 hover:border-emerald-200 hover:ring-1 hover:ring-emerald-200">
        <div class="bg-emerald-100 text-emerald-700 p-3 rounded-xl">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="9" cy="8" r="3"/>
                <path d="M3 19a6 6 0 0 1 12 0"/>
                <circle cx="17" cy="9" r="2.5"/>
                <path d="M14.5 19a5.5 5.5 0 0 1 6.5-4.5"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-bold">{{ $candidatos }}</p>
            <p class="text-sm text-gray-500">Candidatos</p>
        </div>
    </a>

    <a href="{{ route('company.candidates.index', ['status' => 'aprovado']) }}"
       class="group bg-white rounded-2xl p-6 border flex items-center gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">
        <div class="bg-blue-100 text-blue-700 p-3 rounded-xl">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M7 12l3 3 7-7"/>
                <path d="M21 12a9 9 0 1 1-9-9 9 9 0 0 1 9 9Z"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-bold">{{ $contratacoes }}</p>
            <p class="text-sm text-gray-500">Contratações</p>
        </div>
    </a>

    <a href="{{ route('company.candidates.index', ['status' => 'em_analise']) }}"
       class="group bg-white rounded-2xl p-6 border flex items-center gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-yellow-100 hover:border-yellow-200 hover:ring-1 hover:ring-yellow-200">
        <div class="bg-yellow-100 text-yellow-700 p-3 rounded-xl">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 6v6l4 2"/>
                <circle cx="12" cy="12" r="9"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-bold">{{ $emAnalise }}</p>
            <p class="text-sm text-gray-500">Em Análise</p>
        </div>
    </a>

</div>

{{-- SEÇÕES: VAGAS + CANDIDATOS --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- VAGAS RECENTES --}}
    <div class="bg-white rounded-2xl border p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-800">Vagas Recentes</h2>
                <p class="text-xs text-gray-500">Acompanhe as últimas oportunidades</p>
            </div>
            <a href="{{ route('company.jobs.index') }}" class="text-sm text-green-700 hover:text-green-800">
                Ver todas
            </a>
        </div>

        <div class="space-y-3">
            @forelse($vagasRecentes as $vaga)
                <a href="{{ route('company.jobs.candidates', $vaga) }}"
                   class="flex justify-between items-center bg-gray-50 p-4 rounded-xl transition hover:bg-white hover:shadow-md hover:-translate-y-0.5 hover:border hover:border-gray-100">
                    <div>
                        <p class="font-medium">{{ $vaga->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $vaga->applications_count }} candidatos
                        </p>
                    </div>

                    <span class="inline-flex items-center gap-2 text-sm text-gray-400">
                        Ver detalhes
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M5 12h14"/>
                            <path d="M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </a>
            @empty
                <p class="text-sm text-gray-500">Nenhuma vaga cadastrada.</p>
            @endforelse
        </div>
    </div>

    {{-- CANDIDATOS RECENTES --}}
    <div class="bg-white rounded-2xl border p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-800">Candidatos Recentes</h2>
                <p class="text-xs text-gray-500">Novas candidaturas para avaliar</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($candidatosRecentes as $candidatura)
                <a href="{{ route('company.jobs.candidates', $candidatura->job_id) }}"
                   class="flex justify-between items-center rounded-xl px-3 py-2 transition hover:bg-gray-50">
                    <div>
                        <p class="font-medium">{{ $candidatura->student->name }}</p>
                        <p class="text-xs text-gray-500">
                            Vaga: {{ $candidatura->job->title }}
                        </p>
                    </div>

                    <span class="text-sm text-gray-400">Ver perfil →</span>
                </a>
            @empty
                <p class="text-sm text-gray-500">Nenhum candidato ainda.</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
