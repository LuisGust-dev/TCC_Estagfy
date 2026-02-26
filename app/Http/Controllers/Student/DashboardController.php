<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $studentCourse = $student->student?->course;
        $studentId = $student->id;

        $hasApprovedApplication = Application::where('student_id', $studentId)
            ->where('status', 'aprovado')
            ->exists();

        $hasPendingApplication = Application::where('student_id', $studentId)
            ->where('status', 'em_analise')
            ->exists();

        $applicationStatus = $hasApprovedApplication
            ? 'aprovado'
            : ($hasPendingApplication ? 'em_analise' : 'sem_candidatura');

        return view('student.dashboard', [
            'totalJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
                ->openForApplications()
                ->when(!empty($studentCourse), fn ($query) => $query->where('area', $studentCourse), fn ($query) => $query->whereRaw('1 = 0'))
                ->count(),
            'recentJobs' => Job::whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
                ->openForApplications()
                ->when(!empty($studentCourse), fn ($query) => $query->where('area', $studentCourse), fn ($query) => $query->whereRaw('1 = 0'))
                ->latest()
                ->take(5)
                ->get(),
            'applicationsCount' => Application::where('student_id', $studentId)->count(),
            'applicationStatus' => $applicationStatus,
        ]);
    }
}
