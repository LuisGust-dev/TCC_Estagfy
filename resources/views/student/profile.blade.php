@extends('student.layout')

@section('title', 'Meu Perfil')

@section('content')
@php($hideSuccess = true)
<div class="max-w-6xl mx-auto space-y-6">

    <section class="rounded-3xl border bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 p-8 text-white shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="h-20 w-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center overflow-hidden">
                @if($user->photo_url)
                    <img src="{{ $user->photo_url }}"
                         alt="Foto do aluno"
                         class="h-full w-full object-cover">
                @else
                    <span class="text-2xl font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @endif
            </div>
            <div class="min-w-0">
                <h1 class="text-2xl font-bold truncate">{{ $user->name }}</h1>
                <p class="text-sm text-blue-100 truncate">{{ $user->email }}</p>
                <p class="text-xs uppercase tracking-widest mt-2 text-blue-100/90">Perfil de Estudante</p>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('student.profile.update') }}"
          enctype="multipart/form-data"
          class="rounded-3xl border bg-white p-6 md:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h2 class="text-lg font-semibold text-gray-900">Informações pessoais</h2>
            <p class="text-sm text-gray-500">Mantenha seus dados atualizados para facilitar o processo seletivo.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">Nome completo</label>
                <input type="text"
                       id="student-name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       pattern="^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$"
                       title="Informe apenas letras e espaços."
                       maxlength="255"
                       data-name-only
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">E-mail</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">CPF</label>
                <input type="text"
                       id="student-cpf"
                       name="cpf"
                       value="{{ old('cpf', $student?->cpf) }}"
                       inputmode="numeric"
                       maxlength="14"
                       data-mask="cpf"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto de perfil</label>

                <div class="rounded-2xl border border-dashed border-blue-200 bg-blue-50/40 p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="h-16 w-16 rounded-xl bg-white border overflow-hidden flex items-center justify-center">
                            @if($user->photo_url)
                                <img src="{{ $user->photo_url }}"
                                     alt="Foto atual"
                                     class="h-full w-full object-cover">
                            @else
                                <span class="text-xl font-semibold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-2">Envie uma imagem JPG ou PNG (máx. 2MB).</p>
                            <input type="file"
                                   name="photo"
                                   accept="image/png,image/jpeg"
                                   class="w-full text-sm text-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Informações acadêmicas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-sm font-medium text-gray-700">Curso</label>
                    <input type="text"
                           value="{{ $student?->course ?? 'Nao informado' }}"
                           readonly
                           class="mt-1 w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-2.5 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Período</label>
                    <input type="text"
                           name="period"
                           value="{{ old('period', $student?->period) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="pt-2 border-t">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Currículo</h3>
            <p class="text-sm text-gray-500 mb-4">Arquivo usado nas candidaturas.</p>

            <div class="rounded-2xl border border-dashed border-blue-200 bg-blue-50/40 p-5 text-center">
                @if($student?->resume)
                    <p class="text-sm text-gray-700 mb-3">Currículo disponível</p>
                    <a href="{{ asset('storage/' . $student->resume) }}"
                       class="inline-flex items-center rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm text-blue-700 hover:bg-blue-50">
                        Ver currículo
                    </a>
                @else
                    <p class="text-sm text-gray-500">Nenhum currículo enviado.</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Atualizar currículo</label>
                <input type="file"
                       name="resume"
                       accept=".pdf,.doc,.docx"
                       class="w-full text-sm text-gray-600">
            </div>
        </div>

        <div class="pt-2 border-t">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Segurança</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700">Senha atual</label>
                    <div class="relative mt-1" data-password-wrapper>
                        <input type="password"
                               name="current_password"
                               data-password-field
                               placeholder="Digite sua senha atual para alterar"
                               class="w-full rounded-xl border-gray-300 px-4 py-2.5 pr-20 focus:border-blue-500 focus:ring-blue-500">
                        <button type="button"
                                onclick="const input=this.parentElement.querySelector('[data-password-field]'); if(!input) return; input.type = input.type === 'password' ? 'text' : 'password'; this.textContent = input.type === 'text' ? 'Ocultar' : 'Mostrar';"
                                data-password-toggle
                                class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-xs font-medium text-blue-600 hover:bg-blue-50">
                            Mostrar
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Nova senha</label>
                    <div class="relative mt-1" data-password-wrapper>
                        <input type="password"
                               name="password"
                               data-password-field
                               placeholder="Deixe em branco para manter a atual"
                               class="w-full rounded-xl border-gray-300 px-4 py-2.5 pr-20 focus:border-blue-500 focus:ring-blue-500">
                        <button type="button"
                                onclick="const input=this.parentElement.querySelector('[data-password-field]'); if(!input) return; input.type = input.type === 'password' ? 'text' : 'password'; this.textContent = input.type === 'text' ? 'Ocultar' : 'Mostrar';"
                                data-password-toggle
                                class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-xs font-medium text-blue-600 hover:bg-blue-50">
                            Mostrar
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Confirmar nova senha</label>
                    <div class="relative mt-1" data-password-wrapper>
                        <input type="password"
                               name="password_confirmation"
                               data-password-field
                               placeholder="Repita a nova senha"
                               class="w-full rounded-xl border-gray-300 px-4 py-2.5 pr-20 focus:border-blue-500 focus:ring-blue-500">
                        <button type="button"
                                onclick="const input=this.parentElement.querySelector('[data-password-field]'); if(!input) return; input.type = input.type === 'password' ? 'text' : 'password'; this.textContent = input.type === 'text' ? 'Ocultar' : 'Mostrar';"
                                data-password-toggle
                                class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-xs font-medium text-blue-600 hover:bg-blue-50">
                            Mostrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                Salvar alteracoes
            </button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const applyCpfMask = (value) => {
            const digits = value.replace(/\D/g, '').slice(0, 11);
            return digits
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        };

        document.querySelectorAll('input[data-mask="cpf"]').forEach((input) => {
            input.addEventListener('input', () => {
                input.value = applyCpfMask(input.value);
            });
            input.value = applyCpfMask(input.value);
        });

        document.querySelectorAll('input[data-name-only]').forEach((input) => {
            input.addEventListener('input', () => {
                const sanitized = input.value.replace(/[^\pL\s]/gu, '');
                if (input.value !== sanitized) input.value = sanitized;
            });
        });

    });
</script>
@endsection
