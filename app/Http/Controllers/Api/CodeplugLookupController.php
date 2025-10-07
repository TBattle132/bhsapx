<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessId;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CodeplugLookupController extends Controller
{
    public function showByAccessId(Request $request): JsonResponse
    {
        $access = trim((string) $request->query('id', ''));
        if ($access === '') return response()->json(['message' => 'Missing id'], 422);

        $user = $request->user();  // bearer token user (Sanctum)

        $accessId = AccessId::query()
            ->where('value', $access)
            ->where('is_active', true)
            ->first();

        if (!$accessId) return response()->json(['message' => 'Not found'], 404);

        // superuser sees all; otherwise must be same account
        if (!$user->hasRole('superuser') && $user->account_id !== $accessId->account_id) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $codeplug = $accessId->codeplugs()->with('rooms')->first();
        if (!$codeplug) return response()->json(['message' => 'No codeplug'], 404);

        $pivot = $accessId->codeplugs()->where('codeplug_id', $codeplug->id)->first()->pivot;

        return response()->json([
            'valid'       => true,
            'wsUrl'       => $codeplug->ws_url,
            'auth'        => ['mode' => $codeplug->auth_mode, 'simpleKey' => $codeplug->simple_key],
            'radioId'     => $accessId->radio_id,
            'defaultRoom' => $codeplug->default_room,
            'rooms'       => $codeplug->rooms()->orderBy('name')->pluck('name')->values(),
            'volume'      => (int)$codeplug->volume,
            'pttHotkey'   => $codeplug->ptt_hotkey,
            'canTx'       => (bool)$pivot->can_tx,
        ]);
    }
}
