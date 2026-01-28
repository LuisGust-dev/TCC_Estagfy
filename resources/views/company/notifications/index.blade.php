@extends('company.layout')

@section('title', 'Notificações')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-emerald-50 via-white to-green-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Área da Empresa</p>
        <h1 class="text-2xl font-bold text-gray-800">Notificações</h1>
        <p class="text-gray-600">Acompanhe atualizações de vagas e candidatos</p>
    </div>

    <div class="space-y-4">

    @forelse(auth()->user()->notifications as $notification)

        <div class="bg-white border rounded-2xl p-6 flex items-start justify-between gap-4 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
                    🔔
                </div>

                <div>
                    {{-- 🔔 Clique que redireciona --}}
                    <form method="POST"
                          action="{{ route('company.notifications.readAndGo', $notification->id) }}">
                        @csrf
                        <button class="text-left font-medium text-emerald-700 hover:underline">
                            {{ $notification->data['message'] }}
                        </button>
                    </form>

                    <p class="text-sm text-gray-500 mt-1">
                        Vaga: {{ $notification->data['job_title'] }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Aluno: {{ $notification->data['student_name'] }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            <span class="text-[11px] text-gray-400 whitespace-nowrap">
                {{ $notification->created_at->format('H:i') }}
            </span>
        </div>

    @empty
        <div class="rounded-2xl border border-dashed p-8 text-center text-gray-500">
            Nenhuma notificação.
        </div>
    @endforelse


    </div>
</div>

@endsection
