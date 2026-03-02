@extends('student.layout')

@section('title', 'Fluxo de Estágio')

@section('content')
<div class="mb-8 rounded-2xl border bg-gradient-to-r from-blue-50 via-white to-cyan-50 p-6">
    <p class="text-xs font-semibold uppercase tracking-widest text-blue-500">Módulo Informativo</p>
    <h1 class="text-2xl font-bold text-gray-800">Fluxo de documentação do estágio</h1>
    <p class="text-gray-600">
        Veja a ordem dos documentos que precisam ser entregues ao NRI no início e no encerramento do estágio.
    </p>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm">
        <div class="mb-4 inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-blue-700">
            Primeiros documentos para início do estágio
        </div>

        <ol class="space-y-3 text-sm text-gray-700">
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">1.</span>
                Requerimento de estágio
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">2.</span>
                Plano de atividades de estágio curricular
            </li>

            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">3.</span>
                Termo de compromisso e plano de atividades de estágio(TCE)
            </li>
        </ol>
    </section>

    <section class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
        <div class="mb-4 inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">
            Documentos para finalizar o estágio
        </div>

        <ol class="space-y-3 text-sm text-gray-700">

            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">4.</span>
                Ficha de avaliação do supervisor
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">5.</span>
                Avaliação do relatório de estágio
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">6.</span>
                Controle de frequência em estágio
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">7.</span>
                Relatório de atividades de estágio
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">8.</span>
                Termo de realização do estágio
            </li>
            <li class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                <span class="font-semibold text-gray-900">9.</span>
                Relatório de estágio
            </li>
        </ol>
    </section>
</div>
@endsection
