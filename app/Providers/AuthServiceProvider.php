<?php

namespace App\Providers;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            if ($user instanceof User) {
                return route('en.auth.change-password.form', ['token' => $token]);
            }
    
            if ($user instanceof Manager) {
                return route('admin.auth.reset-password', ['token' => $token]);
            }
        });
    }
}
