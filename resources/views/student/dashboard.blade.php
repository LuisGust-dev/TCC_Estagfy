@extends('student.layout')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8 rounded-2xl border bg-gradient-to-r from-blue-50 via-white to-emerald-50 p-6">
    <p class="text-xs font-semibold uppercase tracking-widest text-blue-500">Área do Aluno</p>
    <h1 class="text-2xl font-bold text-gray-800">Seu painel</h1>
    <p class="text-gray-600">Encontre oportunidades e acompanhe suas candidaturas</p>
</div>

{{-- Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <a href="{{ route('student.jobs.index') }}"
       class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-4 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">
        <div class="rounded-xl bg-blue-100 p-3 text-blue-700">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M9 6h6a2 2 0 0 1 2 2v2H7V8a2 2 0 0 1 2-2Z"/>
                <path d="M6 10h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2Z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Vagas disponíveis</p>
            <h2 class="text-2xl font-bold">{{ $totalJobs }}</h2>
        </div>
    </a>

    <a href="{{ route('student.applications.index') }}"
       class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-4 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-100 hover:border-emerald-200 hover:ring-1 hover:ring-emerald-200">
        <div class="rounded-xl bg-emerald-100 p-3 text-emerald-700">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M8 6h8"/>
                <path d="M8 10h8"/>
                <path d="M8 14h5"/>
                <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Minhas candidaturas</p>
            <h2 class="text-2xl font-bold">{{ $applicationsCount }}</h2>
        </div>
    </a>

    <div class="bg-white p-6 rounded-2xl border shadow-sm flex items-center gap-4">
        <div class="rounded-xl bg-yellow-100 p-3 text-yellow-700">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 6v6l4 2"/>
                <circle cx="12" cy="12" r="9"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Status</p>
            <h2 class="text-lg font-semibold text-blue-600">Em breve</h2>
        </div>
    </div>

</div>

{{-- Vagas recentes --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Vagas recentes</h2>
    <a href="{{ route('student.jobs.index') }}"
       class="text-sm font-medium text-blue-600 hover:text-blue-700">
        Ver todas
    </a>
</div>

<div class="space-y-4">

    @forelse($recentJobs as $job)
        <a href="{{ route('student.jobs.show', $job) }}"
           class="bg-white p-5 rounded-2xl border flex justify-between items-center shadow-sm transition hover:bg-white hover:shadow-md hover:-translate-y-0.5 hover:border-blue-100">
            <div>
                <h3 class="font-semibold">{{ $job->title }}</h3>
                <p class="text-sm text-gray-500">
                    {{ $job->location ?? 'Local não informado' }} • {{ $job->type }}
                </p>
            </div>

            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-sm font-medium transition hover:bg-blue-100">
                Ver vaga
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M5 12h14"/>
                    <path d="M13 6l6 6-6 6"/>
                </svg>
            </span>
        </a>
    @empty
        <p class="text-gray-400">Nenhuma vaga cadastrada ainda.</p>
    @endforelse

</div>

@endsection
