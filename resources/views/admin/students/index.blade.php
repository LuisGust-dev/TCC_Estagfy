@extends('admin.layout')

@section('title', 'Alunos | Admin EstagFy')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Alunos</h1>
        <p class="text-gray-600">Gestão dos alunos cadastrados</p>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-visible">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Aluno</th>
                        <th class="text-left px-6 py-3 font-semibold">Curso</th>
                        <th class="text-left px-6 py-3 font-semibold">Período</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Currículo</th>
                        <th class="text-left px-6 py-3 font-semibold">Candidaturas</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-right px-6 py-3 font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $student->student?->course ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $student->student?->period ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $student->email }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($student->student?->resume)
                                    <a class="text-blue-600 hover:underline" href="{{ asset('storage/' . $student->student->resume) }}">
                                        Ver currículo
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $student->applications_count }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $student->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $student->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <details class="relative inline-block text-left">
                                    <summary class="list-none cursor-pointer px-4 py-2 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-200">
                                            <span class="inline-flex items-center gap-1">Ações
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                                            </span>
                                        </summary>
                                    <div class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-gray-200 bg-white p-1 shadow-lg">
                                        <a href="{{ route('admin.users.edit', ['user' => $student, 'redirect_to' => request()->fullUrl()]) }}"
                                           class="block rounded-md px-3 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.toggle', $student) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <button type="submit"
                                                    class="block w-full rounded-md px-3 py-2 text-left text-sm {{ $student->active ? 'text-amber-700' : 'text-emerald-700' }} hover:bg-gray-100">
                                                {{ $student->active ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $student) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <button type="submit"
                                                    class="block w-full rounded-md px-3 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                                Nenhum aluno encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>
@endsection
