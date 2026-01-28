@extends('student.layout')

@section('title', 'Minhas Candidaturas')

@section('content')

<div class="mb-8 rounded-2xl border bg-gradient-to-r from-blue-50 via-white to-emerald-50 p-6">
    <p class="text-xs font-semibold uppercase tracking-widest text-blue-500">Área do Aluno</p>
    <h1 class="text-2xl font-bold text-gray-800">Minhas Candidaturas</h1>
    <p class="text-gray-600">Acompanhe o status das vagas que você se candidatou</p>
</div>

<div class="space-y-4">

@forelse($applications as $application)
    <div class="bg-white border rounded-2xl p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-sm">

        {{-- Informações da vaga --}}
        <div>
            <h2 class="font-semibold text-lg">
                {{ $application->job->title }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ data_get($application, 'job.company.user.name', 'Empresa não informada') }}
            </p>
        </div>

        {{-- Status + Ações --}}
        <div class="flex flex-wrap items-center gap-3">

            {{-- STATUS --}}
            @php
                $statusClasses = [
                    'em_analise' => 'bg-blue-100 text-blue-700',
                    'aprovado'   => 'bg-green-100 text-green-700',
                    'recusado'   => 'bg-red-100 text-red-700',
                ];

                $statusLabels = [
                    'em_analise' => 'Em análise',
                    'aprovado'   => 'Aprovado',
                    'recusado'   => 'Recusado',
                ];
            @endphp

            <span class="inline-block px-4 py-1 rounded-full text-sm font-medium {{ $statusClasses[$application->status] }}">
                {{ $statusLabels[$application->status] }}
            </span>

            @if($application->status === 'aprovado')
                <a href="{{ route('student.chat.show', $application->job_id) }}"
                   class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-sm font-medium transition hover:bg-blue-100">
                    <span class="text-sm">💬</span>
                    Abrir chat
                </a>
            @endif


            {{-- Cancelar candidatura --}}
            @if($application->status === 'em_analise')
                <form
                    method="POST"
                    action="{{ route('student.applications.destroy', $application) }}"
                    onsubmit="return confirm('Deseja realmente cancelar esta candidatura?')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-red-700 text-sm font-medium transition hover:bg-red-100 whitespace-nowrap"
                    >
                        <span class="text-sm">❌</span>
                        Cancelar
                    </button>
                </form>
            @endif

        </div>
    </div>
@empty
    <div class="rounded-2xl border border-dashed p-8 text-center text-gray-500">
        Você ainda não se candidatou a nenhuma vaga.
    </div>
@endforelse


</div>

@endsection
