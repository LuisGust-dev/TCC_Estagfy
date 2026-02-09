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
            <div
                id="company-chat-messages"
                data-last-id="{{ $messages->last()->id ?? 0 }}"
                data-current-user-id="{{ auth()->id() }}"
                class="flex-1 overflow-y-auto p-6 space-y-3"
            >

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

@if($student)
    <script>
        // --- Configuração básica do polling (empresa) ---
        const companyChatMessages = document.getElementById('company-chat-messages');
        const currentCompanyUserId = Number(companyChatMessages?.dataset.currentUserId || 0);
        let companyLastId = Number(companyChatMessages?.dataset.lastId || 0);

        // --- Utilitário: cria o balão de mensagem ---
        function createCompanyMessageBubble(message) {
            const isMe = message.sender_id === currentCompanyUserId;

            const wrapper = document.createElement('div');
            wrapper.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;

            const bubble = document.createElement('div');
            bubble.className = [
                'max-w-[75%] px-4 py-2 rounded-2xl text-sm leading-relaxed shadow-sm',
                isMe ? 'bg-emerald-600 text-white rounded-br-md' : 'bg-white text-gray-800 rounded-bl-md'
            ].join(' ');

            // Texto da mensagem (seguro contra HTML)
            const text = document.createElement('div');
            text.textContent = message.message;

            // Horário da mensagem
            const time = document.createElement('div');
            time.className = 'text-[11px] opacity-70 mt-1 text-right';
            time.textContent = message.time;

            bubble.appendChild(text);
            bubble.appendChild(time);
            wrapper.appendChild(bubble);

            return wrapper;
        }

        // --- Polling: busca novas mensagens e adiciona no final ---
        async function pollCompanyMessages() {
            try {
                const response = await fetch(
                    `{{ route('company.chat.poll', [$job->id, $student->id]) }}?last_id=${companyLastId}`,
                    { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                );

                if (!response.ok) return;

                const data = await response.json();
                if (!data.messages || data.messages.length === 0) return;

                data.messages.forEach((msg) => {
                    companyChatMessages.appendChild(createCompanyMessageBubble(msg));
                    companyLastId = Math.max(companyLastId, msg.id);
                });

                // Mantém o scroll no final
                companyChatMessages.scrollTop = companyChatMessages.scrollHeight;
            } catch (error) {
                // Silencioso para não quebrar a tela caso o fetch falhe
                console.warn('Falha no polling do chat (empresa).', error);
            }
        }

        // --- Dispara o polling a cada 4 segundos ---
        setInterval(pollCompanyMessages, 2000);
    </script>
@endif

@endsection
