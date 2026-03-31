<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Empresa | EstagFy')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .estagfy-login-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 82% 20%, rgba(110, 231, 183, 0.4), transparent 34%), #ecfdf5;
            opacity: 1;
            transition: opacity .35s ease;
        }

        .estagfy-login-overlay.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .estagfy-login-card {
            border: 1px solid rgba(16, 185, 129, .22);
            background: rgba(255, 255, 255, .96);
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            box-shadow: 0 24px 48px -30px rgba(5, 150, 105, .45);
            min-width: 320px;
            text-align: center;
        }

        .estagfy-login-spinner {
            width: 2.2rem;
            height: 2.2rem;
            border: 3px solid #bbf7d0;
            border-top-color: #16a34a;
            border-radius: 9999px;
            margin: 0 auto .75rem;
            animation: estagfySpin .8s linear infinite;
        }

        @keyframes estagfySpin {
            to { transform: rotate(360deg); }
        }

        #company-sidebar {
            transition: width 220ms ease, padding 220ms ease;
        }

        #company-sidebar.is-collapsed {
            width: 5.25rem;
            padding-left: .75rem;
            padding-right: .75rem;
        }

        #company-sidebar.is-collapsed .company-profile-text,
        #company-sidebar.is-collapsed .sidebar-label,
        #company-sidebar.is-collapsed .menu-title,
        #company-sidebar.is-collapsed .sidebar-badge {
            display: none;
        }

        #company-sidebar.is-collapsed .company-profile {
            justify-content: center;
        }

        #company-sidebar.is-collapsed .sidebar-link {
            justify-content: center;
        }

        #company-sidebar.is-collapsed .logout-btn {
            justify-content: center;
        }

        #company-sidebar.is-collapsed #sidebar-toggle-icon {
            transform: rotate(180deg);
        }

        #company-sidebar.is-open {
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
            background: linear-gradient(180deg, #6ee7b7, #10b981);
            opacity: 0;
            transform: translateY(-50%) scale(.85);
            transition: opacity 180ms ease, transform 180ms ease;
        }

        .sidebar-link:hover {
            transform: translateX(3px);
        }

        .sidebar-link.is-active {
            background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
            border-color: rgba(52, 211, 153, .32);
            color: #047857;
            box-shadow: 0 16px 34px -24px rgba(16, 185, 129, .45);
        }

        .sidebar-link.is-active::before {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        .sidebar-link.is-active .sidebar-icon {
            color: #10b981;
        }

        .sidebar-link.is-active .sidebar-label {
            color: #065f46;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50">
@if(session('login_animation') === 'company')
    <div id="company-login-overlay" class="estagfy-login-overlay" aria-hidden="true">
        <div class="estagfy-login-card">
            <div class="estagfy-login-spinner"></div>
            <p class="text-sm font-semibold text-green-700">Entrando na área da empresa</p>
            <p class="mt-1 text-xs text-gray-500">Preparando suas vagas e candidatos...</p>
        </div>
    </div>
@endif

@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $unreadMessagesCount = \App\Models\Message::where('company_id', auth()->id())
        ->where('sender_id', '!=', auth()->id())
        ->whereNull('read_at')
        ->count();
    $isCandidatesRoute = request()->routeIs('company.candidates.*') || request()->routeIs('company.jobs.candidates');
    $isJobsRoute = request()->routeIs('company.jobs.*') && !$isCandidatesRoute;
@endphp

<div class="relative flex min-h-screen" id="company-shell">

    {{-- SIDEBAR --}}
    <aside id="company-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 max-w-[85vw] -translate-x-full bg-white border-r px-4 py-6 flex h-screen shrink-0 flex-col transition-transform duration-200 md:sticky md:top-0 md:z-10 md:max-w-none md:translate-x-0 md:px-6">

        {{-- PERFIL DA EMPRESA --}}
        <div class="company-profile mb-8 flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">

                @if(auth()->user()->photo_url)
                    <img
                        src="{{ auth()->user()->photo_url }}"
                        class="w-11 h-11 rounded-full object-cover"
                        alt="Foto da empresa"
                    >
                @else
                    <div class="w-11 h-11 bg-green-600 text-white rounded-full
                                flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="company-profile-text leading-tight">
                    <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Área da Empresa</p>
                </div>
            </div>

            <button id="sidebar-toggle" type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Abrir ou fechar menu lateral">
                <svg id="sidebar-toggle-icon" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
            </button>
        </div>

        {{-- MENU --}}
        <nav class="space-y-2 flex-1 overflow-y-auto pr-1">
            <p class="menu-title px-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Navegação</p>

            <a href="{{ route('company.dashboard') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2.5 rounded-2xl transition
               {{ request()->routeIs('company.dashboard') ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="sidebar-icon text-green-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h4v8H4z"/>
                        <path d="M10 8h4v12h-4z"/>
                        <path d="M16 4h4v16h-4z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('company.jobs.index') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2.5 rounded-2xl transition
               {{ $isJobsRoute ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="sidebar-icon text-green-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 8a2 2 0 0 1 2-2h4l2 2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Minhas Vagas</span>
            </a>

            <a href="{{ route('company.candidates.index') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2.5 rounded-2xl transition
               {{ $isCandidatesRoute ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="sidebar-icon text-green-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 6h8"/>
                        <path d="M8 10h8"/>
                        <path d="M8 14h5"/>
                        <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Candidatos</span>
            </a>

            <a href="{{ route('company.messages.index') }}"
               class="sidebar-link group flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl transition
               {{ request()->routeIs('company.messages.*') ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="flex items-center gap-3">
                    <span class="sidebar-icon text-green-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                        </svg>
                    </span>
                    <span class="sidebar-label text-sm font-medium">Mensagens</span>
                </span>

                <span id="company-message-badge"
                      class="sidebar-badge bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full {{ $unreadMessagesCount > 0 ? '' : 'hidden' }}">
                    {{ $unreadMessagesCount }}
                </span>
            </a>

            <a href="{{ route('company.notifications.index') }}"
               class="sidebar-link flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl transition
               {{ request()->routeIs('company.notifications.*') ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="flex items-center gap-3">
                    <span class="sidebar-icon text-green-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 9a6 6 0 1 1 12 0v4l2 3H4l2-3z"/>
                            <path d="M9.5 19a2.5 2.5 0 0 0 5 0"/>
                        </svg>
                    </span>
                    <span class="sidebar-label text-sm font-medium">Notificações</span>
                </span>

                <span id="company-notification-badge"
                      class="sidebar-badge bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full {{ $unreadCount > 0 ? '' : 'hidden' }}">
                    {{ $unreadCount }}
                </span>
            </a>

            <a href="{{ route('company.profile.edit') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2.5 rounded-2xl transition
               {{ request()->routeIs('company.profile.*') ? 'is-active' : 'text-gray-600 hover:bg-emerald-50/70 hover:text-emerald-700' }}">
                <span class="sidebar-icon text-green-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Perfil</span>
            </a>

        </nav>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t border-gray-100 pt-4">
            @csrf
            <button class="logout-btn w-full flex items-center justify-center gap-2 rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:bg-gray-50">
                <span class="sidebar-label">Sair</span>
            </button>
        </form>

    </aside>

    <div id="company-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/35 md:hidden"></div>

    {{-- CONTEÚDO --}}
    <main class="flex-1 min-w-0 p-4 sm:p-6 md:p-8 lg:p-10">
        <div class="mb-4 flex items-center justify-between md:hidden">
            <button id="company-sidebar-open" type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
                Menu
            </button>
            <p class="text-xs font-medium uppercase tracking-widest text-gray-400">EstagFy Empresa</p>
        </div>
        @if(session('success') && empty($hideSuccess))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('company-sidebar');
        const toggleButton = document.getElementById('sidebar-toggle');
        const openButton = document.getElementById('company-sidebar-open');
        const backdrop = document.getElementById('company-sidebar-backdrop');
        const stateKey = 'company_sidebar_collapsed';
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notificationBadge = document.getElementById('company-notification-badge');
        const messageBadge = document.getElementById('company-message-badge');
        if (!notificationBadge && !messageBadge) return;

        const pollSummary = async () => {
            try {
                const response = await fetch('{{ route('company.realtime.summary') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) return;

                const data = await response.json();
                const unread = Number(data.unread_notifications || 0);
                const unreadMessages = Number(data.unread_messages || 0);

                if (notificationBadge) {
                    notificationBadge.textContent = String(unread);
                    notificationBadge.classList.toggle('hidden', unread <= 0);
                }

                if (messageBadge) {
                    messageBadge.textContent = String(unreadMessages);
                    messageBadge.classList.toggle('hidden', unreadMessages <= 0);
                }
            } catch (error) {
                console.warn('Falha ao atualizar resumo lateral da empresa.', error);
            }
        };

        setInterval(pollSummary, 6000);
    });
</script>
@if(session('login_animation') === 'company')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('company-login-overlay');
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
