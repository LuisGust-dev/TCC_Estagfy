@extends('student.layout')

@section('title', 'Calendário de Estágio')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-blue-50 via-white to-cyan-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-500">Calendário Informativo</p>
        <h1 class="text-2xl font-bold text-gray-800">Calendário de Estágio</h1>
        <p class="text-gray-600">
            Visualize prazos e datas importantes do seu curso.
        </p>
        @if(!empty($studentCourse))
            <p class="mt-2 text-sm text-blue-700">Curso: <strong>{{ $studentCourse }}</strong></p>
        @endif
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <section class="xl:col-span-2 rounded-2xl border bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-900 capitalize">
                    {{ \Illuminate\Support\Str::ucfirst($monthStart->locale('pt_BR')->isoFormat('MMMM [de] YYYY')) }}
                </h2>

                <div class="flex items-center gap-2">
                    <a href="{{ route('student.calendar.index', ['month' => $prevMonth]) }}"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border text-gray-600 transition hover:bg-gray-100">
                        <span aria-hidden="true">&#8249;</span>
                    </a>
                    <a href="{{ route('student.calendar.index', ['month' => now()->format('Y-m')]) }}"
                       class="rounded-lg border px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-100">
                        Hoje
                    </a>
                    <a href="{{ route('student.calendar.index', ['month' => $nextMonth]) }}"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border text-gray-600 transition hover:bg-gray-100">
                        <span aria-hidden="true">&#8250;</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-xs font-semibold uppercase tracking-wide text-gray-400">
                <div>Dom</div>
                <div>Seg</div>
                <div>Ter</div>
                <div>Qua</div>
                <div>Qui</div>
                <div>Sex</div>
                <div>Sab</div>
            </div>

            <div class="mt-3 grid grid-cols-7 gap-2">
                @for($i = 0; $i < $offset; $i++)
                    <div class="h-24 rounded-xl border border-transparent bg-gray-50/60"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $date = $monthStart->copy()->day($day);
                        $dateKey = $date->toDateString();
                        $dayEvents = $eventsByDate[$dateKey] ?? [];
                        $firstDayEvent = $dayEvents[0] ?? null;
                        $isToday = $date->isToday();
                    @endphp

                    <div class="h-24 rounded-xl border p-2 transition hover:shadow-sm {{ $firstDayEvent ? $firstDayEvent['style']['day'] : 'border-gray-100 bg-white' }} {{ $isToday ? 'ring-2 ring-blue-200' : '' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold {{ $isToday ? 'text-blue-700' : 'text-gray-700' }}">
                                {{ $day }}
                            </span>
                            @if(count($dayEvents) > 0)
                                <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $firstDayEvent['style']['pill'] }}">
                                    {{ count($dayEvents) }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-2 space-y-1">
                            @foreach(array_slice($dayEvents, 0, 2) as $event)
                                <div class="truncate rounded-md px-2 py-1 text-[10px] font-medium border {{ $event['style']['soft'] }}">
                                    {{ $event['title'] }}
                                </div>
                            @endforeach
                            @if(count($dayEvents) > 2)
                                <div class="text-[10px] text-gray-500">
                                    +{{ count($dayEvents) - 2 }} evento(s)
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor

                @for($i = 0; $i < $trailingDays; $i++)
                    <div class="h-24 rounded-xl border border-transparent bg-gray-50/60"></div>
                @endfor
            </div>
        </section>

        <aside class="space-y-4">
            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Eventos do mês</h3>

                <div class="mt-4 space-y-3">
                    @forelse($upcomingEvents as $event)
                        <article class="rounded-xl border p-3 {{ $event['style']['soft'] }}">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full {{ $event['style']['dot'] }}"></span>
                                <span class="text-xs font-semibold uppercase tracking-wide">
                                    {{ $event['style']['label'] }}
                                </span>
                            </div>
                            <h4 class="mt-2 text-sm font-semibold text-gray-900">{{ $event['title'] }}</h4>
                            <p class="mt-1 text-xs text-gray-600">
                                @if($event['end_date'] && !$event['start_date']->isSameDay($event['end_date']))
                                    {{ $event['start_date']->format('d/m/Y') }} até {{ $event['end_date']->format('d/m/Y') }}
                                @else
                                    {{ $event['start_date']->format('d/m/Y') }}
                                @endif
                            </p>
                            @if(!empty($event['description']))
                                <p class="mt-2 text-xs leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($event['description'], 90) }}
                                </p>
                            @endif
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed p-4 text-sm text-gray-500">
                            Nenhum evento cadastrado para este mês.
                        </div>
                    @endforelse
                </div>
            </div>

           

            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-700">Empresas que mais contratam</h3>

                <div class="mt-3 space-y-3">
                    @forelse($topHiringCompanies as $company)
                        <article class="rounded-xl border border-blue-100 bg-blue-50/40 p-3">
                            <div class="flex items-start gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-blue-100 bg-white">
                                    @if($company->photo_url)
                                        <img src="{{ $company->photo_url }}" alt="Foto da empresa" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-sm font-bold text-blue-700">{{ strtoupper(substr($company->company_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $company->company_name }}</h4>
                                    @if(!empty($company->description))
                                        <p class="mt-2 text-xs leading-relaxed text-gray-600">
                                            {{ \Illuminate\Support\Str::limit($company->description, 95) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed p-4 text-sm text-gray-500">
                            Nenhuma empresa destaque cadastrada para seu curso.
                        </div>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>

    @if(empty($studentCourse))
        <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            Defina seu curso no perfil para visualizar o calendário específico da sua área.
        </div>
    @endif
@endsection
