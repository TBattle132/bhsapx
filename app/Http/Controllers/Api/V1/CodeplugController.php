<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessId;
use App\Models\Codeplug;

class CodeplugController extends Controller
{
    /**
     * GET /api/v1/codeplug
     * Headers:
     *   X-Access-ID: 1321
     *   X-Access-Token: <token>
     */
    public function show(Request $request)
    {
        $aid   = $request->header('X-Access-ID');
        $token = $request->header('X-Access-Token');

        if (!$aid || !$token) {
            return response()->json(['message' => 'Missing headers'], 400);
        }

        $access = AccessId::where('access_id', $aid)->first();

        if (!$access || $access->token !== $token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$access->active) {
            return response()->json(['message' => 'Access ID inactive'], 403);
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return response()->json(['message' => 'Access ID expired'], 403);
        }

        // Prefer the codeplug referenced by AccessId, else first one
        $codeplug = $access->codeplug_id
            ? Codeplug::find($access->codeplug_id)
            : Codeplug::orderBy('id')->first();

        if (!$codeplug) {
            return response()->json(['message' => 'No codeplug available'], 404);
        }

        return response()->json([
            'valid'        => true,
            'wsUrl'        => $codeplug->ws_url ?? 'ws://127.0.0.1:5001',
            'auth' => [
                'mode'      => $codeplug->auth_mode ?? 'SIMPLE',
                'simpleKey' => $codeplug->simple_key ?? '',
            ],
            'defaultRoom'  => $codeplug->default_room ?? 'Dispatch',
            'pttHotkey'    => $codeplug->default_hotkey ?? 'F9',
            'volume'       => (int)($codeplug->default_volume ?? 70),
            'canTx'        => (bool)($access->tx_allowed ?? false),
            'rooms'        => [
                $codeplug->default_room ?? 'Dispatch',
                'TAC 1',
                'TAC 2',
                'Dispatch',
            ],
            'radioId'      => $access->id_value ?? null,
        ]);
    }
}
