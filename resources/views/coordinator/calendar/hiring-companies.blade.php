@extends('coordinator.layout')

@section('title', 'Empresas Destaque')

@section('content')
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-amber-50 via-white to-orange-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Coordenação</p>
        <h1 class="text-2xl font-bold text-gray-900">Empresas que mais contratam</h1>
        <p class="text-gray-600">Cadastro manual das empresas destaque por curso.</p>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Curso selecionado</p>
            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $selectedCourse ?? 'Não definido' }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Empresas cadastradas</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $companiesCount ?? 0 }}</p>
        </div>
        <div class="rounded-2xl border bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Última atualização</p>
            <p class="mt-1 text-sm font-semibold text-gray-900">
                {{ $latestUpdateAt ? $latestUpdateAt->format('d/m/Y H:i') : 'Sem registros' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <section class="space-y-6">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Nova empresa destaque</h2>
                <p class="mb-4 text-sm text-gray-500">Curso selecionado: <strong>{{ $selectedCourse }}</strong></p>

                <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course" value="{{ $selectedCourse }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nome da empresa</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>

                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Descrição (opcional)</label>
                            <textarea name="description" rows="2"
                                      class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                        </div>

                        <div class="md:col-span-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Foto da empresa (opcional)</label>
                            <input type="file" name="photo" accept="image/png,image/jpeg"
                                   class="w-full rounded-xl border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                            <p class="mt-1 text-xs text-gray-500">Envie uma logo ou imagem da empresa em JPG ou PNG, até 2MB.</p>
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
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Lista cadastrada</h2>
                            <p class="text-sm text-gray-500">Curso: {{ $selectedCourse }}</p>
                        </div>
                        <form method="GET" action="{{ route('coordinator.calendar.hiring-companies.index') }}" class="w-full lg:w-auto">
                            <div class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 focus-within:border-amber-400 focus-within:ring-2 focus-within:ring-amber-100">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <path d="M20 20l-3.5-3.5"></path>
                                </svg>
                                <input
                                    type="text"
                                    name="q"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Buscar empresa ou descrição..."
                                    class="w-full bg-transparent text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none lg:w-72"
                                >
                                <button
                                    type="submit"
                                    class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-amber-700"
                                >
                                    Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="p-6">
                    <div class="max-h-[62vh] space-y-4 overflow-y-auto pr-1">
                        @forelse($companies as $company)
                            <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                                <div class="mb-3 flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-start gap-3">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-amber-100 bg-amber-50">
                                            @if($company->photo_url)
                                                <img src="{{ $company->photo_url }}" alt="Foto da empresa" class="h-full w-full object-cover">
                                            @else
                                                <span class="text-sm font-bold text-amber-700">{{ strtoupper(substr($company->company_name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Empresa destaque</p>
                                            <p class="truncate text-base font-semibold text-gray-900">{{ $company->company_name }}</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                        #{{ $loop->iteration }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.update', $company) }}" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="course" value="{{ $selectedCourse }}">

                                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                                        <div class="lg:col-span-2">
                                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Nome da empresa</label>
                                            <input
                                                type="text"
                                                name="company_name"
                                                value="{{ $company->company_name }}"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500"
                                            >
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Atualizado em</label>
                                            <p class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600">
                                                {{ $company->updated_at?->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <div class="lg:col-span-3">
                                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Descrição</label>
                                            <textarea
                                                name="description"
                                                rows="2"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500"
                                            >{{ $company->description }}</textarea>
                                        </div>
                                        <div class="lg:col-span-3">
                                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Foto da empresa</label>
                                            <input
                                                type="file"
                                                name="photo"
                                                accept="image/png,image/jpeg"
                                                class="w-full rounded-lg border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500"
                                            >
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <button
                                            type="submit"
                                            class="rounded-lg bg-amber-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-700"
                                        >
                                            Salvar alterações
                                        </button>
                                    </div>
                                </form>
                                <form method="POST" action="{{ route('coordinator.calendar.hiring-companies.destroy', $company) }}"
                                      class="flex justify-end"
                                      onsubmit="return confirm('Deseja remover esta empresa da lista?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="rounded-lg border border-red-200 px-4 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                    >
                                        Excluir
                                    </button>
                                </form>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed p-8 text-center">
                                <p class="text-sm font-semibold text-gray-700">Nenhuma empresa destaque cadastrada</p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Cadastre empresas para o curso selecionado e acompanhe a lista por aqui.
                                </p>
                            </div>
                        @endforelse
                    </div>
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
