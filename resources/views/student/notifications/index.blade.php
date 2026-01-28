@extends('student.layout')

@section('title', 'Notificações')

@section('content')

<h1 class="text-2xl font-bold mb-1">Notificações</h1>
<p class="text-gray-500 mb-8">
    Acompanhe atualizações sobre suas candidaturas
</p>

<div class="space-y-4">

    @forelse(auth()->user()->notifications as $notification)

        <div class="bg-white border rounded-xl p-5 flex justify-between items-start
            {{ is_null($notification->read_at) ? 'border-blue-500 bg-blue-50' : '' }}">

            <div>
                <p class="font-medium text-gray-800">
                    {{ $notification->data['message'] }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Vaga: {{ $notification->data['job_title'] ?? '-' }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    {{ $notification->created_at->diffForHumans() }}
                </p>
            </div>

            @if(is_null($notification->read_at))
                <form method="POST" action="{{ route('student.notifications.markAsRead', $notification->id) }}">
                    @csrf
                    <button class="text-sm text-blue-600 hover:underline">
                        Marcar como lida
                    </button>
                </form>
            @endif
        </div>

    @empty
        <div class="text-center text-gray-400 py-20">
            Nenhuma notificação no momento.
        </div>
    @endforelse

</div>

@endsection
