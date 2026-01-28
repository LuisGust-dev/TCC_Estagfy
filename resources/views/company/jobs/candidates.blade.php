@extends('company.layout')

@section('title', 'Candidatos')

@section('content')
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold">Candidatos</h1>
        @if($job)
            <p class="text-gray-500">Vaga: {{ $job->title }}</p>
        @else
            <p class="text-gray-500">Todas as vagas</p>
        @endif
    </div>

    @if(!$job)
        <div class="flex items-center gap-2 text-sm">
            <a href="{{ route('company.candidates.index') }}"
               class="px-3 py-1 rounded-full border {{ empty($status) ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                Todos
            </a>
            <a href="{{ route('company.candidates.index', ['status' => 'aprovado']) }}"
               class="px-3 py-1 rounded-full border {{ $status === 'aprovado' ? 'bg-green-600 text-white border-green-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Contratados
            </a>
            <a href="{{ route('company.candidates.index', ['status' => 'em_analise']) }}"
               class="px-3 py-1 rounded-full border {{ $status === 'em_analise' ? 'bg-yellow-500 text-white border-yellow-500' : 'text-gray-600 hover:bg-gray-50' }}">
                Em análise
            </a>
            <a href="{{ route('company.candidates.index', ['status' => 'recusado']) }}"
               class="px-3 py-1 rounded-full border {{ $status === 'recusado' ? 'bg-red-600 text-white border-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Recusados
            </a>
        </div>
    @endif
</div>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                @if(!$job)
                    <th class="text-left px-6 py-3">Vaga</th>
                @endif
                <th class="text-left px-6 py-3">Aluno</th>
                <th class="text-left px-6 py-3">Curso</th>
                <th class="text-left px-6 py-3">Semestre</th>
                <th class="text-left px-6 py-3">Status</th>
                <th class="text-left px-6 py-3">Currículo</th>
                <th class="text-right px-6 py-3">Ações</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($applications as $application)
            <tr>
                @if(!$job)
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $application->job->title ?? 'Vaga não informada' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $application->job->location ?? 'Local não informado' }}
                        </div>
                    </td>
                @endif
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">
                        {{ $application->student->name }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $application->student->email }}
                    </div>
                </td>

                <td class="px-6 py-4">
                    {{ optional($application->student->student)->course ?? 'Não informado' }}
                </td>

                <td class="px-6 py-4">
                    {{ optional($application->student->student)->period ?? 'Não informado' }}
                </td>

                <td class="px-6 py-4">
                    @if ($application->status === 'em_analise')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                            Em análise
                        </span>
                    @elseif ($application->status === 'aprovado')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Aprovado
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                            Recusado
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    @if ($application->resume)
                        <a href="{{ asset('storage/' . $application->resume) }}"
                           class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-xs font-medium transition hover:bg-blue-100">
                            📄 Ver
                        </a>
                    @else
                        <span class="text-xs text-gray-400">Não enviado</span>
                    @endif
                </td>

                <td class="px-6 py-4 text-right space-x-2">
                    @if ($application->status === 'aprovado')
                        <a href="{{ route('company.chat.show', [$application->job_id, $application->student_id]) }}"
                            class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 text-xs font-medium transition hover:bg-blue-100">
                            <span class="text-sm">💬</span>
                            Chat
                        </a>
                    @endif

                    @if ($application->status === 'em_analise')
                        <form action="{{ route('company.applications.approve', $application) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button class="px-3 py-1 bg-green-500 text-white rounded text-xs">
                                Aprovar
                            </button>
                        </form>

                        <form action="{{ route('company.applications.reject', $application) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button class="px-3 py-1 bg-red-500 text-white rounded text-xs">
                                Recusar
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $job ? 6 : 7 }}" class="text-center py-6 text-gray-500">
                    Nenhum candidato ainda.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
