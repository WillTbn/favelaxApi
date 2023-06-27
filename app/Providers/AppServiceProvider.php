<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('admin', function(User $user){
            return $user->isAdmin() == 1;
        });
        Gate::define('modelador', function(User $user){
            return $user->isModelador() == 1;
        });
        Gate::define('nvlone', function(User $user){
            return $user->isFinanceOne() == 1;
        });
        Gate::define('nvltwo', function(User $user){
            return $user->isFinanceSecond() == 1;
        });
    }
}
