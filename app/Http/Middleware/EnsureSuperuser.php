<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSuperuser
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !$user->is_superuser) {
            abort(403, 'Forbidden');
        }
        return $next($request);
    }
}
