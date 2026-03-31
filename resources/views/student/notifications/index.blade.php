@extends('student.layout')

@section('title', 'Notificações')

@section('content')

<h1 class="text-2xl font-bold mb-1">Notificações</h1>
<p class="text-gray-500 mb-8">
    Acompanhe atualizações sobre suas candidaturas
</p>

@if($notifications->isNotEmpty())
    <div class="mb-6 flex justify-end">
        <form method="POST" action="{{ route('student.notifications.clearAll') }}"
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

    @forelse($notifications as $notification)

        <form method="POST" action="{{ route('student.notifications.readAndGo', $notification->id) }}">
            @csrf
            <button type="submit"
                    class="w-full text-left bg-white border rounded-2xl p-6 flex items-start justify-between gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:border-blue-200">
                <div class="flex items-start gap-4">
                    @if(!empty($notification->sender_photo_url))
                        <img src="{{ $notification->sender_photo_url }}"
                             alt="{{ $notification->sender_name }}"
                             class="h-12 w-12 rounded-full object-cover ring-2 ring-blue-100">
                    @else
                        <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold ring-2 ring-blue-100">
                            {{ $notification->sender_initial }}
                        </div>
                    @endif

                    <div>
                        <p class="font-medium leading-6 {{ is_null($notification->read_at) ? 'text-blue-700' : 'text-gray-700' }}">
                            <span class="text-gray-900">{{ $notification->sender_name }}</span>
                            <span class="font-normal text-gray-600">{{ ' ' . $notification->data['message'] }}</span>
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Vaga: {{ $notification->data['job_title'] ?? '-' }}
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-2">
                    @if(is_null($notification->read_at))
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    @endif

                    <span class="text-[11px] text-gray-400 whitespace-nowrap">
                        {{ $notification->created_at->format('H:i') }}
                    </span>
                </div>
            </button>
        </form>

    @empty
        <div class="text-center text-gray-400 py-20">
            Nenhuma notificação no momento.
        </div>
    @endforelse

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const snapshot = {
            notificationsCount: Number(@json($notificationsCount ?? 0)),
            notificationsLatestTs: Number(@json($notificationsLatestTs ?? 0)),
        };

        const pollIfChanged = async () => {
            if (document.hidden) return;

            try {
                const response = await fetch('{{ route('student.realtime.summary') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) return;

                const data = await response.json();
                const changed = Number(data.notifications_count || 0) !== snapshot.notificationsCount
                    || Number(data.notifications_latest_ts || 0) !== snapshot.notificationsLatestTs;

                if (changed) {
                    window.location.reload();
                }
            } catch (error) {
                console.warn('Falha ao sincronizar notificações do aluno.', error);
            }
        };

        setInterval(pollIfChanged, 6000);
    });
</script>

@endsection
