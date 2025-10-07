@extends('layouts.bhs', ['title' => 'Codeplugs'])

@section('content')
  <div class="row" style="justify-content:space-between;">
    <h2 style="margin:0">Codeplugs</h2>
    <a class="btn" href="{{ route('cp.create') }}">+ New Codeplug</a>
  </div>

  <table class="table" style="margin-top:12px">
    <thead>
      <tr>
        <th>Name</th>
        <th>Rooms</th>
        <th>Notes</th>
        <th style="width:190px">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($codeplugs as $cp)
        <tr>
          <td>{{ $cp->name }}</td>
          <td><span class="pill">{{ $cp->rooms_count }}</span></td>
          <td class="muted">{{ \Illuminate\Support\Str::limit($cp->notes, 80) }}</td>
          <td>
            <div class="row">
              <a class="btn" href="{{ route('cp.edit', $cp) }}">Edit</a>
              <form method="POST" action="{{ route('cp.destroy', $cp) }}" onsubmit="return confirm('Delete this codeplug?')">
                @csrf @method('DELETE')
                <button class="btn red" type="submit">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">No codeplugs yet.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:10px;">
    {{ $codeplugs->links() }}
  </div>
@endsection
