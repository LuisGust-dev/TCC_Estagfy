<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aluno') | EstagFy</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
    @vite(['resources/css/app.css'])
    <style>
        .estagfy-login-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 18% 20%, rgba(147, 197, 253, 0.45), transparent 38%), #eff6ff;
            opacity: 1;
            transition: opacity .35s ease;
        }

        .estagfy-login-overlay.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .estagfy-login-card {
            border: 1px solid rgba(59, 130, 246, .18);
            background: rgba(255, 255, 255, .95);
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            box-shadow: 0 24px 48px -30px rgba(30, 64, 175, .5);
            min-width: 320px;
            text-align: center;
        }

        .estagfy-login-spinner {
            width: 2.2rem;
            height: 2.2rem;
            border: 3px solid #bfdbfe;
            border-top-color: #2563eb;
            border-radius: 9999px;
            margin: 0 auto .75rem;
            animation: estagfySpin .8s linear infinite;
        }

        @keyframes estagfySpin {
            to { transform: rotate(360deg); }
        }

        #student-sidebar {
            transition: width 220ms ease, padding 220ms ease;
        }

        #student-sidebar.is-collapsed {
            width: 5.25rem;
            padding-left: .75rem;
            padding-right: .75rem;
        }

        #student-sidebar.is-collapsed .student-profile-text,
        #student-sidebar.is-collapsed .sidebar-label,
        #student-sidebar.is-collapsed .menu-title,
        #student-sidebar.is-collapsed .sidebar-badge {
            display: none;
        }

        #student-sidebar.is-collapsed .student-profile {
            justify-content: center;
        }

        #student-sidebar.is-collapsed .sidebar-link {
            justify-content: center;
        }

        #student-sidebar.is-collapsed .logout-btn {
            justify-content: center;
        }

        #student-sidebar.is-collapsed #student-sidebar-toggle-icon {
            transform: rotate(180deg);
        }

        #student-sidebar.is-open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-slate-100 text-gray-900">
@if(session('login_animation') === 'student')
    <div id="student-login-overlay" class="estagfy-login-overlay" aria-hidden="true">
        <div class="estagfy-login-card">
            <div class="estagfy-login-spinner"></div>
            <p class="text-sm font-semibold text-blue-700">Entrando na área do aluno</p>
            <p class="mt-1 text-xs text-gray-500">Carregando seu painel...</p>
        </div>
    </div>
@endif

@php
    $count = auth()->user()->unreadNotifications->count();
    $unreadMessagesCount = \App\Models\Message::where('student_id', auth()->id())
        ->where('sender_id', '!=', auth()->id())
        ->whereNull('read_at')
        ->count();
@endphp

