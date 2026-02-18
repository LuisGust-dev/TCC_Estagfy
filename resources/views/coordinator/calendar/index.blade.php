@extends('coordinator.layout')

@section('title', 'Calendario de Estagio')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenacao</p>
        <h1 class="text-2xl font-bold text-gray-900">Calendario de Estagio</h1>
        <p class="text-gray-600">Cadastre e mantenha as datas oficiais do periodo de estagio.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-1">
            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Nova data</h2>

                <form method="POST" action="{{ route('coordinator.calendar.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titulo</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                    </div>

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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descricao (opcional)</label>
                        <textarea name="description" rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg bg-amber-600 px-4 py-2 text-white font-medium hover:bg-amber-700">
                        Salvar data
                    </button>
                </form>
            </div>
        </section>

        <section class="lg:col-span-2">
            <div class="rounded-2xl border bg-white shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Datas cadastradas</h2>
                </div>

                <div class="divide-y">
                    @forelse($events as $event)
                        <div class="p-5">
                            <form method="POST" action="{{ route('coordinator.calendar.update', $event) }}" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input type="text" name="title" value="{{ $event->title }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                    <input type="date" name="start_date" value="{{ $event->start_date?->format('Y-m-d') }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                    <input type="date" name="end_date" value="{{ $event->end_date?->format('Y-m-d') }}"
                                           class="rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                                    <input type="text" value="Criado em {{ $event->created_at?->format('d/m/Y H:i') }}" disabled
                                           class="rounded-lg border-gray-200 bg-gray-50 text-gray-500">
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
                            Nenhuma data cadastrada ainda.
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
