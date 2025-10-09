<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessId;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * POST /api/v1/auth
     * Body: { "access_id": "1321" }
     * Returns: { "token": "...", "expires_at": "..." }
     */
    public function auth(Request $request)
    {
        $id = trim((string) $request->input('access_id', ''));

        if ($id === '') {
            return response()->json(['error' => 'Missing access_id'], 400);
        }

        $access = AccessId::where('access_id', $id)->first();

        if (!$access || !$access->active) {
            return response()->json(['error' => 'Access ID not recognized or not authorized'], 403);
        }

        // Reuse the existing "token" column and "expires_at" column you already have
        $access->token = Str::random(40);
        // If you want auth to expire independently, feel free to change to a different column later
        $access->expires_at = now()->addHours(12); // adjust as desired
        $access->save();

        return response()->json([
            'token'      => $access->token,
            'expires_at' => $access->expires_at,
        ]);
    }
}
