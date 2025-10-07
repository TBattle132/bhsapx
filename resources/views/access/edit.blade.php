@extends('layouts.app')

@section('content')
  <div class="card card--half">
    <h2>Edit Access ID</h2>
    <div class="muted">{{ $access->label ?? '—' }} • {{ $access->access_id }}</div>
    <div class="hr"></div>

    <form method="POST" action="{{ route('access.update', $access) }}">
      @csrf @method('PUT')

      <label>Label</label>
      <input type="text" name="label" value="{{ old('label',$access->label) }}">

      <label>Codeplug</label>
      <select name="codeplug_id">
        <option value="">— None —</option>
        @foreach($codeplugs as $cp)
          <option value="{{ $cp->id }}" {{ (int)old('codeplug_id',$access->codeplug_id)===(int)$cp->id ? 'selected':'' }}>
            {{ $cp->name }}
          </option>
        @endforeach
      </select>

      <div class="grid-2">
        <div>
          <label>Access ID (public)</label>
          <input type="text" name="access_id" value="{{ old('access_id',$access->access_id) }}" required>
        </div>
        <div>
          <label>Token (secret)</label>
          <input type="text" name="token" value="{{ old('token',$access->token) }}">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>ID Value (display on LCD)</label>
          <input type="text" name="id_value" value="{{ old('id_value',$access->id_value) }}" required>
        </div>
        <div>
          <label>Expires At</label>
          <input
            type="text"
            name="expires_at"
            value="{{ old('expires_at', optional($access->expires_at)->format('Y-m-d H:i:s')) }}"
            placeholder="YYYY-MM-DD HH:MM:SS or leave blank"
          >
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Status</label>
          <select name="active">
            @php $activeOld = old('active', (string)$access->active); @endphp
            <option value="1" {{ $activeOld==='1' ? 'selected':'' }}>Active</option>
            <option value="0" {{ $activeOld==='0' ? 'selected':'' }}>Inactive</option>
          </select>
        </div>
        <div>
          <label>TX Allowed</label>
          <select name="tx_allowed">
            @php $txOld = old('tx_allowed', (string)$access->tx_allowed); @endphp
            <option value="1" {{ $txOld==='1' ? 'selected':'' }}>Yes</option>
            <option value="0" {{ $txOld==='0' ? 'selected':'' }}>No</option>
          </select>
        </div>
      </div>

      <label>Notes</label>
      <input type="text" name="notes" value="{{ old('notes',$access->notes) }}">

      <div class="hr"></div>
      <div class="actions">
        <a class="btn ghost" href="{{ route('access.index') }}">Back</a>
        <button class="btn primary" type="submit">Save</button>
      </div>
    </form>
  </div>
@endsection
