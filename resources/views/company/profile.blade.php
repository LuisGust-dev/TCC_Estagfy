@extends('company.layout')

@section('title', 'Perfil da Empresa')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Título --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Perfil da Empresa</h1>
        <p class="text-gray-500">Gerencie as informações da sua empresa</p>
    </div>

    {{-- Card principal --}}
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        {{-- Header verde --}}
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-400 p-8 text-center text-white">
            <div class="mx-auto w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                🏢
            </div>
            <h2 class="text-xl font-semibold">
                {{ auth()->user()->name }}
            </h2>
            <p class="text-sm opacity-90">
                {{ $company->cnpj ?? 'CNPJ não informado' }}
            </p>
        </div>

        {{-- Conteúdo --}}
        <div class="p-8">

            {{-- Cabeçalho --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    Informações da Empresa
                </h3>

                <a href="{{ route('company.profile.edit') }}"
                   class="flex items-center gap-2 border px-4 py-1.5 rounded-lg text-sm hover:bg-gray-50">
                    ✏️ Editar
                </a>
            </div>

            {{-- Formulário --}}
            <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nome --}}
                <div>
                    <label class="text-sm text-gray-600">Nome da empresa</label>
                    <input type="text" name="name"
                           value="{{ auth()->user()->name }}"
                           class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                </div>

                {{-- CNPJ --}}
                <div>
                    <label class="text-sm text-gray-600">CNPJ</label>
                    <input type="text" name="cnpj"
                           value="{{ $company->cnpj }}"
                           class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                </div>

                {{-- Email e telefone --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-600">E-mail</label>
                        <input type="email" name="email"
                               value="{{ auth()->user()->email }}"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Telefone</label>
                        <input type="text" name="phone"
                               value="{{ $company->phone }}"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                    </div>
                </div>

                {{-- Descrição --}}
                <div>
                    <label class="text-sm text-gray-600">Descrição</label>
                    <textarea name="description" rows="4"
                              class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">{{ $company->description }}</textarea>
                </div>

                {{-- Logo --}}
                <div class="pt-6 border-t">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        Logo da Empresa
                    </h4>

                    <div class="border-2 border-dashed rounded-xl p-6 text-center bg-gray-50">
                        <div class="text-3xl mb-2">⬆️</div>
                        <p class="text-gray-500 text-sm mb-3">
                            Arraste uma imagem ou clique para fazer upload
                        </p>
                        <input type="file" name="logo" class="hidden" id="logo">
                        <label for="logo"
                               class="inline-block border px-4 py-2 rounded-lg text-sm cursor-pointer hover:bg-gray-100">
                            Enviar Logo
                        </label>
                    </div>
                </div>

                {{-- Botão --}}
                <div class="pt-6 text-right">
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg">
                        Salvar Alterações
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
