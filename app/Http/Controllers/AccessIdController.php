<?php

namespace App\Http\Controllers;

use App\Models\AccessId;
use App\Models\Codeplug;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class AccessIdController extends Controller
{
    // ⛔️ DO NOT call $this->middleware() here.
    // We attach middleware in routes/web.php instead.

    public function index(Request $request): View
    {
        $user = $request->user();

        $query = AccessId::query()
            ->with(['account', 'codeplug']);

        // Superusers can see all; others only theirs (or their account’s if you prefer)
        if (!$user->is_superuser) {
            $query->where('user_id', $user->id);
        }

        $items = $query->latest()->paginate(15);

        return view('access.index', [
            'items' => $items,
        ]);
    }

    // Stubs (fill out later as needed)
    public function create(): View
    {
        return view('access.create', [
            'codeplugs' => Codeplug::orderBy('name')->get(),
        ]);
    }

    public function edit(AccessId $accessId): View
    {
        return view('access.edit', [
            'item' => $accessId->load(['account', 'codeplug']),
            'codeplugs' => Codeplug::orderBy('name')->get(),
        ]);
    }
}
