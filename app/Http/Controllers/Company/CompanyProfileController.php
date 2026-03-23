<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $company = Auth::user()->company;

        return view('company.profile', compact('company'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $request->merge([
            'name' => preg_replace('/[^\pL\s]/u', '', (string) $request->name),
            'cnpj' => preg_replace('/\D/', '', (string) $request->cnpj),
            'phone' => preg_replace('/\D/', '', (string) $request->phone),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'cnpj' => 'nullable|digits:14',
            'phone' => 'nullable|digits_between:10,11',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.regex' => 'O nome da empresa deve conter apenas letras e espaços.',
            'cnpj.digits' => 'O CNPJ deve conter exatamente 14 dígitos numéricos.',
            'phone.digits_between' => 'O telefone deve conter entre 10 e 11 dígitos numéricos.',
            'current_password.current_password' => 'A senha atual está incorreta.',
            'current_password.required_with' => 'Informe a senha atual para definir uma nova senha.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
            'password.min' => 'A nova senha deve ter no mínimo :min caracteres.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            $oldPhoto = $user->photo;
            $newPhoto = $request->file('photo')->store('profiles', 'public');
            $userData['photo'] = $newPhoto;

            if (!empty($oldPhoto) && $oldPhoto !== $newPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $user->update($userData);

        $company->update([
            'cnpj' => $validated['cnpj'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('company.profile.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}
