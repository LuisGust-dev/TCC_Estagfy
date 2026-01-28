<aside class="w-64 bg-white border-r flex flex-col justify-between">
    <div>
        <div class="px-6 pt-6 pb-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-green-600 text-white font-bold flex items-center justify-center">
                    EG
                </div>
                <div>
                    <p class="text-sm text-gray-500">Área da Empresa</p>
                    <p class="text-lg font-semibold text-gray-800">Estagfy</p>
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="px-4 space-y-2">
            <p class="px-2 text-xs font-semibold uppercase tracking-widest text-gray-400">Navegação</p>

            <a href="{{ route('company.dashboard') }}"
                class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->routeIs('company.dashboard') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-base">📊</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('company.jobs.index') }}"
                class="group flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->routeIs('company.jobs.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-base">📁</span>
                <span class="text-sm font-medium">Minhas Vagas</span>
            </a>

            <a href="#"
                class="group flex items-center gap-3 px-4 py-2 rounded-xl text-gray-600 transition hover:bg-gray-100">
                <span class="text-base">💬</span>
                <span class="text-sm font-medium">Mensagens</span>
            </a>
        </nav>
    </div>

    {{-- LOGOUT --}}
    <div class="p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-red-600 hover:bg-red-50 transition">
                <span class="text-base">🚪</span>
                <span class="text-sm font-medium">Sair</span>
            </button>
        </form>
    </div>

</aside>
