<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewApplicationNotification;

class ApplicationController extends Controller
{
    /**
     * Aluno se candidata a uma vaga
     */

     public function store(Job $job)
     {
         if (! $job->company || ! $job->company->user || ! $job->company->user->active) {
             abort(404);
         }

         $student = Auth::user();
         $studentProfile = $student->student;

         if (!$studentProfile || empty($studentProfile->course)) {
             return back()->with('error', 'Defina seu curso no perfil antes de se candidatar.');
         }

         if ($job->area !== $studentProfile->course) {
             return back()->with('error', 'Esta vaga não é da área do seu curso.');
         }

         $alreadyApproved = Application::where('student_id', $student->id)
             ->where('status', 'aprovado')
             ->exists();

         if ($alreadyApproved) {
             return back()->with('error', 'Você já foi aprovado em uma vaga e não pode se candidatar a outra.');
         }

         $alreadyApplied = Application::where('job_id', $job->id)
             ->where('student_id', $student->id)
             ->exists();

         if ($alreadyApplied) {
             return back()->with('error', 'Você já se candidatou a esta vaga.');
         }

         if (!$studentProfile || !$studentProfile->resume) {
             return back()->with('error', 'Envie seu currículo antes de se candidatar.');
         }

         $application = Application::create([
             'job_id'      => $job->id,
             'student_id' => $student->id,
             'status'     => 'em_analise',
             'resume'     => $studentProfile->resume,
         ]);

         // 🔔 Notificar empresa
         $companyUser = $job->company->user;

         if ($companyUser) {
             $companyUser->notify(
                 new NewApplicationNotification($application)
             );
         }

         return back()->with('success', 'Candidatura enviada! Fique no aguardo.');
     }


}
