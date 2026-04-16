<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('student.layout', function ($view) {
            $user = Auth::user();

            if (!$user || !$user->isStudent()) {
                return;
            }

            $view->with('studentUnreadNotificationsCount', $user->unreadNotifications()->count());
            $view->with(
                'studentUnreadMessagesCount',
                Message::query()
                    ->where('student_id', $user->id)
                    ->where('sender_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count()
            );
        });

        View::composer('company.layout', function ($view) {
            $user = Auth::user();

            if (!$user || !$user->isCompany()) {
                return;
            }

            $view->with('companyUnreadNotificationsCount', $user->unreadNotifications()->count());
            $view->with(
                'companyUnreadMessagesCount',
                Message::query()
                    ->where('company_id', $user->id)
                    ->where('sender_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count()
            );
        });
    }
}
