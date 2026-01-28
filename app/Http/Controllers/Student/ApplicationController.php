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
        $applications = Application::with('job')
            ->where('student_id', Auth::id())
            ->latest()
            ->get();

        return view('student.applications.index', compact('applications'));
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
