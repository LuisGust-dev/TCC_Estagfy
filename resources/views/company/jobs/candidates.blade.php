@extends('company.layout')

@section('title', 'Candidatos')

@section('content')
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold">Candidatos</h1>
        @if($job)
            <p class="text-gray-500">Vaga: {{ $job->title }}</p>
        @else
            <p class="text-gray-500">Painel por status</p>
        @endif
    </div>
</div>

@php
    $status = $status ?? 'all';
    $statusLinks = [
        'all' => ['label' => 'Todos', 'class' => 'border-gray-300 text-gray-800 bg-gray-50'],
        'em_analise' => ['label' => 'Em análise', 'class' => 'border-yellow-200 text-yellow-700 bg-yellow-50'],
        'aprovado' => ['label' => 'Contratados', 'class' => 'border-green-200 text-green-700 bg-green-50'],
        'finalizado' => ['label' => 'Finalizados', 'class' => 'border-slate-200 text-slate-700 bg-slate-50'],
    ];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-[240px_minmax(0,1fr)] gap-6">
    <aside class="bg-white border rounded-xl p-4 h-fit">
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

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    @if(!$job)
                        <th class="text-left px-6 py-3">Vaga</th>
                    @endif
                    <th class="text-left px-6 py-3">Aluno</th>
                    <th class="text-left px-6 py-3">Curso</th>
                    <th class="text-left px-6 py-3">Semestre</th>
                    <th class="text-left px-6 py-3">Status</th>
                    <th class="text-left px-6 py-3">Currículo</th>
                    <th class="text-right px-6 py-3">Ações</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($applications as $application)
                <tr>
                    @if(!$job)
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">
                                {{ $application->job->title ?? 'Vaga não informada' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $application->job->location ?? 'Local não informado' }}
                            </div>
                        </td>
                    @endif
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $application->student->name }}
                        </div>
                        <div class="text-xs text-gray-500">
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
                        @if ($application->status === 'em_analise')
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                Em análise
                            </span>
                        @elseif ($application->status === 'aprovado')
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                Aprovado
                            </span>
                        @elseif ($application->status === 'recusado')
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                Recusado
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                Finalizado
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        @if ($application->resume)
                            <a href="{{ asset('storage/' . $application->resume) }}"
                               class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-xs font-medium transition hover:bg-blue-100">
                                📄 Ver
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Não enviado</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right space-x-2">
                        @if ($application->status === 'aprovado')
                            <a href="{{ route('company.chat.show', [$application->job_id, $application->student_id]) }}"
                                class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-xs font-medium transition hover:bg-blue-100">
                                <span class="text-sm">💬</span>
                                Chat
                            </a>

                            <form action="{{ route('company.applications.finalize', $application) }}"
                                method="POST" class="inline"
                                onsubmit="return confirm('Deseja finalizar o estágio deste aluno?')">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-slate-600 text-white rounded text-xs hover:bg-slate-700 transition">
                                    Finalizar estágio
                                </button>
                            </form>
                        @endif

                        @if ($application->status === 'em_analise')
                            <form action="{{ route('company.applications.approve', $application) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-green-500 text-white rounded text-xs">
                                    Aprovar
                                </button>
                            </form>

                            <form action="{{ route('company.applications.reject', $application) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-red-500 text-white rounded text-xs">
                                    Recusar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $job ? 6 : 7 }}" class="text-center py-6 text-gray-500">
                        Nenhum candidato neste filtro.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
