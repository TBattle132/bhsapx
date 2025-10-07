<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperuser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->is_superuser) {
            // Optional: flash a nice message
            session()->flash('error', 'Access denied: superuser only.');
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
