<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobBrowseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->trim();

        $jobs = Job::withCount('applications')
            ->whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('company.user', function ($q2) use ($search) {
                            $q2->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->get();

        return view('student.jobs.index', compact('jobs', 'search'));
    }

    public function apply(Job $job)
    {
        Application::firstOrCreate([
            'job_id' => $job->id,
            'student_id' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Parabéns! Você se candidatou a essa vaga. Fique no aguardo.'
        );
    }




public function show(Job $job)
{
    if (! $job->company || ! $job->company->user || ! $job->company->user->active) {
        abort(404);
    }

    $student = Auth::user();

    // verifica se o aluno já se candidatou
    $application = Application::where('job_id', $job->id)
        ->where('student_id', $student->id)
        ->first();

    return view('student.jobs.show', compact('job', 'application'));
}

}
