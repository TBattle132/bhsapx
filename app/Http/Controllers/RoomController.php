<?php

namespace App\Http\Controllers;

use App\Models\Codeplug;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function store(Request $request, Codeplug $codeplug)
    {
        $this->authorizeCp($codeplug);

        $data = $request->validate([
            'name'  => 'required|string|max:120',
            'order' => 'nullable|integer|min:0|max:10000',
        ]);

        Room::create([
            'codeplug_id' => $codeplug->id,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::random(5),
            'order' => $data['order'] ?? 0,
        ]);

        return back()->with('ok','Room added.');
    }

    public function destroy(Codeplug $codeplug, Room $room)
    {
        $this->authorizeCp($codeplug);
        if ($room->codeplug_id !== $codeplug->id) abort(404);
        $room->delete();
        return back()->with('ok','Room removed.');
    }

    protected function authorizeCp(Codeplug $codeplug): void
    {
        $u = auth()->user();
        if ($u && method_exists($u,'hasRole') && $u->hasRole('superuser')) return;
        if ($u && $codeplug->account_id === $u->account_id) return;
        abort(403);
    }
}
