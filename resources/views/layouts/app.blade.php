<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BHS • APX Admin</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100">
  <nav class="bg-slate-800/60 backdrop-blur border-b border-slate-700">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex gap-6 items-center">
        <span class="px-2 py-1 rounded bg-emerald-500/20 text-emerald-300 font-bold">BHS</span>
        <a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a>
        <a href="{{ route('cp.index') }}" class="hover:text-white">Codeplugs</a>
        <a href="{{ route('access.index') }}" class="hover:text-white">Access IDs</a>
        <a href="{{ route('admin.index') }}" class="hover:text-white">Admin</a>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="px-3 py-1.5 rounded bg-slate-700 hover:bg-slate-600">Log out</button>
      </form>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto p-6">
    @if (session('status'))
      <div class="mb-4 rounded bg-emerald-700/30 border border-emerald-600 px-3 py-2 text-emerald-200">
        {{ session('status') }}
      </div>
    @endif
    @if (session('error'))
      <div class="mb-4 rounded bg-red-700/30 border border-red-600 px-3 py-2 text-red-200">
        {{ session('error') }}
      </div>
    @endif
    @yield('content')
  </main>
</body>
</html>
