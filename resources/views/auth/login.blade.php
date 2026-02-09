<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login | EstagFy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .estagfy-animated-gradient {
            background: linear-gradient(120deg, rgba(96, 143, 243, 0.55), rgba(70, 134, 229, 0.55), rgba(14, 165, 233, 0.55));
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
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 relative">
        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 z-10 inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm backdrop-blur transition hover:bg-white">
            <span class="text-base leading-none">←</span>
            Voltar
        </a>

    {{-- LADO ESQUERDO --}}
    <div class="w-full flex flex-col justify-center px-8 lg:px-20 py-12">
        <div class="w-full max-w-lg mx-auto">

        {{-- LOGO --}}
        <div class="flex items-center gap-3 mb-8">
            <img src="{{ asset('images/logo1.png') }}" alt="EstagFy" class="h-15 w-auto" />
        </div>

        <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-xl rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-gray-900">Bem-vindo de volta</h1>
            <p class="text-gray-500 mb-8">
                Entre com suas credenciais para acessar sua conta
            </p>

        {{-- FORM LOGIN --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">E-mail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="seu@email.com"
                    class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                @error('email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- SENHA --}}
            <div>
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-medium text-gray-700">Senha</label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-blue-600 hover:underline">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                @error('password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- BOTÃO --}}
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition"
            >
                Entrar
            </button>
        </form>

        {{-- CADASTRO --}}
        <p class="text-sm text-gray-500 mt-6">
            Não tem uma conta?
            <a href="{{ route('register.choice') }}" class="text-blue-600 font-medium hover:underline">
                Cadastre-se
            </a>
        </p>


        </div>
        </div>
    </div>

    {{-- LADO DIREITO --}}
    <div class="hidden lg:flex items-center justify-center relative overflow-hidden estagfy-animated-gradient">
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-blue-200/40 blur-2xl"></div>
        <div class="absolute -bottom-12 -left-8 w-48 h-48 rounded-full bg-indigo-200/40 blur-2xl"></div>

        <div class="relative bg-white/70 backdrop-blur border border-white shadow-2xl rounded-3xl p-12 max-w-md text-center">
            <div class="mx-auto mb-6 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                    <path d="M4 12l8-5 8 5-8 5-8-5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.5 13.5v3.5c0 1.9 4.1 3.5 5.5 3.5s5.5-1.6 5.5-3.5v-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900">Seu proximo estagio comeca aqui</h2>
            <p class="text-gray-600 mb-8">
                Conecte seu talento a empresas reais, acompanhe candidaturas e receba
                resposta rapida em um so lugar.
            </p>


        </div>
    </div>

    </div>
</body>
</html>
