<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\InternshipCalendar;
use App\Models\TopHiringCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InternshipCalendarController extends Controller
{
    public function index(Request $request)
    {
        $studentCourse = auth()->user()->student?->course;
        $monthInput = (string) $request->query('month', '');

        $monthStart = preg_match('/^\d{4}-\d{2}$/', $monthInput)
            ? Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth()
            : now()->startOfMonth();

        $monthEnd = $monthStart->copy()->endOfMonth();

        $events = InternshipCalendar::query()
            ->when(!empty($studentCourse), function ($query) use ($studentCourse) {
                $query->where('course', $studentCourse);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->whereDate('start_date', '<=', $monthEnd->toDateString())
            ->where(function ($query) use ($monthStart) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $monthStart->toDateString());
            })
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        $today = Carbon::today();

        $calendarEvents = $events->map(function (InternshipCalendar $event) use ($today) {
            $startDate = $event->start_date->copy();
            $endDate = ($event->end_date ?: $event->start_date)->copy();
            $timing = $this->resolveTiming($startDate, $endDate, $today);

            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'timing' => $timing,
                'style' => $this->styleForTiming($timing),
            ];
        })->values();

        $eventsByDate = [];

        foreach ($calendarEvents as $event) {
            $rangeStart = $event['start_date']->lt($monthStart)
                ? $monthStart->copy()
                : $event['start_date']->copy();

            $rangeEnd = $event['end_date']->gt($monthEnd)
                ? $monthEnd->copy()
                : $event['end_date']->copy();

            for ($date = $rangeStart->copy(); $date->lte($rangeEnd); $date->addDay()) {
                $eventsByDate[$date->toDateString()][] = $event;
            }
        }

        $upcomingEvents = $calendarEvents
            ->sortBy(fn ($event) => $event['start_date']->toDateString())
            ->values()
            ->take(6);

        $legendItems = collect(['atraso', 'hoje', 'futuro'])
            ->map(fn (string $timing) => [
                'timing' => $timing,
                'style' => $this->styleForTiming($timing),
            ]);

        $topHiringCompanies = TopHiringCompany::query()
            ->when(!empty($studentCourse), fn ($query) => $query->where('course', $studentCourse), fn ($query) => $query->whereRaw('1 = 0'))
            ->orderBy('company_name')
            ->take(5)
            ->get();

        $offset = $monthStart->dayOfWeek;
        $daysInMonth = $monthStart->daysInMonth;
        $trailingDays = (7 - (($offset + $daysInMonth) % 7)) % 7;

        return view('student.calendar.index', [
            'studentCourse' => $studentCourse,
            'monthStart' => $monthStart,
            'prevMonth' => $monthStart->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $monthStart->copy()->addMonth()->format('Y-m'),
            'offset' => $offset,
            'daysInMonth' => $daysInMonth,
            'trailingDays' => $trailingDays,
            'eventsByDate' => $eventsByDate,
            'upcomingEvents' => $upcomingEvents,
            'legendItems' => $legendItems,
            'topHiringCompanies' => $topHiringCompanies,
        ]);
    }

    private function resolveTiming(Carbon $startDate, Carbon $endDate, Carbon $today): string
    {
        if ($endDate->lt($today)) {
            return 'atraso';
        }

        if ($startDate->lte($today) && $endDate->gte($today)) {
            return 'hoje';
        }

        return 'futuro';
    }

    private function styleForTiming(string $timing): array
    {
        return [
            'dot' => 'bg-blue-500',
            'soft' => 'bg-blue-50 text-blue-700 border-blue-100',
            'pill' => 'bg-blue-100 text-blue-700',
            'day' => 'border-blue-200 bg-blue-50/30',
            'label' => 'Evento acadêmico',
        ];
    }
}
