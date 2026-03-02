@extends('student.layout')

@section('title')
Vagas de Estágio
@endsection

@section('content')
@php
    $hideSuccess = true;
    $studentCourse = auth()->user()->student?->course;
@endphp

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<h1 class="text-2xl font-bold mb-1">Vagas de Estágio</h1>
<p class="text-gray-500 mb-8">Encontre a oportunidade perfeita para sua carreira</p>

<div class="rounded-2xl p-5 mb-8 border border-blue-100 bg-gradient-to-r from-white via-blue-50/40 to-white shadow-sm">
    <form method="GET" action="{{ route('student.jobs.index') }}" class="space-y-4">
        <div class="flex items-center gap-3 rounded-xl border border-blue-100 bg-white px-4 py-3 transition-all duration-200 focus-within:border-blue-400 focus-within:shadow-[0_0_0_4px_rgba(59,130,246,.15)]">
            <span class="text-blue-600">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M20 20l-3.5-3.5"></path>
                </svg>
            </span>

            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Buscar por cargo ou empresa..."
                class="w-full bg-transparent text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none"
            >

            @if(filled((string) $search))
                <a href="{{ route('student.jobs.index') }}" class="text-xs text-gray-500 hover:text-gray-700">
                    Limpar
                </a>
            @endif

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition"
            >
                Buscar
            </button>
        </div>

        <div class="flex flex-wrap items-center gap-2 text-sm">
       
            <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-gray-600 border border-gray-200">
                {{ $studentCourse ?? 'Curso não definido' }}
            </span>
            <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-gray-600 border border-gray-200">
                {{ $jobs->count() }} vaga(s) encontrada(s)
            </span>
        </div>
    </form>
</div>

<div class="space-y-6">
    @forelse($jobs as $job)
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-100">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex gap-4">
                @if($job->company->user->photo)
                    <img
                        src="{{ asset('storage/' . $job->company->user->photo) }}"
                        class="h-16 w-16 shrink-0 rounded-xl object-cover ring-1 ring-slate-200"
                        alt="Foto da empresa {{ $job->company->user->name }}"
                    >
                @else
                    <div class="h-16 w-16 shrink-0 rounded-xl bg-gray-200 flex items-center justify-center font-bold text-gray-500 ring-1 ring-slate-200">
                        {{ strtoupper(substr($job->company->user->name, 0, 1)) }}
                    </div>
                @endif

                    <div class="max-w-3xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h2>
                            <span class="rounded-full px-3 py-1 text-xs font-medium
                                @if($job->type === 'Remoto')
                                    bg-green-100 text-green-700
                                @elseif($job->type === 'Presencial')
                                    bg-blue-100 text-blue-700
                                @else
                                    bg-amber-100 text-amber-700
                                @endif">
                                {{ $job->type }}
                            </span>
                        </div>

                        <p class="mt-1 text-sm font-medium text-gray-600">{{ $job->company->user->name }}</p>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ Str::limit($job->description, 180) }}</p>

                        <div class="mt-4 flex flex-wrap gap-2">
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

                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($job->requirements ?? [] as $requirement)
                                <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                    {{ $requirement }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex w-full shrink-0 items-end justify-end lg:w-auto">
                    <form method="POST" action="{{ route('student.jobs.apply', $job) }}">
                        @csrf
                        <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                            Inscrever-se
                        </button>
                    </form>
                </div>
            </div>
        </article>
    @empty
        <div class="text-center py-24 text-gray-400">
            <p class="text-lg">Nenhuma vaga disponível no momento.</p>
        </div>
    @endforelse
</div>
@endsection
