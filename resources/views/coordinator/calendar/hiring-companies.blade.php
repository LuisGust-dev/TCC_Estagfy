@extends('coordinator.layout')

@section('title', 'Empresas Destaque')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenacao</p>
        <h1 class="text-2xl font-bold text-gray-900">Empresas que mais contratam</h1>
        <p class="text-gray-600">Cadastro manual das empresas destaque por curso.</p>
    </div>

    <div class="mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ route('coordinator.calendar.index', ['course' => $selectedCourse]) }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Novo evento
        </a>
        <a href="{{ route('coordinator.calendar.events', ['course' => $selectedCourse]) }}"
           class="rounded-lg border px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
            Eventos cadastrados
        </a>
        <a href="{{ route('coordinator.calendar.hiring-companies.index', ['course' => $selectedCourse]) }}"
           class="rounded-lg bg-amber-600 px-3 py-2 text-sm font-medium text-white">
            Empresas destaque
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border bg-white p-4 shadow-sm lg:sticky lg:top-6">
                <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Cursos</p>

                <nav class="space-y-1">
                    @foreach($courses as $course)
                        <a href="{{ route('coordinator.calendar.hiring-companies.index', ['course' => $course]) }}"
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

        <section class="space-y-6 lg:col-span-3">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Nova empresa destaque</h2>
                <p class="mb-4 text-sm text-gray-500">Curso selecionado: <strong>{{ $selectedCourse }}</strong></p>

                <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course" value="{{ $selectedCourse }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nome da empresa</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Descricao (opcional)</label>
                            <textarea name="description" rows="2"
                                      class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="rounded-xl bg-amber-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-amber-700">
                            Salvar empresa
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border bg-white shadow-sm">
                <div class="border-b px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Lista cadastrada</h2>
                    <p class="text-sm text-gray-500">Curso: {{ $selectedCourse }}</p>
                </div>

                <div class="p-6">
                    <article class="rounded-2xl border bg-white shadow-sm">
                        <header class="rounded-t-2xl border-b border-amber-200 bg-amber-50 px-4 py-3 text-amber-700">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                    <h3 class="text-sm font-semibold">Empresas destaque</h3>
                                </div>
                                <span class="rounded-full bg-white/80 px-2 py-0.5 text-xs font-semibold">
                                    {{ $companies->count() }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs">Cards com informacoes e acoes de gerenciamento.</p>
                        </header>

                        <div class="max-h-[60vh] space-y-3 overflow-y-auto p-3">
                            @forelse($companies as $company)
                                <article class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                    <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.update', $company) }}" class="space-y-3">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="course" value="{{ $selectedCourse }}">

                                        <input type="text" name="company_name" value="{{ $company->company_name }}"
                                               class="w-full rounded-lg border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">

                                        <textarea name="description" rows="2"
                                                  class="w-full rounded-lg border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">{{ $company->description }}</textarea>

                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-xs text-gray-500">
                                                Atualizado em {{ $company->updated_at?->format('d/m/Y H:i') }}
                                            </span>
                                            <button type="submit"
                                                    class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-amber-700">
                                                Atualizar
                                            </button>
                                        </div>
                                    </form>

                                    <div class="mt-2 flex justify-end">
                                        <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.destroy', $company) }}"
                                              onsubmit="return confirm('Deseja remover esta empresa da lista?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed p-6 text-center text-xs text-gray-500">
                                    Nenhuma empresa destaque cadastrada para este curso.
                                </div>
                            @endforelse
                        </div>
                    </article>
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
