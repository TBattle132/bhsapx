@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="mb-3">Your Codeplugs</h1>
  <p>This is a placeholder. You’re logged in as <strong>{{ auth()->user()->name }}</strong>.</p>
  <ul class="mt-3">
    <li>Later: list codeplugs for your account</li>
    <li>Later: create / edit / assign rooms</li>
  </ul>
  <div class="mt-4">
    <a class="btn btn-secondary" href="{{ route('dashboard') }}">← Back to Dashboard</a>
  </div>
</div>
@endsection
