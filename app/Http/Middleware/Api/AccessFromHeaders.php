<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AccessId;

class AccessFromHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $aid   = trim((string) $request->header('X-Access-ID'));
        $token = trim((string) $request->header('X-Access-Token'));

        if ($aid === '' || $token === '') {
            return response()->json(['ok' => false, 'error' => 'missing_headers'], 401);
        }

        $access = AccessId::where('access_id', $aid)->first();
        if (!$access) {
            return response()->json(['ok' => false, 'error' => 'invalid_access_id'], 401);
        }

        if (!$access->active) {
            return response()->json(['ok' => false, 'error' => 'inactive'], 403);
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return response()->json(['ok' => false, 'error' => 'expired'], 403);
        }

        if (!hash_equals((string)$access->token, (string)$token)) {
            return response()->json(['ok' => false, 'error' => 'invalid_token'], 401);
        }

        // Attach to request for controllers
        $request->attributes->set('access', $access);

        return $next($request);
    }
}
