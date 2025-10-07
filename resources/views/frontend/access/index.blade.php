@extends('layouts.bhs', ['title' => 'Access IDs'])

@section('content')
  <div class="row" style="justify-content:space-between;">
    <h2 style="margin:0">Access IDs</h2>
    <span class="muted">Create IDs and link them to Codeplugs (toggle TX permission).</span>
  </div>

  <form method="POST" action="{{ route('access.store') }}" class="grid two" style="margin:12px 0">
    @csrf
    <div class="field">
      <label>Label</label>
      <input type="text" name="label" placeholder="Dispatcher #1">
    </div>
    <div class="field">
      <label>Access ID (unique)</label>
      <input type="text" name="id_value" required>
    </div>
    <div class="field">
      <label>Active</label>
      <select name="active">
        <option value="1" selected>Yes</option>
        <option value="0">No</option>
      </select>
    </div>
    <div class="row">
      <button class="btn" type="submit">Create</button>
    </div>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th>ID Value</th>
        <th>Label</th>
        <th>Linked Codeplugs</th>
        <th style="width:220px">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($accessIds as $a)
        <tr>
          <td><strong>{{ $a->id_value }}</strong> @if(!$a->active)<span class="pill">inactive</span>@endif</td>
          <td class="muted">{{ $a->label }}</td>
          <td>
            @foreach($a->codeplugs as $cp)
              <div class="row" style="gap:6px;margin:4px 0">
                <span class="pill">{{ $cp->name }}</span>
                <form method="POST" action="{{ route('access.detach', [$a, $cp]) }}">
                  @csrf @method('DELETE')
                  <button class="btn red" type="submit">Unlink</button>
                </form>
                <span class="muted">TX:</span>
                <form method="POST" action="{{ route('access.attach', $a) }}">
                  @csrf
                  <input type="hidden" name="codeplug_id" value="{{ $cp->id }}">
                  <input type="hidden" name="can_tx" value="{{ $a->pivot->can_tx ? 0 : 1 }}">
                  <button class="btn" type="submit">{{ $a->pivot->can_tx ? 'Disable' : 'Enable' }}</button>
                </form>
              </div>
            @endforeach

            <form method="POST" action="{{ route('access.attach', $a) }}" class="row" style="gap:6px;margin-top:8px">
              @csrf
              <select name="codeplug_id" required>
                <option value="">Select codeplug…</option>
                @foreach($codeplugs as $cp)
                  @if(!$a->codeplugs->contains('id',$cp->id))
                    <option value="{{ $cp->id }}">{{ $cp->name }}</option>
                  @endif
                @endforeach
              </select>
              <label style="display:flex;align-items:center;gap:8px">
                <input type="checkbox" name="can_tx" value="1"> TX allowed
              </label>
              <button class="btn" type="submit">Link</button>
            </form>
          </td>
          <td>
            <form method="POST" action="{{ route('access.destroy', $a) }}" onsubmit="return confirm('Delete this Access ID?')">
              @csrf @method('DELETE')
              <button class="btn red" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">No Access IDs yet.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:10px;">
    {{ $accessIds->links() }}
  </div>
@endsection
