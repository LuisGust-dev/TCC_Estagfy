<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        // 📌 Vagas da empresa
        $jobs = Job::where('company_id', $company->id)->get();

        // 📊 Cards
        $vagasAtivas = $jobs->count();

        $candidatos = Application::whereIn(
            'job_id',
            $jobs->pluck('id')
        )->count();

        $contratacoes = Application::whereIn(
            'job_id',
            $jobs->pluck('id')
        )->where('status', 'aprovado')->count();

        $emAnalise = Application::whereIn(
            'job_id',
            $jobs->pluck('id')
        )->where('status', 'em_analise')->count();

        // 🧳 Vagas recentes (da empresa)
        $vagasRecentes = Job::where('company_id', $company->id)
            ->withCount('applications')
            ->latest()
            ->take(3)
            ->get();

        // 👥 Candidatos recentes (para vagas da empresa)
        $candidatosRecentes = Application::whereIn(
            'job_id',
            $jobs->pluck('id')
        )
            ->with(['student', 'job'])
            ->latest()
            ->take(3)
            ->get();

        return view('company.dashboard', compact(
            'vagasAtivas',
            'candidatos',
            'contratacoes',
            'emAnalise',
            'vagasRecentes',
            'candidatosRecentes'
        ));
    }
}
