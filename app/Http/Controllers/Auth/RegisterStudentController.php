<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterStudentController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->cpf),
        ]);

        $request->validate(
            [
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|max:255',
                'cpf' => 'required|digits:11|unique:students,cpf',
                'course' => ['required', Rule::in(config('internship.courses', []))],
                'period' => 'required|string|max:50',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'name.unique' => 'Este nome ja esta cadastrado.',
                'email.unique' => 'Este e-mail ja esta cadastrado.',
                'cpf.unique' => 'Este CPF ja esta cadastrado.',
            ]
        );

        $resumePath = $request->file('resume')->store('resumes', 'public');
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'photo' => $photoPath,
        ]);

        Student::create([
            'user_id' => $user->id,
            'cpf' => $request->cpf,
            'course' => $request->course,
            'period' => $request->period,
            'resume' => $resumePath,
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard');
    }
}
