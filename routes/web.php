<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterCompanyController;
use App\Http\Controllers\Auth\RegisterStudentController;

/* Company */
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\JobCandidateController;

/* Student */
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\JobBrowseController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\InternshipCalendarController as StudentInternshipCalendarController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Student\StudentChatController;
use App\Http\Controllers\Company\CompanyChatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\InternalRoleController as AdminInternalRoleController;
use App\Http\Controllers\Coordinator\InternshipCalendarController as CoordinatorInternshipCalendarController;
use App\Http\Controllers\Coordinator\TopHiringCompanyController as CoordinatorTopHiringCompanyController;
use App\Http\Controllers\Coordinator\CoordinatorAuthController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Escolha do tipo de cadastro
Route::get('/register/choice', function () {
    return view('auth.register-choice');
})->name('register.choice');


// Cadastro - Aluno (formulário)
Route::get('/register/student', function () {
    return view('auth.register-student');
})->name('register.student');

// Cadastro - Aluno (envio)
Route::post('/register/student', [RegisterStudentController::class, 'store'])
    ->name('register.student.store');

// Cadastro - Empresa (formulário)
Route::get('/register/company', function () {
    return view('auth.register-company');
})->name('register.company');

// Cadastro - Empresa (envio)
Route::post('/register/company', [RegisterCompanyController::class, 'store'])
    ->name('register.company.store');

// Rotas de autenticação padrão (login, logout, etc)
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Login do COORDENADOR (com seleção de curso)
|--------------------------------------------------------------------------
*/
Route::get('/coordinator/login', [CoordinatorAuthController::class, 'create'])
    ->name('coordinator.login');
Route::post('/coordinator/login', [CoordinatorAuthController::class, 'store'])
    ->name('coordinator.login.store');

/*
|--------------------------------------------------------------------------
| Perfil Geral (Laravel Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas do ALUNO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        /*
        | Dashboard do Aluno
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | Perfil do Aluno
        */
        Route::get('/profile', [StudentProfileController::class, 'show'])
            ->name('profile.show');
        Route::put('/profile', [StudentProfileController::class, 'update'])
            ->name('profile.update');

        /*
        | Vagas disponíveis
        */
        Route::get('/jobs', [JobBrowseController::class, 'index'])
            ->name('jobs.index');

        /*
        | Candidatar-se a uma vaga
        */

        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
            ->name('jobs.apply');


        /*
        | Minhas candidaturas
        */

        // ✅ MINHAS CANDIDATURAS
        Route::get('/applications', [StudentApplicationController::class, 'index'])
            ->name('applications.index');



Route::get('/jobs/{job}', [JobBrowseController::class, 'show'])
    ->name('jobs.show');


Route::delete('/applications/{application}', [StudentApplicationController::class, 'destroy'])
    ->name('applications.destroy');

Route::get('/calendar', [StudentInternshipCalendarController::class, 'index'])
    ->name('calendar.index');

Route::view('/fluxo-estagio', 'student.internship-flow')
    ->name('flow.index');


    // 📌 Lista de notificações
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications;

        return view('student.notifications.index', [
            'notifications' => $notifications,
            'notificationsCount' => $notifications->count(),
            'notificationsLatestTs' => optional($notifications->max('updated_at'))?->timestamp ?? 0,
        ]);
    })->name('notifications.index');

    Route::get('/realtime/summary', function () {
        $user = auth()->user();
        $studentCourse = $user->student?->course;

        $jobsQuery = \App\Models\Job::query()
            ->whereHas('company.user', function ($query) {
                $query->where('active', true);
            })
            ->openForApplications()
            ->when(!empty($studentCourse), function ($query) use ($studentCourse) {
                $query->where('area', $studentCourse);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            });

        $jobsCount = (clone $jobsQuery)->count();
        $jobsLatest = (clone $jobsQuery)->max('updated_at');

        $applicationsQuery = \App\Models\Application::query()
            ->where('student_id', $user->id);
        $applicationsCount = (clone $applicationsQuery)->count();
        $applicationsLatest = (clone $applicationsQuery)->max('updated_at');

        $notificationsQuery = $user->notifications();
        $notificationsCount = (clone $notificationsQuery)->count();
        $notificationsLatest = (clone $notificationsQuery)->max('updated_at');
        $unreadMessages = \App\Models\Message::query()
            ->where('student_id', $user->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'unread_notifications' => $user->unreadNotifications()->count(),
            'unread_messages' => $unreadMessages,
            'jobs_count' => $jobsCount,
            'jobs_latest_ts' => $jobsLatest ? strtotime((string) $jobsLatest) : 0,
            'applications_count' => $applicationsCount,
            'applications_latest_ts' => $applicationsLatest ? strtotime((string) $applicationsLatest) : 0,
            'notifications_count' => $notificationsCount,
            'notifications_latest_ts' => $notificationsLatest ? strtotime((string) $notificationsLatest) : 0,
        ]);
    })->name('realtime.summary');

    // ✅ Marcar notificação como lida
    Route::post('/notifications/{id}/read', function ($id) {
        auth()->user()
            ->notifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);

        return back();
    })->name('notifications.markAsRead');

    Route::post('/notifications/{notification}/read-and-redirect', function ($notificationId) {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        $status = $notification->data['status'] ?? null;
        $jobId = $notification->data['job_id'] ?? null;

        if ($status === 'finalizado') {
            return redirect()->route('student.jobs.index');
        }

        if ($jobId) {
            $jobExists = \App\Models\Job::query()->whereKey($jobId)->exists();

            if (! $jobExists) {
                return redirect()
                    ->route('student.notifications.index')
                    ->with('error', 'As informações desta vaga foram excluídas e não estão mais disponíveis.');
            }

            return redirect()->route('student.jobs.show', $jobId);
        }

        return redirect()->route('student.notifications.index');
    })->name('notifications.readAndGo');

    // 🗑️ Apagar todas as notificações do aluno
    Route::post('/notifications/clear-all', function () {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'Todas as notificações foram apagadas.');
    })->name('notifications.clearAll');


    });






