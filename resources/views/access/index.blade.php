@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl text-gray-200">
  <h1 class="text-xl font-bold mb-4">Access IDs</h1>

  @if(session('status'))
    <div class="p-3 rounded bg-emerald-900/40 border border-emerald-700 mb-4">
      {{ session('status') }}
    </div>
  @endif

  <div class="grid md:grid-cols-2 gap-6">
    <!-- List -->
    <div class="bg-slate-900/60 border border-slate-800 rounded p-4">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-slate-400">
            <th class="text-left py-2">Label</th>
            <th class="text-left py-2">Access ID</th>
            <th class="text-left py-2">Radio ID</th>
            <th class="text-left py-2">Codeplug</th>
            <th class="text-left py-2">Active</th>
            <th class="text-left py-2">TX</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $row)
          <tr class="border-t border-slate-800">
            <td class="py-2">{{ $row->label ?? '—' }}</td>
            <td class="py-2 font-mono">{{ $row->access_id }}</td>
            <td class="py-2 font-mono">{{ $row->id_value }}</td>
            <td class="py-2">{{ optional($row->codeplug)->name ?? '—' }}</td>
            <td class="py-2">{{ $row->active ? 'Yes' : 'No' }}</td>
            <td class="py-2">{{ $row->tx_allowed ? 'Yes' : 'No' }}</td>
            <td class="py-2 text-right">
              <form method="POST" action="{{ route('access.destroy', $row) }}" onsubmit="return confirm('Delete this Access ID?')">
                @csrf @method('DELETE')
                <button class="px-2 py-1 rounded bg-red-800/60 border border-red-700">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="py-6 text-center text-slate-400">No Access IDs yet.</td></tr>
        @endforelse
        </tbody>
      </table>

      <div class="mt-4">
        {{ $items->links() }}
      </div>
    </div>

    <!-- Create -->
    <div class="bg-slate-900/60 border border-slate-800 rounded p-4">
      <h2 class="font-semibold mb-2">Create Access ID</h2>
      <form method="POST" action="{{ route('access.store') }}" class="space-y-3">
        @csrf

        <div>
          <label class="block text-sm text-slate-400">Label</label>
          <input name="label" class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2"
                 placeholder="Dispatcher #1" value="{{ old('label') }}">
          @error('label') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm text-slate-400">Access ID (unique)</label>
            <input name="access_id" required class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2"
                   placeholder="BHS-ALPHA-001" value="{{ old('access_id') }}">
            @error('access_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label class="block text-sm text-slate-400">Radio ID (unique)</label>
            <input name="id_value" required class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2"
                   placeholder="1234567" value="{{ old('id_value') }}">
            @error('id_value') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        <div>
          <label class="block text-sm text-slate-400">Codeplug</label>
          <select name="codeplug_id" class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2">
            <option value="">— None —</option>
            @foreach($codeplugs as $cp)
              <option value="{{ $cp->id }}" @selected(old('codeplug_id')==$cp->id)>{{ $cp->name }}</option>
            @endforeach
          </select>
          @error('codeplug_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="active" value="1" class="accent-emerald-500" {{ old('active', 1) ? 'checked' : '' }}>
            <span>Active</span>
          </label>
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="tx_allowed" value="1" class="accent-emerald-500" {{ old('tx_allowed', 0) ? 'checked' : '' }}>
            <span>TX Allowed</span>
          </label>
        </div>

        <div>
          <label class="block text-sm text-slate-400">Expires At (optional)</label>
          <input type="datetime-local" name="expires_at"
                 class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2"
                 value="{{ old('expires_at') }}">
          @error('expires_at') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm text-slate-400">Notes</label>
          <textarea name="notes" rows="3" class="w-full bg-slate-950/60 border border-slate-800 rounded px-3 py-2"
                    placeholder="Any internal notes…">{{ old('notes') }}</textarea>
          @error('notes') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
          <button class="px-3 py-2 rounded bg-emerald-700 hover:bg-emerald-600">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
