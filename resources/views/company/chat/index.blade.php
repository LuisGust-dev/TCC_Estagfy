@extends('company.layout')

@section('title', 'Chat')

@section('content')

<div class="flex flex-col md:flex-row h-[700px] bg-white border rounded-2xl overflow-hidden shadow-sm">

    {{-- 🟢 LISTA DE CONVERSAS --}}
    <div class="w-full md:w-1/3 border-r bg-gray-50 overflow-y-auto">

        <div class="p-4 border-b">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Conversas</p>
            <h2 class="text-lg font-semibold text-gray-800">Mensagens</h2>
        </div>

        @forelse($conversations as $key => $group)
            @php
                $lastMessage = $group->first();
                $studentItem = $lastMessage->student;
                $jobItem = $lastMessage->job;
            @endphp

            <a href="{{ route('company.chat.show', [$jobItem->id, $studentItem->id]) }}"
               class="flex items-center gap-3 px-4 py-3 border-b hover:bg-gray-100 transition
               {{ optional($student)->id === $studentItem->id ? 'bg-white' : '' }}">
                <div class="h-10 w-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr($studentItem->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-sm text-gray-800 truncate">
                        {{ $studentItem->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ $jobItem->title }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">
                        {{ $lastMessage->message }}
                    </p>
                </div>
                <span class="text-[11px] text-gray-400">
                    {{ $lastMessage->created_at->format('H:i') }}
                </span>
            </a>
        @empty
            <p class="p-4 text-sm text-gray-400">
                Nenhuma conversa
            </p>
        @endforelse

    </div>

    {{-- 🔵 CHAT --}}
    <div class="flex-1 flex flex-col bg-gray-50">

        @if($student)

            {{-- HEADER --}}
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

            {{-- MENSAGENS --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-3">

                @foreach($messages as $message)
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
                @endforeach

            </div>

            {{-- INPUT --}}
            <form method="POST"
                  action="{{ route('company.chat.send', [$job->id, $student->id]) }}"
                  class="p-4 border-t bg-white flex gap-2">
                @csrf

                <input name="message"
                       required
                       placeholder="Digite sua mensagem..."
                       class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">

                <button class="bg-emerald-600 text-white px-6 rounded-full hover:bg-emerald-700 transition">
                    Enviar
                </button>
            </form>

        @else
            <div class="flex-1 flex items-center justify-center text-gray-400">
                Selecione uma conversa à esquerda
            </div>
        @endif

    </div>
</div>

@endsection
