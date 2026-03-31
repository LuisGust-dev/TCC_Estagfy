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

        #coordinator-sidebar {
            transition: width 220ms ease, padding 220ms ease;
        }

        #coordinator-sidebar.is-collapsed {
            width: 5.25rem;
            padding-left: .75rem;
            padding-right: .75rem;
        }

        #coordinator-sidebar.is-collapsed .coordinator-profile-text,
        #coordinator-sidebar.is-collapsed .sidebar-label,
        #coordinator-sidebar.is-collapsed .menu-title {
            display: none;
        }

        #coordinator-sidebar.is-collapsed .coordinator-profile {
            justify-content: center;
        }

        #coordinator-sidebar.is-collapsed .sidebar-link,
        #coordinator-sidebar.is-collapsed .logout-btn {
            justify-content: center;
        }

        #coordinator-sidebar.is-collapsed #coordinator-sidebar-toggle-icon {
            transform: rotate(180deg);
        }

        #coordinator-sidebar.is-open {
            transform: translateX(0);
        }

        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease, border-color 180ms ease, color 180ms ease;
            border: 1px solid transparent;
        }

        .sidebar-link::before {
            content: "";
            position: absolute;
            left: -0.75rem;
            top: 50%;
            width: 1.1rem;
            height: 70%;
            border-radius: 9999px;
            background: linear-gradient(180deg, #fbbf24, #d97706);
            opacity: 0;
            transform: translateY(-50%) scale(.85);
            transition: opacity 180ms ease, transform 180ms ease;
        }

        .sidebar-link:hover {
            transform: translateX(3px);
        }

        .sidebar-link.is-active {
            background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);
            border-color: rgba(251, 191, 36, .32);
            color: #b45309;
            box-shadow: 0 16px 34px -24px rgba(217, 119, 6, .42);
        }

        .sidebar-link.is-active::before {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        .sidebar-link.is-active .sidebar-icon {
            color: #d97706;
        }

        .sidebar-link.is-active .sidebar-label {
            color: #92400e;
            font-weight: 600;
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
    <div class="relative flex min-h-screen">
        <aside id="coordinator-sidebar" class="fixed inset-y-0 left-0 z-40 w-72 max-w-[85vw] -translate-x-full bg-white border-r flex h-screen shrink-0 flex-col px-4 transition-transform duration-200 md:sticky md:top-0 md:z-10 md:max-w-none md:translate-x-0">
            <div class="coordinator-profile border-b px-2 py-5 flex items-start justify-between gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-amber-600 text-white flex items-center justify-center font-semibold">
                        C
                    </div>
                    <div class="coordinator-profile-text leading-tight">
                        <p class="font-semibold text-gray-800 text-sm">Coordenação de Curso</p>
                        <p class="text-xs text-gray-500">Curso: {{ session('coordinator_course') }}</p>
                    </div>
                </div>

                <button id="coordinator-sidebar-toggle" type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                        aria-label="Abrir ou fechar menu lateral">
                    <svg id="coordinator-sidebar-toggle-icon" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-0 py-4 space-y-1 overflow-y-auto pr-1">
                <p class="menu-title px-3 pb-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                    Menu
                </p>

                <a href="{{ route('coordinator.calendar.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('coordinator.calendar.index') ? 'is-active' : 'text-gray-600 hover:bg-amber-50/70 hover:text-amber-700' }}">
                    <span class="sidebar-icon text-amber-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="5" width="16" height="15" rx="2"/>
                            <path d="M8 3v4"/>
                            <path d="M16 3v4"/>
                            <path d="M4 10h16"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Novo evento</span>
                </a>

                <a href="{{ route('coordinator.calendar.events') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('coordinator.calendar.events') ? 'is-active' : 'text-gray-600 hover:bg-amber-50/70 hover:text-amber-700' }}">
                    <span class="sidebar-icon text-amber-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M8 6h8"/>
                            <path d="M8 10h8"/>
                            <path d="M8 14h5"/>
                            <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Eventos cadastrados</span>
                </a>

                <a href="{{ route('coordinator.calendar.hiring-companies.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('coordinator.calendar.hiring-companies.*') ? 'is-active' : 'text-gray-600 hover:bg-amber-50/70 hover:text-amber-700' }}">
                    <span class="sidebar-icon text-amber-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M3 21h18"/>
                            <path d="M6 21V7h12v14"/>
                            <path d="M9 10h2"/>
                            <path d="M13 10h2"/>
                            <path d="M9 14h2"/>
                            <path d="M13 14h2"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Empresas destaque</span>
                </a>
            </nav>

            <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn w-full flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:bg-gray-50">
                        <span class="sidebar-label">Sair</span>
                    </button>
                </form>
            </div>
        </aside>

        <div id="coordinator-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/35 md:hidden"></div>

        <main class="flex-1 min-w-0 p-4 sm:p-6 md:p-8">
        <div class="mb-4 flex items-center justify-between md:hidden">
            <button id="coordinator-sidebar-open" type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
                Menu
            </button>
            <p class="text-xs font-medium uppercase tracking-widest text-gray-400">EstagFy Coordenação</p>
        </div>
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
    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('coordinator-sidebar');
            const toggleButton = document.getElementById('coordinator-sidebar-toggle');
            const openButton = document.getElementById('coordinator-sidebar-open');
            const backdrop = document.getElementById('coordinator-sidebar-backdrop');
            const stateKey = 'coordinator_sidebar_collapsed';
            const desktopMedia = window.matchMedia('(min-width: 768px)');

            if (!sidebar || !toggleButton) return;

            if (desktopMedia.matches && localStorage.getItem(stateKey) === '1') {
                sidebar.classList.add('is-collapsed');
            }

            toggleButton.addEventListener('click', () => {
                if (!desktopMedia.matches) {
                    sidebar.classList.remove('is-open');
                    backdrop?.classList.add('hidden');
                    return;
                }

                sidebar.classList.toggle('is-collapsed');
                localStorage.setItem(stateKey, sidebar.classList.contains('is-collapsed') ? '1' : '0');
            });

            const openSidebar = () => {
                sidebar.classList.add('is-open');
                backdrop?.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.remove('is-open');
                backdrop?.classList.add('hidden');
            };

            openButton?.addEventListener('click', openSidebar);
            backdrop?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (desktopMedia.matches) {
                    sidebar.classList.remove('is-open');
                    backdrop?.classList.add('hidden');
                    if (localStorage.getItem(stateKey) === '1') {
                        sidebar.classList.add('is-collapsed');
                    } else {
                        sidebar.classList.remove('is-collapsed');
                    }
                    return;
                }

                sidebar.classList.remove('is-collapsed');
            });
        });
    </script>
</body>
</html>



