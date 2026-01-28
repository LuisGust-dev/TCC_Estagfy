@extends('admin.layout')

@section('title', 'Alunos | Admin EstagFy')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Alunos</h1>
        <p class="text-gray-600">Gestao dos alunos cadastrados</p>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Aluno</th>
                        <th class="text-left px-6 py-3 font-semibold">Curso</th>
                        <th class="text-left px-6 py-3 font-semibold">Periodo</th>
                        <th class="text-left px-6 py-3 font-semibold">E-mail</th>
                        <th class="text-left px-6 py-3 font-semibold">Curriculo</th>
                        <th class="text-left px-6 py-3 font-semibold">Candidaturas</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-right px-6 py-3 font-semibold">Acoes</th>
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
                                        Ver curriculo
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
                                <form method="POST" action="{{ route('admin.users.toggle', $student) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-sm font-medium {{ $student->active ? 'text-red-600 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                        {{ $student->active ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
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
