<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessId;
use App\Models\Codeplug;

class CodeplugController extends Controller
{
    /**
     * GET /api/v1/codeplug
     * Requires headers:
     *   X-Access-ID: <access_id>
     *   X-Access-Token: <token>  (given by /auth)
     * Response on success:
     * {
     *   "ok": true,
     *   "codeplug": {
     *     "name": "...",
     *     "ws_url": "ws://127.0.0.1:5001",
     *     "default_room": "Dispatch",
     *     "default_volume": 70,
     *     "default_hotkey": "F9",
     *     "rooms": ["Dispatch","TAC 1","TAC 2"]
     *   }
     * }
     */
    public function show(Request $request)
    {
        $aid   = $request->header('X-Access-ID');
        $token = $request->header('X-Access-Token');

        if (!$aid || !$token) {
            return response()->json(['ok' => false, 'error' => 'missing_headers'], 401);
        }

        $access = AccessId::where('access_id', $aid)
            ->where('token', $token)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$access || !$access->codeplug_id) {
            return response()->json(['ok' => false, 'error' => 'not_authorized'], 403);
        }

        $cp = Codeplug::find($access->codeplug_id);
        if (!$cp) {
            return response()->json(['ok' => false, 'error' => 'no_codeplug'], 404);
        }

        return response()->json([
            'ok' => true,
            'codeplug' => [
                'name'           => $cp->name,
                'ws_url'         => $cp->ws_url,
                'default_room'   => $cp->default_room,
                'default_volume' => (int) $cp->default_volume,
                'default_hotkey' => $cp->default_hotkey,
                // Optionally add dynamic rooms pulled from elsewhere:
                'rooms'          => ['Dispatch','TAC 1','TAC 2'],
            ],
        ]);
    }
}
