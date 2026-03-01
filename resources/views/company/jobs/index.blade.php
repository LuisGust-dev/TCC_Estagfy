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
        <span class="text-lg">＋</span> Nova Vaga
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
    <div class="group bg-white border border-gray-200 rounded-xl px-4 py-4 sm:px-6 sm:py-5 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">

        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between md:gap-6">

            {{-- ESQUERDA --}}
            <a href="{{ route('company.jobs.candidates', $job) }}" class="block min-w-0 flex-1">

                {{-- TÍTULO --}}
                <h2 class="text-base font-semibold text-gray-900 mb-1">
                    {{ $job->title }}
                </h2>

                {{-- LOCAL + TIPO --}}
                <div class="mb-2 flex flex-wrap items-center gap-2 text-sm text-gray-500">
                    <span class="inline-flex max-w-full items-center gap-1 break-words">
                        📍 {{ $job->location ?? 'Local não informado' }}
                    </span>
                    <span class="inline-flex max-w-full items-center gap-1 break-words">
                        🎯 {{ $job->area ?? 'Área não informada' }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        🪑 {{ $job->vacancies ?? 1 }} vaga(s)
                    </span>

                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-medium
                        @if($job->type === 'Remoto')
                            bg-emerald-100 text-emerald-700
                        @elseif($job->type === 'Presencial')
                            bg-blue-100 text-blue-700
                        @else
                            bg-purple-100 text-purple-700
                        @endif
                        ">
                        {{ $job->type ?? 'Híbrido' }}
                    </span>
                </div>

                {{-- DESCRIÇÃO --}}
                <p class="mb-3 text-sm leading-relaxed text-gray-600 break-words">
                    {{ Str::limit($job->description, 160) }}
                </p>

                {{-- REQUISITOS --}}
                <div class="flex flex-wrap gap-2">
                    @foreach($job->requirements ?? [] as $requirement)
                        <span
                            class="px-3 py-1 text-xs rounded-full
                                   bg-gray-100 text-gray-700">
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

                    <span
                        class="inline-flex items-center gap-2
                               bg-blue-50 text-blue-600
                               px-4 py-2 rounded-full text-sm font-medium">
                        👤 {{ $job->applications_count }} candidatos
                    </span>
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
                            🗑
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>
@empty
    <div class="text-center py-24 text-gray-400">
        <p class="text-lg font-medium">Nenhuma vaga cadastrada</p>
        <p class="text-sm mt-1">
            Clique em <strong>Nova Vaga</strong> para começar
        </p>
    </div>
@endforelse

</div>

@endsection
