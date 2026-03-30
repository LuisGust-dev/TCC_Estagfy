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
    @php
        $companyUser = data_get($application, 'job.company.user');
        $statusClasses = [
            'em_analise' => 'bg-amber-100 text-amber-800 border border-amber-200',
            'aprovado'   => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
            'recusado'   => 'bg-rose-100 text-rose-700 border border-rose-200',
            'finalizado' => 'bg-indigo-100 text-indigo-700 border border-indigo-200',
        ];

        $statusLabels = [
            'em_analise' => 'Em análise',
            'aprovado'   => 'Aprovado',
            'recusado'   => 'Recusado',
            'finalizado' => 'Estágio finalizado',
        ];
    @endphp
    <article class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-100">
        <div class="border-b border-slate-100 bg-gradient-to-r from-white via-blue-50/50 to-emerald-50/40 px-6 py-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                        @if($companyUser?->photo_url)
                            <img
                                src="{{ $companyUser->photo_url }}"
                                alt="Foto da empresa {{ $companyUser->name }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <span class="text-base font-semibold text-slate-600">
                                {{ strtoupper(substr($companyUser->name ?? 'E', 0, 1)) }}
                            </span>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-xl font-bold text-slate-900">
                                {{ $application->job->title }}
                            </h2>
                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ $application->job->type ?? 'Tipo não informado' }}
                            </span>
                        </div>

                        <p class="mt-1 text-sm font-medium text-slate-600">
                            {{ $companyUser->name ?? 'Empresa não informada' }}
                        </p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            {{ Str::limit($application->job->description ?? 'Sem descrição disponível.', 140) }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses[$application->status] ?? 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                        {{ $statusLabels[$application->status] ?? ucfirst(str_replace('_', ' ', $application->status)) }}
                    </span>

                    @if(in_array($application->status, ['aprovado', 'finalizado'], true))
                        <a href="{{ route('student.chat.show', $application->job_id) }}"
                           class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-100">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                            </svg>
                            Abrir chat
                        </a>
                    @endif

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
                                class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-100 whitespace-nowrap"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                                Cancelar candidatura
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-3 px-6 py-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Local</p>
                <p class="mt-1 text-sm font-medium text-slate-800">{{ $application->job->location ?? 'Não informado' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Área</p>
                <p class="mt-1 text-sm font-medium text-slate-800">{{ $application->job->area ?? 'Não informada' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Bolsa</p>
                <p class="mt-1 text-sm font-medium text-slate-800">R$ {{ number_format((float) ($application->job->salary ?? 0), 2, ',', '.') }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Candidatura</p>
                <p class="mt-1 text-sm font-medium text-slate-800">{{ optional($application->created_at)->format('d/m/Y') ?? 'Não informado' }}</p>
            </div>
        </div>
    </article>
@empty
    <div class="rounded-2xl border border-dashed p-8 text-center text-gray-500">
        Você ainda não se candidatou a nenhuma vaga.
    </div>
@endforelse


</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const snapshot = {
            applicationsCount: Number(@json($applicationsCount ?? 0)),
            applicationsLatestTs: Number(@json($applicationsLatestTs ?? 0)),
        };

        const pollIfChanged = async () => {
            if (document.hidden) return;

            try {
                const response = await fetch('{{ route('student.realtime.summary') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) return;

                const data = await response.json();
                const changed = Number(data.applications_count || 0) !== snapshot.applicationsCount
                    || Number(data.applications_latest_ts || 0) !== snapshot.applicationsLatestTs;

                if (changed) {
                    window.location.reload();
                }
            } catch (error) {
                console.warn('Falha ao sincronizar candidaturas.', error);
            }
        };

        setInterval(pollIfChanged, 6000);
    });
</script>

@endsection
