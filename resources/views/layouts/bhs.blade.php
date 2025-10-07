<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'BHS APX' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root { color-scheme: dark; }
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#0f172a;color:#e5e7eb;margin:0}
    a{color:#93c5fd;text-decoration:none}
    .shell{max-width:1100px;margin:24px auto;padding:0 16px}
    .nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
    .brand{display:flex;align-items:center;gap:10px}
    .brand .badge{background:#00D3A7;color:#052e28;font-weight:800;border-radius:8px;padding:6px 10px}
    .card{background:#111827;border:1px solid #1f2937;border-radius:14px;padding:20px}
    .row{display:flex;flex-wrap:wrap;gap:12px;align-items:center}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;background:#1f2937;color:#e5e7eb;border:0;cursor:pointer}
    .btn:hover{background:#374151}
    .btn.red{background:#7a1e1e}
    .btn.red:hover{background:#8b2323}
    .table{width:100%;border-collapse:separate;border-spacing:0 8px}
    .table th{font-weight:600;color:#aab2c5;text-align:left;padding:6px 10px}
    .table td{background:#0f172a;border:1px solid #1f2937;padding:10px;border-radius:10px}
    .field{display:grid;grid-template-columns:140px 1fr;gap:10px;margin:8px 0}
    input[type=text], textarea, select{background:#0f172a;border:1px solid #1f2937;border-radius:10px;color:#e5e7eb;padding:10px}
    .muted{color:#9aa5b1}
    .pill{display:inline-block;padding:4px 8px;border-radius:999px;background:#172036;border:1px solid #263147}
    .grid{display:grid;gap:12px}
    .grid.two{grid-template-columns:1fr 1fr}
  </style>
  @stack('head')
</head>
<body>
<div class="shell">
  <div class="nav">
    <div class="brand">
      <div class="badge">BHS</div>
      <div class="muted">APX Console</div>
    </div>
    <div class="row">
      <a class="btn" href="{{ route('dashboard') }}">Dashboard</a>
      <a class="btn" href="{{ route('cp.index') }}">Codeplugs</a>
      <a class="btn" href="{{ route('access.index') }}">Access IDs</a>
      @php($u = auth()->user())
      @if($u && method_exists($u,'hasRole') && $u->hasRole('superuser'))
        <a class="btn" href="{{ route('admin.index') }}">Admin</a>
      @endif
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn red" type="submit">Logout</button>
      </form>
    </div>
  </div>

  @if(session('ok'))
    <div class="card" style="margin-bottom:12px;background:#0b2f22;border-color:#1d3f30;color:#c7f0df">
      {{ session('ok') }}
    </div>
  @endif

  <div class="card">
    @yield('content')
  </div>
</div>
@stack('body')
</body>
</html>
