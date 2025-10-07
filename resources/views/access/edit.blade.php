@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Access ID</h1>
<form method="POST" action="{{ route('access.update', $access) }}" class="grid gap-4 max-w-2xl">
  @csrf @method('PUT')

  <x-input-label>Codeplug</x-input-label>
  <select name="codeplug_id" class="bg-slate-800 border border-slate-700 rounded px-3 py-2">
    @foreach($codeplugs as $cp)
      <option value="{{ $cp->id }}" @selected($access->codeplug_id==$cp->id)>{{ $cp->name }}</option>
    @endforeach
  </select>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <x-input-label>Access ID (human)</x-input-label>
      <input name="access_id" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $access->access_id }}" required>
    </div>
    <div>
      <x-input-label>ID Value (device)</x-input-label>
      <input name="id_value" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $access->id_value }}" required>
    </div>
  </div>

  <x-input-label>Label (optional)</x-input-label>
  <input name="label" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $access->label }}">

  <div class="grid grid-cols-3 gap-4">
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="tx_allowed" value="1" @checked($access->tx_allowed)> <span>TX Allowed</span>
    </label>
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="active" value="1" @checked($access->active)> <span>Active</span>
    </label>
    <div>
      <x-input-label>Expires (optional)</x-input-label>
      <input type="date" name="expires_at" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $access->expires_at?->format('Y-m-d') }}">
    </div>
  </div>

  <x-input-label>Notes</x-input-label>
  <textarea name="notes" rows="4" class="bg-slate-800 border border-slate-700 rounded px-3 py-2">{{ $access->notes }}</textarea>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white">Update</button>
    <a href="{{ route('access.index') }}" class="px-4 py-2 rounded bg-slate-700 hover:bg-slate-600">Cancel</a>
  </div>
</form>
@endsection
