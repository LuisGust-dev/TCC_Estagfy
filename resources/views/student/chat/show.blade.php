@extends('student.layout')

@section('title', 'Chat')

@section('content')

<h1 class="text-xl font-bold mb-4">
    💬 Chat — {{ $job->title }}
</h1>

<div class="bg-white border rounded-xl p-4 h-[500px] flex flex-col">

    {{-- Mensagens --}}
    <div class="flex-1 overflow-y-auto space-y-3 mb-4">

        @forelse($messages as $message)

            <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">
                <div class="inline-block px-4 py-2 rounded-lg max-w-[70%]
                    {{ $message->sender_id === auth()->id()
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-100 text-gray-800' }}">

                    {{ $message->message }}

                    <div class="text-xs opacity-70 mt-1">
                        {{ $message->created_at->format('H:i') }}
                    </div>
                </div>
            </div>

        @empty
            <p class="text-gray-400 text-center mt-20">
                Nenhuma mensagem ainda.
            </p>
        @endforelse

    </div>

    {{-- Enviar mensagem --}}
    <form method="POST" action="{{ route('student.chat.send', $job) }}"
          class="flex gap-2">
        @csrf

        <input
            name="message"
            required
            placeholder="Digite sua mensagem..."
            class="flex-1 border rounded-lg px-4 py-2">

        <button class="bg-blue-600 text-white px-6 rounded-lg">
            Enviar
        </button>
    </form>

</div>

@endsection
