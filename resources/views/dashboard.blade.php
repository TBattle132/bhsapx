@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('cp.index') }}" class="p-6 rounded border border-slate-700 bg-slate-800/40 hover:bg-slate-800">Manage Codeplugs</a>
    <a href="{{ route('access.index') }}" class="p-6 rounded border border-slate-700 bg-slate-800/40 hover:bg-slate-800">Manage Access IDs</a>
    <a href="{{ route('admin.index') }}" class="p-6 rounded border border-slate-700 bg-slate-800/40 hover:bg-slate-800">Admin</a>
  </div>
@endsection
