@extends('layouts.app')
@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Codeplug</h1>
<form method="POST" action="{{ route('cp.update', $codeplug) }}" class="grid gap-4 max-w-2xl">
  @csrf @method('PUT')
  <x-input-label>Name</x-input-label>
  <input name="name" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->name }}" required>

  <x-input-label>WS URL</x-input-label>
  <input name="ws_url" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->ws_url }}" required>

  <x-input-label>Auth Mode</x-input-label>
  <select name="auth_mode" class="bg-slate-800 border border-slate-700 rounded px-3 py-2">
    @foreach(['SIMPLE','JWT','OAUTH'] as $m)
      <option value="{{ $m }}" @selected($codeplug->auth_mode === $m)>{{ $m }}</option>
    @endforeach
  </select>

  <x-input-label>Simple Key (optional)</x-input-label>
  <input name="simple_key" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->simple_key }}">

  <div class="grid grid-cols-3 gap-4">
    <div>
      <x-input-label>Default Room</x-input-label>
      <input name="default_room" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->default_room }}" required>
    </div>
    <div>
      <x-input-label>Default Volume</x-input-label>
      <input type="number" min="0" max="100" name="default_volume" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->default_volume }}" required>
    </div>
    <div>
      <x-input-label>Default Hotkey</x-input-label>
      <input name="default_hotkey" class="bg-slate-800 border border-slate-700 rounded px-3 py-2" value="{{ $codeplug->default_hotkey }}" required>
    </div>
  </div>

  <x-input-label>Notes</x-input-label>
  <textarea name="notes" rows="4" class="bg-slate-800 border border-slate-700 rounded px-3 py-2">{{ $codeplug->notes }}</textarea>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white">Update</button>
    <a href="{{ route('cp.index') }}" class="px-4 py-2 rounded bg-slate-700 hover:bg-slate-600">Cancel</a>
  </div>
</form>
@endsection
