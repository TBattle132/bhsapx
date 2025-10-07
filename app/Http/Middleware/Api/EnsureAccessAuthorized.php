<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AccessId;

class EnsureAccessAuthorized
{
    public function handle(Request $request, Closure $next): Response
    {
        // Expect headers:
        // X-Access-ID: <access_ids.access_id>
        // X-Access-Token: <access_ids.token>
        $accessIdValue = $request->header('X-Access-ID');
        $token         = $request->header('X-Access-Token');

        if (!$accessIdValue || !$token) {
            return response()->json([
                'ok' => false,
                'error' => 'missing_credentials',
                'message' => 'X-Access-ID and X-Access-Token headers are required.',
            ], 401);
        }

        $access = AccessId::query()
            ->where('access_id', $accessIdValue)
            ->where('token', $token)
            ->first();

        if (!$access) {
            return response()->json([
                'ok' => false,
                'error' => 'invalid_credentials',
            ], 401);
        }

        if (!$access->active) {
            return response()->json([
                'ok' => false,
                'error' => 'access_inactive',
            ], 403);
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return response()->json([
                'ok' => false,
                'error' => 'access_expired',
            ], 403);
        }

        // Stash for controller use
        $request->attributes->set('access', $access);

        return $next($request);
    }
}
