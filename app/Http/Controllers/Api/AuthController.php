<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\AccessId;

class AuthController extends Controller
{
    /**
     * POST /api/v1/auth
     * body: { "access_id": "1321" }
     * returns: { "token": "...", "expires_at": "..." }
     */
    public function auth(Request $request)
    {
        $v = Validator::make($request->all(), [
            'access_id' => ['required','string','max:128'],
        ]);

        if ($v->fails()) {
            return response()->json(['error' => 'Bad request', 'details' => $v->errors()], 422);
        }

        $accessId = $request->input('access_id');

        $row = AccessId::query()
            ->where('access_id', $accessId)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$row) {
            // Not found / inactive / expired
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Issue or reuse a token
        if (empty($row->token)) {
            $row->token = Str::random(48);
        }
        // Optional: rotate token every login
        // $row->token = Str::random(48);

        $row->save();

        // You can set a separate token expiry if you want;
        // here we mirror the row expiry (or 24h if null).
        $expires = $row->expires_at ?? now()->addDay();

        return response()->json([
            'token'      => $row->token,
            'expires_at' => $expires->toISOString()
        ]);
    }
}
