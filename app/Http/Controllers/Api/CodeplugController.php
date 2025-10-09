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
     * Headers:
     *   X-Access-ID: 1321
     *   X-Access-Token: <token from /api/v1/auth>
     */
    public function index(Request $request)
    {
        $accessId  = $request->header('X-Access-ID');
        $token     = $request->header('X-Access-Token');

        if (!$accessId || !$token) {
            return response()->json(['error' => 'Missing headers'], 400);
        }

        $access = AccessId::where('access_id', $accessId)->first();

        if (!$access || !$access->active) {
            return response()->json(['error' => 'Access not found or inactive'], 403);
        }

        if ($access->token !== $token) {
            return response()->json(['error' => 'Invalid token'], 403);
        }

        if ($access->expires_at && now()->greaterThan($access->expires_at)) {
            return response()->json(['error' => 'Token expired'], 403);
        }

        // Load the codeplug bound to this access row
        $cp = null;
        if ($access->codeplug_id) {
            $cp = Codeplug::find($access->codeplug_id);
        }

        if (!$cp) {
            // Fall back: try any default codeplug (or return 404)
            $cp = Codeplug::orderBy('id', 'asc')->first();
            if (!$cp) {
                return response()->json(['error' => 'No codeplug configured'], 404);
            }
        }

        // Map DB -> JSON the app expects
        // Your columns from earlier messages:
        // codeplugs: ws_url, auth_mode, simple_key, default_room, default_volume, default_hotkey
        // access_ids: tx_allowed
        $payload = [
            'valid'       => true,
            'wsUrl'       => $cp->ws_url,
            'auth'        => [
                'mode'      => $cp->auth_mode,
                'simpleKey' => $cp->simple_key,
            ],
            'pttHotkey'   => $cp->default_hotkey,
            'defaultRoom' => $cp->default_room,
            'canTx'       => (bool) $access->tx_allowed,
            // You can optionally provide a curated list:
            'rooms'       => [$cp->default_room, 'TAC 1', 'TAC 2', 'Dispatch'],
            'volume'      => (int) $cp->default_volume,
            // A radio ID the gateway may also send back later; use something stable-ish:
            'radioId'     => $access->id_value ?? (string)$access->id,
        ];

        return response()->json($payload);
    }
}
