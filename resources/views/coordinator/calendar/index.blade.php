@extends('coordinator.layout')

@section('title', 'Calendário de Estágio')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenação</p>
        <h1 class="text-2xl font-bold text-gray-900">Calendário de Estágio</h1>
        <p class="text-gray-600">Cadastre novas datas e mantenha o cronograma atualizado por curso.</p>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Curso selecionado</p>
            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $selectedCourse ?? 'Não definido' }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Eventos no curso</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $eventsCount }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Acesso rápido</p>
            <a href="{{ route('coordinator.calendar.events') }}"
               class="mt-1 inline-flex text-sm font-semibold text-amber-700 hover:text-amber-800">
                Ver lista de eventos
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <section>
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
                            <label class="mb-1 block text-sm font-medium text-gray-700">Título</label>
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
                            <label class="mb-1 block text-sm font-medium text-gray-700">Descrição (opcional)</label>
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
