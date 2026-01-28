<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aluno') | EstagFy</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-100 text-gray-900">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r flex flex-col">


        {{-- PERFIL DO ALUNO --}}
        <div class="px-6 py-5 flex items-center gap-3 border-b">

            @if(auth()->user()->photo)
                <img
                    src="{{ asset('storage/' . auth()->user()->photo) }}"
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

            <div class="leading-tight">
                <p class="font-semibold text-gray-800 text-sm">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-500">
                    Estudante
                </p>
            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-4 space-y-1">
            <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                Menu
            </p>

            {{-- DASHBOARD --}}
            <a href="{{ route('student.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg
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
                Dashboard
            </a>

            {{-- PERFIL --}}
            <a href="{{ route('student.profile.show') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.profile.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.profile.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20a8 8 0 0 1 16 0"/>
                    </svg>
                </span>
                Perfil
            </a>

            {{-- VAGAS --}}
            <a href="{{ route('student.jobs.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.jobs.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.jobs.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 6h6a2 2 0 0 1 2 2v2H7V8a2 2 0 0 1 2-2Z"/>
                        <path d="M6 10h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2Z"/>
                    </svg>
                </span>
                Vagas
            </a>

            {{-- CANDIDATURAS --}}
            <a href="{{ route('student.applications.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg
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
                Candidaturas
            </a>

            {{-- NOTIFICAÇÕES --}}
            <a href="{{ route('student.notifications.index') }}"
               class="flex justify-between items-center px-4 py-2.5 rounded-lg
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
                    Notificacoes
                </span>

                @php
                    $count = auth()->user()->unreadNotifications->count();
                @endphp

                @if($count > 0)
                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $count }}
                    </span>
                @endif
            </a>

            {{-- MENSAGENS --}}
            <a href="{{ route('student.messages.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg
               {{ request()->routeIs('student.messages.*') || request()->routeIs('student.chat.*')
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-blue-600 {{ request()->routeIs('student.messages.*') || request()->routeIs('student.chat.*') ? 'text-white' : '' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 11a8 8 0 0 1-8 8H7l-4 3V11a8 8 0 1 1 18 0Z"/>
                    </svg>
                </span>
                Mensagens
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left text-red-500 text-sm hover:text-red-600">
                    Sair
                </button>
            </form>
        </div>

    </aside>

    {{-- CONTEÚDO --}}
    <main class="flex-1 p-8">
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

</body>
</html>
