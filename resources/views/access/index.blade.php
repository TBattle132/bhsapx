@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold">Access IDs</h1>
  <a href="{{ route('access.create') }}" class="px-3 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white">New Access ID</a>
</div>

<div class="overflow-hidden rounded border border-slate-700">
  <table class="min-w-full text-sm">
    <thead class="bg-slate-800/60">
      <tr>
        <th class="text-left px-3 py-2">ID</th>
        <th class="text-left px-3 py-2">Label</th>
        <th class="text-left px-3 py-2">Codeplug</th>
        <th class="text-left px-3 py-2">TX</th>
        <th class="text-left px-3 py-2">Active</th>
        <th class="text-left px-3 py-2">Expires</th>
        <th class="text-right px-3 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($accessIds as $a)
      <tr class="border-t border-slate-800">
        <td class="px-3 py-2 font-mono">{{ $a->access_id }}</td>
        <td class="px-3 py-2">{{ $a->label }}</td>
        <td class="px-3 py-2">{{ optional($a->codeplug)->name }}</td>
        <td class="px-3 py-2">{{ $a->tx_allowed ? 'Yes' : 'No' }}</td>
        <td class="px-3 py-2">{{ $a->active ? 'Yes' : 'No' }}</td>
        <td class="px-3 py-2">{{ $a->expires_at?->toDateString() ?? '—' }}</td>
        <td class="px-3 py-2 text-right">
          <a href="{{ route('access.edit', $a) }}" class="px-2 py-1 rounded bg-sky-600 hover:bg-sky-500 text-white">Edit</a>
          <form action="{{ route('access.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Delete this Access ID?')">
            @csrf @method('DELETE')
            <button class="px-2 py-1 rounded bg-red-600 hover:bg-red-500 text-white">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td class="px-3 py-6 text-center text-slate-400" colspan="7">No access IDs yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $accessIds->links() }}</div>
@endsection
