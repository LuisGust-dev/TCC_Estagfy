<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Support\ResumeStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RuntimeException;

class RegisterStudentController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->cpf),
            'period' => preg_replace('/\D/', '', (string) $request->period),
        ]);

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:users,name', 'regex:/^[\pL\s]+$/u'],
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|max:255',
                'cpf' => 'required|digits:11|unique:students,cpf',
                'course' => ['required', Rule::in(config('internship.courses', []))],
                'period' => 'required|integer|min:1|max:20',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'name.unique' => 'Este nome ja esta cadastrado.',
                'name.regex' => 'O nome deve conter apenas letras e espaços.',
                'email.unique' => 'Este e-mail ja esta cadastrado.',
                'cpf.unique' => 'Este CPF ja esta cadastrado.',
                'period.integer' => 'O período deve conter apenas números.',
                'period.min' => 'O período deve ser maior que zero.',
                'period.max' => 'O período informado é inválido.',
            ]
        );

        try {
            $resumePath = ResumeStorage::store($request->file('resume'));
        } catch (RuntimeException $exception) {
            return back()
                ->withInput($request->except(['password', 'photo', 'resume']))
                ->with('error', 'Não foi possível enviar o currículo no momento. Tente novamente.');
        }
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
