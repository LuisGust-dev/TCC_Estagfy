@extends('company.layout')

@section('title', 'Notificações')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8 rounded-2xl border bg-gradient-to-r from-emerald-50 via-white to-green-50 p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Área da Empresa</p>
        <h1 class="text-2xl font-bold text-gray-800">Notificações</h1>
        <p class="text-gray-600">Acompanhe atualizações de vagas e candidatos</p>
    </div>

    @if(auth()->user()->notifications->isNotEmpty())
        <div class="mb-6 flex justify-end">
            <form method="POST" action="{{ route('company.notifications.clearAll') }}"
                  onsubmit="return confirm('Deseja apagar todas as notificações? Esta ação não pode ser desfeita.');">
                @csrf
                <button type="submit"
                        class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-700 transition hover:border-red-300 hover:bg-red-100">
                    Apagar todas
                </button>
            </form>
        </div>
    @endif

    <div class="space-y-4">

    @forelse(auth()->user()->notifications as $notification)

        <form method="POST" action="{{ route('company.notifications.readAndGo', $notification->id) }}">
            @csrf
            <button type="submit"
                    class="w-full text-left bg-white border rounded-2xl p-6 flex items-start justify-between gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:border-emerald-200">
                <div class="flex items-start gap-4">
                    <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
                        🔔
                    </div>

                    <div>
                        <p class="font-medium {{ is_null($notification->read_at) ? 'text-emerald-700' : 'text-gray-700' }}">
                            {{ $notification->data['message'] }}
                        </p>

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

                <div class="flex flex-col items-end gap-2">
                    @if(is_null($notification->read_at))
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    @endif

                    <span class="text-[11px] text-gray-400 whitespace-nowrap">
                        {{ $notification->created_at->format('H:i') }}
                    </span>
                </div>
            </button>
        </form>

    @empty
        <div class="rounded-2xl border border-dashed p-8 text-center text-gray-500">
            Nenhuma notificação.
        </div>
    @endforelse


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setInterval(() => {
            if (document.hidden) return;
            window.location.reload();
        }, 6000);
    });
</script>

@endsection
