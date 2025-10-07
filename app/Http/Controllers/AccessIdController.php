<?php

namespace App\Http\Controllers;

use App\Models\AccessId;
use App\Models\Codeplug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccessIdController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $accountId = $user->account_id ?? null;

        $accessIds = AccessId::query()
            ->when($accountId, fn($q) => $q->where('account_id', $accountId))
            ->with('codeplug')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('access.index', compact('accessIds'));
    }

    public function create()
    {
        $codeplugs = Codeplug::orderBy('name')->get();
        return view('access.create', compact('codeplugs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codeplug_id' => ['required','exists:codeplugs,id'],
            'access_id'   => ['required','string','max:128','unique:access_ids,access_id'],
            'label'       => ['nullable','string','max:191'],
            'id_value'    => ['required','string','max:191','unique:access_ids,id_value'],
            'tx_allowed'  => ['nullable','boolean'],
            'active'      => ['nullable','boolean'],
            'expires_at'  => ['nullable','date'],
            'notes'       => ['nullable','string'],
        ]);

        $data['account_id'] = Auth::user()->account_id ?? null;
        $data['user_id'] = Auth::id();
        $data['token'] = Str::random(40);
        $data['tx_allowed'] = (bool)($data['tx_allowed'] ?? false);
        $data['active'] = (bool)($data['active'] ?? true);

        AccessId::create($data);

        return redirect()->route('access.index')->with('status', 'Access ID created.');
    }

    public function edit(AccessId $access)
    {
        $codeplugs = Codeplug::orderBy('name')->get();
        return view('access.edit', ['access' => $access, 'codeplugs' => $codeplugs]);
    }

    public function update(Request $request, AccessId $access)
    {
        $data = $request->validate([
            'codeplug_id' => ['required','exists:codeplugs,id'],
            'access_id'   => ['required','string','max:128', Rule::unique('access_ids', 'access_id')->ignore($access->id)],
            'label'       => ['nullable','string','max:191'],
            'id_value'    => ['required','string','max:191', Rule::unique('access_ids', 'id_value')->ignore($access->id)],
            'tx_allowed'  => ['nullable','boolean'],
            'active'      => ['nullable','boolean'],
            'expires_at'  => ['nullable','date'],
            'notes'       => ['nullable','string'],
        ]);

        $data['tx_allowed'] = (bool)($data['tx_allowed'] ?? false);
        $data['active'] = (bool)($data['active'] ?? false);

        $access->update($data);

        return redirect()->route('access.index')->with('status', 'Access ID updated.');
    }

    public function destroy(AccessId $access)
    {
        $access->delete();
        return redirect()->route('access.index')->with('status', 'Access ID deleted.');
    }
}
