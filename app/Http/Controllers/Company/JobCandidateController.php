<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Support\Facades\DB;

class JobCandidateController extends Controller
{
    /**
     * Lista candidatos da vaga
     */
    public function all()
    {
        $company = Auth::user()->company;

        $jobIds = Job::where('company_id', $company->id)
            ->pluck('id');

        $status = request()->query('status');

        $applicationsQuery = Application::whereIn('job_id', $jobIds);

        if (!empty($status)) {
            $applicationsQuery->where('status', $status);
        }

        $applications = $applicationsQuery
            ->with(['student.student', 'job'])
            ->latest()
            ->get();

        $job = null;

        return view('company.jobs.candidates', compact('job', 'applications', 'status'));
    }

    public function index(Job $job)
    {
        // garante que a vaga pertence à empresa logada
        if ($job->company_id !== Auth::user()->company->id) {
            abort(403);
        }

        $applications = $job->applications()
            ->with('student.student')
            ->latest()
            ->get();

        return view('company.jobs.candidates', compact('job', 'applications'));
    }

    /**
     * Aprovar candidatura
     */

    public function approve(Application $application)
    {
        $companyId = Auth::user()->company->id;

        if ($application->job->company_id !== $companyId) {
            abort(403);
        }

        if ($application->status !== 'em_analise') {
            return back()->with('error', 'Só é possível aprovar candidaturas em análise.');
        }

        $alreadyApproved = Application::where('student_id', $application->student_id)
            ->where('status', 'aprovado')
            ->where('id', '!=', $application->id)
            ->exists();

        if ($alreadyApproved) {
            return back()->with('error', 'Este aluno já foi aprovado em outra vaga.');
        }

        DB::transaction(function () use ($application) {
            $application->update(['status' => 'aprovado']);

            Application::where('student_id', $application->student_id)
                ->where('status', 'em_analise')
                ->where('id', '!=', $application->id)
                ->delete();
        });

        // 🔔 Notificar aluno
        $application->student->notify(
            new ApplicationStatusNotification($application)
        );

        return back()->with('success', 'Candidatura aprovada.');
    }




    /**
     * Recusar candidatura
     */
    public function reject(Application $application)
    {
        $companyId = Auth::user()->company->id;

        if ($application->job->company_id !== $companyId) {
            abort(403);
        }

        $application->update(['status' => 'recusado']);

        // 🔔 Notificar aluno
        $application->student->notify(
            new ApplicationStatusNotification($application)
        );

        return back()->with('success', 'Candidatura recusada.');
    }




}
