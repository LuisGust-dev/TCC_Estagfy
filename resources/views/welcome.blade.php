@extends('layouts.guest')

@section('title', 'EstagFy')

@section('content')

{{-- =========================
1️⃣ HERO
========================= --}}
<section class="bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-700 py-28 text-center text-white relative overflow-hidden">

    {{-- Badge --}}
    <div class="flex justify-center mb-6">
        <span class="inline-flex items-center gap-2 bg-white/20 px-5 py-2 rounded-full text-sm backdrop-blur shadow">
            🚀 Conectando talentos às melhores oportunidades
        </span>
    </div>

    {{-- Título --}}
    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
        Conectando <span class="text-yellow-300">alunos</span> e
        <span class="text-yellow-300">empresas</span><br>
        para oportunidades de estágio
    </h1>

    {{-- Subtítulo --}}
    <p class="text-blue-100 max-w-2xl mx-auto mb-12 text-lg">
        O EstagFy é a plataforma completa para encontrar vagas, gerenciar candidaturas
        e iniciar sua carreira profissional.
    </p>

    {{-- Botões --}}
    <div class="flex justify-center gap-4">
       <a href="{{ route('register.choice') }}"
           class="bg-white text-blue-700 px-10 py-4 rounded-xl font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition">
            Comece agora →
        </a>

        <a href="{{ route('login') }}"
           class="border border-white text-white px-10 py-4 rounded-xl font-semibold hover:bg-white/10 transition">
            Já tenho conta
        </a>
    </div>
</section>

{{-- =========================
2️⃣ FUNCIONALIDADES
========================= --}}
<section class="py-24 bg-white">
    <h2 class="text-3xl font-bold text-center mb-4 text-gray-900">
        Tudo que você precisa em um só lugar
    </h2>

    <p class="text-gray-600 text-center mb-16">
        Ferramentas completas para alunos e empresas gerenciarem todo o processo de estágio
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 max-w-6xl mx-auto px-6">

        {{-- Card --}}
        @php
            $features = [
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M4 6.5h16M6 6.5V18a1.5 1.5 0 0 0 1.5 1.5h9A1.5 1.5 0 0 0 18 18V6.5M9.5 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Vagas de Estagio',
                    'text' => 'Centenas de oportunidades em diversas areas',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm10 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3ZM2.5 18a4.5 4.5 0 0 1 9 0m3 0a4.5 4.5 0 0 1 9 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Gestao de Candidatos',
                    'text' => 'Empresas gerenciam candidaturas facilmente',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 4v3M17 4v3M4 9.5h16M6.5 12.5h3M6.5 16h3M12.5 12.5h3M12.5 16h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><rect x="4" y="6.5" width="16" height="13" rx="2" stroke="currentColor" stroke-width="1.7"/></svg>',
                    'title' => 'Calendario Integrado',
                    'text' => 'Organize entrevistas e prazos',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 18.5l-3.5 2V6.5A2.5 2.5 0 0 1 6 4h12a2.5 2.5 0 0 1 2.5 2.5V14a2.5 2.5 0 0 1-2.5 2.5H7Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Chat Direto',
                    'text' => 'Comunicacao direta entre empresas e alunos',
                ],
            ];
        @endphp

        @foreach($features as $feature)
            <div class="group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white w-14 h-14 flex items-center justify-center rounded-2xl mb-5 shadow-lg ring-4 ring-blue-600/15 transition duration-300 group-hover:scale-110 group-hover:-rotate-3">
                    {!! $feature['icon'] !!}
                </div>

                <h3 class="font-semibold mb-3 text-gray-900 text-lg">
                    {{ $feature['title'] }}
                </h3>

                <p class="text-base text-gray-600">
                    {{ $feature['text'] }}
                </p>
            </div>
        @endforeach
    </div>
</section>

{{-- =========================
3️⃣ SOBRE NOS
========================= --}}
<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4 text-gray-900">
            Sobre nos
        </h2>

        <p class="text-gray-600 text-center mb-16">
            Conheca quem esta por tras do desenvolvimento do EstagFy
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="bg-white p-8 md:p-10 rounded-3xl border border-gray-100 shadow-lg flex flex-col sm:flex-row gap-8 items-center">
                <div class="relative">
                    <div class="absolute -inset-2 rounded-3xl bg-gradient-to-br from-blue-200 to-emerald-200 blur-sm"></div>
                    <img src="{{ asset('images/aluno.jpeg') }}" alt="Foto do desenvolvedor" class="relative w-32 h-32 md:w-40 md:h-40 rounded-3xl object-cover bg-gray-100 ring-4 ring-white shadow-xl" />
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-2">Desenvolvedor</p>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Luis Gustavo</h3>
                    <p class="text-gray-600">
                        Desenvolvedor do EstagFy, responsavel pela arquitetura, interface e experiencia do usuario.
                    </p>
                </div>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-3xl border border-gray-100 shadow-lg flex flex-col sm:flex-row gap-8 items-center">
                <div class="relative">
                    <div class="absolute -inset-2 rounded-3xl bg-gradient-to-br from-amber-200 to-rose-200 blur-sm"></div>
                    <img src="{{ asset('images/orientador.png') }}" alt="Foto do orientador" class="relative w-32 h-32 md:w-40 md:h-40 rounded-3xl object-cover bg-gray-100 ring-4 ring-white shadow-xl" />
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 mb-2">Orientador</p>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Prof George Gabriel</h3>
                    <p class="text-gray-600">
                        Orientador do projeto, contribuindo com direcionamento tecnico e academico.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================
4️⃣ ALUNO x EMPRESA
========================= --}}
<section class="py-24 bg-gray-50">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-6xl mx-auto px-6">

        {{-- Aluno --}}
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 flex items-center gap-2">
                🎓 Para Alunos
            </h3>

            <ul class="space-y-3 text-sm text-gray-600 mb-8">
                <li>✔ Encontre vagas compatíveis com seu perfil</li>
                <li>✔ Acompanhe suas candidaturas</li>
                <li>✔ Gerencie entrevistas e prazos</li>
                <li>✔ Comunicação direta com empresas</li>
            </ul>

            <a href="{{ route('register.student') }}"
               class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold transition">
                Cadastrar como Aluno
            </a>
        </div>

        {{-- Empresa --}}
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-md hover:shadow-xl transition">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 flex items-center gap-2">
                🏢 Para Empresas
            </h3>

            <ul class="space-y-3 text-sm text-gray-600 mb-8">
                <li>✔ Publique vagas rapidamente</li>
                <li>✔ Gerencie candidatos em um só lugar</li>
                <li>✔ Acesse currículos e perfis</li>
                <li>✔ Contrate com facilidade</li>
            </ul>

            <a href="{{ route('register.company') }}"
               class="block text-center bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-xl font-semibold transition">
                Cadastrar como Empresa
            </a>
        </div>

    </div>
</section>

@endsection
