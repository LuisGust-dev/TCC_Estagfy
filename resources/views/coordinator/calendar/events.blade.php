@extends('coordinator.layout')

@section('title', 'Eventos Cadastrados')

@section('content')
    @php
        $today = now()->startOfDay();

        $overdueEvents = $events->filter(function ($event) use ($today) {
            $end = ($event->end_date ?? $event->start_date)?->copy()->startOfDay();
            return $end && $end->lt($today);
        })->values();

        $inProgressEvents = $events->filter(function ($event) use ($today) {
            $start = $event->start_date?->copy()->startOfDay();
            $end = ($event->end_date ?? $event->start_date)?->copy()->startOfDay();
            return $start && $end && $start->lte($today) && $end->gte($today);
        })->values();

        $upcomingEvents = $events->filter(function ($event) use ($today) {
            $start = $event->start_date?->copy()->startOfDay();
            return $start && $start->gt($today);
        })->values();

        $columns = [
            [
                'title' => 'Atrasados',
                'subtitle' => 'Eventos com prazo encerrado',
                'count' => $overdueEvents->count(),
                'header' => 'bg-red-50 text-red-700 border-red-200',
                'cards' => $overdueEvents,
                'dot' => 'bg-red-500',
            ],
            [
                'title' => 'Em andamento',
                'subtitle' => 'Eventos ativos hoje',
                'count' => $inProgressEvents->count(),
                'header' => 'bg-amber-50 text-amber-700 border-amber-200',
                'cards' => $inProgressEvents,
                'dot' => 'bg-amber-500',
            ],
            [
                'title' => 'Próximos',
                'subtitle' => 'Eventos futuros',
                'count' => $upcomingEvents->count(),
                'header' => 'bg-blue-50 text-blue-700 border-blue-200',
                'cards' => $upcomingEvents,
                'dot' => 'bg-blue-500',
            ],
        ];
    @endphp

    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenação</p>
        <h1 class="text-2xl font-bold text-gray-900">Eventos cadastrados</h1>
        <p class="text-gray-600">Visualização em board para acompanhar o andamento do calendário.</p>
    </div>

    <div class="mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ route('coordinator.calendar.index') }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Novo evento
        </a>
        <a href="{{ route('coordinator.calendar.events') }}"
           class="rounded-lg bg-amber-600 px-3 py-2 text-sm font-medium text-white">
            Eventos cadastrados
        </a>
        <a href="{{ route('coordinator.calendar.hiring-companies.index') }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Empresas destaque
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <section class="space-y-4">
            <div class="rounded-2xl border bg-white px-5 py-4 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Curso: {{ $selectedCourse }}</h2>
                <p class="text-sm text-gray-500">{{ $events->count() }} evento(s) no total</p>
            </div>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                @foreach($columns as $column)
                    <article class="rounded-2xl border bg-white shadow-sm">
                        <header class="rounded-t-2xl border-b px-4 py-3 {{ $column['header'] }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $column['dot'] }}"></span>
                                    <h3 class="text-sm font-semibold">{{ $column['title'] }}</h3>
                                </div>
                                <span class="rounded-full bg-white/70 px-2 py-0.5 text-xs font-semibold">
                                    {{ $column['count'] }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs">{{ $column['subtitle'] }}</p>
                        </header>

                        <div class="max-h-[68vh] space-y-3 overflow-y-auto p-3">
                            @forelse($column['cards'] as $event)
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $event->title }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">
                                        @if($event->end_date && !$event->start_date->isSameDay($event->end_date))
                                            {{ $event->start_date->format('d/m/Y') }} até {{ $event->end_date->format('d/m/Y') }}
                                        @else
                                            {{ $event->start_date->format('d/m/Y') }}
                                        @endif
                                    </p>
                                    @if(!empty($event->description))
                                        <p class="mt-2 text-xs leading-relaxed text-gray-600">
                                            {{ \Illuminate\Support\Str::limit($event->description, 100) }}
                                        </p>
                                    @endif

                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <details class="w-full rounded-lg border bg-white p-2">
                                            <summary class="cursor-pointer text-xs font-semibold text-amber-700">
                                                Editar evento
                                            </summary>

                                            <form method="POST" action="{{ route('coordinator.calendar.update', $event) }}" class="mt-3 space-y-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="course" value="{{ $selectedCourse }}">

                                                <input type="text" name="title" value="{{ $event->title }}"
                                                       class="w-full rounded-lg border-gray-300 text-xs focus:border-amber-500 focus:ring-amber-500">
                                                <div class="grid grid-cols-2 gap-2">
                                                    <input type="date" name="start_date" value="{{ $event->start_date?->format('Y-m-d') }}"
                                                           class="w-full rounded-lg border-gray-300 text-xs focus:border-amber-500 focus:ring-amber-500">
                                                    <input type="date" name="end_date" value="{{ $event->end_date?->format('Y-m-d') }}"
                                                           class="w-full rounded-lg border-gray-300 text-xs focus:border-amber-500 focus:ring-amber-500">
                                                </div>
                                                <textarea name="description" rows="2"
                                                          class="w-full rounded-lg border-gray-300 text-xs focus:border-amber-500 focus:ring-amber-500">{{ $event->description }}</textarea>

                                                <button type="submit"
                                                        class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-700">
                                                    Salvar alterações
                                                </button>
                                            </form>
                                        </details>

                                        <form method="POST" action="{{ route('coordinator.calendar.destroy', $event) }}"
                                              onsubmit="return confirm('Deseja remover esta data do calendário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed p-4 text-center text-xs text-gray-500">
                                    Nenhum evento nesta coluna.
                                </div>
                            @endforelse
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>

    @if($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
