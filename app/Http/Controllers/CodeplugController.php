<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessId;

class CodeplugController extends Controller
{
    /**
     * GET /api/codeplug?id=<ACCESS_ID_STRING>
     * Returns the codeplugs/rooms the authenticated user can use via that Access ID.
     */
    public function show(Request $request)
    {
        $accessIdStr = (string) $request->query('id', '');
        if ($accessIdStr === '') {
            return response()->json(['ok' => false, 'error' => 'Missing query parameter: id'], 422);
        }

        $user = $request->user();

        // AccessID must belong to this user and be active
        $access = AccessId::query()
            ->where('access_id', $accessIdStr)
            ->where('user_id', $user->id)
            ->where('active', true)
            ->with(['codeplugs.rooms'])
            ->first();

        if (!$access) {
            return response()->json(['ok' => false, 'error' => 'Access ID not found or not assigned to this user'], 403);
        }

        // Build response including pivot permissions
        $result = $access->codeplugs->map(function ($cp) {
            return [
                'id' => $cp->id,
                'name' => $cp->name,
                'ws_url' => $cp->ws_url,
                'auth_mode' => $cp->auth_mode,
                'default_room' => $cp->default_room,
                'default_volume' => $cp->default_volume,
                'default_hotkey' => $cp->default_hotkey,
                'permissions' => $cp->pivot->permissions ?? null, // array via cast
                'rooms' => $cp->rooms->map(fn ($r) => [
                    'id' => $r->id,
                    'name' => $r->name,
                    'sort' => $r->sort,
                ])->values(),
            ];
        })->values();

        return response()->json([
            'ok' => true,
            'access_id' => $accessIdStr,
            'codeplugs' => $result,
        ]);
    }
}
