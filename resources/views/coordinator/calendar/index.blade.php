@extends('coordinator.layout')

@section('title', 'Calendario de Estagio')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenacao</p>
        <h1 class="text-2xl font-bold text-gray-900">Calendario de Estagio</h1>
        <p class="text-gray-600">Cadastre novas datas e mantenha o cronograma atualizado por curso.</p>
    </div>

    <div class="mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ route('coordinator.calendar.index', ['course' => $selectedCourse]) }}"
           class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('coordinator.calendar.index') ? 'bg-amber-600 text-white' : 'border text-gray-600 hover:bg-gray-100' }}">
            Novo evento
        </a>
        <a href="{{ route('coordinator.calendar.events', ['course' => $selectedCourse]) }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Eventos cadastrados
        </a>
        <a href="{{ route('coordinator.calendar.hiring-companies.index', ['course' => $selectedCourse]) }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Empresas destaque
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Curso selecionado</p>
            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $selectedCourse ?? 'Nao definido' }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Eventos no curso</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $eventsCount }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Acesso rapido</p>
            <a href="{{ route('coordinator.calendar.events', ['course' => $selectedCourse]) }}"
               class="mt-1 inline-flex text-sm font-semibold text-amber-700 hover:text-amber-800">
                Ver lista de eventos
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border bg-white p-4 shadow-sm lg:sticky lg:top-6">
                <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Cursos</p>

                <nav class="space-y-1">
                    @foreach($courses as $course)
                        <a href="{{ route('coordinator.calendar.index', ['course' => $course]) }}"
                           class="flex items-center justify-between rounded-lg px-3 py-2 text-sm transition {{ $selectedCourse === $course ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>{{ $course }}</span>
                            <span class="rounded-full px-2 py-0.5 text-xs {{ $selectedCourse === $course ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $courseCounts[$course] ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        <section class="lg:col-span-3">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Novo evento</h2>
                    <p class="text-sm text-gray-500">Curso: <strong>{{ $selectedCourse }}</strong></p>
                </div>

                <form method="POST" action="{{ route('coordinator.calendar.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course" value="{{ $selectedCourse }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Titulo</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Data inicial</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Data final (opcional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Descricao (opcional)</label>
                            <textarea name="description" rows="3"
                                      class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="rounded-xl bg-amber-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-amber-700">
                            Salvar evento
                        </button>
                    </div>
                </form>
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
