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
use App\Http\Controllers\Coordinator\InternshipCalendarController as CoordinatorInternshipCalendarController;
use App\Http\Controllers\Coordinator\TopHiringCompanyController as CoordinatorTopHiringCompanyController;

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


    // 📌 Lista de notificações
    Route::get('/notifications', function () {
        return view('student.notifications.index');
    })->name('notifications.index');

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

        if ($jobId) {
            return redirect()->route('student.jobs.show', $jobId);
        }

        return redirect()->route('student.notifications.index');
    })->name('notifications.readAndGo');


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

            return redirect()->route(
                'company.jobs.candidates',
                $notification->data['job_id']
            );
        })->name('notifications.readAndGo');



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
        Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])
            ->name('users.toggle');

        Route::get('/companies', [AdminCompanyController::class, 'index'])
            ->name('companies.index');

        Route::get('/students', [AdminStudentController::class, 'index'])
            ->name('students.index');
    });
});
