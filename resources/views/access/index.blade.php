@extends('layouts.app')

@section('content')
  <div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
      <div>
        <h2>Access IDs</h2>
        <div class="muted">Provision tokens, map to codeplugs, set TX permissions & expirations.</div>
      </div>
      <div>
        <a class="btn primary" href="{{ route('access.create') }}">+ New Access ID</a>
      </div>
    </div>

    <div class="hr"></div>

    <div style="overflow:auto">
      <table>
        <thead>
        <tr>
          <th>Label / Access ID</th>
          <th>Codeplug</th>
          <th>Status</th>
          <th>Permissions</th>
          <th>Expires</th>
          <th style="width:240px">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($accessIds as $a)
          <tr>
            <td>
              <div style="font-weight:700">{{ $a->label ?? '—' }}</div>
              <div class="muted" style="font-size:12px">ID: <strong>{{ $a->access_id }}</strong></div>
              @if($a->notes)
                <div class="muted" style="font-size:12px">{{ \Illuminate\Support\Str::limit($a->notes, 80) }}</div>
              @endif
            </td>
            <td class="muted">{{ $a->codeplug?->name ?? '—' }}</td>
            <td>
              @if($a->active)
                <span class="badge ok">Active</span>
              @else
                <span class="badge">Inactive</span>
              @endif
            </td>
            <td>
              @if($a->tx_allowed)
                <span class="badge ok">TX Allowed</span>
              @else
                <span class="badge danger">TX Blocked</span>
              @endif
            </td>
            <td class="muted">{{ $a->expires_at ? $a->expires_at->toDayDateTimeString() : '—' }}</td>
            <td class="actions">
              <a class="btn" href="{{ route('access.edit', $a) }}">Edit</a>
              <form method="POST" action="{{ route('access.destroy', $a) }}" onsubmit="return confirm('Delete this Access ID?');">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="muted">No access IDs yet.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:12px">
      {{ $accessIds->links() }}
    </div>
  </div>
@endsection
