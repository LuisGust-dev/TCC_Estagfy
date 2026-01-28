<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('user')
            ->withCount('jobs')
            ->withCount('applications')
            ->latest('id')
            ->paginate(20);

        return view('admin.companies.index', compact('companies'));
    }
}
