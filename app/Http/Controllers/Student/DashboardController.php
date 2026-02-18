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
        $studentCourse = $student->student?->course;

        return view('student.dashboard', [
            'totalJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
                ->when(!empty($studentCourse), fn ($query) => $query->where('area', $studentCourse), fn ($query) => $query->whereRaw('1 = 0'))
                ->count(),
            'recentJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
                ->when(!empty($studentCourse), fn ($query) => $query->where('area', $studentCourse), fn ($query) => $query->whereRaw('1 = 0'))
                ->latest()
                ->take(5)
                ->get(),
            'applicationsCount' => 0, // depois ligamos com applications
        ]);
    }
}
