<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coordenação | EstagFy')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .estagfy-login-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 82% 18%, rgba(251, 191, 36, 0.28), transparent 34%), #fffbeb;
            opacity: 1;
            transition: opacity .35s ease;
        }

        .estagfy-login-overlay.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .estagfy-login-card {
            border: 1px solid rgba(217, 119, 6, .18);
            background: rgba(255, 255, 255, .96);
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            box-shadow: 0 24px 48px -30px rgba(180, 83, 9, .35);
            min-width: 320px;
            text-align: center;
        }

        .estagfy-login-spinner {
            width: 2.2rem;
            height: 2.2rem;
            border: 3px solid #fde68a;
            border-top-color: #d97706;
            border-radius: 9999px;
            margin: 0 auto .75rem;
            animation: estagfySpin .8s linear infinite;
        }

        @keyframes estagfySpin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-gray-900">
    @if(session('login_animation') === 'coordinator')
        <div id="coordinator-login-overlay" class="estagfy-login-overlay" aria-hidden="true">
            <div class="estagfy-login-card">
                <div class="estagfy-login-spinner"></div>
                <p class="text-sm font-semibold text-amber-700">Entrando na área da coordenação</p>
                <p class="mt-1 text-xs text-gray-500">Carregando calendário e gestão acadêmica...</p>
            </div>
        </div>
    @endif
    <div class="border-b bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold">
                    C
                </div>
                <div>
                    <p class="text-sm text-gray-500">Painel</p>
                    <p class="text-lg font-semibold">Coordenação de Curso</p>
                    <p class="text-xs text-gray-500">Curso: {{ session('coordinator_course') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
    @if(session('login_animation') === 'coordinator')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('coordinator-login-overlay');
            if (!overlay) return;

            setTimeout(() => {
                overlay.classList.add('is-hidden');
                setTimeout(() => overlay.remove(), 380);
            }, 1900);
        });
    </script>
    @endif
</body>
</html>




