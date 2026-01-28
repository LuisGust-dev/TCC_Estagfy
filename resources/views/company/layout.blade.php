<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Empresa | EstagFy')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">

@php
    $unreadCount = auth()->user()->unreadNotifications->count();
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r px-6 py-6 flex flex-col">

        {{-- PERFIL DA EMPRESA --}}
        <div class="flex items-center gap-3 mb-8">

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

            <div class="leading-tight">
                <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">Área da Empresa</p>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="space-y-2 flex-1">
            <p class="px-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Navegação</p>

            <a href="{{ route('company.dashboard') }}"
               class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.dashboard') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.dashboard') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12h4v8H4z"/>
                        <path d="M10 8h4v12h-4z"/>
                        <path d="M16 4h4v16h-4z"/>
                    </svg>
                </span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('company.jobs.index') }}"
               class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.jobs.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.jobs.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 8a2 2 0 0 1 2-2h4l2 2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                    </svg>
                </span>
                <span class="text-sm font-medium">Minhas Vagas</span>
            </a>

            <a href="{{ route('company.candidates.index') }}"
               class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.candidates.*') || request()->routeIs('company.jobs.candidates') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.candidates.*') || request()->routeIs('company.jobs.candidates') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 6h8"/>
                        <path d="M8 10h8"/>
                        <path d="M8 14h5"/>
                        <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                <span class="text-sm font-medium">Candidatos</span>
            </a>

            <a href="{{ route('company.profile.edit') }}"
               class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.profile.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.profile.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                    </svg>
                </span>
                <span class="text-sm font-medium">Perfil</span>
            </a>

            <a href="{{ route('company.messages.index') }}"
               class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.messages.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-green-600 {{ request()->routeIs('company.messages.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                    </svg>
                </span>
                <span class="text-sm font-medium">Mensagens</span>
            </a>

            <a href="{{ route('company.notifications.index') }}"
               class="flex items-center justify-between gap-3 px-4 py-2 rounded-xl transition
               {{ request()->routeIs('company.notifications.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="flex items-center gap-3">
                    <span class="text-green-600 {{ request()->routeIs('company.notifications.*') ? 'text-white' : '' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 9a6 6 0 1 1 12 0v4l2 3H4l2-3z"/>
                            <path d="M9.5 19a2.5 2.5 0 0 0 5 0"/>
                        </svg>
                    </span>
                    <span class="text-sm font-medium">Notificações</span>
                </span>

                @if($unreadCount > 0)
                    <span class="bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

        </nav>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-red-600 hover:bg-red-50 transition">
                <span class="text-base">🚪</span>
                <span class="text-sm font-medium">Sair</span>
            </button>
        </form>

    </aside>

    {{-- CONTEÚDO --}}
    <main class="flex-1 p-10">
        @yield('content')
    </main>

</div>
</body>
</html>
