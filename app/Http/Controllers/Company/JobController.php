<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $statusFilter = $request->query('status', 'all');

        if (!in_array($statusFilter, ['all', 'active', 'inactive'], true)) {
            $statusFilter = 'all';
        }

        $jobs = Job::where('company_id', $company->id)
            ->withCount('applications')
            ->withCount('approvedApplications')
            ->latest()
            ->get();

        $jobs->each(function (Job $job) {
            $job->is_active = is_null($job->closed_at)
                && $job->approved_applications_count < $job->vacancies
                && $job->isWithinDefinedPeriod();
        });

        if ($statusFilter === 'active') {
            $jobs = $jobs->filter(fn (Job $job) => $job->is_active)->values();
        } elseif ($statusFilter === 'inactive') {
            $jobs = $jobs->filter(fn (Job $job) => !$job->is_active)->values();
        }

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $jobs->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $jobs = new LengthAwarePaginator(
            $currentItems,
            $jobs->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('company.jobs.index', compact('jobs', 'statusFilter'));
    }


    public function create()
    {
        $courses = config('internship.courses', []);

        return view('company.jobs.create', compact('courses'));
    }

    public function edit(Job $job)
    {
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $courses = config('internship.courses', []);

        return view('company.jobs.create', compact('courses', 'job'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateJobPayload($request);

        Job::create([
            'company_id' => Auth::user()->company->id,
            'title'      => $validated['title'],
            'description'=> $validated['description'],
            'location'   => $validated['location'],
            'type'       => $validated['type'],
            'area'       => $validated['area'],
            'vacancies'  => $validated['vacancies'],
            'flow_type'  => $validated['flow_type'],
            'period_start' => $validated['flow_type'] === 'defined_period' ? $validated['period_start'] : null,
            'period_end'   => $validated['flow_type'] === 'defined_period' ? $validated['period_end'] : null,
            'salary'     => $validated['salary'],
            'requirements' => $validated['requirements'],
        ]);

        return redirect()
            ->route('company.jobs.index')
            ->with('success', 'Vaga criada com sucesso!');
    }

    public function update(Request $request, Job $job)
    {
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $this->validateJobPayload($request);

        $job->update([
            'title'      => $validated['title'],
            'description'=> $validated['description'],
            'location'   => $validated['location'],
            'type'       => $validated['type'],
            'area'       => $validated['area'],
            'vacancies'  => $validated['vacancies'],
            'flow_type'  => $validated['flow_type'],
            'period_start' => $validated['flow_type'] === 'defined_period' ? $validated['period_start'] : null,
            'period_end'   => $validated['flow_type'] === 'defined_period' ? $validated['period_end'] : null,
            'salary'     => $validated['salary'],
            'requirements' => $validated['requirements'],
        ]);

        return redirect()
            ->route('company.jobs.index')
            ->with('success', 'Vaga atualizada com sucesso!');
    }



public function destroy(Job $job)
{
    if ($job->company_id !== auth()->user()->company->id) {
        abort(403);
    }

    $job->delete();

    return redirect()
        ->route('company.jobs.index')
        ->with('success', 'Vaga excluída com sucesso!');
}

    private function validateJobPayload(Request $request): array
    {
        $validated = $request->validate(
            [
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'location'    => 'required|string|max:255',
                'type'        => ['required', Rule::in(['Presencial', 'Remoto', 'Híbrido'])],
                'area'        => ['required', Rule::in(config('internship.courses', []))],
                'vacancies'   => 'required|integer|min:1|max:10',
                'flow_type'   => ['required', Rule::in(['continuous', 'defined_period'])],
                'period_start' => 'nullable|required_if:flow_type,defined_period|date',
                'period_end'   => 'nullable|required_if:flow_type,defined_period|date|after_or_equal:period_start',
                'salary'      => 'required|numeric|min:0',
                'requirements' => 'required|array|min:1',
                'requirements.*' => 'required|string|max:120',
            ],
            [
                'required' => 'O campo :attribute é obrigatório.',
                'required_if' => 'O campo :attribute é obrigatório.',
                'string' => 'O campo :attribute deve ser um texto.',
                'integer' => 'O campo :attribute deve ser um número inteiro.',
                'numeric' => 'O campo :attribute deve ser numérico.',
                'min' => 'O campo :attribute deve ter no mínimo :min.',
                'max' => 'O campo :attribute deve ter no máximo :max.',
                'date' => 'O campo :attribute deve ser uma data válida.',
                'after_or_equal' => 'O campo :attribute deve ser uma data igual ou posterior à data inicial.',
                'array' => 'O campo :attribute deve ser uma lista válida.',
                'in' => 'O valor selecionado para :attribute é inválido.',
                'requirements.min' => 'Adicione pelo menos um requisito.',
            ],
            [
                'title' => 'título da vaga',
                'description' => 'descrição',
                'location' => 'localização',
                'type' => 'tipo de trabalho',
                'area' => 'curso',
                'vacancies' => 'quantidade de vagas',
                'flow_type' => 'fluxo da vaga',
                'period_start' => 'data inicial do período',
                'period_end' => 'data final do período',
                'salary' => 'remuneração',
                'requirements' => 'requisitos',
                'requirements.*' => 'requisito',
            ]
        );

        $validated['requirements'] = collect($validated['requirements'] ?? [])
            ->map(fn ($item) => trim($item))
            ->filter(fn ($item) => $item !== '')
            ->values()
            ->all();

        return $validated;
    }

}
