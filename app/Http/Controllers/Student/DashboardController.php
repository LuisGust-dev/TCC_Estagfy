<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        return view('student.dashboard', [
            'totalJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })->count(),
            'recentJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })->latest()->take(5)->get(),
            'applicationsCount' => 0, // depois ligamos com applications
        ]);
    }
}
