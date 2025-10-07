@extends('layouts.app')

@section('content')
  <div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
      <div>
        <h2>Codeplugs</h2>
        <div class="muted">Manage codeplug endpoints, defaults and notes.</div>
      </div>
      <div>
        <a class="btn primary" href="{{ route('cp.create') }}">+ New Codeplug</a>
      </div>
    </div>

    <div class="hr"></div>

    <div style="overflow:auto">
      <table>
        <thead>
        <tr>
          <th>Name</th>
          <th>WS URL</th>
          <th>Auth</th>
          <th>Defaults</th>
          <th>Updated</th>
          <th style="width:220px">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($codeplugs as $cp)
          <tr>
            <td>
              <div style="font-weight:700">{{ $cp->name }}</div>
              @if($cp->notes)
                <div class="muted" style="font-size:12px">{{ \Illuminate\Support\Str::limit($cp->notes, 80) }}</div>
              @endif
            </td>
            <td class="muted">{{ $cp->ws_url }}</td>
            <td>
              <span class="badge {{ $cp->auth_mode === 'SIMPLE' ? 'ok' : '' }}">{{ $cp->auth_mode }}</span>
            </td>
            <td class="muted">
              Room: <strong>{{ $cp->default_room }}</strong><br>
              Vol: <strong>{{ $cp->default_volume }}</strong> • Hotkey: <strong>{{ $cp->default_hotkey }}</strong>
            </td>
            <td class="muted">{{ $cp->updated_at?->diffForHumans() }}</td>
            <td class="actions">
              <a class="btn" href="{{ route('cp.edit', $cp) }}">Edit</a>
              <form method="POST" action="{{ route('cp.destroy', $cp) }}" onsubmit="return confirm('Delete this codeplug?');">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="muted">No codeplugs yet.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:12px">
      {{ $codeplugs->links() }}
    </div>
  </div>
@endsection
