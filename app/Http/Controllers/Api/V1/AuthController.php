<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\AccessId;

class AuthController extends Controller
{
    /**
     * POST /api/v1/auth
     * Body JSON: { "access_id": "1321" }
     */
    public function auth(Request $request)
    {
        $v = Validator::make($request->all(), [
            'access_id' => ['required', 'string', 'max:128'],
        ]);

        if ($v->fails()) {
            return response()->json(['message' => 'Invalid request', 'errors' => $v->errors()], 422);
        }

        $access = AccessId::where('access_id', $request->input('access_id'))->first();

        if (!$access) {
            return response()->json(['message' => 'Access ID not found'], 404);
        }

        if (!$access->active) {
            return response()->json(['message' => 'Access ID inactive'], 403);
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return response()->json(['message' => 'Access ID expired'], 403);
        }

        // Issue/refresh token
        $access->token = Str::random(40);
        $access->save();

        return response()->json([
            'token'      => $access->token,
            'expires_at' => $access->expires_at,
        ]);
    }
}
