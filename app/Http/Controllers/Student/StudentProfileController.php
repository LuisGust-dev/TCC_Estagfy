<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        $student = $user->student;
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->cpf),
        ]);

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'regex:/^[\\pL\\s\'-]+$/u'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'cpf' => [
                    'required',
                    'regex:/^[0-9]{11}$/',
                    Rule::unique('students', 'cpf')->ignore($student?->id),
                ],
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'period' => 'nullable|string|max:50',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'current_password' => 'nullable|required_with:password|current_password',
                'password' => 'nullable|string|min:6|confirmed',
            ],
            [
                'current_password.current_password' => 'A senha atual está incorreta.',
                'current_password.required_with' => 'Informe a senha atual para definir uma nova senha.',
                'password.confirmed' => 'A confirmação da nova senha não confere.',
                'password.min' => 'A nova senha deve ter no mínimo :min caracteres.',
                'name.regex' => 'O nome completo deve conter apenas letras.',
                'cpf.regex' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
            ]
        );

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->hasFile('photo')) {
            $oldPhoto = $user->photo;
            $newPhoto = $request->file('photo')->store('profiles', 'public');
            $userData['photo'] = $newPhoto;

            if (!empty($oldPhoto) && $oldPhoto !== $newPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        $studentData = [
            'cpf' => $validated['cpf'],
            'course' => $student?->course,
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
