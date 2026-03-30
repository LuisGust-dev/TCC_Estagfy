<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Support\ProfilePhotoStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class RegisterCompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'name' => preg_replace('/[^\pL\s]/u', '', (string) $request->name),
            'cnpj' => preg_replace('/\D/', '', (string) $request->cnpj),
            'phone' => preg_replace('/\D/', '', (string) $request->phone),
        ]);

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:users,name', 'regex:/^[\pL\s]+$/u'],
                'cnpj' => 'required|digits:14|unique:companies,cnpj',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|digits_between:10,11',
                'password' => 'required|string|min:8|max:255',
                'description' => 'required|string|max:1000',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'name.required' => 'O nome da empresa e obrigatorio.',
                'name.max' => 'O nome da empresa deve ter no maximo :max caracteres.',
                'name.unique' => 'Este nome de empresa ja esta cadastrado.',
                'name.regex' => 'O nome da empresa deve conter apenas letras e espaços.',
                'cnpj.required' => 'O CNPJ e obrigatorio.',
                'cnpj.digits' => 'O CNPJ deve conter exatamente :digits digitos numericos.',
                'cnpj.unique' => 'Este CNPJ ja esta cadastrado.',
                'email.required' => 'O e-mail corporativo e obrigatorio.',
                'email.email' => 'Informe um e-mail valido.',
                'email.unique' => 'Este e-mail ja esta cadastrado.',
                'phone.required' => 'O telefone e obrigatorio.',
                'phone.digits_between' => 'O telefone deve conter entre :min e :max digitos.',
                'password.required' => 'A senha e obrigatoria.',
                'password.min' => 'A senha deve ter no minimo :min caracteres.',
                'password.max' => 'A senha deve ter no maximo :max caracteres.',
                'description.required' => 'A descricao da empresa e obrigatoria.',
                'description.max' => 'A descricao deve ter no maximo :max caracteres.',
                'photo.image' => 'O arquivo da logo/foto deve ser uma imagem.',
                'photo.mimes' => 'A logo/foto deve estar no formato: jpg, jpeg ou png.',
                'photo.max' => 'A logo/foto deve ter no maximo 2MB.',
            ]
        );

        $photoPath = null;

        if ($request->hasFile('photo')) {
            try {
                $photoPath = ProfilePhotoStorage::store($request->file('photo'));
            } catch (RuntimeException $exception) {
                return back()
                    ->withInput($request->except(['password', 'photo']))
                    ->with('error', 'Não foi possível enviar a foto de perfil no momento. Tente novamente.');
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company',
            'photo' => $photoPath,
        ]);

        Company::create([
            'user_id' => $user->id,
            'cnpj' => $request->cnpj,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        Auth::login($user);

        return redirect()->route('company.dashboard');
    }
}
