@extends('company.layout')

@section('title', 'Candidatos')

@section('content')
@php
    $status = $status ?? 'all';
    $statusLinks = [
        'all' => ['label' => 'Todos', 'class' => 'border-gray-300 text-gray-800 bg-gray-50'],
        'em_analise' => ['label' => 'Em análise', 'class' => 'border-yellow-200 text-yellow-700 bg-yellow-50'],
        'aprovado' => ['label' => 'Contratados', 'class' => 'border-green-200 text-green-700 bg-green-50'],
        'finalizado' => ['label' => 'Finalizados', 'class' => 'border-slate-200 text-slate-700 bg-slate-50'],
    ];

    $statusMap = [
        'em_analise' => ['label' => 'Em análise', 'class' => 'bg-amber-100 text-amber-800 border border-amber-200'],
        'aprovado' => ['label' => 'Aprovado', 'class' => 'bg-emerald-100 text-emerald-800 border border-emerald-200'],
        'recusado' => ['label' => 'Recusado', 'class' => 'bg-rose-100 text-rose-800 border border-rose-200'],
        'finalizado' => ['label' => 'Finalizado', 'class' => 'bg-slate-100 text-slate-700 border border-slate-200'],
    ];
@endphp

<div class="mb-6 flex flex-col gap-2">
    <h1 class="text-2xl font-bold text-gray-900">Candidatos</h1>
    @if($job)
        <p class="text-gray-500">
            Vaga selecionada:
            <span class="font-medium text-gray-700">{{ $job->title }}</span>
        </p>
    @else
        <p class="text-gray-500">Painel geral por status das candidaturas.</p>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-[240px_minmax(0,1fr)] gap-6">
    <aside class="bg-white border rounded-2xl p-4 h-fit shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Filtros</p>
        <nav class="space-y-2">
            @foreach($statusLinks as $key => $filter)
                @php
                    $link = $job
                        ? route('company.jobs.candidates', ['job' => $job, 'status' => $key])
                        : route('company.candidates.index', ['status' => $key]);
                @endphp
                <a href="{{ $link }}"
                   class="block rounded-lg border px-3 py-2 text-sm font-medium transition {{ $status === $key ? $filter['class'] : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    {{ $filter['label'] }}
                </a>
            @endforeach
        </nav>
    </aside>

    <div class="bg-white border rounded-2xl shadow-sm overflow-visible">
        <table class="w-full text-sm align-top table-fixed">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    @if(!$job)
                        <th class="text-left px-6 py-3 font-semibold">Vaga</th>
                    @endif
                    <th class="text-left px-6 py-3 font-semibold">Aluno</th>
                    <th class="text-left px-6 py-3 font-semibold">Curso</th>
                    <th class="text-left px-6 py-3 font-semibold">Semestre</th>
                    <th class="text-left px-6 py-3 font-semibold">Status</th>
                    <th class="text-left px-6 py-3 font-semibold">Currículo</th>
                    <th class="text-right px-6 py-3 font-semibold">Ações</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($applications as $application)
                <tr class="hover:bg-gray-50/60">
                    @if(!$job)
                    <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">
                                {{ $application->job->title ?? 'Vaga não informada' }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $application->job->location ?? 'Local não informado' }}
                            </div>
                        </td>
                    @endif
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900 leading-tight">
                            {{ $application->student->name }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $application->student->email }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        {{ optional($application->student->student)->course ?? 'Não informado' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ optional($application->student->student)->period ?? 'Não informado' }}
                    </td>

                    <td class="px-6 py-4">
                        @php
                            $statusMeta = $statusMap[$application->status] ?? ['label' => ucfirst(str_replace('_', ' ', $application->status)), 'class' => 'bg-gray-100 text-gray-700 border border-gray-200'];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['class'] }}">
                            {{ $statusMeta['label'] }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        @if ($application->resume)
                            <a href="{{ $application->resume_url }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-blue-700 text-xs font-medium transition hover:bg-blue-100">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <path d="M14 2v6h6"></path>
                                </svg>
                                Ver
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Não enviado</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right relative">
                        <details class="relative inline-block text-left">
                            <summary class="list-none cursor-pointer rounded-lg border border-gray-200 bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-200">
                                <span class="inline-flex items-center gap-1">
                                    Ações
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </summary>

                            <div class="absolute right-0 z-50 mt-2 w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg">
                                @if ($application->status === 'aprovado')
                                    <a href="{{ route('company.chat.show', [$application->job_id, $application->student_id]) }}"
                                       class="block rounded-md px-3 py-2 text-xs font-medium text-blue-700 hover:bg-gray-100">
                                        Chat
                                    </a>
                                    <form action="{{ route('company.applications.finalize', $application) }}"
                                          method="POST"
                                          onsubmit="return confirm('Deseja finalizar o estágio deste aluno?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="block w-full rounded-md px-3 py-2 text-left text-xs font-medium text-slate-700 hover:bg-gray-100">
                                            Finalizar estágio
                                        </button>
                                    </form>
                                @elseif ($application->status === 'em_analise')
                                    <form action="{{ route('company.applications.approve', $application) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="block w-full rounded-md px-3 py-2 text-left text-xs font-medium text-emerald-700 hover:bg-gray-100">
                                            Aprovar
                                        </button>
                                    </form>
                                    <form action="{{ route('company.applications.reject', $application) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="block w-full rounded-md px-3 py-2 text-left text-xs font-medium text-rose-700 hover:bg-gray-100">
                                            Recusar
                                        </button>
                                    </form>
                                @else
                                    <span class="block rounded-md px-3 py-2 text-xs text-gray-400">
                                        Sem ações
                                    </span>
                                @endif
                            </div>
                        </details>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $job ? 6 : 7 }}" class="text-center py-10 text-gray-500">
                        Nenhum candidato neste filtro.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
