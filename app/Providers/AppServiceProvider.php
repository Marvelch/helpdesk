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
            $id = @Auth::user()->id ? Auth::user()->id : 0;
            $count = @Notification::where('users_id',$id)
                                ->where('read',NULL)
                                ->count();

            $notifList = @Notification::where('users_id',$id)
                                ->where('read',NULL)
                                ->latest()
                                ->take(5)
                                ->get();

            $view->with('countNotif', $count)
                 ->with('notifList',$notifList);
        });
    }
}
