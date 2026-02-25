<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\InternshipCalendar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InternshipCalendarController extends Controller
{
    public function index(Request $request)
    {
        $selectedCourse = $this->selectedCourse($request);

        $eventsCount = InternshipCalendar::query()
            ->when(!empty($selectedCourse), fn ($query) => $query->where('course', $selectedCourse))
            ->count();

        return view('coordinator.calendar.index', compact('selectedCourse', 'eventsCount'));
    }

    public function events(Request $request)
    {
        $selectedCourse = $this->selectedCourse($request);

        $events = InternshipCalendar::query()
            ->when(!empty($selectedCourse), fn ($query) => $query->where('course', $selectedCourse))
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        return view('coordinator.calendar.events', compact('events', 'selectedCourse'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'course' => ['required', Rule::in(config('internship.courses', []))],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        InternshipCalendar::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Data do calendário cadastrada com sucesso.');
    }

    public function update(Request $request, InternshipCalendar $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'course' => ['required', Rule::in(config('internship.courses', []))],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $event->update($validated);

        return back()->with('success', 'Evento do calendário atualizado com sucesso.');
    }

    public function destroy(InternshipCalendar $event)
    {
        $event->delete();

        return back()->with('success', 'Evento removido do calendário.');
    }

    private function selectedCourse(Request $request): ?string
    {
        return $request->session()->get('coordinator_course');
    }
}
