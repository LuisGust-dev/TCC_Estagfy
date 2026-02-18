<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\InternshipCalendar;

class InternshipCalendarController extends Controller
{
    public function index()
    {
        $studentCourse = auth()->user()->student?->course;

        $events = InternshipCalendar::query()
            ->when(!empty($studentCourse), function ($query) use ($studentCourse) {
                $query->where('course', $studentCourse);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        return view('student.calendar.index', compact('events'));
    }
}
