<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | EstagFy')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #admin-sidebar {
            transition: width 220ms ease, padding 220ms ease;
        }

        #admin-sidebar.is-collapsed {
            width: 5.25rem;
            padding-left: .75rem;
            padding-right: .75rem;
        }

        #admin-sidebar.is-collapsed .admin-profile-text,
        #admin-sidebar.is-collapsed .sidebar-label,
        #admin-sidebar.is-collapsed .menu-title {
            display: none;
        }

        #admin-sidebar.is-collapsed .admin-profile {
            justify-content: center;
        }

        #admin-sidebar.is-collapsed .sidebar-link,
        #admin-sidebar.is-collapsed .logout-btn {
            justify-content: center;
        }

        #admin-sidebar.is-collapsed #admin-sidebar-toggle-icon {
            transform: rotate(180deg);
        }

        #admin-sidebar.is-open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-slate-100 text-gray-900">
<div class="relative flex min-h-screen">
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-72 max-w-[85vw] -translate-x-full bg-white border-r flex h-screen shrink-0 flex-col px-4 transition-transform duration-200 md:sticky md:top-0 md:z-10 md:max-w-none md:translate-x-0">
        <div class="admin-profile border-b px-2 py-5 flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">
                    A
                </div>
                <div class="admin-profile-text leading-tight">
                    <p class="font-semibold text-gray-800 text-sm">Admin EstagFy</p>
                    <p class="text-xs text-gray-500">Painel Administrativo</p>
                </div>
            </div>

            <button id="admin-sidebar-toggle" type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Abrir ou fechar menu lateral">
                <svg id="admin-sidebar-toggle-icon" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-0 py-4 space-y-1 overflow-y-auto pr-1">
            <p class="menu-title px-3 pb-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                Menu
            </p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h4v8H4z"/>
                        <path d="M10 8h4v12h-4z"/>
                        <path d="M16 4h4v16h-4z"/>
                    </svg>
                </span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.companies.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.companies.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.companies.*') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 21h18"/>
                        <path d="M6 21V7h12v14"/>
                        <path d="M9 10h2"/>
                        <path d="M13 10h2"/>
                        <path d="M9 14h2"/>
                        <path d="M13 14h2"/>
                    </svg>
                </span>
                <span class="sidebar-label">Empresas</span>
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.students.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3 1 9l11 6 11-6-11-6Z"/>
                        <path d="M5 11.5V15c0 2.8 3.1 5 7 5s7-2.2 7-5v-3.5"/>
                    </svg>
                </span>
                <span class="sidebar-label">Alunos</span>
            </a>

            <a href="{{ route('admin.coordinators.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.coordinators.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.coordinators.*') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                        <path d="M19 7h2"/>
                        <path d="M20 6v2"/>
                    </svg>
                </span>
                <span class="sidebar-label">Coordenadores</span>
            </a>

            <a href="{{ route('admin.admins.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.admins.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.admins.*') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3l7 4v5c0 4.5-2.9 7.8-7 9-4.1-1.2-7-4.5-7-9V7l7-4Z"/>
                        <path d="M9.5 12l1.7 1.7L14.8 10"/>
                    </svg>
                </span>
                <span class="sidebar-label">Administradores</span>
            </a>

            <a href="{{ route('admin.reports.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="{{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-blue-600' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 19h16"/>
                        <path d="M7 16V9"/>
                        <path d="M12 16V5"/>
                        <path d="M17 16v-4"/>
                    </svg>
                </span>
                <span class="sidebar-label">Relatórios</span>
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

    <div id="admin-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/35 md:hidden"></div>

    <main class="flex-1 min-w-0 p-4 sm:p-6 md:p-8">
        <div class="mb-4 flex items-center justify-between md:hidden">
            <button id="admin-sidebar-open" type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
                Menu
            </button>
            <p class="text-xs font-medium uppercase tracking-widest text-gray-400">EstagFy Admin</p>
        </div>

        @if(session('success'))
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
        const sidebar = document.getElementById('admin-sidebar');
        const toggleButton = document.getElementById('admin-sidebar-toggle');
        const openButton = document.getElementById('admin-sidebar-open');
        const backdrop = document.getElementById('admin-sidebar-backdrop');
        const stateKey = 'admin_sidebar_collapsed';
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
