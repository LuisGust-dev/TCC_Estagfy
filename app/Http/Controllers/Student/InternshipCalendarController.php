<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\InternshipCalendar;

class InternshipCalendarController extends Controller
{
    public function index()
    {
        $events = InternshipCalendar::query()
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        return view('student.calendar.index', compact('events'));
    }
}
