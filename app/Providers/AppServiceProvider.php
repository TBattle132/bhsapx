<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // leave empty for now
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('superuser', function ($user) {
            return (bool) ($user->is_superuser ?? false);
        });
    }
}
