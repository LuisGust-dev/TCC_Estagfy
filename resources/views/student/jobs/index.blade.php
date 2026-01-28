@extends('student.layout')

@section('title', 'Vagas de Estágio')

@section('content')

{{-- HEADER --}}
<h1 class="text-2xl font-bold mb-1">Vagas de Estágio</h1>
<p class="text-gray-500 mb-8">
    Encontre a oportunidade perfeita para sua carreira
</p>

{{-- BUSCA + FILTROS (VISUAL) --}}
<div class="bg-white border rounded-xl p-4 mb-8">
    <div class="flex flex-wrap gap-3 items-center">

        {{-- BUSCA --}}
        <div class="flex items-center gap-2 flex-1 border rounded-lg px-3 py-2">
            🔍
            <input
                type="text"
                placeholder="Buscar por cargo ou empresa..."
                class="w-full focus:outline-none text-sm"
            >
        </div>

        {{-- FILTROS (visual apenas) --}}
        <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            ⚙️ Todas
        </button>

        <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100">
            Tecnologia
        </button>

        <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100">
            Marketing
        </button>

        <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100">
            Finanças
        </button>

        <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100">
            Design
        </button>

    </div>
</div>

{{-- LISTA DE VAGAS --}}
<div class="space-y-6">

@forelse($jobs as $job)

    <div class="bg-white border rounded-xl p-6 flex justify-between gap-6 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-100 hover:border-blue-200 hover:ring-1 hover:ring-blue-200">

        {{-- ESQUERDA --}}
        <div class="flex gap-4">

            {{-- LOGO DA EMPRESA --}}
            @if($job->company->user->photo)
                <img src="{{ asset('storage/'.$job->company->user->photo) }}"
                     class="w-14 h-14 rounded-lg object-cover">
            @else
                <div class="w-14 h-14 rounded-lg bg-gray-200
                            flex items-center justify-center font-bold text-gray-500">
                    {{ strtoupper(substr($job->company->user->name, 0, 1)) }}
                </div>
            @endif

            <div class="max-w-2xl">

                {{-- TÍTULO --}}
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ $job->title }}
                </h2>

                {{-- EMPRESA --}}
                <p class="text-sm text-gray-500">
                    {{ $job->company->user->name }}
                </p>

                {{-- DESCRIÇÃO --}}
                <p class="text-sm text-gray-600 mt-2">
                    {{ Str::limit($job->description, 160) }}
                </p>

                {{-- INFO --}}
                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mt-3">
                    <span>📍 {{ $job->location }}</span>
                    <span>💰 R$ {{ number_format($job->salary, 2, ',', '.') }}</span>
                    <span>👥 {{ $job->applications_count }} candidatos</span>
                </div>

                {{-- REQUISITOS --}}
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($job->requirements ?? [] as $requirement)
                        <span class="px-3 py-1 text-xs rounded-full
                                     bg-emerald-600 text-white">
                            {{ $requirement }}
                        </span>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- DIREITA --}}
        <div class="flex flex-col items-end gap-4">

            {{-- TIPO --}}
            <span
                class="px-3 py-1 rounded-full text-xs font-medium
                @if($job->type === 'Remoto')
                    bg-green-100 text-green-700
                @elseif($job->type === 'Presencial')
                    bg-blue-100 text-blue-700
                @else
                    bg-purple-100 text-purple-700
                @endif">
                {{ $job->type }}
            </span>

            {{-- BOTÃO --}}
            <form method="POST" action="{{ route('student.jobs.apply', $job) }}">
                @csrf
                <button
                    class="bg-blue-600 hover:bg-blue-700
                           text-white px-6 py-2 rounded-lg text-sm font-medium">
                    Inscrever-se
                </button>
            </form>

        </div>

    </div>

@empty
    <div class="text-center py-24 text-gray-400">
        <p class="text-lg">Nenhuma vaga disponível no momento.</p>
    </div>
@endforelse

</div>

@endsection
