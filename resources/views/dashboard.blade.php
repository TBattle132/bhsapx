<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>BHS APX — Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#111827;color:#e5e7eb;margin:0}
    .wrap{max-width:960px;margin:40px auto;padding:16px}
    .card{background:#1f2937;border:1px solid #374151;border-radius:12px;padding:20px}
    a{color:#93c5fd}
    .row{display:flex;gap:12px;flex-wrap:wrap;margin-top:12px}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;background:#374151;color:#e5e7eb;text-decoration:none}
    .btn:hover{background:#4b5563}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h1 style="margin:0 0 6px">Dashboard</h1>
      <p style="margin:0 0 12px">Welcome, {{ auth()->user()->name ?? 'user' }}.</p>
      <div class="row">
        <a class="btn" href="{{ url('/cp') }}">Manage Codeplugs</a>
        <a class="btn" href="{{ url('/access') }}">Manage Access IDs</a>
        <a class="btn" href="{{ url('/admin') }}">Admin (superuser)</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
          @csrf
          <button class="btn" type="submit">Logout</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
