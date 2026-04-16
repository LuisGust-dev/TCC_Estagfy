<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobBrowseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->trim();
        $keyword = $request->string('keyword')->trim();
        if ($keyword->isEmpty()) {
            // Compatibilidade com URLs antigas que usavam "language".
            $keyword = $request->string('language')->trim();
        }
        $minVacancies = $request->integer('vacancies_min');
        $salaryMin = $request->input('salary_min');
        $salaryMax = $request->input('salary_max');
        $studentCourse = Auth::user()->student?->course;

        $jobs = Job::withCount('applications')
            ->whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
            ->openForApplications()
            ->when(empty($studentCourse), function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('company.user', function ($q2) use ($search) {
                            $q2->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($minVacancies > 0, function ($query) use ($minVacancies) {
                $query->where('vacancies', '>=', $minVacancies);
            })
            ->when($keyword->isNotEmpty(), function ($query) use ($keyword) {
                $term = mb_strtolower((string) $keyword);
                $query->where(function ($q) use ($term) {
                    $q->whereRaw('LOWER(title) like ?', ['%' . $term . '%'])
                        ->orWhereRaw('LOWER(description) like ?', ['%' . $term . '%'])
                        ->orWhereRaw('LOWER(requirements) like ?', ['%' . $term . '%']);
                });
            })
            ->when(is_numeric($salaryMin), function ($query) use ($salaryMin) {
                $query->where('salary', '>=', (float) $salaryMin);
            })
            ->when(is_numeric($salaryMax), function ($query) use ($salaryMax) {
                $query->where('salary', '<=', (float) $salaryMax);
            })
            ->latest()
            ->get()
            ->filter(fn (Job $job) => $job->matchesCourse($studentCourse))
            ->values();

        $jobsCount = $jobs->count();
        $jobsLatestTs = optional($jobs->max('updated_at'))?->timestamp ?? 0;

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $jobs->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $jobs = new LengthAwarePaginator(
            $currentItems,
            $jobsCount,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('student.jobs.index', compact(
            'jobs',
            'search',
            'keyword',
            'minVacancies',
            'salaryMin',
            'salaryMax',
            'jobsCount',
            'jobsLatestTs'
        ));
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
    $studentCourse = $student->student?->course;

    if (empty($studentCourse) || ! $job->matchesCourse($studentCourse)) {
        abort(404);
    }

    // verifica se o aluno já se candidatou
    $application = Application::where('job_id', $job->id)
        ->where('student_id', $student->id)
        ->first();

    $approvedCount = Application::where('job_id', $job->id)
        ->where('status', 'aprovado')
        ->count();

    if (!$application && ($approvedCount >= $job->vacancies || ! is_null($job->closed_at) || ! $job->isWithinDefinedPeriod())) {
        abort(404);
    }

    return view('student.jobs.show', compact('job', 'application'));
}

}
