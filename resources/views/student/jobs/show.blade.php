@extends('student.layout')

@section('title', 'Detalhes da Vaga')

@section('content')

<a href="{{ route('student.jobs.index') }}" class="text-sm text-gray-500 mb-4 inline-block">
    ← Voltar para vagas
</a>

<div class="bg-white border rounded-xl p-8 space-y-6">

    <div>
        <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
        <p class="text-gray-500">{{ data_get($job, 'company.user.name', 'Empresa não informada') }}</p>
    </div>

    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
        <span>📍 {{ $job->location ?? 'Local não informado' }}</span>
        <span>🎯 {{ $job->area ?? 'Área não informada' }}</span>
        <span>🪑 {{ $job->vacancies ?? 1 }} vaga(s)</span>
        <span>💼 {{ $job->type ?? 'Tipo não informado' }}</span>

        @if($job->salary)
            <span>💰 R$ {{ number_format($job->salary, 2, ',', '.') }}</span>
        @endif
    </div>

    <div>
        <h2 class="font-semibold mb-2">Descrição</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ $job->description }}
        </p>
    </div>

    @if(!empty($job->requirements))
        <div>
            <h2 class="font-semibold mb-2">Requisitos</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($job->requirements as $requirement)
                    <span class="px-3 py-1 text-xs rounded-full bg-emerald-600 text-white">
                        {{ $requirement }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- STATUS DA CANDIDATURA --}}
    @if($application)
        @php
            $colors = [
                'em_analise' => 'bg-blue-100 text-blue-700',
                'aprovado' => 'bg-green-100 text-green-700',
                'recusado' => 'bg-red-100 text-red-700',
            ];

            $labels = [
                'em_analise' => 'Em análise',
                'aprovado' => 'Aprovado',
                'recusado' => 'Recusado',
            ];
        @endphp

        <span class="inline-block px-4 py-2 rounded-full text-sm font-medium {{ $colors[$application->status] }}">
            {{ $labels[$application->status] }}
        </span>
    @else
        <form method="POST" action="{{ route('student.jobs.apply', $job) }}">
            @csrf
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                Inscrever-se na vaga
            </button>
        </form>
    @endif

</div>

@endsection
