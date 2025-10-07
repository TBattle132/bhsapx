@extends('layouts.app')

@section('content')
  <div class="card card--half">
    <h2>New Codeplug</h2>
    <div class="hr"></div>

    <form method="POST" action="{{ route('cp.store') }}">
      @csrf

      <label>Name</label>
      <input type="text" name="name" value="{{ old('name') }}" required>

      <label>WebSocket URL</label>
      <input type="url" name="ws_url" value="{{ old('ws_url','ws://127.0.0.1:5001') }}" required>

      <div class="grid-2">
        <div>
          <label>Auth Mode</label>
          <select name="auth_mode">
            @foreach(['SIMPLE','JWT'] as $m)
              <option value="{{ $m }}" {{ old('auth_mode','SIMPLE')===$m?'selected':'' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>Simple Key (if SIMPLE)</label>
          <input type="text" name="simple_key" value="{{ old('simple_key') }}">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Default Room</label>
          <input type="text" name="default_room" value="{{ old('default_room','Dispatch') }}" required>
        </div>
        <div>
          <label>Default Volume</label>
          <input type="number" min="0" max="100" name="default_volume" value="{{ old('default_volume',70) }}" required>
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Default Hotkey</label>
          <input type="text" name="default_hotkey" value="{{ old('default_hotkey','F9') }}" required>
        </div>
        <div>
          <label>Notes</label>
          <input type="text" name="notes" value="{{ old('notes') }}">
        </div>
      </div>

      <div class="hr"></div>
      <div class="actions">
        <a class="btn ghost" href="{{ route('cp.index') }}">Cancel</a>
        <button class="btn primary" type="submit">Create</button>
      </div>
    </form>
  </div>
@endsection
