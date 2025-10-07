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
     * headers:
     *   X-Access-ID: 1321
     *   X-Access-Token: <token from /auth>
     *
     * returns a shape your WPF app expects
     */
    public function show(Request $request)
    {
        $id    = $request->header('X-Access-ID');
        $token = $request->header('X-Access-Token');

        if (!$id || !$token) {
            return response()->json(['error' => 'Missing headers'], 400);
        }

        $row = AccessId::query()
            ->where('access_id', $id)
            ->where('token', $token)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$row) {
            return response()->json(['valid' => false, 'error' => 'Forbidden'], 403);
        }

        // Load codeplug if linked
        $cp = null;
        if ($row->codeplug_id) {
            $cp = Codeplug::find($row->codeplug_id);
        }

        // Fallbacks if codeplug row missing
        $wsUrl         = $cp->ws_url         ?? 'ws://127.0.0.1:5001';
        $defaultRoom   = $cp->default_room   ?? 'Dispatch';
        $defaultVolume = (int)($cp->default_volume ?? 70);
        $hotkey        = $cp->default_hotkey ?? 'F9';

        // Build rooms list (static for now; adjust if you store zones/channels)
        $rooms = [$defaultRoom, 'TAC 1', 'TAC 2'];

        return response()->json([
            'valid'        => true,
            'wsUrl'        => $wsUrl,
            'canTx'        => (bool)$row->tx_allowed,
            'radioId'      => $row->id_value ?: '—',
            'rooms'        => $rooms,
            'defaultRoom'  => $defaultRoom,
            'volume'       => $defaultVolume,
            'pttHotkey'    => $hotkey,
            'auth' => [
                'mode'      => 'SIMPLE',
                'simpleKey' => $cp->simple_key ?? 'YourSharedKeyHere',
            ],
        ]);
    }
}
