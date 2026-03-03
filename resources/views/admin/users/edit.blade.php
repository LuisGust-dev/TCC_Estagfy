@extends('admin.layout')

@section('title', 'Editar Usuário | Admin EstagFy')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar usuário</h1>
                <p class="text-gray-600">Atualize dados e permissões da conta</p>
            </div>
            <a href="{{ $redirectTo ?? route('admin.users.index') }}"
               class="px-4 py-2 rounded-lg border text-sm font-medium text-gray-700 hover:bg-gray-100">
                Voltar
            </a>
        </div>

        <div class="bg-white rounded-2xl border p-6 shadow-sm">
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PATCH')
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

                <div>
                    <label class="text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Perfil</label>
                        <select id="user-role" name="role" class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach(['student' => 'Aluno', 'company' => 'Empresa', 'admin' => 'Admin', 'coordinator' => 'Coordenador'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Status</label>
                        <select name="active" class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="1" @selected((string) old('active', $user->active ? '1' : '0') === '1')>Ativo</option>
                            <option value="0" @selected((string) old('active', $user->active ? '1' : '0') === '0')>Inativo</option>
                        </select>
                    </div>
                </div>

                <div id="student-fields" data-role-target="student" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">CPF</label>
                        <input type="text" name="cpf" value="{{ old('cpf', optional($user->student)->cpf) }}"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Somente números">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Curso</label>
                        <input type="text" name="course" value="{{ old('course', optional($user->student)->course) }}"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Período</label>
                        <input type="text" name="period" value="{{ old('period', optional($user->student)->period) }}"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div id="company-fields" data-role-target="company" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">CNPJ</label>
                        <input type="text" name="cnpj" value="{{ old('cnpj', optional($user->company)->cnpj) }}"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Somente números">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Telefone</label>
                        <input type="text" name="phone" value="{{ old('phone', optional($user->company)->phone) }}"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Somente números">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Descrição</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', optional($user->company)->description) }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nova senha (opcional)</label>
                        <input type="password" name="password"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Mínimo 8 caracteres">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Confirmar nova senha</label>
                        <input type="password" name="password_confirmation"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                        Salvar alterações
                    </button>
                    <a href="{{ $redirectTo ?? route('admin.users.index') }}"
                       class="px-4 py-2 rounded-lg border text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleSelect = document.getElementById('user-role');
            const roleSections = document.querySelectorAll('[data-role-target]');

            if (!roleSelect) return;

            const updateVisibility = () => {
                const selectedRole = roleSelect.value;

                roleSections.forEach((section) => {
                    const target = section.getAttribute('data-role-target');
                    const shouldShow = selectedRole === target;

                    section.style.display = shouldShow ? '' : 'none';
                    section.querySelectorAll('input, textarea, select').forEach((field) => {
                        field.disabled = !shouldShow;
                    });
                });
            };

            updateVisibility();
            roleSelect.addEventListener('change', updateVisibility);
        });
    </script>
@endsection
