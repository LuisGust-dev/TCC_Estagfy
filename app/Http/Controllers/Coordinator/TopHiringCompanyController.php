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
        [$courses, $selectedCourse, $courseCounts] = $this->courseContext($request);

        $companies = TopHiringCompany::query()
            ->when(!empty($selectedCourse), fn ($query) => $query->where('course', $selectedCourse))
            ->orderBy('company_name')
            ->get();

        return view('coordinator.calendar.hiring-companies', compact('companies', 'courses', 'selectedCourse', 'courseCounts'));
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

    private function courseContext(Request $request): array
    {
        $courses = config('internship.courses', []);
        $selectedCourse = $request->query('course');

        if (!in_array($selectedCourse, $courses, true)) {
            $selectedCourse = $courses[0] ?? null;
        }

        $courseCounts = TopHiringCompany::query()
            ->selectRaw('course, COUNT(*) as total')
            ->whereNotNull('course')
            ->groupBy('course')
            ->pluck('total', 'course');

        return [$courses, $selectedCourse, $courseCounts];
    }
}
