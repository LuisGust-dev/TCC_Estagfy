@extends('student.layout')

@section('title', 'Notificações')

@section('content')

<h1 class="text-2xl font-bold mb-1">Notificações</h1>
<p class="text-gray-500 mb-8">
    Acompanhe atualizações sobre suas candidaturas
</p>

<div class="space-y-4">

    @forelse(auth()->user()->notifications as $notification)

        <form method="POST" action="{{ route('student.notifications.readAndGo', $notification->id) }}">
            @csrf
            <button type="submit"
                    class="w-full text-left bg-white border rounded-2xl p-6 flex items-start justify-between gap-4 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:border-blue-200">
                <div class="flex items-start gap-4">
                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                        🔔
                    </div>

                    <div>
                        <p class="font-medium {{ is_null($notification->read_at) ? 'text-blue-700' : 'text-gray-700' }}">
                            {{ $notification->data['message'] }}
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

@endsection
