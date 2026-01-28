<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $company = Auth::user()->company;

        return view('company.profile', compact('company'));
    }

    public function update(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
        ]);

        $company->update([
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('company.profile.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}
