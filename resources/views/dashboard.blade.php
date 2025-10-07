@extends('layouts.app')

@section('content')
  <div class="cards">
    <div class="card card--third">
      <h2>Codeplugs</h2>
      <p class="muted">Create and manage community or org codeplugs used by the APX client.</p>
      <div class="hr"></div>
      <a class="btn primary" href="{{ route('cp.index') }}">Open Codeplugs</a>
    </div>

    <div class="card card--third">
      <h2>Access IDs</h2>
      <p class="muted">Provision Access IDs, tokens and TX permissions for users/devices.</p>
      <div class="hr"></div>
      <a class="btn primary" href="{{ route('access.index') }}">Open Access IDs</a>
    </div>

    <div class="card card--third">
      <h2>Admin</h2>
      <p class="muted">Superuser operations, global controls and system oversight.</p>
      <div class="hr"></div>
      <a class="btn ghost" href="{{ route('admin.index') }}">Open Admin</a>
    </div>
  </div>
@endsection
