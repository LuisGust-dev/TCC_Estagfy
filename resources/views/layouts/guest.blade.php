<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EstagFy')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <header class="flex items-center justify-between px-10 py-4 bg-white shadow-sm">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo1.png') }}" alt="EstagFy" class="h-14 md:h-16 w-auto" />
        </div>

        <div class="flex gap-4 items-center">
            <a href="{{ route('login') }}" class="text-base font-semibold px-3 py-2 rounded-lg hover:bg-gray-100 transition">Login</a>
            <a href="{{ route('register.choice') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg text-base font-semibold shadow hover:bg-blue-700 transition">
                Cadastre-se
            </a>
        </div>
    </header>

    @yield('content')

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 text-sm py-6 mt-20 text-center">
        © {{ date('Y') }} EstagFy. Todos os direitos reservados.
    </footer>

</body>
</html>
