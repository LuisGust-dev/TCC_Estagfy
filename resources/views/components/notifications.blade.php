@php
    $user = auth()->user();
    $unread = $user?->unreadNotifications ?? collect();
@endphp

@if($user && $unread->count())
    <div class="mb-6">
        <div class="bg-white border rounded-xl p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">🔔 Notificações</h2>

                <span class="text-xs bg-red-600 text-white px-2 py-1 rounded-full">
                    {{ $unread->count() }} novas
                </span>
            </div>

            <div class="space-y-3">
                @foreach($unread as $n)
                    <div class="border rounded-lg p-3 bg-blue-50">
                        <p class="font-medium text-sm">
                            {{ $n->data['message'] ?? 'Notificação' }}
                        </p>

                        @if(!empty($n->data['job_title']))
                            <p class="text-xs text-gray-600 mt-1">
                                Vaga: {{ $n->data['job_title'] }}
                            </p>
                        @endif

                        @if(!empty($n->data['student_name']))
                            <p class="text-xs text-gray-600">
                                Aluno: {{ $n->data['student_name'] }}
                            </p>
                        @endif

                        <p class="text-xs text-gray-400 mt-1">
                            {{ $n->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
