@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Codeplugs</h1>
  <a href="{{ route('cp.create') }}" class="px-3 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white">New Codeplug</a>
</div>

<div class="overflow-hidden rounded border border-slate-700">
  <table class="min-w-full text-sm">
    <thead class="bg-slate-800/60">
      <tr>
        <th class="text-left px-3 py-2">Name</th>
        <th class="text-left px-3 py-2">WS URL</th>
        <th class="text-left px-3 py-2">Auth</th>
        <th class="text-left px-3 py-2">Defaults</th>
        <th class="text-right px-3 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($codeplugs as $cp)
      <tr class="border-t border-slate-800">
        <td class="px-3 py-2">{{ $cp->name }}</td>
        <td class="px-3 py-2">{{ $cp->ws_url }}</td>
        <td class="px-3 py-2">{{ $cp->auth_mode }}</td>
        <td class="px-3 py-2">
          Room: {{ $cp->default_room }} • Vol: {{ $cp->default_volume }} • Hotkey: {{ $cp->default_hotkey }}
        </td>
        <td class="px-3 py-2 text-right">
          <a href="{{ route('cp.edit', $cp) }}" class="px-2 py-1 rounded bg-sky-600 hover:bg-sky-500 text-white">Edit</a>
          <form action="{{ route('cp.destroy', $cp) }}" method="POST" class="inline" onsubmit="return confirm('Delete this codeplug?')">
            @csrf @method('DELETE')
            <button class="px-2 py-1 rounded bg-red-600 hover:bg-red-500 text-white">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td class="px-3 py-6 text-center text-slate-400" colspan="5">No codeplugs yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $codeplugs->links() }}</div>
@endsection
