<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterCompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'cnpj' => preg_replace('/\D/', '', (string) $request->cnpj),
            'phone' => preg_replace('/\D/', '', (string) $request->phone),
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'cnpj'        => 'required|digits:14',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|digits_between:10,11',
            'password'    => 'required|string|min:6|max:255',
            'description' => 'required|string|max:1000',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 👈 NOVO
        ]);

        $photoPath = null;

if ($request->hasFile('photo')) {
    $photoPath = $request->file('photo')
        ->store('profiles', 'public');
}



        // cria usuário
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'company',
            'photo'    => $photoPath, // 👈 AQUI
        ]);

        // cria empresa
        Company::create([
            'user_id'     => $user->id,
            'cnpj'        => $request->cnpj,
            'phone'       => $request->phone,
            'description' => $request->description,
        ]);

        // login automático
        Auth::login($user);

        return redirect()->route('company.dashboard');
    }
}
