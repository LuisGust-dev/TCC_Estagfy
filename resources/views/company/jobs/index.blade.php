@extends('company.layout')

@section('title', 'Minhas Vagas')

@section('content')

{{-- HEADER --}}
<div class="mb-8 flex flex-col gap-4 sm:mb-10 sm:flex-row sm:items-center sm:justify-between">
    <div class="min-w-0">
        <h1 class="text-2xl font-bold text-gray-900">Minhas Vagas</h1>
        <p class="text-gray-500">Gerencie suas vagas e candidatos</p>
    </div>

    <a href="{{ route('company.jobs.create') }}"
       class="inline-flex w-full items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
              text-white px-5 py-2 rounded-lg text-sm font-medium shadow sm:w-auto">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14"></path>
            <path d="M5 12h14"></path>
        </svg>
        Nova Vaga
    </a>
</div>

@php
    $statusFilter = $statusFilter ?? 'all';
@endphp

<div class="mb-6 flex flex-wrap items-center gap-2">
    <a href="{{ route('company.jobs.index', ['status' => 'all']) }}"
       class="px-3 py-1.5 rounded-full border text-sm font-medium transition {{ $statusFilter === 'all' ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        Todas
    </a>
    <a href="{{ route('company.jobs.index', ['status' => 'active']) }}"
       class="px-3 py-1.5 rounded-full border text-sm font-medium transition {{ $statusFilter === 'active' ? 'bg-emerald-600 text-white border-emerald-600' : 'text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        Ativas
    </a>
    <a href="{{ route('company.jobs.index', ['status' => 'inactive']) }}"
       class="px-3 py-1.5 rounded-full border text-sm font-medium transition {{ $statusFilter === 'inactive' ? 'bg-slate-700 text-white border-slate-700' : 'text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        Inativas
    </a>
</div>

{{-- LISTA --}}
<div class="space-y-6">

@forelse($jobs as $job)
    <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-100">

        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between md:gap-6">

            {{-- ESQUERDA --}}
            <a href="{{ route('company.jobs.candidates', $job) }}" class="block min-w-0 flex-1">

                {{-- TÍTULO --}}
                <h2 class="text-base font-semibold text-gray-900 mb-1">
                    {{ $job->title }}
                </h2>

                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span
                        class="rounded-full px-3 py-1 text-xs font-medium
                        @if($job->type === 'Remoto')
                            bg-emerald-100 text-emerald-700
                        @elseif($job->type === 'Presencial')
                            bg-blue-100 text-blue-700
                        @else
                            bg-amber-100 text-amber-700
                        @endif
                        ">
                        {{ $job->type ?? 'Híbrido' }}
                    </span>
                </div>

                {{-- DESCRIÇÃO --}}
                <p class="mb-3 text-sm leading-relaxed text-gray-600 break-words">
                    {{ Str::limit($job->description, 160) }}
                </p>

                <div class="mb-4 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-700">
                        <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-5.5 8-12a8 8 0 1 0-16 0c0 6.5 8 12 8 12Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        {{ $job->location ?? 'Local não informado' }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-700">
                        <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 7h18M7 3v8M17 3v8M5 11h14a2 2 0 0 1 2 2v6H3v-6a2 2 0 0 1 2-2Z"></path>
                        </svg>
                        {{ $job->area ?? 'Área não informada' }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-700">
                        <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 7h16"></path>
                            <path d="M4 12h16"></path>
                            <path d="M4 17h10"></path>
                        </svg>
                        {{ $job->vacancies ?? 1 }} vaga(s)
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-700">
                        <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 1v22"></path>
                            <path d="M17 5H9a3 3 0 0 0 0 6h6a3 3 0 1 1 0 6H6"></path>
                        </svg>
                        R$ {{ number_format($job->salary, 2, ',', '.') }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-700">
                        <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        {{ $job->applications_count }} candidato(s)
                    </span>

                    @if($job->flow_type === 'defined_period' && $job->period_start && $job->period_end)
                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-blue-100 bg-blue-50 px-2.5 py-1.5 text-xs font-medium text-blue-700">
                            <svg class="h-3.5 w-3.5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <path d="M16 2v4M8 2v4M3 10h18"></path>
                            </svg>
                            {{ $job->period_start->format('d/m/Y') }} até {{ $job->period_end->format('d/m/Y') }}
                        </span>
                    @endif
                </div>

                {{-- REQUISITOS --}}
                <div class="flex flex-wrap gap-2">
                    @foreach($job->requirements ?? [] as $requirement)
                        <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                            {{ $requirement }}
                        </span>
                    @endforeach
                </div>

            </a>

            {{-- DIREITA --}}
            <div class="flex w-full shrink-0 flex-col items-start gap-3 md:w-auto md:items-end md:justify-between">

                {{-- CANDIDATOS --}}
                <div class="mb-1 flex w-full flex-wrap items-center gap-2 md:mb-4 md:w-auto md:flex-col md:items-end">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $job->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-700' }}">
                        {{ $job->is_active ? 'Ativa' : 'Inativa' }}
                    </span>

                    <a href="{{ route('company.jobs.candidates', $job) }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 transition hover:bg-blue-100">
                        Ver candidatos
                    </a>
                </div>

                {{-- AÇÕES --}}
                <div class="flex w-full flex-wrap items-center gap-2 md:w-auto md:justify-end">
                    <a href="{{ route('company.jobs.edit', $job) }}"
                       class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
                       title="Editar vaga">
                        Editar
                    </a>

                    <form method="POST"
                          action="{{ route('company.jobs.destroy', $job) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?')">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="flex items-center justify-center
                                   w-10 h-10 rounded-lg
                                   border border-red-200
                                   text-red-500
                                   hover:bg-red-50 transition">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18"></path>
                                <path d="M8 6V4h8v2"></path>
                                <path d="M19 6l-1 14H6L5 6"></path>
                                <path d="M10 11v6M14 11v6"></path>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </article>
@empty
    <div class="text-center py-24 text-gray-400">
        <p class="text-lg font-medium">Nenhuma vaga cadastrada</p>
        <p class="text-sm mt-1">
            Clique em <strong>Nova Vaga</strong> para começar
        </p>
    </div>
@endforelse

</div>

@if($jobs->hasPages())
    <div class="mt-8 flex justify-end">
        <div class="flex flex-col items-end text-right">
            <nav class="inline-flex overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm" aria-label="Paginação">
                @if($jobs->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-300">Anterior</span>
                @else
                    <a href="{{ $jobs->previousPageUrl() }}"
                       class="px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                        Anterior
                    </a>
                @endif

                @foreach($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                    @if($page == $jobs->currentPage())
                        <span class="border-x border-gray-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="border-l border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($jobs->hasMorePages())
                    <a href="{{ $jobs->nextPageUrl() }}"
                       class="border-l border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                        Próxima
                    </a>
                @else
                    <span class="border-l border-gray-200 px-3 py-2 text-sm text-gray-300">Próxima</span>
                @endif
            </nav>
        </div>
    </div>
@endif

@endsection
