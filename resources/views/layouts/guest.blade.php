<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EstagFy')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo1-removebg-preview.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <header class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-10 bg-white shadow-sm">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo1-removebg-preview.png') }}" alt="EstagFy" class="h-14 md:h-16 w-auto" />
        </div>

        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:gap-4">
            <a href="{{ route('login') }}"
               class="inline-flex w-full justify-center items-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-base font-semibold text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300/60 sm:w-auto">
                Login
            </a>
            <a href="{{ route('register.choice') }}"
               class="w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg text-base font-semibold shadow hover:bg-blue-700 transition sm:w-auto">
                Cadastre-se
            </a>
        </div>
    </header>

    @isset($slot)
        {{ $slot }}
    @endisset
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 text-sm py-6 mt-20 text-center">
        © {{ date('Y') }} EstagFy. Todos os direitos reservados.
    </footer>

</body>
</html>





