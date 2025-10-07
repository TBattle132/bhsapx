<?php

namespace App\Http\Controllers;

use App\Models\Codeplug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeplugController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $accountId = $user->account_id ?? null;

        $codeplugs = Codeplug::query()
            ->when($accountId, fn($q) => $q->where('account_id', $accountId))
            ->orderBy('name')
            ->paginate(10);

        return view('cp.index', compact('codeplugs'));
    }

    public function create()
    {
        return view('cp.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:191',
            'notes'           => 'nullable|string',
            'ws_url'          => 'required|string|max:191',
            'auth_mode'       => 'required|string|in:SIMPLE,JWT,OAUTH',
            'simple_key'      => 'nullable|string|max:191',
            'default_room'    => 'required|string|max:64',
            'default_volume'  => 'required|integer|min:0|max:100',
            'default_hotkey'  => 'required|string|max:16',
        ]);

        $data['account_id'] = Auth::user()->account_id ?? null;

        Codeplug::create($data);

        return redirect()->route('cp.index')->with('status', 'Codeplug created.');
    }

    public function edit(Codeplug $codeplug)
    {
        return view('cp.edit', compact('codeplug'));
    }

    public function update(Request $request, Codeplug $codeplug)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:191',
            'notes'           => 'nullable|string',
            'ws_url'          => 'required|string|max:191',
            'auth_mode'       => 'required|string|in:SIMPLE,JWT,OAUTH',
            'simple_key'      => 'nullable|string|max:191',
            'default_room'    => 'required|string|max:64',
            'default_volume'  => 'required|integer|min:0|max:100',
            'default_hotkey'  => 'required|string|max:16',
        ]);

        $codeplug->update($data);

        return redirect()->route('cp.index')->with('status', 'Codeplug updated.');
    }

    public function destroy(Codeplug $codeplug)
    {
        $codeplug->delete();

        return redirect()->route('cp.index')->with('status', 'Codeplug deleted.');
    }
}
