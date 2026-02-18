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
        ✅ {{ session('success') }}
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
            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 border border-blue-100">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                Área ativa
            </span>
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
        <div class="bg-white border rounded-xl p-6 flex justify-between gap-6 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">
            <div class="flex gap-4">
                @if($job->company->user->photo)
                    <img src="{{ asset('storage/' . $job->company->user->photo) }}" class="w-14 h-14 rounded-lg object-cover">
                @else
                    <div class="w-14 h-14 rounded-lg bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                        {{ strtoupper(substr($job->company->user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="max-w-2xl">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $job->company->user->name }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($job->description, 160) }}</p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 mt-3">
                        <span>📍 {{ $job->location }}</span>
                        <span>🎯 {{ $job->area ?? 'Área não informada' }}</span>
                        <span>🪑 {{ $job->vacancies ?? 1 }} vaga(s)</span>
                        @if($job->flow_type === 'defined_period' && $job->period_start && $job->period_end)
                            <span>📆 {{ $job->period_start->format('d/m/Y') }} até {{ $job->period_end->format('d/m/Y') }}</span>
                        @endif
                        <span>💰 R$ {{ number_format($job->salary, 2, ',', '.') }}</span>
                        <span>👥 {{ $job->applications_count }} candidatos</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach($job->requirements ?? [] as $requirement)
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-600 text-white">
                                {{ $requirement }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-end gap-4">
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($job->type === 'Remoto')
                        bg-green-100 text-green-700
                    @elseif($job->type === 'Presencial')
                        bg-blue-100 text-blue-700
                    @else
                        bg-purple-100 text-purple-700
                    @endif">
                    {{ $job->type }}
                </span>

                <form method="POST" action="{{ route('student.jobs.apply', $job) }}">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                        Inscrever-se
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-24 text-gray-400">
            <p class="text-lg">Nenhuma vaga disponível no momento.</p>
        </div>
    @endforelse
</div>
@endsection
