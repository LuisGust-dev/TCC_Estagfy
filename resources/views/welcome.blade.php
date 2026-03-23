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

    .hero-typed-slot {
        display: block;
        min-height: 1.2em;
        line-height: 1.1;
    }

    #hero-typed-text {
        display: inline-block;
    }

    @keyframes heroBlink {
        50% { opacity: 0; }
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 700ms ease, transform 700ms ease;
        transition-delay: var(--reveal-delay, 0ms);
        will-change: opacity, transform;
    }

    .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .process-step-card {
        transition: transform 260ms ease, filter 260ms ease;
    }

    .process-step-card .process-step-badge {
        transition: transform 280ms ease, box-shadow 280ms ease, filter 280ms ease;
    }

    .process-step-card .process-step-title,
    .process-step-card .process-step-label {
        transition: color 220ms ease, transform 220ms ease;
    }

    .process-step-card:hover {
        transform: translateY(-8px);
        filter: saturate(1.05);
    }

    .process-step-card:hover .process-step-badge {
        transform: scale(1.08);
        box-shadow: 0 18px 32px -18px rgba(59, 130, 246, 0.45);
        filter: brightness(1.03);
    }

    .process-step-card:hover .process-step-title {
        transform: translateY(-1px);
        color: #111827;
    }

    .process-step-card:hover .process-step-label {
        transform: translateY(-1px);
    }

    .stack-card {
        transition: transform 280ms ease, box-shadow 280ms ease, border-color 240ms ease, background-color 240ms ease;
    }

    .stack-card .stack-icon,
    .stack-card .stack-title,
    .stack-card .stack-text {
        transition: transform 260ms ease, box-shadow 260ms ease, color 220ms ease;
    }

    .stack-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 50px -28px rgba(15, 23, 42, 0.28);
        border-color: rgba(148, 163, 184, 0.35);
        background-color: rgba(255, 255, 255, 0.98);
    }

    .stack-card:hover .stack-icon {
        transform: scale(1.08) rotate(-4deg);
        box-shadow: 0 18px 30px -20px rgba(59, 130, 246, 0.45);
    }

    .stack-card:hover .stack-title {
        transform: translateY(-1px);
        color: #111827;
    }

    .stack-card:hover .stack-text {
        color: #475569;
    }

    @media (prefers-reduced-motion: reduce) {
        .scroll-reveal,
        .scroll-reveal.is-visible,
        .process-step-card,
        .process-step-card .process-step-badge,
        .process-step-card .process-step-title,
        .process-step-card .process-step-label,
        .process-step-card:hover,
        .process-step-card:hover .process-step-badge,
        .process-step-card:hover .process-step-title,
        .process-step-card:hover .process-step-label,
        .stack-card,
        .stack-card .stack-icon,
        .stack-card .stack-title,
        .stack-card .stack-text,
        .stack-card:hover,
        .stack-card:hover .stack-icon,
        .stack-card:hover .stack-title,
        .stack-card:hover .stack-text {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>

{{-- =========================
1️⃣ HERO
========================= --}}
<section class="welcome-hero-shell py-20 md:py-24 text-center text-white relative overflow-hidden">
    <div class="hero-slide is-active" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-slide" data-hero-slide style="background-image: url('https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="hero-overlay"></div>

    <div class="relative z-10">

    {{-- Badge --}}
    <div class="flex justify-center mb-6">
        <span class="inline-flex items-center gap-2 bg-white/20 px-5 py-2 rounded-full text-sm backdrop-blur shadow">
            Conectando talentos a oportunidades de estágio
        </span>
    </div>

    {{-- Título --}}
    <h1 class="mx-auto max-w-4xl text-4xl md:text-6xl font-extrabold leading-tight mb-6">
        <span>Conectando alunos e empresas para </span>
        <span class="hero-typed-slot">
            <span id="hero-typed-text" class="text-yellow-300"></span>
            <span class="hero-typewriter-caret" aria-hidden="true"></span>
        </span>
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
    <h2 class="scroll-reveal text-3xl font-bold text-center mb-4 text-gray-900">
        Tudo que você precisa em um só lugar
    </h2>

    <p class="scroll-reveal text-gray-600 text-center mb-16" style="--reveal-delay: 80ms;">
        Ferramentas completas para alunos e empresas gerenciarem todo o processo de estágio
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 max-w-6xl mx-auto px-6">

        {{-- Card --}}
        @php
            $features = [
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M4 6.5h16M6 6.5V18a1.5 1.5 0 0 0 1.5 1.5h9A1.5 1.5 0 0 0 18 18V6.5M9.5 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Vagas de Estágio',
                    'text' => 'Centenas de oportunidades em diversas áreas',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm10 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3ZM2.5 18a4.5 4.5 0 0 1 9 0m3 0a4.5 4.5 0 0 1 9 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Gestão de Candidatos',
                    'text' => 'Empresas gerenciam candidaturas facilmente',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 4v3M17 4v3M4 9.5h16M6.5 12.5h3M6.5 16h3M12.5 12.5h3M12.5 16h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><rect x="4" y="6.5" width="16" height="13" rx="2" stroke="currentColor" stroke-width="1.7"/></svg>',
                    'title' => 'Calendário Integrado',
                    'text' => 'Organize entrevistas e prazos',
                ],
                [
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" class="w-7 h-7"><path d="M7 18.5l-3.5 2V6.5A2.5 2.5 0 0 1 6 4h12a2.5 2.5 0 0 1 2.5 2.5V14a2.5 2.5 0 0 1-2.5 2.5H7Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'title' => 'Chat Direto',
                    'text' => 'Comunicação direta entre empresas e alunos',
                ],
            ];
        @endphp

        @foreach($features as $feature)
            <div class="scroll-reveal group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-2xl" style="--reveal-delay: {{ $loop->index * 90 }}ms;">
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
3️⃣ SOBRE NÓS
========================= --}}
<section class="py-24 bg-gradient-to-b from-slate-50 to-blue-50/40">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 gap-24">
            <div class="grid grid-cols-1 items-center gap-14 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
                <div class="scroll-reveal">
                    <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 text-blue-700 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] mb-5">
                        Sobre o sistema
                    </span>
                    <h2 class="max-w-2xl text-3xl md:text-5xl font-bold tracking-tight text-slate-900 leading-tight">
                        Um complemento inteligente para a
                        <span class="text-indigo-600">jornada acadêmica e profissional</span>
                    </h2>
                    <div class="mt-6 max-w-2xl space-y-5 text-lg leading-8 text-slate-600">
                        <p>
                            O <strong class="text-slate-900">EstagFy</strong> foi desenvolvido para centralizar o processo de estágio em um único ambiente, conectando alunos, empresas, coordenadores e administração acadêmica.
                        </p>
                        <p>
                            A plataforma organiza vagas, candidaturas, documentos, calendário, notificações e comunicação direta entre os envolvidos, reduzindo etapas manuais e dando mais clareza ao acompanhamento do estágio.
                        </p>
                        <p>
                            O objetivo é oferecer uma experiência mais intuitiva, segura e organizada como apoio ao fluxo institucional, sem substituir os sistemas oficiais da instituição.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="inline-flex items-center rounded-full border border-blue-200 bg-white px-4 py-2 text-sm font-medium text-blue-700 shadow-sm">
                            Apoio à gestão de estágios
                        </span>
                        <span class="inline-flex items-center rounded-full border border-emerald-200 bg-white px-4 py-2 text-sm font-medium text-emerald-700 shadow-sm">
                            Organização de documentos
                        </span>
                        <span class="inline-flex items-center rounded-full border border-indigo-200 bg-white px-4 py-2 text-sm font-medium text-indigo-700 shadow-sm">
                            Acompanhamento em tempo real
                        </span>
                    </div>
                </div>

                <div class="scroll-reveal relative" style="--reveal-delay: 120ms;">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(59,130,246,0.18),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(99,102,241,0.18),transparent_45%)]"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-blue-100 bg-white/90 shadow-[0_25px_80px_-30px_rgba(37,99,235,0.35)] backdrop-blur">
                        <div class="flex items-center gap-2 border-b border-slate-100 px-5 py-4">
                            <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                            <div class="ml-4 flex-1 rounded-full bg-slate-100 px-4 py-1 text-center text-xs font-medium text-slate-400">
                                estagfy.app/dashboard
                            </div>
                        </div>
                        <div class="grid gap-5 p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Módulos</p>
                                    <p class="mt-3 text-2xl font-bold text-slate-900">4 perfis</p>
                                    <p class="mt-2 text-sm text-slate-500">Aluno, empresa, coordenador e administrador.</p>
                                </div>
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Fluxo</p>
                                    <p class="mt-3 text-2xl font-bold text-slate-900">1 jornada</p>
                                    <p class="mt-2 text-sm text-slate-500">Da candidatura à conclusão do estágio.</p>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Visão centralizada do estágio</p>
                                        <p class="mt-2 text-sm leading-6 text-slate-600">
                                            Painéis específicos por perfil, ações administrativas, relatórios e acompanhamento de eventos acadêmicos no mesmo ambiente.
                                        </p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-blue-700 shadow-sm">Ativo</span>
                                </div>
                            </div>

                            <div class="grid gap-3">
                                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                                    <span class="text-sm font-medium text-slate-700">Candidaturas e status</span>
                                    <span class="text-xs font-semibold text-emerald-600">Organizado</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                                    <span class="text-sm font-medium text-slate-700">Calendário e eventos</span>
                                    <span class="text-xs font-semibold text-blue-600">Integrado</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                                    <span class="text-sm font-medium text-slate-700">Mensagens e notificações</span>
                                    <span class="text-xs font-semibold text-indigo-600">Sincronizado</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="scroll-reveal rounded-[2rem] border border-slate-200 bg-white px-6 py-12 shadow-sm md:px-10 md:py-14">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-indigo-700">
                        Processo
                    </span>
                    <h3 class="mt-4 text-3xl font-bold text-slate-900 md:text-4xl">Como funciona</h3>
                    <p class="mt-3 text-lg text-slate-600">
                        Um processo simples e guiado para apoiar o estágio do início ao encerramento.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-10 md:grid-cols-4 md:gap-8">
                    @foreach([
                        ['step' => 'Passo 01', 'title' => 'Cadastro', 'text' => 'O aluno e a empresa criam seus perfis com dados essenciais para participação no processo.', 'accent' => 'blue'],
                        ['step' => 'Passo 02', 'title' => 'Acompanhamento', 'text' => 'As vagas e candidaturas são gerenciadas em painéis próprios com status atualizados.', 'accent' => 'indigo'],
                        ['step' => 'Passo 03', 'title' => 'Documentos', 'text' => 'Documentação, calendário e orientações ficam organizados dentro do fluxo de estágio.', 'accent' => 'emerald'],
                        ['step' => 'Passo 04', 'title' => 'Conclusão', 'text' => 'O estágio pode ser finalizado com registro das etapas e acompanhamento institucional.', 'accent' => 'amber'],
                    ] as $item)
                        <div class="scroll-reveal process-step-card relative text-center" style="--reveal-delay: {{ $loop->index * 110 }}ms;">
                            <div class="process-step-badge mx-auto flex h-16 w-16 items-center justify-center rounded-full border-4 border-white shadow-lg {{ $item['accent'] === 'blue' ? 'bg-blue-600 shadow-blue-200/70' : ($item['accent'] === 'indigo' ? 'bg-indigo-600 shadow-indigo-200/70' : ($item['accent'] === 'emerald' ? 'bg-emerald-600 shadow-emerald-200/70' : 'bg-amber-500 shadow-amber-200/70')) }}">
                                <span class="h-2.5 w-2.5 rounded-full bg-white"></span>
                            </div>
                            <div class="mt-5">
                                <p class="process-step-label text-xs font-semibold uppercase tracking-[0.18em] {{ $item['accent'] === 'blue' ? 'text-blue-600' : ($item['accent'] === 'indigo' ? 'text-indigo-600' : ($item['accent'] === 'emerald' ? 'text-emerald-600' : 'text-amber-600')) }}">
                                    {{ $item['step'] }}
                                </p>
                                <h4 class="process-step-title mt-3 text-2xl font-bold text-slate-900">{{ $item['title'] }}</h4>
                                <p class="mt-3 text-sm leading-7 text-slate-600">
                                    {{ $item['text'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 items-start gap-14 lg:grid-cols-[0.95fr_1.05fr] lg:gap-16">
                <div class="scroll-reveal">
                    <span class="inline-flex items-center rounded-full bg-violet-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-violet-700">
                        Desenvolvimento
                    </span>
                    <h3 class="mt-5 max-w-xl text-3xl font-bold leading-tight text-slate-900 md:text-5xl">
                        Construído com tecnologias atuais e foco em qualidade
                    </h3>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">
                        O EstagFy foi desenvolvido como projeto acadêmico com arquitetura Laravel, persistência em MySQL, interface em Blade com TailwindCSS e prototipação de interface apoiada por Figma.
                    </p>
                    <p class="mt-4 max-w-xl text-lg leading-8 text-slate-600">
                        A estrutura foi pensada para oferecer clareza de navegação, manutenção de código e escalabilidade gradual conforme novas demandas acadêmicas e institucionais surgem.
                    </p>
                    <div class="mt-8 inline-flex items-center gap-3 rounded-2xl border border-violet-200 bg-white px-5 py-3 text-sm font-medium text-violet-700 shadow-sm">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-violet-100">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 12h5M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                            </svg>
                        </span>
                        Projeto acadêmico orientado por boas práticas
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @foreach([
                        ['title' => 'Laravel', 'text' => 'Backend, regras de negócio, autenticação e módulos por perfil.', 'color' => 'rose'],
                        ['title' => 'MySQL', 'text' => 'Persistência de usuários, vagas, candidaturas, mensagens e calendário.', 'color' => 'blue'],
                        ['title' => 'TailwindCSS', 'text' => 'Interface responsiva, organizada e consistente em todo o sistema.', 'color' => 'cyan'],
                        ['title' => 'Figma', 'text' => 'Apoio no protótipo visual e evolução da experiência de uso.', 'color' => 'violet'],
                    ] as $stack)
                        <div class="scroll-reveal stack-card rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" style="--reveal-delay: {{ $loop->index * 100 }}ms;">
                            <div class="stack-icon flex h-14 w-14 items-center justify-center rounded-2xl {{ $stack['color'] === 'rose' ? 'bg-rose-50 text-rose-500' : ($stack['color'] === 'blue' ? 'bg-blue-50 text-blue-500' : ($stack['color'] === 'cyan' ? 'bg-cyan-50 text-cyan-500' : 'bg-violet-50 text-violet-500')) }}">
                                @if($stack['title'] === 'Laravel')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7l4 2.5m0 0L14 7m-4 2.5V14m8-5.5L14 7m4 1.5V14L14 16.5m-8-8L10 7m-4 1.5V14L10 16.5m4 0L10 14m4 2.5L18 14"/>
                                    </svg>
                                @elseif($stack['title'] === 'MySQL')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <ellipse cx="12" cy="6.5" rx="6.5" ry="2.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 6.5v5c0 1.4 2.9 2.5 6.5 2.5s6.5-1.1 6.5-2.5v-5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 11.5v5c0 1.4 2.9 2.5 6.5 2.5s6.5-1.1 6.5-2.5v-5"/>
                                    </svg>
                                @elseif($stack['title'] === 'TailwindCSS')
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 13c1-2 2.5-3 4.5-3 3 0 3.4 3 5.5 3 1.2 0 2.2-.5 3-1.5-1 2-2.5 3-4.5 3-3 0-3.4-3-5.5-3-1.2 0-2.2.5-3 1.5Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 17c1-2 2.5-3 4.5-3 3 0 3.4 3 5.5 3 1.2 0 2.2-.5 3-1.5-1 2-2.5 3-4.5 3-3 0-3.4-3-5.5-3-1.2 0-2.2.5-3 1.5Z"/>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16c1.5 1 3 1.5 4 1.5 2 0 4-1.6 4-4.3V6l-8 3.1V16Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-2.3-.9A1.8 1.8 0 0 0 3 9.8c0 .8.5 1.5 1.2 1.7l3.8 1.5"/>
                                    </svg>
                                @endif
                            </div>
                            <h4 class="stack-title mt-6 text-2xl font-bold text-slate-900">{{ $stack['title'] }}</h4>
                            <p class="stack-text mt-3 text-base leading-7 text-slate-600">{{ $stack['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================
4️⃣ ALUNO x EMPRESA
========================= --}}
<section class="py-24 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="scroll-reveal text-center mb-12">
            <span class="inline-flex items-center rounded-full bg-indigo-100 text-indigo-700 px-4 py-1 text-xs font-semibold uppercase tracking-wider">
                Fluxos principais
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4">Uma experiência pensada para cada perfil</h2>
            <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                Estudantes e empresas encontram uma jornada clara, rápida e organizada para transformar estágios em resultados reais.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Aluno --}}
            <article class="scroll-reveal group relative overflow-hidden bg-white p-8 rounded-3xl border border-blue-100 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                <div class="absolute -top-20 -right-12 w-44 h-44 rounded-full bg-gradient-to-br from-blue-200/60 to-cyan-200/60 blur-2xl"></div>
                <div class="absolute top-0 left-0 h-1 w-full bg-gradient-to-r from-blue-600 to-cyan-500"></div>

                <div class="relative">
                    <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider mb-4">
                        Jornada do estudante
                    </span>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900 flex items-center gap-2">
                        <span class="text-3xl">🎓</span> Para Alunos
                    </h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Organize sua busca por estágio com um processo simples, acompanhamento em tempo real e contato direto com as empresas.
                    </p>

                    <ul class="space-y-3 text-sm text-gray-700 mb-8">
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold">✓</span> Encontre vagas compatíveis com seu perfil</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold">✓</span> Acompanhe suas candidaturas em um painel único</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold">✓</span> Gerencie entrevistas e prazos com mais controle</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold">✓</span> Comunicação direta com empresas</li>
                    </ul>

                    <a href="{{ route('register.student') }}"
                    class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold transition shadow-md shadow-blue-200/70">
                        Cadastrar como Aluno
                    </a>
                </div>
            </article>

            {{-- Empresa --}}
            <article class="scroll-reveal group relative overflow-hidden bg-white p-8 rounded-3xl border border-emerald-100 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300" style="--reveal-delay: 120ms;">
                <div class="absolute -top-20 -right-12 w-44 h-44 rounded-full bg-gradient-to-br from-emerald-200/60 to-teal-200/60 blur-2xl"></div>
                <div class="absolute top-0 left-0 h-1 w-full bg-gradient-to-r from-emerald-600 to-teal-500"></div>

                <div class="relative">
                    <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider mb-4">
                        Fluxo de recrutamento
                    </span>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900 flex items-center gap-2">
                        <span class="text-3xl">🏢</span> Para Empresas
                    </h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Publique oportunidades, avalie candidatos e conduza contratações com mais agilidade e organização em um só lugar.
                    </p>

                    <ul class="space-y-3 text-sm text-gray-700 mb-8">
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">✓</span> Publique vagas rapidamente</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">✓</span> Gerencie candidatos em um só painel</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">✓</span> Acesse currículos e perfis com facilidade</li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">✓</span> Contrate com processo mais eficiente</li>
                    </ul>

                    <a href="{{ route('register.company') }}"
                    class="block text-center bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition shadow-md shadow-emerald-200/70">
                        Cadastrar como Empresa
                    </a>
                </div>
            </article>
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

        const revealItems = document.querySelectorAll('.scroll-reveal');
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, {
                threshold: 0.14,
                rootMargin: '0px 0px -40px 0px',
            });

            revealItems.forEach((item) => revealObserver.observe(item));
        } else {
            revealItems.forEach((item) => item.classList.add('is-visible'));
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
