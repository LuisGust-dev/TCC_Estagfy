@extends('company.layout')

@section('title', 'Minhas Vagas')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Minhas Vagas</h1>
        <p class="text-gray-500">Gerencie suas vagas e candidatos</p>
    </div>

    <a href="{{ route('company.jobs.create') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700
              text-white px-5 py-2 rounded-lg text-sm font-medium shadow">
        <span class="text-lg">＋</span> Nova Vaga
    </a>
</div>

{{-- LISTA --}}
<div class="space-y-6">

@forelse($jobs as $job)
    <a href="{{ route('company.jobs.candidates', $job) }}"
       class="group block bg-white border border-gray-200 rounded-xl px-6 py-5 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">

        <div class="flex justify-between gap-6">

            {{-- ESQUERDA --}}
            <div class="flex-1">

                {{-- TÍTULO --}}
                <h2 class="text-base font-semibold text-gray-900 mb-1">
                    {{ $job->title }}
                </h2>

                {{-- LOCAL + TIPO --}}
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <span class="flex items-center gap-1">
                        📍 {{ $job->location ?? 'Local não informado' }}
                    </span>

                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-medium
                        @if($job->type === 'Remoto')
                            bg-emerald-100 text-emerald-700
                        @elseif($job->type === 'Presencial')
                            bg-blue-100 text-blue-700
                        @else
                            bg-purple-100 text-purple-700
                        @endif
                        ">
                        {{ $job->type ?? 'Híbrido' }}
                    </span>
                </div>

                {{-- DESCRIÇÃO --}}
                <p class="text-sm text-gray-600 mb-3 leading-relaxed">
                    {{ Str::limit($job->description, 160) }}
                </p>

                {{-- REQUISITOS --}}
                <div class="flex flex-wrap gap-2">
                    @foreach($job->requirements ?? [] as $requirement)
                        <span
                            class="px-3 py-1 text-xs rounded-full
                                   bg-gray-100 text-gray-700">
                            {{ $requirement }}
                        </span>
                    @endforeach
                </div>

            </div>

            {{-- DIREITA --}}
            <div class="flex flex-col items-end justify-between">

                {{-- CANDIDATOS --}}
                <span
                    class="inline-flex items-center gap-2
                           bg-blue-50 text-blue-600
                           px-4 py-2 rounded-full text-sm font-medium mb-4">
                    👤 {{ $job->applications_count }} candidatos
                </span>

                {{-- AÇÕES --}}
                <form method="POST"
                      action="{{ route('company.jobs.destroy', $job) }}"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?')"
                      onclick="event.stopPropagation();">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="flex items-center justify-center
                               w-10 h-10 rounded-lg
                               border border-red-200
                               text-red-500
                               hover:bg-red-50 transition">
                        🗑
                    </button>
                </form>

            </div>

        </div>

    </a>
@empty
    <div class="text-center py-24 text-gray-400">
        <p class="text-lg font-medium">Nenhuma vaga cadastrada</p>
        <p class="text-sm mt-1">
            Clique em <strong>Nova Vaga</strong> para começar
        </p>
    </div>
@endforelse

</div>

@endsection
