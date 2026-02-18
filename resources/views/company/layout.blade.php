<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Empresa | EstagFy')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
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
    </style>
</head>
<body class="bg-gray-50">

@php
    $unreadCount = auth()->user()->unreadNotifications->count();
    $unreadMessagesCount = \App\Models\Message::where('company_id', auth()->id())
        ->where('sender_id', '!=', auth()->id())
        ->whereNull('read_at')
        ->count();
    $isCandidatesRoute = request()->routeIs('company.candidates.*') || request()->routeIs('company.jobs.candidates');
    $isJobsRoute = request()->routeIs('company.jobs.*') && !$isCandidatesRoute;
@endphp

<div class="flex min-h-screen" id="company-shell">

    {{-- SIDEBAR --}}
    <aside id="company-sidebar" class="w-64 bg-white border-r px-6 py-6 flex h-screen shrink-0 flex-col sticky top-0">

        {{-- PERFIL DA EMPRESA --}}
        <div class="company-profile mb-8 flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">

                @if(auth()->user()->photo)
                    <img
                        src="{{ asset('storage/' . auth()->user()->photo) }}"
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
               class="sidebar-link group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.dashboard') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.dashboard') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h4v8H4z"/>
                        <path d="M10 8h4v12h-4z"/>
                        <path d="M16 4h4v16h-4z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('company.jobs.index') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ $isJobsRoute ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ $isJobsRoute ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 8a2 2 0 0 1 2-2h4l2 2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Minhas Vagas</span>
            </a>

            <a href="{{ route('company.candidates.index') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ $isCandidatesRoute ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ $isCandidatesRoute ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 6h8"/>
                        <path d="M8 10h8"/>
                        <path d="M8 14h5"/>
                        <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Candidatos</span>
            </a>

            <a href="{{ route('company.profile.edit') }}"
               class="sidebar-link group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.profile.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.profile.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                    </svg>
                </span>
                <span class="sidebar-label text-sm font-medium">Perfil</span>
            </a>

            <a href="{{ route('company.messages.index') }}"
               class="sidebar-link group flex items-center justify-between gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.messages.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="flex items-center gap-3">
                    <span class="text-green-600 {{ request()->routeIs('company.messages.*') ? 'text-white' : '' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                        </svg>
                    </span>
                    <span class="sidebar-label text-sm font-medium">Mensagens</span>
                </span>

                @if($unreadMessagesCount > 0)
                    <span class="sidebar-badge bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                        {{ $unreadMessagesCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('company.notifications.index') }}"
               class="sidebar-link flex items-center justify-between gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.notifications.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="flex items-center gap-3">
                    <span class="text-green-600 {{ request()->routeIs('company.notifications.*') ? 'text-white' : '' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 9a6 6 0 1 1 12 0v4l2 3H4l2-3z"/>
                            <path d="M9.5 19a2.5 2.5 0 0 0 5 0"/>
                        </svg>
                    </span>
                    <span class="sidebar-label text-sm font-medium">Notificações</span>
                </span>

                @if($unreadCount > 0)
                    <span class="sidebar-badge bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
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

    {{-- CONTEÚDO --}}
    <main class="flex-1 min-w-0 p-10">
        @yield('content')
    </main>

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('company-sidebar');
        const toggleButton = document.getElementById('sidebar-toggle');
        const stateKey = 'company_sidebar_collapsed';

        if (!sidebar || !toggleButton) return;

        if (localStorage.getItem(stateKey) === '1') {
            sidebar.classList.add('is-collapsed');
        }

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('is-collapsed');
            localStorage.setItem(stateKey, sidebar.classList.contains('is-collapsed') ? '1' : '0');
        });
    });
</script>
</body>
</html>
