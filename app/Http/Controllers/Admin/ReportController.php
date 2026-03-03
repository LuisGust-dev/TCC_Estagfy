<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->extractFilters($request);

        $usersQuery = User::query();
        if ($filters['role']) {
            $usersQuery->where('role', $filters['role']);
        }
        if ($filters['active'] !== null) {
            $usersQuery->where('active', $filters['active']);
        }
        $this->applyDateRange($usersQuery, $filters['from'], $filters['to'], 'created_at');

        $applicationsQuery = Application::query()
            ->with(['student', 'job.company.user'])
            ->latest();
        if ($filters['status']) {
            $applicationsQuery->where('status', $filters['status']);
        }
        $this->applyDateRange($applicationsQuery, $filters['from'], $filters['to'], 'created_at');

        $companiesQuery = Company::query()
            ->with('user')
            ->withCount('jobs')
            ->withCount('applications')
            ->latest('id');
        if ($filters['active'] !== null) {
            $companiesQuery->whereHas('user', function (Builder $query) use ($filters) {
                $query->where('active', $filters['active']);
            });
        }
        $this->applyDateRange($companiesQuery, $filters['from'], $filters['to'], 'created_at');

        $users = (clone $usersQuery)->latest()->take(10)->get();
        $applications = (clone $applicationsQuery)->take(10)->get();
        $companies = (clone $companiesQuery)->take(10)->get();

        $summary = [
            'users' => (clone $usersQuery)->count(),
            'companies' => (clone $companiesQuery)->count(),
            'applications' => (clone $applicationsQuery)->count(),
        ];

        return view('admin.reports.index', compact(
            'filters',
            'summary',
            'users',
            'applications',
            'companies'
        ));
    }

    public function usersCsv(Request $request): StreamedResponse
    {
        $filters = $this->extractFilters($request);

        $query = User::query();
        if ($filters['role']) {
            $query->where('role', $filters['role']);
        }
        if ($filters['active'] !== null) {
            $query->where('active', $filters['active']);
        }
        $this->applyDateRange($query, $filters['from'], $filters['to'], 'created_at');

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nome', 'Email', 'Perfil', 'Status', 'Cadastro']);

            $query->orderBy('created_at', 'desc')->chunk(500, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->name,
                        $user->email,
                        $user->role,
                        $user->active ? 'Ativo' : 'Inativo',
                        optional($user->created_at)->format('d/m/Y H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, 'relatorio_usuarios.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function companiesCsv(Request $request): StreamedResponse
    {
        $filters = $this->extractFilters($request);

        $query = Company::query()->with('user')->withCount('jobs')->withCount('applications');
        if ($filters['active'] !== null) {
            $query->whereHas('user', function (Builder $builder) use ($filters) {
                $builder->where('active', $filters['active']);
            });
        }
        $this->applyDateRange($query, $filters['from'], $filters['to'], 'created_at');

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Empresa', 'Email', 'CNPJ', 'Telefone', 'Vagas', 'Candidaturas', 'Status']);

            $query->orderByDesc('id')->chunk(500, function ($companies) use ($handle) {
                foreach ($companies as $company) {
                    fputcsv($handle, [
                        data_get($company, 'user.name', 'Empresa'),
                        data_get($company, 'user.email', '-'),
                        $company->cnpj ?: '-',
                        $company->phone ?: '-',
                        $company->jobs_count,
                        $company->applications_count,
                        data_get($company, 'user.active') ? 'Ativo' : 'Inativo',
                    ]);
                }
            });

            fclose($handle);
        }, 'relatorio_empresas.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function applicationsCsv(Request $request): StreamedResponse
    {
        $filters = $this->extractFilters($request);

        $query = Application::query()->with(['student', 'job.company.user']);
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        $this->applyDateRange($query, $filters['from'], $filters['to'], 'created_at');

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Aluno', 'Email', 'Empresa', 'Vaga', 'Status', 'Data']);

            $query->latest()->chunk(500, function ($applications) use ($handle) {
                foreach ($applications as $application) {
                    fputcsv($handle, [
                        data_get($application, 'student.name', 'Aluno'),
                        data_get($application, 'student.email', '-'),
                        data_get($application, 'job.company.user.name', 'Empresa'),
                        data_get($application, 'job.title', '-'),
                        $application->status,
                        optional($application->created_at)->format('d/m/Y H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, 'relatorio_candidaturas.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function applyDateRange(Builder $query, ?Carbon $from, ?Carbon $to, string $column): void
    {
        if ($from) {
            $query->whereDate($column, '>=', $from->toDateString());
        }

        if ($to) {
            $query->whereDate($column, '<=', $to->toDateString());
        }
    }

    private function extractFilters(Request $request): array
    {
        $from = $this->parseDate($request->query('from'));
        $to = $this->parseDate($request->query('to'));

        $role = $request->query('role');
        $status = $request->query('status');

        $active = $request->query('active');
        if (!in_array($active, ['1', '0'], true)) {
            $active = null;
        }

        if (!in_array($role, ['student', 'company', 'admin', 'coordinator'], true)) {
            $role = null;
        }

        if (!in_array($status, ['em_analise', 'aprovado', 'recusado'], true)) {
            $status = null;
        }

        return [
            'from' => $from,
            'to' => $to,
            'role' => $role,
            'status' => $status,
            'active' => $active === null ? null : $active === '1',
            'from_input' => $request->query('from'),
            'to_input' => $request->query('to'),
        ];
    }

    private function parseDate(?string $date): ?Carbon
    {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }
}
