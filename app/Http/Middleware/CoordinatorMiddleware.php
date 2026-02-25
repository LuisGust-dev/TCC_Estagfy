<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoordinatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isCoordinator()) {
            return redirect()->route('coordinator.login');
        }

        $selectedCourse = $request->session()->get('coordinator_course');
        $courses = config('internship.courses', []);

        if (!in_array($selectedCourse, $courses, true)) {
            return redirect()
                ->route('coordinator.login')
                ->with('error', 'Selecione o curso que você coordena para continuar.');
        }

        return $next($request);
    }
}
