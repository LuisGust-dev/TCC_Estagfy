<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Empresa | EstagFy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .estagfy-animated-gradient {
            background: linear-gradient(120deg, rgba(5, 150, 105, 0.5), rgba(8, 245, 166, 0.5), rgba(10, 83, 37, 0.5));
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
<body class="min-h-screen bg-slate-50 text-gray-900">

<div class="min-h-screen lg:h-screen lg:overflow-hidden grid grid-cols-1 lg:grid-cols-2">
    {{-- LADO ESQUERDO --}}
    <div class="relative flex items-center justify-center px-6 py-10 lg:py-12 overflow-hidden">
        <div class="absolute -top-16 -right-12 w-56 h-56 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 w-64 h-64 rounded-full bg-emerald-200/40 blur-3xl"></div>

        <div class="w-full max-w-2xl">
            <div class="bg-white/80 backdrop-blur border border-white shadow-2xl rounded-3xl p-8 md:p-10">

        {{-- voltar --}}
        <a href="{{ route('register.choice') }}" class="text-sm text-gray-500 hover:underline">
            ← Voltar
        </a>

        {{-- logo --}}
        <div class="flex items-center gap-3 mt-6 mb-8">
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-1">
            Cadastro de Empresa
        </h1>
        <p class="text-gray-500 mb-6">
            Preencha os dados abaixo para criar sua conta
        </p>

        <form method="POST"
              action="{{ route('register.company.store') }}"
              enctype="multipart/form-data"
              class="space-y-4">


            @csrf


            {{-- Logo / Foto da empresa --}}
<div>
    <label class="block text-sm font-medium text-gray-700">
        Logo / Foto da empresa (opcional)
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
                    Nome da empresa
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Nome da sua empresa">
            </div>

            {{-- CNPJ --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                <input type="text" name="cnpj" value="{{ old('cnpj') }}"
                       class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="00.000.000/0000-00">
            </div>

            {{-- Email / Telefone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        E-mail corporativo
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="contato@empresa.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Telefone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="(00) 00000-0000">
                </div>
            </div>

            {{-- Senha --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password"
                       class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="••••••••">
            </div>

            {{-- Descrição --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Descrição da empresa
                </label>
                <textarea name="description" rows="4"
                          class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Conte um pouco sobre sua empresa...">{{ old('description') }}</textarea>
            </div>

            {{-- Botão --}}
            <button type="submit"
                    class="w-full bg-emerald-600 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-emerald-700 hover:shadow-xl transition">
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
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-emerald-200/40 blur-2xl"></div>
        <div class="absolute -bottom-12 -left-8 w-48 h-48 rounded-full bg-green-200/40 blur-2xl"></div>

        <div class="relative bg-white/70 backdrop-blur border border-white shadow-2xl rounded-3xl p-12 max-w-md">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-sm font-semibold uppercase tracking-widest text-emerald-600">Empresas</span>
            </div>

            <div class="mb-6 w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-green-600 text-white flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                    <path d="M4 9h6v11H4z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <path d="M10 5h6v15h-6z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <path d="M16 8h4v12h-4z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold mb-3 text-gray-900">Recrute com mais agilidade</h2>
            <p class="text-gray-600 mb-8">
                Publique vagas, acompanhe candidatos e converse direto com talentos em um painel simples e moderno.
            </p>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="rounded-2xl border border-white/60 bg-white/60 p-4">
                    <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold">Velocidade</p>
                    <p class="mt-2 font-medium text-gray-900">Publicação em minutos</p>
                </div>
                <div class="rounded-2xl border border-white/60 bg-white/60 p-4">
                    <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold">Organização</p>
                    <p class="mt-2 font-medium text-gray-900">Candidatos centralizados</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
