<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno | EstagFy</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .estagfy-animated-gradient {
            background: linear-gradient(
                120deg,
                rgba(37, 99, 235, 0.5),
                rgba(59, 130, 246, 0.5),
rgb(74, 71, 228)
            );
            background-size: 200% 200%;
            animation: estagfyGradient 12s ease infinite;
        }

        @keyframes estagfyGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-slate-50 text-gray-900">

<div class="h-screen overflow-hidden grid grid-cols-1 lg:grid-cols-2">

    {{-- LADO ESQUERDO --}}
    <div class="relative flex items-center justify-center px-6 py-10 lg:py-12">
        <div class="absolute -top-16 -right-12 w-56 h-56 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 w-64 h-64 rounded-full bg-indigo-200/40 blur-3xl"></div>

        <div class="w-full max-w-xl">
            <div class="bg-white/80 backdrop-blur border border-white shadow-2xl rounded-3xl p-8 md:p-10">

                {{-- voltar --}}
                <a href="{{ route('register.choice') }}" class="text-sm text-gray-500 hover:underline">
                    ← Voltar
                </a>

                <h1 class="text-2xl font-bold text-gray-800 mt-6 mb-1">
                    Cadastro de Aluno
                </h1>

                <p class="text-gray-500 mb-6">
                    Preencha os dados abaixo para criar sua conta
                </p>

                <form method="POST"
                      action="{{ route('register.student.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">

                    @csrf

                    {{-- Foto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Foto de perfil (opcional)
                        </label>
                        <input type="file"
                               name="photo"
                               accept="image/*"
                               class="mt-2 w-full border-2 border-dashed rounded-xl p-4 text-sm text-gray-500 bg-white">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nome --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nome completo
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="255"
                               class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Seu nome completo">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- CPF --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            CPF
                        </label>
                        <input type="text" name="cpf" value="{{ old('cpf') }}" required inputmode="numeric" pattern="[0-9]*" maxlength="11"
                               data-only-digits data-maxlen="11"
                               class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="00000000000">
                        @error('cpf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            E-mail
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required maxlength="255"
                               class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="seu@email.com">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Senha
                        </label>
                        <input type="password" name="password" required minlength="6" maxlength="255"
                               class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="••••••••">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Curso / Período --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Curso
                            </label>
                            <input type="text" name="course" value="{{ old('course') }}" required maxlength="255"
                                   class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Ex: Eng. Software">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Período
                            </label>
                            <input type="text" name="period" value="{{ old('period') }}" required maxlength="50"
                                   class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Ex: 6º período">
                        </div>
                    </div>

                    {{-- Currículo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Currículo (PDF ou DOC)
                        </label>
                        <input type="file" name="resume" required
                               class="mt-2 w-full border-2 border-dashed rounded-xl p-4 text-sm text-gray-500 bg-white">
                        @error('resume')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Botão --}}
                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition">
                        Criar conta
                    </button>

                </form>

                <p class="mt-8 text-sm text-gray-500 text-center">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        Fazer login
                    </a>
                </p>

            </div>
        </div>
    </div>

    {{-- LADO DIREITO --}}
    <div class="hidden lg:flex items-center justify-center relative overflow-hidden estagfy-animated-gradient">
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-blue-200/40 blur-2xl"></div>
        <div class="absolute -bottom-12 -left-8 w-48 h-48 rounded-full bg-indigo-200/40 blur-2xl"></div>

        <div class="relative bg-white/70 backdrop-blur border border-white shadow-2xl rounded-3xl p-12 max-w-md">
            <span class="text-sm font-semibold uppercase tracking-widest text-blue-600">
                Alunos
            </span>

            <div class="mt-6 mb-6 w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                    <path d="M4 10l8-5 8 5-8 5-8-5Z"
                          stroke="currentColor" stroke-width="1.7"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.5 13.5v3.5c0 1.9 4.1 3.5 5.5 3.5s5.5-1.6 5.5-3.5v-3.5"
                          stroke="currentColor" stroke-width="1.7"
                          stroke-linecap="round"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold mb-3 text-gray-900">
                Seu estágio começa aqui
            </h2>

            <p class="text-gray-600 mb-8">
                Descubra oportunidades reais, acompanhe suas candidaturas e converse direto com empresas.
            </p>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="rounded-2xl border border-white/60 bg-white/60 p-4">
                    <p class="text-xs uppercase tracking-widest text-blue-600 font-semibold">
                        Carreira
                    </p>
                    <p class="mt-2 font-medium text-gray-900">
                        Vagas alinhadas ao seu curso
                    </p>
                </div>

                <div class="rounded-2xl border border-white/60 bg-white/60 p-4">
                    <p class="text-xs uppercase tracking-widest text-blue-600 font-semibold">
                        Controle
                    </p>
                    <p class="mt-2 font-medium text-gray-900">
                        Status em tempo real
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
<script>
    (function () {
        const inputs = document.querySelectorAll('input[data-only-digits]');
        inputs.forEach((input) => {
            const maxLen = Number(input.getAttribute('data-maxlen')) || null;
            input.addEventListener('input', () => {
                let v = input.value.replace(/\D/g, '');
                if (maxLen) v = v.slice(0, maxLen);
                if (input.value !== v) input.value = v;
            });
        });
    })();
</script>
</html>
