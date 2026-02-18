<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $student = $user->student;
        $courses = config('internship.courses', []);

        return view('student.profile', compact('user', 'student', 'courses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $request->merge([
            'cpf' => preg_replace('/\\D/', '', (string) $request->cpf),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'cpf' => [
                'required',
                'digits:11',
                Rule::unique('students', 'cpf')->ignore($student?->id),
            ],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'course' => ['required', Rule::in(config('internship.courses', []))],
            'period' => 'nullable|string|max:50',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->hasFile('photo')) {
            if (!empty($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $userData['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($userData);

        $studentData = [
            'cpf' => $validated['cpf'],
            'course' => $validated['course'],
            'period' => $validated['period'] ?? null,
        ];

        if ($request->hasFile('resume')) {
            $studentData['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        if ($student) {
            $student->update($studentData);
        } else {
            $user->student()->create($studentData);
        }

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
