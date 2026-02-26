@extends('company.layout')

@section('title', isset($job) ? 'Editar Vaga' : 'Nova Vaga')

@section('content')
@php
    $isEdit = isset($job);
    $requirementsInput = old('requirements', $isEdit ? ($job->requirements ?? []) : []);
    if (empty($requirementsInput)) {
        $requirementsInput = [''];
    }
@endphp
<div class="max-w-5xl mx-auto">

    {{-- Voltar --}}
    <a href="{{ route('company.jobs.index') }}"
        class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
        ← Voltar
    </a>

    {{-- Header --}}
    <h1 class="text-3xl font-bold text-gray-800">{{ $isEdit ? 'Editar Vaga' : 'Nova Vaga' }}</h1>
    <p class="text-gray-500 mb-8">{{ $isEdit ? 'Atualize as informações da vaga de estágio' : 'Preencha as informações da vaga de estágio' }}</p>

    {{-- Card --}}
    <form action="{{ $isEdit ? route('company.jobs.update', $job) : route('company.jobs.store') }}"
        method="POST"
        novalidate
        class="bg-white border rounded-2xl p-8 md:p-10 shadow-sm space-y-8">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        {{-- Título --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Título da vaga</label>
            <input type="text" name="title"
                value="{{ old('title', $isEdit ? $job->title : '') }}"
                placeholder="Ex: Estágio em..."
                required
                class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descrição --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="5"
                placeholder="Descreva as atividades e responsabilidades do estágio..."
                required
                class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description', $isEdit ? $job->description : '') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Grid 2 col --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Localização</label>
                <input type="text" name="location"
                    value="{{ old('location', $isEdit ? $job->location : '') }}"
                    placeholder="Ex: Guanambi, Ba"
                    required
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('location')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de trabalho</label>
                <select name="type" required
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="Presencial" @selected(old('type', $isEdit ? $job->type : 'Presencial') === 'Presencial')>Presencial</option>
                    <option value="Remoto" @selected(old('type', $isEdit ? $job->type : null) === 'Remoto')>Remoto</option>
                    <option value="Híbrido" @selected(old('type', $isEdit ? $job->type : null) === 'Híbrido')>Híbrido</option>
                </select>
                @error('type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Remuneração</label>
                <input type="number" name="salary"
                    value="{{ old('salary', $isEdit ? $job->salary : '') }}"
                    placeholder="Ex: 400.00"
                    min="0"
                    step="0.01"
                    required
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('salary')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade de vagas</label>
                <select name="vacancies" required
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" @selected((int) old('vacancies', $isEdit ? $job->vacancies : 1) === $i)>{{ $i }}</option>
                    @endfor
                </select>
                @error('vacancies')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fluxo da vaga</label>
                <select name="flow_type" id="flow_type" required
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="continuous" @selected(old('flow_type', $isEdit ? $job->flow_type : 'continuous') === 'continuous')>Fluxo contínuo</option>
                    <option value="defined_period" @selected(old('flow_type', $isEdit ? $job->flow_type : null) === 'defined_period')>Período definido</option>
                </select>
                <p id="flow_type_hint" class="mt-2 text-xs text-gray-500">
                    Fluxo contínuo: a vaga fica ativa até preencher todas as vagas disponíveis.
                </p>
                @error('flow_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Curso</label>
                <select name="area" required
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Selecione o Curso</option>
                    @foreach($courses as $course)
                        <option value="{{ $course }}" @selected(old('area', $isEdit ? $job->area : null) === $course)>{{ $course }}</option>
                    @endforeach
                </select>
                @error('area')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="period_start_wrap" class="{{ old('flow_type', $isEdit ? $job->flow_type : 'continuous') === 'defined_period' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data inicial do período</label>
                <input type="date" name="period_start" value="{{ old('period_start', $isEdit && $job->period_start ? $job->period_start->format('Y-m-d') : '') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('period_start')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="period_end_wrap" class="{{ old('flow_type', $isEdit ? $job->flow_type : 'continuous') === 'defined_period' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data final do período</label>
                <input type="date" name="period_end" value="{{ old('period_end', $isEdit && $job->period_end ? $job->period_end->format('Y-m-d') : '') }}"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('period_end')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Requisitos --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos</label>
            <div id="requirements-list" class="space-y-3">
                @foreach($requirementsInput as $requirement)
                    <input type="text" name="requirements[]"
                        value="{{ $requirement }}"
                        placeholder="Ex: Conhecimento básico em React"
                        required
                        class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @endforeach
            </div>
            @error('requirements')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @error('requirements.0')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button type="button" id="add-requirement"
                class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-xl border text-sm text-gray-700 hover:bg-gray-50">
                <span class="text-lg leading-none">+</span>
                Adicionar requisito
            </button>
        </div>

        {{-- Botões --}}
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6">
            <a href="{{ route('company.jobs.index') }}"
                class="px-6 py-3 rounded-xl border text-center text-gray-600 hover:bg-gray-50">
                Cancelar
            </a>

            <button type="submit"
                class="px-8 py-3 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                {{ $isEdit ? 'Salvar alterações' : 'Publicar Vaga' }}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addButton = document.getElementById('add-requirement');
        const list = document.getElementById('requirements-list');
        const flowType = document.getElementById('flow_type');
        const periodStartWrap = document.getElementById('period_start_wrap');
        const periodEndWrap = document.getElementById('period_end_wrap');
        const flowTypeHint = document.getElementById('flow_type_hint');

        addButton.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'requirements[]';
            input.placeholder = 'Ex: Conhecimento básico em React';
            input.className = 'w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none';
            list.appendChild(input);
            input.focus();
        });

        function togglePeriodFields() {
            const isDefinedPeriod = flowType.value === 'defined_period';
            periodStartWrap.classList.toggle('hidden', !isDefinedPeriod);
            periodEndWrap.classList.toggle('hidden', !isDefinedPeriod);
            const periodStartInput = periodStartWrap.querySelector('input[name="period_start"]');
            const periodEndInput = periodEndWrap.querySelector('input[name="period_end"]');
            periodStartInput.required = isDefinedPeriod;
            periodEndInput.required = isDefinedPeriod;

            flowTypeHint.textContent = isDefinedPeriod
                ? 'Período definido: a vaga ficará ativa somente entre a data inicial e a data final.'
                : 'Fluxo contínuo: a vaga fica ativa até preencher todas as vagas disponíveis.';
        }

        flowType.addEventListener('change', togglePeriodFields);
        togglePeriodFields();
    });
</script>

@endsection
