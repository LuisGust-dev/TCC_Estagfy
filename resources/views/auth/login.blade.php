<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EstagFy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --estagfy-blue-700: #1d4ed8;
            --estagfy-blue-600: #2563eb;
            --estagfy-cyan-500: #06b6d4;
            --estagfy-slate-900: #0f172a;
        }

        .estagfy-soft-background {
            background:
                radial-gradient(circle at 12% 10%, rgba(59, 130, 246, .14), transparent 32%),
                radial-gradient(circle at 88% 90%, rgba(14, 165, 233, .15), transparent 34%),
                #f8fafc;
        }

        .estagfy-animated-gradient {
            background:
                radial-gradient(circle at 18% 20%, rgba(255, 255, 255, .22), transparent 38%),
                radial-gradient(circle at 85% 82%, rgba(255, 255, 255, .20), transparent 36%),
                linear-gradient(120deg, rgba(96, 143, 243, 0.55), rgba(70, 134, 229, 0.55), rgba(14, 165, 233, 0.55));
            background-size: 200% 200%;
            animation: estagfyGradient 12s ease infinite;
        }

        .estagfy-login-card {
            box-shadow: 0 30px 80px -45px rgba(15, 23, 42, .5);
        }

        .estagfy-input:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        @keyframes estagfyGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="min-h-screen estagfy-soft-background text-gray-900">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 relative">
        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 z-10 inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/85 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            <span class="text-base leading-none">←</span>
            Voltar
        </a>

    {{-- LADO ESQUERDO --}}
    <div class="w-full flex flex-col justify-center px-8 lg:px-20 py-12">
        <div class="w-full max-w-lg mx-auto">

        {{-- LOGO --}}
        <div class="mb-8 flex items-center justify-between gap-3">
            <img src="{{ asset('images/logo1-removebg-preview.png') }}" alt="EstagFy" class="h-15 w-auto" />
            <span class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-blue-700">
                Acesso
            </span>
        </div>

        <div class="estagfy-login-card rounded-3xl border border-white/80 bg-white/88 p-8 backdrop-blur">
            <div class="mb-5 flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none">
                        <path d="M12 2L4 6v6c0 4.4 3.2 8.5 8 9.5 4.8-1 8-5.1 8-9.5V6l-8-4Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Área segura</p>
                    <p class="text-xs text-slate-600">Acesso para aluno, empresa e coordenação</p>
                </div>
            </div>

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
                    class="estagfy-input mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
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
                    class="estagfy-input mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
                >

                @error('password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- BOTÃO --}}
            <button
                type="submit"
                class="w-full rounded-xl bg-gradient-to-r from-[var(--estagfy-blue-600)] to-[var(--estagfy-blue-700)] py-3 font-semibold text-white shadow-lg shadow-blue-200 transition-all duration-200 hover:-translate-y-0.5 hover:to-sky-700 hover:shadow-xl"
            >
                Entrar
            </button>

            <a href="{{ route('coordinator.login') }}"
               class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-sky-200 bg-sky-50 px-4 py-2.5 text-sm font-medium text-sky-700 transition hover:border-sky-300 hover:bg-sky-100">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none">
                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M5 21a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
                Entrar como coordenador
            </a>
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

        <div class="relative max-w-md rounded-3xl border border-white bg-white/72 p-12 text-center shadow-2xl backdrop-blur">
            <div class="mx-auto mb-6 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center">
                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                    <path d="M4 12l8-5 8 5-8 5-8-5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.5 13.5v3.5c0 1.9 4.1 3.5 5.5 3.5s5.5-1.6 5.5-3.5v-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.22em] text-sky-700">Plataforma EstagFy</p>
            <h2 class="text-2xl font-bold mb-3 text-gray-900">Seu próximo estágio começa aqui</h2>
            <p class="text-gray-600 mb-8">
                Conecte seu talento a empresas reais, acompanhe candidaturas e receba
                resposta rápida em um só lugar.
            </p>

            <div class="grid grid-cols-2 gap-3 text-left text-sm">
                <div class="rounded-2xl border border-white/70 bg-white/60 p-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-700">Prático</p>
                    <p class="mt-1 text-gray-700">Processo simples e direto</p>
                </div>
                <div class="rounded-2xl border border-white/70 bg-white/60 p-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-700">Rápido</p>
                    <p class="mt-1 text-gray-700">Acesso imediato às vagas</p>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>
</html>
