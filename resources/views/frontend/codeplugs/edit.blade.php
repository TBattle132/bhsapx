@extends('layouts.bhs', ['title' => 'Edit Codeplug'])

@section('content')
  <div class="row" style="justify-content:space-between;">
    <h2 style="margin:0">Edit: {{ $codeplug->name }}</h2>
    <a class="btn" href="{{ route('cp.index') }}">← Back</a>
  </div>

  <form method="POST" action="{{ route('cp.update', $codeplug) }}" style="margin-top:12px" class="grid">
    @csrf @method('PUT')
    <div class="field">
      <label>Name</label>
      <input type="text" name="name" required value="{{ old('name',$codeplug->name) }}">
    </div>
    <div class="field">
      <label>Notes</label>
      <textarea name="notes" rows="3">{{ old('notes',$codeplug->notes) }}</textarea>
    </div>
    <div class="row">
      <button class="btn" type="submit">Save</button>
    </div>
  </form>

  <hr style="border:none;border-top:1px solid #1f2937;margin:16px 0">

  <h3>Rooms</h3>
  <form method="POST" action="{{ route('rooms.store', $codeplug) }}" class="row" style="gap:8px;margin:8px 0 12px">
    @csrf
    <input type="text" name="name" placeholder="New room name" required>
    <input type="text" name="order" placeholder="Order (optional)" style="width:160px">
    <button class="btn" type="submit">Add Room</button>
  </form>

  <table class="table">
    <thead><tr><th>Name</th><th>Slug</th><th>Order</th><th style="width:120px">Actions</th></tr></thead>
    <tbody>
      @forelse($rooms as $r)
        <tr>
          <td>{{ $r->name }}</td>
          <td class="muted">{{ $r->slug }}</td>
          <td>{{ $r->order }}</td>
          <td>
            <form method="POST" action="{{ route('rooms.destroy', [$codeplug, $r]) }}" onsubmit="return confirm('Delete this room?')">
              @csrf @method('DELETE')
              <button class="btn red" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="muted">No rooms yet.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
