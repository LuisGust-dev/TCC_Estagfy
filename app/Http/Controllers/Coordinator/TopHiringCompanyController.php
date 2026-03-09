<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\TopHiringCompany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TopHiringCompanyController extends Controller
{
    public function index(Request $request)
    {
        $selectedCourse = $this->selectedCourse($request);
        $search = trim((string) $request->query('q', ''));

        $companiesQuery = TopHiringCompany::query()
            ->when(!empty($selectedCourse), fn ($query) => $query->where('course', $selectedCourse))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('company_name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });

        $companies = (clone $companiesQuery)
            ->orderBy('company_name')
            ->get();

        $companiesCount = $companies->count();
        $latestUpdateAt = $companies->max('updated_at');

        return view('coordinator.calendar.hiring-companies', compact(
            'companies',
            'selectedCourse',
            'search',
            'companiesCount',
            'latestUpdateAt'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'course' => ['required', Rule::in(config('internship.courses', []))],
            'description' => 'nullable|string|max:255',
        ]);

        TopHiringCompany::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Empresa destaque cadastrada com sucesso.');
    }

    public function update(Request $request, TopHiringCompany $company)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'course' => ['required', Rule::in(config('internship.courses', []))],
            'description' => 'nullable|string|max:255',
        ]);

        $company->update($validated);

        return back()->with('success', 'Empresa destaque atualizada com sucesso.');
    }

    public function destroy(TopHiringCompany $company)
    {
        $company->delete();

        return back()->with('success', 'Empresa destaque removida.');
    }

    private function selectedCourse(Request $request): ?string
    {
        return $request->session()->get('coordinator_course');
    }
}
