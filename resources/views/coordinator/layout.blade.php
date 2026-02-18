<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coordenacao | EstagFy')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-gray-900">
    <div class="border-b bg-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold">
                    C
                </div>
                <div>
                    <p class="text-sm text-gray-500">Painel</p>
                    <p class="text-lg font-semibold">Coordenação de Curso</p>
                </div>
            </div>

           
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900">
                    Sair
                </button>
            </form>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-10">
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
</body>
</html>
