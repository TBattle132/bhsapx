<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessId;

class PttController extends Controller
{
    // Both endpoints require the headers X-Access-ID + X-Access-Token, and that the AccessId is active & not expired.

    public function start(Request $request)
    {
        $access = $this->resolveAccess($request);
        if (!$access) {
            return response()->json(['ok' => false, 'error' => 'not_authorized'], 403);
        }
        if (!$access->tx_allowed) {
            return response()->json(['ok' => false, 'error' => 'tx_not_permitted'], 200);
        }
        // (Optional) Mark TX start in logs/DB/metrics
        return response()->json(['ok' => true]);
    }

    public function stop(Request $request)
    {
        $access = $this->resolveAccess($request);
        if (!$access) {
            return response()->json(['ok' => false, 'error' => 'not_authorized'], 403);
        }
        // (Optional) Mark TX stop
        return response()->json(['ok' => true]);
    }

    private function resolveAccess(Request $request): ?AccessId
    {
        $aid   = $request->header('X-Access-ID');
        $token = $request->header('X-Access-Token');

        if (!$aid || !$token) return null;

        return AccessId::where('access_id', $aid)
            ->where('token', $token)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();
    }
}