/*
|--------------------------------------------------------------------------
| Rotas do COORDENADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'coordinator'])
    ->prefix('coordinator')
    ->name('coordinator.')
    ->group(function () {
        Route::get('/calendar', [CoordinatorInternshipCalendarController::class, 'index'])
            ->name('calendar.index');
        Route::get('/calendar/events', [CoordinatorInternshipCalendarController::class, 'events'])
            ->name('calendar.events');
        Route::get('/calendar/hiring-companies', [CoordinatorTopHiringCompanyController::class, 'index'])
            ->name('calendar.hiring-companies.index');
        Route::post('/calendar', [CoordinatorInternshipCalendarController::class, 'store'])
            ->name('calendar.store');
        Route::put('/calendar/{event}', [CoordinatorInternshipCalendarController::class, 'update'])
            ->name('calendar.update');
        Route::delete('/calendar/{event}', [CoordinatorInternshipCalendarController::class, 'destroy'])
            ->name('calendar.destroy');
        Route::post('/calendar/hiring-companies', [CoordinatorTopHiringCompanyController::class, 'store'])
            ->name('calendar.hiring-companies.store');
        Route::put('/calendar/hiring-companies/{company}', [CoordinatorTopHiringCompanyController::class, 'update'])
            ->name('calendar.hiring-companies.update');
        Route::delete('/calendar/hiring-companies/{company}', [CoordinatorTopHiringCompanyController::class, 'destroy'])
            ->name('calendar.hiring-companies.destroy');
    });


/*
|--------------------------------------------------------------------------
| Rotas da EMPRESA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'company'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {

        /*
        | Dashboard da Empresa
        */
        Route::get('/dashboard', [\App\Http\Controllers\Company\DashboardController::class, 'index'])
        ->name('dashboard');


        /*
        | Vagas da Empresa
        */
        Route::get('/jobs', [JobController::class, 'index'])
            ->name('jobs.index');

        Route::get('/jobs/create', [JobController::class, 'create'])
            ->name('jobs.create');

        Route::post('/jobs', [JobController::class, 'store'])
            ->name('jobs.store');

        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
            ->name('jobs.edit');

        Route::put('/jobs/{job}', [JobController::class, 'update'])
            ->name('jobs.update');

        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
            ->name('jobs.destroy');

        /*
        | Candidatos por Vaga
        */
        Route::get('/candidates', [JobCandidateController::class, 'all'])
            ->name('candidates.index');

        Route::get('/jobs/{job}/candidates', [JobCandidateController::class, 'index'])
            ->name('jobs.candidates');

        Route::patch('/applications/{application}/approve', [JobCandidateController::class, 'approve'])
            ->name('applications.approve');

        Route::patch('/applications/{application}/reject', [JobCandidateController::class, 'reject'])
            ->name('applications.reject');

        Route::patch('/applications/{application}/finalize', [JobCandidateController::class, 'finalize'])
            ->name('applications.finalize');

        /*
        | Perfil da Empresa
        */
        Route::get('/profile', [CompanyProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [CompanyProfileController::class, 'update'])
            ->name('profile.update');


             // 📌 Lista de notificações da empresa
        Route::get('/notifications', function () {
            return view('company.notifications.index');
        })->name('notifications.index');

        Route::get('/realtime/summary', function () {
            $user = auth()->user();
            $companyId = $user->company?->id;

            $jobsQuery = \App\Models\Job::query()
                ->where('company_id', $companyId);

            $jobIds = (clone $jobsQuery)->pluck('id');

            $applicationsQuery = \App\Models\Application::query()
                ->whereIn('job_id', $jobIds);

            $unreadMessages = \App\Models\Message::query()
                ->where('company_id', $user->id)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();

            return response()->json([
                'unread_notifications' => $user->unreadNotifications()->count(),
                'unread_messages' => $unreadMessages,
                'dashboard_vagas_ativas' => (clone $jobsQuery)->openForApplications()->count(),
                'dashboard_candidatos' => (clone $applicationsQuery)->count(),
                'dashboard_contratacoes' => (clone $applicationsQuery)->where('status', 'aprovado')->count(),
                'dashboard_em_analise' => (clone $applicationsQuery)->where('status', 'em_analise')->count(),
                'dashboard_jobs_latest_ts' => (($latest = (clone $jobsQuery)->max('updated_at')) ? strtotime((string) $latest) : 0),
                'dashboard_apps_latest_ts' => (($latest = (clone $applicationsQuery)->max('updated_at')) ? strtotime((string) $latest) : 0),
            ]);
        })->name('realtime.summary');

        // ✅ Marcar notificação como lida
        Route::post('/notifications/{id}/read', function ($id) {
            auth()->user()
                ->notifications()
                ->where('id', $id)
                ->update(['read_at' => now()]);

            return back();
        })->name('notifications.markAsRead');




        Route::post('/notifications/{notification}/read-and-redirect', function ($notificationId) {
            $notification = auth()->user()->notifications()->findOrFail($notificationId);
            $notification->markAsRead();

            $jobId = $notification->data['job_id'] ?? null;
            $companyId = auth()->user()->company?->id;

            if (!$jobId || !$companyId) {
                return redirect()
                    ->route('company.notifications.index')
                    ->with('error', 'As informações desta vaga foram excluídas e não estão mais disponíveis.');
            }

            $jobExistsForCompany = \App\Models\Job::query()
                ->whereKey($jobId)
                ->where('company_id', $companyId)
                ->exists();

            if (! $jobExistsForCompany) {
                return redirect()
                    ->route('company.notifications.index')
                    ->with('error', 'As informações desta vaga foram excluídas e não estão mais disponíveis.');
            }

            return redirect()->route(
                'company.jobs.candidates',
                $jobId
            );
        })->name('notifications.readAndGo');

        // 🗑️ Apagar todas as notificações da empresa
        Route::post('/notifications/clear-all', function () {
            auth()->user()->notifications()->delete();

            return back()->with('success', 'Todas as notificações foram apagadas.');
        })->name('notifications.clearAll');



        /*
|--------------------------------------------------------------------------
| CHAT - EMPRESA
|--------------------------------------------------------------------------
*/

        Route::get('/messages', [CompanyChatController::class, 'index'])
    ->name('messages.index');

Route::get('/chat/{job}/{student}', [CompanyChatController::class, 'show'])
    ->name('chat.show');

Route::post('/chat/{job}/{student}', [CompanyChatController::class, 'send'])
    ->name('chat.send');
Route::get('/chat/{job}/{student}/poll', [CompanyChatController::class, 'poll'])
    ->name('chat.poll');


    });






    /*
|--------------------------------------------------------------------------
| CHAT - ALUNO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/messages', [StudentChatController::class, 'index'])
            ->name('messages.index');

        Route::get('/chat/{job}', [StudentChatController::class, 'show'])
            ->name('chat.show');

        Route::post('/chat/{job}', [StudentChatController::class, 'send'])
            ->name('chat.send');
        Route::get('/chat/{job}/poll', [StudentChatController::class, 'poll'])
            ->name('chat.poll');
    });







/*
|--------------------------------------------------------------------------
| Rotas do ADMIN (futuro)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');
        Route::patch('/users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');
        Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])
            ->name('users.toggle');

        Route::get('/companies', [AdminCompanyController::class, 'index'])
            ->name('companies.index');

        Route::get('/students', [AdminStudentController::class, 'index'])
            ->name('students.index');

        Route::get('/coordinators', [AdminInternalRoleController::class, 'coordinators'])
            ->name('coordinators.index');

        Route::get('/admins', [AdminInternalRoleController::class, 'admins'])
            ->name('admins.index');

        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('reports.index');
        Route::get('/reports/users.csv', [AdminReportController::class, 'usersCsv'])
            ->name('reports.users.csv');
        Route::get('/reports/companies.csv', [AdminReportController::class, 'companiesCsv'])
            ->name('reports.companies.csv');
        Route::get('/reports/applications.csv', [AdminReportController::class, 'applicationsCsv'])
            ->name('reports.applications.csv');
    });
});
