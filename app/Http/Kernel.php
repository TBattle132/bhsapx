<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware aliases.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        // Laravel defaults (keep your existing ones here) ...
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'validated.json' => \Illuminate\Foundation\Http\Middleware\ValidatePrecognitiveRequests::class,

        // Your custom alias
        'ensure.superuser' => \App\Http\Middleware\EnsureSuperuser::class,
    ];
}
\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

