<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterStudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'course'   => 'required|string|max:255',
            'period'   => 'required|string|max:50',
            'resume'   => 'required|file|mimes:pdf,doc,docx|max:2048',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 👈 NOVO
        ]);

        // upload do currículo
        $resumePath = $request->file('resume')->store('resumes', 'public');
        $photoPath = null;

if ($request->hasFile('photo')) {
    $photoPath = $request->file('photo')
        ->store('profiles', 'public');
}


        // cria usuário
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
            'photo'    => $photoPath, // 👈 AQUI
        ]);


        // cria aluno
        Student::create([
            'user_id' => $user->id,
            'course'  => $request->course,
            'period'  => $request->period,
            'resume'  => $resumePath,
        ]);

        // login automático
        Auth::login($user);

        return redirect()->route('student.dashboard');
    }
}
