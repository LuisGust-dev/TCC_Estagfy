<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $companiesQuery = Company::with('user')
            ->withCount('jobs')
            ->withCount('applications');

        if ($search !== '') {
            $companiesQuery->where(function ($query) use ($search) {
                $query->where('cnpj', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $companies = $companiesQuery
            ->latest('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.companies.index', compact('companies', 'search'));
    }
}
