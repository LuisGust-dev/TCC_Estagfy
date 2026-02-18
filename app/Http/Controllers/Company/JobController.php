<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;

        $jobs = Job::where('company_id', $company->id)
            ->withCount('applications')
            ->latest()
            ->get();

        return view('company.jobs.index', compact('jobs'));
    }


    public function create()
    {
        $courses = config('internship.courses', []);

        return view('company.jobs.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'type'        => 'nullable|string|max:50',
            'area'        => ['required', Rule::in(config('internship.courses', []))],
            'vacancies'   => 'required|integer|min:1|max:10',
            'salary'      => 'nullable|numeric',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:120',
        ]);

        $requirements = collect($request->input('requirements', []))
            ->map(fn ($item) => trim($item))
            ->filter(fn ($item) => $item !== '')
            ->values()
            ->all();

        Job::create([
            'company_id' => Auth::user()->company->id,
            'title'      => $request->title,
            'description'=> $request->description,
            'location'   => $request->location,
            'type'       => $request->type,
            'area'       => $request->area,
            'vacancies'  => $request->vacancies,
            'salary'     => $request->salary,
            'requirements' => $requirements,
        ]);

        return redirect()
            ->route('company.jobs.index')
            ->with('success', 'Vaga criada com sucesso!');
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

}
