@extends('layouts.guest')

@section('title', 'Recuperar senha | EstagFy')

@section('content')
<main class="mx-auto w-full max-w-3xl px-4 py-14 sm:px-6 lg:py-16">
    <section class="rounded-3xl border border-white/70 bg-white/90 p-6 shadow-xl backdrop-blur sm:p-8">
        <div class="mb-6">
            <span class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-blue-700">
                Segurança da conta
            </span>
            <h1 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">Recuperar senha</h1>
            <p class="mt-2 text-sm text-gray-600 sm:text-base">
                Informe seu e-mail para receber um link e redefinir sua senha.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ __('Enviamos o link de recuperação para o e-mail informado.') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       placeholder="seu@email.com"
                       class="mt-2 w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-gray-900 shadow-sm transition focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 hover:underline">
                    Voltar para login
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700">
                    Enviar link de recuperação
                </button>
            </div>
        </form>
    </section>
</main>
@endsection
