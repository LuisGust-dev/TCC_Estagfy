@extends('student.layout')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Título --}}
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Perfil do Aluno</h1>
        <p class="text-gray-500">Confira suas informações acadêmicas</p>
    </div>

    {{-- Card principal --}}
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        {{-- Header azul --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-8 text-center text-white">
            <div class="mx-auto w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mb-4 overflow-hidden">
                @if($user->photo)
                    <img
                        src="{{ asset('storage/' . $user->photo) }}"
                        alt="Foto do aluno"
                        class="w-full h-full object-cover"
                    >
                @else
                    <span class="text-2xl font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @endif
            </div>
            <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
            <p class="text-sm opacity-90">{{ $user->email }}</p>
        </div>

        {{-- Conteúdo --}}
        <div class="p-8">

            {{-- Cabeçalho --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    Informações do Estudante
                </h3>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm text-gray-600">Nome completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-600">E-mail</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Status</label>
                        <input type="text" value="Estudante"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50" readonly>
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-600">CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf', $student?->cpf) }}"
                           class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-600">Curso</label>
                        <input type="text" name="course" value="{{ old('course', $student?->course) }}"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Período</label>
                        <input type="text" name="period" value="{{ old('period', $student?->period) }}"
                               class="w-full mt-1 border rounded-lg px-4 py-2 bg-gray-50">
                    </div>
                </div>

                <div class="pt-6 border-t">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        Currículo do Aluno
                    </h4>

                    <div class="border-2 border-dashed rounded-xl p-6 text-center bg-gray-50">
                        @if($student?->resume)
                            <div class="text-3xl mb-2">📄</div>
                            <p class="text-gray-500 text-sm mb-3">
                                Currículo disponível para visualização
                            </p>
                            <a href="{{ asset('storage/' . $student->resume) }}"
                               class="inline-block border px-4 py-2 rounded-lg text-sm hover:bg-gray-100">
                                Ver Currículo
                            </a>
                        @else
                            <div class="text-3xl mb-2">⬆️</div>
                            <p class="text-gray-500 text-sm mb-3">
                                Nenhum currículo enviado
                            </p>
                        @endif
                        <div class="mt-4">
                            <label class="block text-sm text-gray-600 mb-2">Atualizar currículo</label>
                            <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
