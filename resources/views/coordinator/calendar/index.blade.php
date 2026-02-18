@extends('coordinator.layout')

@section('title', 'Calendario de Estagio')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenacao</p>
        <h1 class="text-2xl font-bold text-gray-900">Calendario de Estagio</h1>
        <p class="text-gray-600">Organize as datas por curso para manter o calendario limpo e focado.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border bg-white p-4 shadow-sm">
                <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Cursos</p>

                <nav class="space-y-1">
                    @foreach($courses as $course)
                        <a href="{{ route('coordinator.calendar.index', ['course' => $course]) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ $selectedCourse === $course ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>{{ $course }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $selectedCourse === $course ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $courseCounts[$course] ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        <section class="lg:col-span-3 space-y-6">
            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Novo evento</h2>
                <p class="text-sm text-gray-500 mb-4">Curso selecionado: <strong>{{ $selectedCourse }}</strong></p>

                <form method="POST" action="{{ route('coordinator.calendar.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course" value="{{ $selectedCourse }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titulo</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data inicial</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data final (opcional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descricao (opcional)</label>
                        <textarea name="description" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit"
                            class="rounded-lg bg-amber-600 px-4 py-2 text-white font-medium hover:bg-amber-700">
                        Salvar data
                    </button>
                </form>
            </div>

            <div class="rounded-2xl border bg-white shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Datas cadastradas</h2>
                    <p class="text-sm text-gray-500">Curso: {{ $selectedCourse }}</p>
                </div>

                <div class="divide-y">
                    @forelse($events as $event)
                        <div class="p-5">
                            <form method="POST" action="{{ route('coordinator.calendar.update', $event) }}" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="course" value="{{ $selectedCourse }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input type="text" name="title" value="{{ $event->title }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                    <input type="text" value="Criado em {{ $event->created_at?->format('d/m/Y H:i') }}" disabled
                                           class="rounded-lg border-gray-200 bg-gray-50 text-gray-500">
                                    <input type="date" name="start_date" value="{{ $event->start_date?->format('Y-m-d') }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                    <input type="date" name="end_date" value="{{ $event->end_date?->format('Y-m-d') }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                </div>

                                <textarea name="description" rows="2"
                                          class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">{{ $event->description }}</textarea>

                                <div class="flex items-center gap-2">
                                    <button type="submit"
                                            class="rounded-lg bg-amber-600 px-3 py-1.5 text-sm text-white font-medium hover:bg-amber-700">
                                        Atualizar
                                    </button>
                            </form>

                            <form method="POST" action="{{ route('coordinator.calendar.destroy', $event) }}"
                                  onsubmit="return confirm('Deseja remover esta data do calendario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-600 font-medium hover:bg-red-50">
                                    Excluir
                                </button>
                            </form>
                                </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Nenhuma data cadastrada para este curso.
                        </div>
                    @endforelse
                </div>
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
