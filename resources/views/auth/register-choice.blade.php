<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar conta | EstagFy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    .estagfy-bg-gradient {
        background: linear-gradient(
            120deg,
#4a47e4,
            #0B9B5B,
                        #4A47E4,
                        #0B9B5B
                    );
        background-size: 400% 400%;
        animation: estagfy-gradient-shift 7s ease-in-out infinite;
    }

    @keyframes estagfy-gradient-shift {
        0% { background-position: 0% 50%; }
        25% { background-position: 100% 30%; }
        50% { background-position: 100% 70%; }
        75% { background-position: 0% 70%; }
        100% { background-position: 0% 50%; }
    }
</style>

<body class="min-h-screen text-gray-900 estagfy-bg-gradient">


    {{-- container geral --}}
    <div class="min-h-screen flex items-center justify-center px-6 py-16 relative overflow-hidden">
        <div class="absolute -top-16 -right-12 w-56 h-56 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 w-64 h-64 rounded-full bg-indigo-200/40 blur-3xl"></div>

        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm backdrop-blur transition hover:bg-white">
            <span class="text-base leading-none">←</span>
            Voltar
        </a>

        <div class="w-full max-w-5xl text-center">



        <div class="bg-white
            border border-gray-200/70
            shadow-2xl rounded-3xl p-10 md:p-12">
                <h1 class="text-3xl font-bold text-gray-900">
                    Criar sua conta
                </h1>

                <p class="text-gray-500 mt-2 mb-10">
                    Escolha o tipo de perfil para comecar sua jornada
                </p>

                {{-- Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-center">

                {{-- Aluno --}}
                <a href="{{ route('register.student') }}"
                   class="group mx-auto w-full max-w-sm bg-white
                          border border-gray-200/70 rounded-2xl
                          p-8 text-left shadow-sm
                          hover:shadow-2xl hover:-translate-y-1
                          transition duration-300">

                    <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white w-14 h-14
                                flex items-center justify-center rounded-2xl mb-5 shadow-lg ring-4 ring-blue-600/15
                                transition duration-300 group-hover:scale-110 group-hover:-rotate-3">
                        <svg viewBox="0 0 24 24" fill="none" class="w-7 h-7">
                            <path d="M4 12l8-5 8 5-8 5-8-5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.5 13.5v3.5c0 1.9 4.1 3.5 5.5 3.5s5.5-1.6 5.5-3.5v-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-semibold mb-3 text-gray-900">
                        Sou Aluno
                    </h2>

                    <p class="text-gray-600 text-sm leading-relaxed">
                        Busco oportunidades de estagio e quero acompanhar candidaturas em tempo real
                    </p>
                </a>

                {{-- Empresa --}}
                <a href="{{ route('register.company') }}"
                   class="group mx-auto w-full max-w-sm bg-white
                          border border-gray-200/70 rounded-2xl
                          p-8 text-left shadow-sm
                          hover:shadow-2xl hover:-translate-y-1
                          transition duration-300">

                    <div class="bg-gradient-to-br from-emerald-600 to-green-600 text-white w-14 h-14
                                flex items-center justify-center rounded-2xl mb-5 shadow-lg ring-4 ring-emerald-600/15
                                transition duration-300 group-hover:scale-110 group-hover:rotate-2">
                        <svg viewBox="0 0 24 24" fill="none" class="w-7 h-7">
                            <path d="M4 20h16M6 20V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 10h2M9 14h2M13 10h2M13 14h2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-semibold mb-3 text-gray-900">
                        Sou Empresa
                    </h2>

                    <p class="text-gray-600 text-sm leading-relaxed">
                        Quero publicar vagas e gerenciar candidatos com mais agilidade
                    </p>
                </a>

                </div>

                <p class="mt-12 text-sm text-gray-500">
                    Ja tem uma conta?
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">
                        Fazer login
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>
</html>
