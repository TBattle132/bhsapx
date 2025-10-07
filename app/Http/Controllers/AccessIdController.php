<?php

namespace App\Http\Controllers;

use App\Models\AccessId;
use App\Models\Codeplug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessIdController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $accountId = optional($request->user())->account_id;

        $items = AccessId::with(['codeplug'])
            ->where('account_id', $accountId)
            ->latest()
            ->paginate(15);

        $codeplugs = Codeplug::where('account_id', $accountId)
            ->orderBy('name')
            ->get(['id','name']);

        return view('access.index', compact('items', 'codeplugs'));
    }

    public function store(Request $request)
    {
        $accountId = optional($request->user())->account_id;

        $validated = $request->validate([
            'label'       => ['nullable', 'string', 'max:191'],
            'access_id'   => ['required', 'string', 'max:128', 'unique:access_ids,access_id'],
            'id_value'    => ['required', 'string', 'max:191', 'unique:access_ids,id_value'],
            'codeplug_id' => ['nullable', 'exists:codeplugs,id'],
            'active'      => ['nullable', 'boolean'],
            'tx_allowed'  => ['nullable', 'boolean'],
            'expires_at'  => ['nullable', 'date'],
            'notes'       => ['nullable', 'string'],
        ]);

        $validated['account_id'] = $accountId;
        $validated['user_id']    = $request->user()->id;
        $validated['token']      = Str::random(40);
        $validated['active']     = (bool)($validated['active'] ?? true);
        $validated['tx_allowed'] = (bool)($validated['tx_allowed'] ?? false);

        AccessId::create($validated);

        return redirect()->route('access.index')->with('status', 'Access ID created.');
    }

    public function update(Request $request, AccessId $access)
    {
        $this->authorizeRow($request, $access);

        $validated = $request->validate([
            'label'       => ['nullable', 'string', 'max:191'],
            'access_id'   => ['required', 'string', 'max:128', 'unique:access_ids,access_id,' . $access->id],
            'id_value'    => ['required', 'string', 'max:191', 'unique:access_ids,id_value,' . $access->id],
            'codeplug_id' => ['nullable', 'exists:codeplugs,id'],
            'active'      => ['nullable', 'boolean'],
            'tx_allowed'  => ['nullable', 'boolean'],
            'expires_at'  => ['nullable', 'date'],
            'notes'       => ['nullable', 'string'],
        ]);

        $validated['active']     = (bool)($validated['active'] ?? false);
        $validated['tx_allowed'] = (bool)($validated['tx_allowed'] ?? false);

        $access->update($validated);

        return redirect()->route('access.index')->with('status', 'Access ID updated.');
    }

    public function destroy(Request $request, AccessId $access)
    {
        $this->authorizeRow($request, $access);
        $access->delete();
        return redirect()->route('access.index')->with('status', 'Access ID deleted.');
    }

    private function authorizeRow(Request $request, AccessId $row): void
    {
        $accountId = optional($request->user())->account_id;
        abort_unless((int)$row->account_id === (int)$accountId, 403);
    }
}
