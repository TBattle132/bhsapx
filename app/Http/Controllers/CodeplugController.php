<?php

namespace App\Http\Controllers;

use App\Models\Codeplug;
use App\Models\Room;
use Illuminate\Http\Request;

class CodeplugController extends Controller
{
    public function index()
    {
        $u = auth()->user();
        $q = Codeplug::query()->withCount('rooms')->latest();

        if (!($u && method_exists($u,'hasRole') && $u->hasRole('superuser'))) {
            $q->where('account_id', $u->account_id);
        }

        $codeplugs = $q->paginate(12);
        return view('frontend.codeplugs.index', compact('codeplugs'));
    }

    public function create()
    {
        return view('frontend.codeplugs.create');
    }

    public function store(Request $request)
    {
        $u = auth()->user();
        $data = $request->validate([
            'name'  => 'required|string|max:120',
            'notes' => 'nullable|string',
        ]);

        $cp = Codeplug::create([
            'account_id' => ($u && method_exists($u,'hasRole') && $u->hasRole('superuser')) ? ($u->account_id ?? null) : $u->account_id,
            'name'       => $data['name'],
            'notes'      => $data['notes'] ?? null,
        ]);

        return redirect()->route('cp.index')->with('ok', 'Codeplug created.');
    }

    public function edit(Codeplug $codeplug)
    {
        $this->authorizeView($codeplug);
        $rooms = $codeplug->rooms()->get();
        return view('frontend.codeplugs.edit', compact('codeplug','rooms'));
    }

    public function update(Request $request, Codeplug $codeplug)
    {
        $this->authorizeView($codeplug);

        $data = $request->validate([
            'name'  => 'required|string|max:120',
            'notes' => 'nullable|string',
        ]);

        $codeplug->update($data);
        return back()->with('ok','Saved.');
    }

    public function destroy(Codeplug $codeplug)
    {
        $this->authorizeView($codeplug);
        $codeplug->delete();
        return redirect()->route('cp.index')->with('ok','Deleted.');
    }

    private function authorizeView(Codeplug $codeplug): void
    {
        $u = auth()->user();
        if ($u && method_exists($u,'hasRole') && $u->hasRole('superuser')) return;
        if ($u && $codeplug->account_id === $u->account_id) return;
        abort(403);
    }
}
