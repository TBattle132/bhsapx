<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\AccessId;
use App\Models\Codeplug;

class ClientApiController extends Controller
{
    /**
     * POST /api/v1/auth
     * Body: { "access_id": "1234", "token": "secret-or-empty" }
     * If token empty, issue one (rotates token for that AccessID).
     */
    public function auth(Request $request): JsonResponse
    {
        $data = $request->validate([
            'access_id' => ['required', 'string', 'max:128'],
            'token'     => ['nullable', 'string', 'max:191'],
        ]);

        $access = AccessId::where('access_id', $data['access_id'])->first();

        if (!$access) {
            return response()->json([
                'ok' => false,
                'error' => 'unknown_access_id',
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

        // If client supplied a token, it must match.
        // If no token supplied and none exists, mint one.
        // If no token supplied but one exists, return an error unless you want auto-rotate.
        $incoming = $data['token'] ?? null;

        if ($incoming) {
            if ($access->token !== $incoming) {
                return response()->json([
                    'ok' => false,
                    'error' => 'invalid_token',
                ], 401);
            }
        } else {
            // issue/rotate a token if missing
            if (empty($access->token)) {
                $access->token = Str::random(40);
                $access->save();
            }
        }

        return response()->json([
            'ok' => true,
            'access' => [
                'id'          => $access->id,
                'access_id'   => $access->access_id,
                'label'       => $access->label,
                'active'      => (bool)$access->active,
                'tx_allowed'  => (bool)$access->tx_allowed,
                'expires_at'  => optional($access->expires_at)?->toIso8601String(),
                'codeplug_id' => $access->codeplug_id,
                'account_id'  => $access->account_id,
                'token'       => $access->token, // return current token (new or existing)
            ],
        ]);
    }

    /**
     * GET /api/v1/me  (auth header middleware required)
     */
    public function me(Request $request): JsonResponse
    {
        /** @var \App\Models\AccessId $access */
        $access = $request->attributes->get('access');

        return response()->json([
            'ok' => true,
            'access' => [
                'id'          => $access->id,
                'access_id'   => $access->access_id,
                'label'       => $access->label,
                'active'      => (bool)$access->active,
                'tx_allowed'  => (bool)$access->tx_allowed,
                'expires_at'  => optional($access->expires_at)?->toIso8601String(),
                'codeplug_id' => $access->codeplug_id,
                'account_id'  => $access->account_id,
            ],
        ]);
    }

    /**
     * GET /api/v1/codeplug
     * Returns the codeplug JSON for this AccessID's assigned codeplug.
     */
    public function codeplug(Request $request): JsonResponse
    {
        /** @var \App\Models\AccessId $access */
        $access = $request->attributes->get('access');

        if (!$access->codeplug_id) {
            return response()->json([
                'ok' => false,
                'error' => 'no_codeplug_assigned',
            ], 404);
        }

        $codeplug = Codeplug::where('id', $access->codeplug_id)
            ->where('account_id', $access->account_id) // tenant safety
            ->first();

        if (!$codeplug) {
            return response()->json([
                'ok' => false,
                'error' => 'codeplug_not_found',
            ], 404);
        }

        // Shape a client-friendly payload from your columns
        return response()->json([
            'ok' => true,
            'codeplug' => [
                'id'             => $codeplug->id,
                'name'           => $codeplug->name,
                'default_room'   => $codeplug->default_room,
                'default_volume' => (int)$codeplug->default_volume,
                'default_hotkey' => $codeplug->default_hotkey,
                'ws_url'         => $codeplug->ws_url,
                'auth_mode'      => $codeplug->auth_mode,
                // You can include zones/channels once you build that structure in DB
            ],
        ]);
    }

    /**
     * POST /api/v1/telemetry
     * Body example: { "room":"Dispatch", "volume":70, "mic":0, "state":"IDLE" }
     */
    public function telemetry(Request $request): JsonResponse
    {
        /** @var \App\Models\AccessId $access */
        $access = $request->attributes->get('access');

        $data = $request->validate([
            'room'   => ['nullable', 'string', 'max:64'],
            'volume' => ['nullable', 'integer', 'min:0', 'max:100'],
            'mic'    => ['nullable', 'integer', 'min:0', 'max:100'],
            'state'  => ['nullable', 'string', 'max:32'],
        ]);

        // For now just acknowledge; later you can persist or forward to WS
        return response()->json([
            'ok' => true,
            'received' => $data,
            'access_id' => $access->access_id,
        ]);
    }

    /**
     * POST /api/v1/ptt/start
     * Enforce tx_allowed
     */
    public function pttStart(Request $request): JsonResponse
    {
        /** @var \App\Models\AccessId $access */
        $access = $request->attributes->get('access');

        if (!$access->tx_allowed) {
            return response()->json([
                'ok' => false,
                'error' => 'tx_not_permitted',
            ], 403);
        }

        // TODO: forward to radio broker/WebSocket server
        return response()->json([
            'ok' => true,
            'tx' => 'started',
        ]);
    }

    /**
     * POST /api/v1/ptt/stop
     */
    public function pttStop(Request $request): JsonResponse
    {
        /** @var \App\Models\AccessId $access */
        $access = $request->attributes->get('access');

        // TODO: forward to radio broker/WebSocket server
        return response()->json([
            'ok' => true,
            'tx' => 'stopped',
        ]);
    }
}
