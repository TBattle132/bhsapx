@extends('layouts.app')

@section('content')
  <div class="card card--half">
    <h2>Edit Codeplug</h2>
    <div class="muted">{{ $codeplug->name }}</div>
    <div class="hr"></div>

    <form method="POST" action="{{ route('cp.update', $codeplug) }}">
      @csrf @method('PUT')

      <label>Name</label>
      <input type="text" name="name" value="{{ old('name',$codeplug->name) }}" required>

      <label>WebSocket URL</label>
      <input type="url" name="ws_url" value="{{ old('ws_url',$codeplug->ws_url) }}" required>

      <div class="grid-2">
        <div>
          <label>Auth Mode</label>
          <select name="auth_mode">
            @foreach(['SIMPLE','JWT'] as $m)
              <option value="{{ $m }}" {{ old('auth_mode',$codeplug->auth_mode)===$m?'selected':'' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>Simple Key (if SIMPLE)</label>
          <input type="text" name="simple_key" value="{{ old('simple_key',$codeplug->simple_key) }}">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Default Room</label>
          <input type="text" name="default_room" value="{{ old('default_room',$codeplug->default_room) }}" required>
        </div>
        <div>
          <label>Default Volume</label>
          <input type="number" min="0" max="100" name="default_volume" value="{{ old('default_volume',$codeplug->default_volume) }}" required>
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Default Hotkey</label>
          <input type="text" name="default_hotkey" value="{{ old('default_hotkey',$codeplug->default_hotkey) }}" required>
        </div>
        <div>
          <label>Notes</label>
          <input type="text" name="notes" value="{{ old('notes',$codeplug->notes) }}">
        </div>
      </div>

      <div class="hr"></div>
      <div class="actions">
        <a class="btn ghost" href="{{ route('cp.index') }}">Back</a>
        <button class="btn primary" type="submit">Save</button>
      </div>
    </form>
  </div>
@endsection
