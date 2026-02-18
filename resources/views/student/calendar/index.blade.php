@extends('student.layout')

@section('title', 'Calendario de Estagio')

@section('content')
<div class="mb-8 rounded-2xl border bg-gradient-to-r from-blue-50 via-white to-cyan-50 p-6">
    <p class="text-xs font-semibold uppercase tracking-widest text-blue-500">Calendario Informativo</p>
    <h1 class="text-2xl font-bold text-gray-800">Calendario de Estagio</h1>
    <p class="text-gray-600">Acompanhe os periodos e datas importantes definidos pela coordenacao.</p>
</div>

<div class="space-y-4">
    @forelse($events as $event)
        <article class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($event->end_date && !$event->start_date->isSameDay($event->end_date))
                            {{ $event->start_date->format('d/m/Y') }} ate {{ $event->end_date->format('d/m/Y') }}
                        @else
                            {{ $event->start_date->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
            </div>

            @if(!empty($event->description))
                <p class="mt-3 text-sm text-gray-700 leading-relaxed">
                    {{ $event->description }}
                </p>
            @endif
        </article>
    @empty
        <div class="rounded-2xl border border-dashed bg-white p-8 text-center text-gray-500">
            Nenhuma data cadastrada no calendario de estagio.
        </div>
    @endforelse
</div>
@endsection
