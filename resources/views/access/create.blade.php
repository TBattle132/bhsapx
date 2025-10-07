@extends('layouts.app')

@section('content')
  <div class="card card--half">
    <h2>New Access ID</h2>
    <div class="hr"></div>

    <form method="POST" action="{{ route('access.store') }}">
      @csrf

      <label>Label</label>
      <input type="text" name="label" value="{{ old('label') }}" placeholder="Dispatcher console, EOC #2…">

      <label>Codeplug</label>
      <select name="codeplug_id">
        <option value="">— None —</option>
        @foreach($codeplugs as $cp)
          <option value="{{ $cp->id }}" {{ old('codeplug_id')==$cp->id?'selected':'' }}>
            {{ $cp->name }}
          </option>
        @endforeach
      </select>

      <div class="grid-2">
        <div>
          <label>Access ID (public)</label>
          <input type="text" name="access_id" value="{{ old('access_id') }}" required>
        </div>
        <div>
          <label>Token (secret)</label>
          <input type="text" name="token" value="{{ old('token') }}" placeholder="Auto if blank">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>ID Value (display on LCD)</label>
          <input type="text" name="id_value" value="{{ old('id_value') }}" required>
        </div>
        <div>
          <label>Expires At</label>
          <input type="text" name="expires_at" value="{{ old('expires_at') }}" placeholder="YYYY-MM-DD HH:MM:SS or leave blank">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Status</label>
          <select name="active">
            <option value="1" {{ old('active','1')==='1'?'selected':'' }}>Active</option>
            <option value="0" {{ old('active')==='0'?'selected':'' }}>Inactive</option>
          </select>
        </div>
        <div>
          <label>TX Allowed</label>
          <select name="tx_allowed">
            <option value="1" {{ old('tx_allowed','0')==='1'?'selected':'' }}>Yes</option>
            <option value="0" {{ old('tx_allowed','0')==='0'?'selected':'' }}>No</option>
          </select>
        </div>
      </div>

      <label>Notes</label>
      <input type="text" name="notes" value="{{ old('notes') }}">

      <div class="hr"></div>
      <div class="actions">
        <a class="btn ghost" href="{{ route('access.index') }}">Cancel</a>
        <button class="btn primary" type="submit">Create</button>
      </div>
    </form>
  </div>
@endsection
