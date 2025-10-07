<?php

namespace App\Http\Controllers;

use App\Models\Codeplug;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CodeplugController extends Controller
{
    // ⛔️ No $this->middleware() here.

    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Codeplug::query();

        if (!$user->is_superuser) {
            // non-superuser: only see items under their account (adapt as needed)
            $query->where('account_id', $user->account_id ?? 0);
        }

        $items = $query->latest()->paginate(15);

        return view('cp.index', [
            'items' => $items,
        ]);
    }

    public function create(): View
    {
        return view('cp.create');
    }

    public function edit(Codeplug $codeplug): View
    {
        return view('cp.edit', ['item' => $codeplug]);
    }
}
