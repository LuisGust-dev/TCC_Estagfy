@extends('company.layout')

@section('title', 'Nova Vaga')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Voltar --}}
    <a href="{{ route('company.jobs.index') }}"
        class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
        ← Voltar
    </a>

    {{-- Header --}}
    <h1 class="text-3xl font-bold text-gray-800">Nova Vaga</h1>
    <p class="text-gray-500 mb-8">Preencha as informações da vaga de estágio</p>

    {{-- Card --}}
    <form action="{{ route('company.jobs.store') }}"
        method="POST"
        class="bg-white border rounded-2xl p-8 md:p-10 shadow-sm space-y-8">
        @csrf

        {{-- Título --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Título da vaga</label>
            <input type="text" name="title"
                placeholder="Ex: Estágio em Desenvolvimento Web"
                class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Descrição --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="5"
                placeholder="Descreva as atividades e responsabilidades do estágio..."
                class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
        </div>

        {{-- Grid 2 col --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Localização</label>
                <input type="text" name="location"
                    placeholder="Ex: São Paulo, SP"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de trabalho</label>
                <select name="type"
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="Presencial">Presencial</option>
                    <option value="Remoto">Remoto</option>
                    <option value="Híbrido">Híbrido</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Remuneração</label>
                <input type="text" name="salary"
                    placeholder="Ex: R$ 1.800,00"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                <input type="text" name="area"
                    placeholder="Ex: Tecnologia"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
        </div>

        {{-- Requisitos --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos</label>
            <div id="requirements-list" class="space-y-3">
                <input type="text" name="requirements[]"
                    placeholder="Ex: Conhecimento básico em React"
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
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
                Publicar Vaga
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addButton = document.getElementById('add-requirement');
        const list = document.getElementById('requirements-list');

        addButton.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'requirements[]';
            input.placeholder = 'Ex: Conhecimento básico em React';
            input.className = 'w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none';
            list.appendChild(input);
            input.focus();
        });
    });
</script>

@endsection
