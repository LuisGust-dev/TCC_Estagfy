<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    if ($user->role === 'student') {
        return redirect()->route('student.dashboard')->with('login_animation', 'student');
    }

    if ($user->role === 'company') {
        return redirect()->route('company.dashboard')->with('login_animation', 'company');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')->with('login_animation', 'admin');
    }

    if ($user->role === 'coordinator') {
        if (!session()->has('coordinator_course')) {
            return redirect()->route('coordinator.login');
        }

        return redirect()->route('coordinator.calendar.index')->with('login_animation', 'coordinator');
    }

    return redirect('/'); // fallback
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $redirectToLogin = $request->boolean('redirect_to_login');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $request->session()->forget('coordinator_course');

        if ($redirectToLogin) {
            return redirect()->route('login');
        }

        return redirect('/');
    }
}
