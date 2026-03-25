<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CoordinatorAuthController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->isCoordinator()) {
                return $this->redirectByRole($user->role);
            }

            if ($request->session()->has('coordinator_course')) {
                return redirect()->route('coordinator.calendar.index');
            }
        }

        $courses = config('internship.courses', []);

        return view('auth.coordinator-login', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'course' => ['required', 'string'],
        ]);

        $courses = config('internship.courses', []);

        if (!in_array($validated['course'], $courses, true)) {
            return back()
                ->withInput()
                ->withErrors(['course' => 'Selecione um curso válido.']);
        }

        if (Auth::check()) {
            $currentUser = Auth::user();

            if ($currentUser->isCoordinator()) {
                $request->session()->put('coordinator_course', $validated['course']);

                return redirect()->route('coordinator.calendar.index')->with('login_animation', 'coordinator');
            }

            return $this->redirectByRole($currentUser->role);
        }

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'coordinator',
        ];

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email', 'course'))
                ->withErrors(['email' => 'Credenciais inválidas para coordenador.']);
        }

        $request->session()->regenerate();
        $request->session()->put('coordinator_course', $validated['course']);

        return redirect()->route('coordinator.calendar.index')->with('login_animation', 'coordinator');
    }

    private function redirectByRole(?string $role): RedirectResponse
    {
        return match ($role) {
            'student' => redirect()->route('student.dashboard'),
            'company' => redirect()->route('company.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'coordinator' => redirect()->route('coordinator.calendar.index'),
            default => redirect('/'),
        };
    }
}
