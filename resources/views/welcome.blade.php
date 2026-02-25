@extends('layouts.guest')

@section('title', 'EstagFy')

@section('content')

<style>
    .welcome-hero-shell {
        min-height: clamp(520px, 78vh, 760px);
        isolation: isolate;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 900ms ease, transform 6s ease;
        will-change: opacity, transform;
    }

    .hero-slide.is-active {
        opacity: 1;
        transform: scale(1);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(115deg, rgba(29, 78, 216, .80), rgba(30, 64, 175, .78), rgba(2, 132, 199, .78)),
            radial-gradient(circle at 14% 20%, rgba(255, 255, 255, .22), transparent 33%),
            radial-gradient(circle at 82% 86%, rgba(255, 255, 255, .15), transparent 36%);
        z-index: 1;
    }

    .hero-typewriter-caret {
        display: inline-block;
        width: .14em;
        margin-left: .08em;
        background-color: rgba(255, 255, 255, .9);
        animation: heroBlink 1s steps(1, end) infinite;
        vertical-align: text-bottom;
    }

    @keyframes heroBlink {
        50% { opacity: 0; }
    }
</style>

{{-- =========================
1️⃣ HERO
========================= --}}
<section class="welcome-hero-shell py-20 md:py-24 text-center text-white relative overflow-hidden">
    <div class="hero-slide is-active" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-overlay"></div>

    <div class="relative z-10">

    {{-- Badge --}}
    <div class="flex justify-center mb-6">
        <span class="inline-flex items-center gap-2 bg-white/20 px-5 py-2 rounded-full text-sm backdrop-blur shadow">
            🚀 Conectando talentos às melhores oportunidades
        </span>
    </div>

    {{-- Título --}}
    <h1 class="mx-auto max-w-4xl text-4xl md:text-6xl font-extrabold leading-tight mb-6">
        <span>Conectando alunos e empresas para </span>
        <span id="hero-typed-text" class="text-yellow-300"></span>
        <span class="hero-typewriter-caret" aria-hidden="true"></span>
    </h1>

    {{-- Subtítulo --}}
    <p class="text-blue-100 max-w-2xl mx-auto mb-12 text-lg">
        O EstagFy é a plataforma completa para encontrar vagas, gerenciar candidaturas
        e iniciar sua carreira profissional.
    </p>

    {{-- Botões --}}
    <div class="flex flex-col sm:flex-row justify-center gap-4">
       <a href="{{ route('register.choice') }}"
           class="bg-white text-blue-700 px-10 py-4 rounded-xl font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition">
            Comece agora →
        </a>

        <a href="{{ route('login') }}"
           class="border border-white text-white px-10 py-4 rounded-xl font-semibold hover:bg-white/10 transition">
            Já tenho conta
        </a>
    </div>
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
<section class="py-24 bg-gradient-to-b from-slate-50 to-blue-50/40">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 text-blue-700 px-4 py-1 text-xs font-semibold uppercase tracking-wider mb-4">
                Plataforma educacional
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Sobre o EstagFy
            </h2>
            <p class="text-gray-600 text-lg">
                O EstagFy foi criado para aproximar formacao academica e mercado de trabalho, com uma experiencia simples, organizada e focada no desenvolvimento profissional dos estudantes.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <div class="rounded-2xl border border-blue-100 bg-white/80 backdrop-blur p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-blue-700 mb-2">Missao</h3>
                <p class="text-gray-700">
                    Facilitar o acesso dos alunos a oportunidades de estagio com processos claros e acompanhamento em tempo real.
                </p>
            </div>

            <div class="rounded-2xl border border-emerald-100 bg-white/80 backdrop-blur p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-emerald-700 mb-2">Visao</h3>
                <p class="text-gray-700">
                    Ser referencia em conexao entre instituicoes de ensino, estudantes e empresas que investem em novos talentos.
                </p>
            </div>

            <div class="rounded-2xl border border-indigo-100 bg-white/80 backdrop-blur p-6 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-indigo-700 mb-2">Compromisso</h3>
                <p class="text-gray-700">
                    Entregar uma plataforma segura, intuitiva e acessivel para apoiar decisoes de carreira com qualidade.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <article class="group relative overflow-hidden bg-white p-8 rounded-3xl border border-blue-100 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="absolute top-0 left-0 h-1 w-full bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                    <div class="relative shrink-0">
                        <div class="absolute -inset-2 rounded-3xl bg-gradient-to-br from-blue-200 to-cyan-200 blur-sm"></div>
                        <img src="{{ asset('images/aluno.jpeg') }}" alt="Foto do desenvolvedor" class="relative w-28 h-28 md:w-32 md:h-32 rounded-3xl object-cover bg-gray-100 ring-4 ring-white shadow-xl" />
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider mb-3">
                            Desenvolvimento da plataforma
                        </span>
                        <h3 class="text-2xl font-bold text-gray-900 leading-tight">Luis Gustavo</h3>
                        <p class="text-sm text-gray-500 font-medium mb-3">Desenvolvedor Full Stack</p>
                        <p class="text-gray-600 mb-4">
                            Responsavel pela arquitetura, experiencia do usuario e evolucao tecnica do EstagFy, com foco em usabilidade e eficiencia no fluxo de estagios.
                        </p>
                        <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Arquitetura</span>
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">UX educacional</span>
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Laravel</span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="group relative overflow-hidden bg-white p-8 rounded-3xl border border-amber-100 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="absolute top-0 left-0 h-1 w-full bg-gradient-to-r from-amber-500 to-orange-500"></div>
                <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                    <div class="relative shrink-0">
                        <div class="absolute -inset-2 rounded-3xl bg-gradient-to-br from-amber-200 to-orange-200 blur-sm"></div>
                        <img src="{{ asset('images/orientador.png') }}" alt="Foto do orientador" class="relative w-28 h-28 md:w-32 md:h-32 rounded-3xl object-cover bg-gray-100 ring-4 ring-white shadow-xl" />
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider mb-3">
                            Orientacao academica
                        </span>
                        <h3 class="text-2xl font-bold text-gray-900 leading-tight">Prof. George Gabriel</h3>
                        <p class="text-sm text-gray-500 font-medium mb-3">Orientador do projeto</p>
                        <p class="text-gray-600 mb-4">
                            Contribui com direcionamento tecnico e academico para garantir qualidade metodologica e alinhamento do sistema com objetivos de formacao profissional.
                        </p>
                        <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Metodologia</span>
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Qualidade academica</span>
                            <span class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Mentoria</span>
                        </div>
                    </div>
                </div>
            </article>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = Array.from(document.querySelectorAll('[data-hero-slide]'));
        let activeSlide = 0;

        if (slides.length > 1) {
            setInterval(() => {
                slides[activeSlide].classList.remove('is-active');
                activeSlide = (activeSlide + 1) % slides.length;
                slides[activeSlide].classList.add('is-active');
            }, 4200);
        }

        const typedEl = document.getElementById('hero-typed-text');
        if (!typedEl) return;

        const words = [
            'oportunidades',
            'carreiras promissoras',
            'conexões com empresas',
            'crescimento profissional',
            'novos talentos'
        ];

        let wordIndex = 0;
        let charIndex = 0;
        let deleting = false;

        const runTypewriter = () => {
            const currentWord = words[wordIndex];

            if (!deleting) {
                typedEl.textContent = currentWord.slice(0, charIndex + 1);
                charIndex += 1;

                if (charIndex === currentWord.length) {
                    deleting = true;
                    setTimeout(runTypewriter, 1900);
                    return;
                }

                setTimeout(runTypewriter, 85);
                return;
            }

            typedEl.textContent = currentWord.slice(0, charIndex - 1);
            charIndex -= 1;

            if (charIndex === 0) {
                deleting = false;
                wordIndex = (wordIndex + 1) % words.length;
                setTimeout(runTypewriter, 420);
                return;
            }

            setTimeout(runTypewriter, 55);
        };

        runTypewriter();
    });
</script>

@endsection
