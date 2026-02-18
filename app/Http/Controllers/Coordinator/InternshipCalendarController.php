<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\InternshipCalendar;
use Illuminate\Http\Request;

class InternshipCalendarController extends Controller
{
    public function index()
    {
        $events = InternshipCalendar::query()
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        return view('coordinator.calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
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
}
