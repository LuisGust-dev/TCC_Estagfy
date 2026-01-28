<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'cnpj' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $userData['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($userData);

        $company->update([
            'cnpj' => $request->cnpj,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('company.profile.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}
