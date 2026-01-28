@extends('company.layout')

@section('title', 'Chat')

@section('content')

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden h-[700px] flex flex-col">

    {{-- Header --}}
    <div class="p-4 border-b bg-white">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $student->name }}</p>
                <p class="text-xs text-gray-500">{{ $job->title }}</p>
            </div>
        </div>
    </div>

    {{-- Mensagens --}}
    <div class="flex-1 overflow-y-auto space-y-3 p-6 bg-gray-50">

        @forelse($messages as $message)

            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] px-4 py-2 rounded-2xl text-sm leading-relaxed shadow-sm
                    {{ $message->sender_id === auth()->id()
                        ? 'bg-emerald-600 text-white rounded-br-md'
                        : 'bg-white text-gray-800 rounded-bl-md' }}">

                    {{ $message->message }}

                    <div class="text-[11px] opacity-70 mt-1 text-right">
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
    <form method="POST"
          action="{{ route('company.chat.send', [$job, $student]) }}"
          class="p-4 border-t bg-white flex gap-2">
        @csrf

        <input
            name="message"
            required
            placeholder="Digite sua mensagem..."
            class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">

        <button class="bg-emerald-600 text-white px-6 rounded-full hover:bg-emerald-700 transition">
            Enviar
        </button>
    </form>

</div>

@endsection
