<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Coordenador | EstagFy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .estagfy-animated-gradient {
            background: linear-gradient(120deg, rgba(245, 158, 11, 0.45), rgba(59, 130, 246, 0.42), rgba(14, 165, 233, 0.4));
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
<body class="min-h-screen estagfy-animated-gradient text-gray-900">
    <div class="min-h-screen flex items-center justify-center px-6 py-10">
        <div class="absolute top-8 left-8 h-40 w-40 rounded-full bg-amber-200/40 blur-3xl"></div>
        <div class="absolute bottom-10 right-10 h-52 w-52 rounded-full bg-blue-200/40 blur-3xl"></div>

        <div class="relative w-full max-w-md rounded-3xl border border-white/70 bg-white/88 p-8 shadow-2xl backdrop-blur">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="redirect_to_login" value="1">
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                        ← Voltar para login geral
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">← Voltar para login geral</a>
            @endauth

            <h1 class="mt-6 text-2xl font-bold text-gray-900">Login do Coordenador</h1>
            <p class="mt-1 text-sm text-gray-500">Acesse com e-mail, senha e selecione o curso que você coordena.</p>

            @if($errors->any())
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('coordinator.login.store') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Senha</label>
                    <input type="password" name="password" required
                           class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Curso coordenado</label>
                    <select name="course" required
                            class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-amber-500 focus:ring-amber-500">
                        <option value="">Selecione o curso</option>
                        @foreach($courses as $course)
                            <option value="{{ $course }}" @selected(old('course') === $course)>{{ $course }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-amber-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-amber-700">
                    Entrar como coordenador
                </button>
            </form>
        </div>
    </div>
</body>
</html>