<div class="relative flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="student-sidebar" class="fixed inset-y-0 left-0 z-40 w-72 max-w-[85vw] -translate-x-full bg-white border-r flex h-screen shrink-0 flex-col px-4 transition-transform duration-200 md:sticky md:top-0 md:z-10 md:max-w-none md:translate-x-0">


        {{-- PERFIL DO ALUNO --}}
        <div class="student-profile border-b px-2 py-5 flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">

                @if(auth()->user()->photo_url)
                    <img
                        src="{{ auth()->user()->photo_url }}"
                        alt="Foto do aluno"
                        class="w-11 h-11 rounded-full object-cover"
                    >
                @else
                    <div
                        class="w-11 h-11 rounded-full bg-blue-600 text-white
                               flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="student-profile-text leading-tight">
                    <p class="font-semibold text-gray-800 text-sm">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Estudante
                    </p>
                </div>
            </div>

            <button id="student-sidebar-toggle" type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Abrir ou fechar menu lateral">
                <svg id="student-sidebar-toggle-icon" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
            </button>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-0 py-4 space-y-1 overflow-y-auto pr-1">
            <p class="menu-title px-3 pb-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                Menu
            </p>

            {{-- DASHBOARD --}}
            <a href="{{ route('student.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.dashboard')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.dashboard') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h4v8H4z"/>
                        <path d="M10 8h4v12h-4z"/>
                        <path d="M16 4h4v16h-4z"/>
                    </svg>
                </span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            {{-- VAGAS --}}
            <a href="{{ route('student.jobs.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.jobs.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.jobs.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 6h6a2 2 0 0 1 2 2v2H7V8a2 2 0 0 1 2-2Z"/>
                        <path d="M6 10h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                <span class="sidebar-label">Vagas</span>
            </a>

            {{-- CANDIDATURAS --}}
            <a href="{{ route('student.applications.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.applications.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.applications.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 6h8"/>
                        <path d="M8 10h8"/>
                        <path d="M8 14h5"/>
                        <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                <span class="sidebar-label">Candidaturas</span>
            </a>

            {{-- CALENDÁRIO DE ESTÁGIO --}}
            <a href="{{ route('student.calendar.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.calendar.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.calendar.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="5" width="16" height="15" rx="2"/>
                        <path d="M8 3v4"/>
                        <path d="M16 3v4"/>
                        <path d="M4 10h16"/>
                    </svg>
                </span>
                <span class="sidebar-label">Calendário de Estágio</span>
            </a>

            {{-- FLUXO DE ESTÁGIO --}}
            <a href="{{ route('student.flow.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.flow.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.flow.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 7h16"/>
                        <path d="M4 12h10"/>
                        <path d="M4 17h7"/>
                        <circle cx="18" cy="17" r="2"/>
                    </svg>
                </span>
                <span class="sidebar-label">Fluxo de estágio</span>
            </a>

            {{-- NOTIFICAÇÕES --}}
            <a href="{{ route('student.notifications.index') }}"
               class="sidebar-link flex justify-between items-center px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.notifications.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="flex items-center gap-3">
                    <span class="text-blue-600 {{ request()->routeIs('student.notifications.*') ? 'text-white' : '' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 9a6 6 0 1 1 12 0v4l2 3H4l2-3z"/>
                            <path d="M9.5 19a2.5 2.5 0 0 0 5 0"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Notificações</span>
                </span>

                <span id="student-notification-badge"
                      class="sidebar-badge bg-red-500 text-white text-xs px-2 py-0.5 rounded-full {{ $count > 0 ? '' : 'hidden' }}">
                    {{ $count }}
                </span>
            </a>

            {{-- MENSAGENS --}}
            <a href="{{ route('student.messages.index') }}"
               class="sidebar-link flex items-center justify-between px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.messages.*') || request()->routeIs('student.chat.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="flex items-center gap-3">
                    <span class="text-blue-600 {{ request()->routeIs('student.messages.*') || request()->routeIs('student.chat.*') ? 'text-white' : '' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Mensagens</span>
                </span>

                <span id="student-message-badge"
                      class="sidebar-badge bg-red-500 text-white text-xs px-2 py-0.5 rounded-full {{ $unreadMessagesCount > 0 ? '' : 'hidden' }}">
                    {{ $unreadMessagesCount }}
                </span>
            </a>

            {{-- PERFIL --}}
            <a href="{{ route('student.profile.show') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.profile.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.profile.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                    </svg>
                </span>
                <span class="sidebar-label">Perfil</span>
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn w-full flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-400 hover:bg-gray-50">
                    <span class="sidebar-label">Sair</span>
                </button>
            </form>
        </div>

    </aside>

    <div id="student-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/35 md:hidden"></div>

    {{-- CONTEÚDO --}}
    <main class="flex-1 min-w-0 p-4 sm:p-6 md:p-8">
        <div class="mb-4 flex items-center justify-between md:hidden">
            <button id="student-sidebar-open" type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
                Menu
            </button>
            <p class="text-xs font-medium uppercase tracking-widest text-gray-400">EstagFy Aluno</p>
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
        const sidebar = document.getElementById('student-sidebar');
        const toggleButton = document.getElementById('student-sidebar-toggle');
        const openButton = document.getElementById('student-sidebar-open');
        const backdrop = document.getElementById('student-sidebar-backdrop');
        const stateKey = 'student_sidebar_collapsed';
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
        const notificationBadge = document.getElementById('student-notification-badge');
        const messageBadge = document.getElementById('student-message-badge');
        if (!notificationBadge && !messageBadge) return;

        const pollSummary = async () => {
            try {
                const response = await fetch('{{ route('student.realtime.summary') }}', {
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
                console.warn('Falha ao atualizar resumo lateral do aluno.', error);
            }
        };

        setInterval(pollSummary, 6000);
    });
</script>
@if(session('login_animation') === 'student')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('student-login-overlay');
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

