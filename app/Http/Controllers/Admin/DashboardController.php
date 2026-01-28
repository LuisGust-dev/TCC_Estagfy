<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalCompanies = User::where('role', 'company')->count();
        $totalJobs = Job::count();
        $totalApplications = Application::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalCompanies',
            'totalJobs',
            'totalApplications'
        ));
    }
}
