@extends('layouts.bhs', ['title' => 'New Codeplug'])

@section('content')
  <h2 style="margin-top:0">Create Codeplug</h2>
  <form method="POST" action="{{ route('cp.store') }}" class="grid">
    @csrf
    <div class="field">
      <label>Name</label>
      <input type="text" name="name" required value="{{ old('name') }}">
    </div>
    <div class="field">
      <label>Notes</label>
      <textarea name="notes" rows="4">{{ old('notes') }}</textarea>
    </div>
    <div class="row">
      <a class="btn" href="{{ route('cp.index') }}">Cancel</a>
      <button class="btn" type="submit">Save</button>
    </div>
  </form>
@endsection
