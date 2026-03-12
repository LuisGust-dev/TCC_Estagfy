@extends('company.layout')

@section('title', 'Perfil da Empresa')

@section('content')
@php($hideSuccess = true)
<div class="max-w-6xl mx-auto space-y-6">

    <section class="rounded-3xl border bg-gradient-to-r from-emerald-600 via-emerald-500 to-cyan-500 p-8 text-white shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="h-20 w-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center overflow-hidden">
                @if(auth()->user()->photo_url)
                    <img src="{{ auth()->user()->photo_url }}"
                         alt="Foto da empresa"
                         class="h-full w-full object-cover">
                @else
                    <span class="text-2xl font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                @endif
            </div>
            <div class="min-w-0">
                <h1 class="text-2xl font-bold truncate">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-emerald-100 truncate">{{ auth()->user()->email }}</p>
                <p class="text-xs uppercase tracking-widest mt-2 text-emerald-100/90">Perfil da Empresa</p>
            </div>
        </div>
    </section>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('company.profile.update') }}"
          enctype="multipart/form-data"
          class="rounded-3xl border bg-white p-6 md:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h2 class="text-lg font-semibold text-gray-900">Informações da empresa</h2>
            <p class="text-sm text-gray-500">Mantenha os dados institucionais e contato sempre atualizados.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">Nome da empresa</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">E-mail</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Telefone</label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone', $company->phone) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">CNPJ</label>
                <input type="text"
                       name="cnpj"
                       value="{{ old('cnpj', $company->cnpj) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto de perfil da empresa</label>

                <div class="rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/40 p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="h-16 w-16 rounded-xl bg-white border overflow-hidden flex items-center justify-center">
                            @if(auth()->user()->photo_url)
                                <img src="{{ auth()->user()->photo_url }}"
                                     alt="Foto atual"
                                     class="h-full w-full object-cover">
                            @else
                                <span class="text-xl font-semibold text-emerald-600">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-2">Envie uma imagem JPG ou PNG (máx. 2MB).</p>
                            <input type="file"
                                   name="photo"
                                   accept="image/png,image/jpeg"
                                   class="w-full text-sm text-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2 border-t">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Descrição da empresa</h3>
            <p class="text-sm text-gray-500 mb-4">Apresente sua empresa para os estudantes.</p>

            <textarea name="description" rows="4"
                      class="w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $company->description) }}</textarea>
        </div>

        <div class="pt-2 border-t">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Segurança</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-sm font-medium text-gray-700">Nova senha</label>
                    <input type="password"
                           name="password"
                           placeholder="Deixe em branco para manter a atual"
                           class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Confirmar nova senha</label>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Repita a nova senha"
                           class="mt-1 w-full rounded-xl border-gray-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-emerald-700">
                Salvar alterações
            </button>
        </div>
    </form>
</div>
@endsection
