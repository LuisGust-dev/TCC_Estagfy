<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $student = $user->student;

        return view('student.profile', compact('user', 'student'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'course' => 'nullable|string|max:255',
            'period' => 'nullable|string|max:50',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $studentData = [
            'course' => $validated['course'] ?? null,
            'period' => $validated['period'] ?? null,
        ];

        if ($request->hasFile('resume')) {
            $studentData['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $student = $user->student;
        if ($student) {
            $student->update($studentData);
        } else {
            $user->student()->create($studentData);
        }

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
