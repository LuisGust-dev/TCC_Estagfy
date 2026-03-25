<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalCompanies = User::where('role', 'company')->count();
        $totalJobs = Job::count();
        $totalApplications = Application::count();
        $totalCoordinators = User::where('role', 'coordinator')->count();

        $roleDistribution = [
            ['label' => 'Alunos', 'count' => $totalStudents, 'color' => '#3b82f6'],
            ['label' => 'Empresas', 'count' => $totalCompanies, 'color' => '#10b981'],
            ['label' => 'Admins', 'count' => User::where('role', 'admin')->count(), 'color' => '#6366f1'],
            ['label' => 'Coordenadores', 'count' => $totalCoordinators, 'color' => '#f59e0b'],
        ];

        $applicationStatus = [
            ['label' => 'Em análise', 'count' => Application::where('status', 'em_analise')->count(), 'color' => '#f59e0b'],
            ['label' => 'Aprovado', 'count' => Application::where('status', 'aprovado')->count(), 'color' => '#10b981'],
            ['label' => 'Recusado', 'count' => Application::where('status', 'recusado')->count(), 'color' => '#f43f5e'],
            ['label' => 'Finalizado', 'count' => Application::where('status', 'finalizado')->count(), 'color' => '#6366f1'],
        ];

        $monthlyLabels = [];
        $monthlyValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $monthlyLabels[] = $month->translatedFormat('M/Y');
            $monthlyValues[] = User::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ])->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalCompanies',
            'totalJobs',
            'totalApplications',
            'roleDistribution',
            'applicationStatus',
            'monthlyLabels',
            'monthlyValues'
        ));
    }
}
