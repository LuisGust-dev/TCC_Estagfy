<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EstagFy</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
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

        .estagfy-feature-panel {
            box-shadow: 0 36px 80px -42px rgba(15, 23, 42, .55);
        }

        .estagfy-feature-pill {
            background: linear-gradient(120deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .62));
        }

        @keyframes estagfyGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="min-h-[100dvh] estagfy-soft-background text-gray-900">
    <div class="min-h-[100dvh] grid grid-cols-1 lg:grid-cols-2 relative">
        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 z-10 inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/85 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            <span class="text-base leading-none">←</span>
            Voltar
        </a>

    {{-- LADO ESQUERDO --}}
    <div class="w-full flex flex-col justify-center px-4 sm:px-8 lg:px-20 py-20 lg:py-10">
        <div class="w-full max-w-lg mx-auto">

        {{-- LOGO --}}
        <div class="mb-8 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
            <img src="{{ asset('images/logo1-removebg-preview.png') }}" alt="EstagFy" class="h-15 w-auto" />
            <span class="self-start whitespace-nowrap rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-blue-700 sm:self-auto">
                Acesso
            </span>
        </div>

        <div class="estagfy-login-card rounded-3xl border border-white/80 bg-white/88 p-6 sm:p-8 backdrop-blur">
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

                    <a href="{{ url('/forgot-password') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Esqueceu a senha?
                    </a>
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

        <div class="estagfy-feature-panel relative w-full max-w-lg rounded-[2rem] border border-white/75 bg-white/70 p-10 backdrop-blur-xl">
            <div class="mb-7 flex items-center justify-between gap-3">
                <div class="inline-flex items-center gap-3 rounded-2xl border border-white/70 bg-white/75 px-4 py-2">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                            <path d="M4 12l8-5 8 5-8 5-8-5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.5 13.5v3.5c0 1.9 4.1 3.5 5.5 3.5s5.5-1.6 5.5-3.5v-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-blue-700">Plataforma EstagFy</p>
                        <p class="text-xs text-slate-500">Ambiente profissional para estágios</p>
                    </div>
                </div>
            </div>

            <h2 class="mb-3 text-3xl font-bold leading-tight text-slate-900">
                Transforme candidaturas em
                <span class="text-blue-700">resultados reais</span>
            </h2>
            <p class="mb-7 text-[15px] leading-relaxed text-slate-600">
                Encontre vagas certas, acompanhe cada etapa e converse com empresas no mesmo fluxo.
            </p>

            <div class="space-y-3 text-sm">
                <div class="estagfy-feature-pill flex items-start gap-3 rounded-2xl border border-white/70 px-4 py-3.5 text-slate-700">
                    <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                        <svg viewBox="0 0 20 20" fill="none" class="h-3.5 w-3.5">
                            <path d="M5 10.5 8.2 13.5 15 6.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Processo estruturado para aluno, empresa e coordenação.
                </div>
                <div class="estagfy-feature-pill flex items-start gap-3 rounded-2xl border border-white/70 px-4 py-3.5 text-slate-700">
                    <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                        <svg viewBox="0 0 20 20" fill="none" class="h-3.5 w-3.5">
                            <path d="M5 10.5 8.2 13.5 15 6.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Acompanhamento em tempo real das candidaturas.
                </div>
            </div>

            <div class="mt-7 rounded-2xl border border-white/70 bg-white/65 px-4 py-3">
                <p class="text-center text-xs font-medium tracking-wide text-slate-600">
                    Painel unificado para alunos, empresas e coordenação.
                </p>
            </div>
        </div>
    </div>

    </div>
</body>
</html>




