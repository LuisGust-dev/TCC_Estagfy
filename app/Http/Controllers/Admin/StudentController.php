<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $studentsQuery = User::where('role', 'student')
            ->with('student')
            ->withCount('applications');

        if ($search !== '') {
            $studentsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('course', 'like', "%{$search}%")
                            ->orWhere('period', 'like', "%{$search}%")
                            ->orWhere('cpf', 'like', "%{$search}%");
                    });
            });
        }

        $students = $studentsQuery
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.students.index', compact('students', 'search'));
    }
}
