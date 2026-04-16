<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Lista as candidaturas do aluno logado
     */
    public function index()
    {
        $applicationsQuery = Application::with('job.company.user')
            ->where('student_id', Auth::id());

        $applicationsCount = (clone $applicationsQuery)->count();
        $applicationsLatestTs = optional((clone $applicationsQuery)->max('updated_at'))?->timestamp ?? 0;

        $applications = $applicationsQuery
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('student.applications.index', compact(
            'applications',
            'applicationsCount',
            'applicationsLatestTs'
        ));
    }


public function destroy(Application $application)
{
    // Garante que a candidatura pertence ao aluno logado
    if ($application->student_id !== Auth::id()) {
        abort(403);
    }

    // Só permite cancelar se estiver em análise
    if ($application->status !== 'em_analise') {
        return back()->with('error', 'Não é possível cancelar esta candidatura.');
    }

    $application->delete();

    return redirect()
        ->route('student.applications.index')
        ->with('success', 'Candidatura cancelada com sucesso.');
}

}
