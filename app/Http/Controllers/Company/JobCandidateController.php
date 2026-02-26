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
    private function resolveStatusFilter(?string $status, string $default = 'all'): string
    {
        $allowedStatuses = ['all', 'em_analise', 'aprovado', 'finalizado', 'recusado'];

        if (!in_array($status, $allowedStatuses, true)) {
            return $default;
        }

        return $status;
    }

    /**
     * Lista candidatos da vaga
     */
    public function all()
    {
        $company = Auth::user()->company;

        $jobIds = Job::where('company_id', $company->id)
            ->pluck('id');

        $status = $this->resolveStatusFilter(request()->query('status'), 'all');

        $applicationsQuery = Application::whereIn('job_id', $jobIds);

        if ($status !== 'all') {
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

        $status = $this->resolveStatusFilter(request()->query('status'), 'all');

        $applicationsQuery = $job->applications()
            ->with('student.student')
            ->latest();

        if ($status !== 'all') {
            $applicationsQuery->where('status', $status);
        }

        $applications = $applicationsQuery->get();

        return view('company.jobs.candidates', compact('job', 'applications', 'status'));
    }

    /**
     * Aprovar candidatura
     */

    public function approve(Application $application)
    {
        $companyId = Auth::user()->company->id;
        $studentRejectedApplicationIds = [];
        $autoRejectedApplicationIds = [];

        if ($application->job->company_id !== $companyId) {
            abort(403);
        }

        if ($application->status !== 'em_analise') {
            return back()->with('error', 'Só é possível aprovar candidaturas em análise.');
        }

        $approvedForJob = Application::where('job_id', $application->job_id)
            ->where('status', 'aprovado')
            ->count();

        if ($approvedForJob >= $application->job->vacancies) {
            return back()->with('error', 'Esta vaga já atingiu o limite de candidatos aprovados.');
        }

        $alreadyApproved = Application::where('student_id', $application->student_id)
            ->where('status', 'aprovado')
            ->where('id', '!=', $application->id)
            ->exists();

        if ($alreadyApproved) {
            return back()->with('error', 'Este aluno já foi aprovado em outra vaga.');
        }

        DB::transaction(function () use ($application, &$studentRejectedApplicationIds, &$autoRejectedApplicationIds) {
            $application->update(['status' => 'aprovado']);

            $studentRejectedApplicationIds = Application::where('student_id', $application->student_id)
                ->where('status', 'em_analise')
                ->where('id', '!=', $application->id)
                ->pluck('id')
                ->all();

            if (!empty($studentRejectedApplicationIds)) {
                Application::whereIn('id', $studentRejectedApplicationIds)
                    ->update(['status' => 'recusado']);
            }

            $approvedForJob = Application::where('job_id', $application->job_id)
                ->where('status', 'aprovado')
                ->count();

            if ($approvedForJob >= $application->job->vacancies) {
                $autoRejectedApplicationIds = Application::where('job_id', $application->job_id)
                    ->where('status', 'em_analise')
                    ->pluck('id')
                    ->all();

                if (!empty($autoRejectedApplicationIds)) {
                    Application::whereIn('id', $autoRejectedApplicationIds)
                        ->update(['status' => 'recusado']);
                }

                if (is_null($application->job->closed_at)) {
                    $application->job->update(['closed_at' => now()]);
                }
            }
        });

        // 🔔 Notificar aluno
        $application->student->notify(
            new ApplicationStatusNotification($application)
        );

        if (!empty($studentRejectedApplicationIds)) {
            $studentRejectedApplications = Application::whereIn('id', $studentRejectedApplicationIds)
                ->with('student')
                ->get();

            foreach ($studentRejectedApplications as $studentRejectedApplication) {
                $studentRejectedApplication->student?->notify(
                    new ApplicationStatusNotification($studentRejectedApplication)
                );
            }
        }

        if (!empty($autoRejectedApplicationIds)) {
            $autoRejectedApplications = Application::whereIn('id', $autoRejectedApplicationIds)
                ->with('student')
                ->get();

            foreach ($autoRejectedApplications as $autoRejectedApplication) {
                $autoRejectedApplication->student?->notify(
                    new ApplicationStatusNotification($autoRejectedApplication)
                );
            }
        }

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

        if ($application->status !== 'em_analise') {
            return back()->with('error', 'Só é possível recusar candidaturas em análise.');
        }

        $application->update(['status' => 'recusado']);

        // 🔔 Notificar aluno
        $application->student->notify(
            new ApplicationStatusNotification($application)
        );

        return back()->with('success', 'Candidatura recusada.');
    }

    /**
     * Finalizar estágio de candidatura aprovada
     */
    public function finalize(Application $application)
    {
        $companyId = Auth::user()->company->id;

        if ($application->job->company_id !== $companyId) {
            abort(403);
        }

        if ($application->status !== 'aprovado') {
            return back()->with('error', 'Só é possível finalizar estágios de candidaturas aprovadas.');
        }

        $application->update(['status' => 'finalizado']);

        $application->student->notify(
            new ApplicationStatusNotification($application)
        );

        return back()->with('success', 'Estágio finalizado com sucesso. O aluno pode se candidatar novamente.');
    }




}
