<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        view()->composer('*', function ($view)
        {
            $countNotif = 0;
            $notifList = [];

            // Check if there's an authenticated user
            if (Auth::check()) {
                $id = Auth::user()->id;

                $countNotif = Notification::where('users_id', $id)
                    ->where('read', NULL)
                    ->count();

                $notifList = Notification::where('users_id', $id)
                    ->where('read', NULL)
                    ->latest()
                    ->take(5)
                    ->get();
            }

            $view->with('countNotif', $countNotif)
                 ->with('notifList', $notifList);
        });
    }
}
