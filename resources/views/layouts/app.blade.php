<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'BHS • APX Console') }}</title>

  {{-- BHS Brand CSS (no build step required) --}}
  <style>
    :root{
      --bhs-bg:#0E141A;
      --bhs-surface:#0F151B;
      --bhs-surface-2:#121A22;
      --bhs-edge:#0A0F14;
      --bhs-muted:#9AA5B1;
      --bhs-text:#E6EEF7;
      --bhs-accent:#00D3A7;
      --bhs-accent-2:#0E3728;
      --bhs-danger:#FF7A00;
      --bhs-danger-2:#922E00;
      --bhs-amber:#F0C272;
      --glass: rgba(255,255,255,.04);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; background:var(--bhs-bg); color:var(--bhs-text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    }
    a{color:var(--bhs-accent); text-decoration:none}
    a:hover{text-decoration:underline}
    .wrap{min-height:100%}

    /* Top bar */
    .topbar{
      position:sticky; top:0; z-index:50;
      background:linear-gradient(180deg, #182028 0%, #0F151C 100%);
      border-bottom:1px solid var(--bhs-edge);
      box-shadow:0 10px 30px rgba(0,0,0,.25);
    }
    .topbar-inner{
      display:flex; align-items:center; justify-content:space-between;
      max-width:1180px; margin:0 auto; padding:14px 18px;
    }
    .brand{
      display:flex; align-items:center; gap:10px;
      padding:6px 10px; border-radius:12px;
      background:#0B1015; border:1px solid #1F2A36;
    }
    .brand-badge{
      display:inline-block; padding:2px 8px; border-radius:8px;
      background:var(--bhs-accent-2); color:#CFFFEF; font-weight:700; font-size:12px;
      border:1px solid var(--bhs-accent);
    }
    .brand-title{color:var(--bhs-muted); font-weight:600}

    /* Nav */
    .nav{display:flex; align-items:center; gap:8px}
    .nav a, .nav button{
      display:inline-flex; align-items:center; gap:8px;
      padding:8px 12px; border-radius:10px;
      color:var(--bhs-text); border:1px solid #1C2A36; background:#13202A;
    }
    .nav a:hover{background:#1A2A36}
    .nav .active{outline:1px solid var(--bhs-accent); box-shadow:0 0 0 2px rgba(0,211,167,.12) inset}

    /* Logout form button */
    .btn-link{background:#7A1E1E; border-color:#7A1E1E}
    .btn-link:hover{filter:brightness(1.05)}

    /* Container */
    .container{max-width:1180px; margin:24px auto; padding:0 18px}
    .cards{display:grid; grid-template-columns:repeat(12,1fr); gap:16px}
    .card{
      grid-column: span 12;
      background:linear-gradient(180deg,#0F141B 0%,#0B1117 100%);
      border:1px solid var(--bhs-edge);
      border-radius:18px; padding:18px;
      box-shadow:0 10px 40px rgba(0,0,0,.25);
    }
    @media(min-width:900px){ .card--third{grid-column: span 4} .card--half{grid-column: span 6} }
    .card h2{margin:0 0 10px 0; font-size:18px}
    .muted{color:var(--bhs-muted)}
    .hr{height:1px; background:var(--bhs-edge); margin:12px 0}

    /* Table */
    table{width:100%; border-collapse:separate; border-spacing:0}
    th,td{padding:12px; text-align:left}
    thead th{font-size:12px; text-transform:uppercase; letter-spacing:.04em; color:var(--bhs-muted)}
    tbody tr{background:var(--glass)}
    tbody tr+tr{border-top:1px solid var(--bhs-edge)}
    .actions{display:flex; gap:8px; flex-wrap:wrap}

    /* Buttons / Inputs */
    .btn{display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:12px; border:1px solid #1C2A36; background:#13202A; color:var(--bhs-text); cursor:pointer}
    .btn:hover{background:#1A2A36}
    .btn.primary{background:#0E3728; border-color:var(--bhs-accent); color:#CFFFEF}
    .btn.primary:hover{filter:brightness(1.1)}
    .btn.warn{background:#402012; border-color:#7a3b1e; color:#FFD2B3}
    .btn.danger{background:#35150A; border-color:#5d230c; color:#FFBA94}
    .btn.ghost{background:#0F151B; border-color:#1C2A36; color:var(--bhs-muted)}
    .badge{display:inline-flex; align-items:center; padding:2px 8px; border-radius:999px; font-size:12px; border:1px solid #253446; background:#0F1B26}
    .badge.ok{border-color:var(--bhs-accent); color:#CFFFEF}
    .badge.danger{border-color:#FF9A3A; color:#FFDDBA}

    input[type="text"], input[type="number"], input[type="url"], textarea, select{
      width:100%; padding:10px 12px; border-radius:12px;
      border:1px solid #1D2732; background:#0E141A; color:var(--bhs-text)
    }
    textarea{min-height:120px; resize:vertical}
    label{display:block; font-size:12px; text-transform:uppercase; letter-spacing:.04em; color:var(--bhs-muted); margin:12px 0 6px}
    .grid-2{display:grid; gap:16px}
    @media(min-width:900px){ .grid-2{grid-template-columns:1fr 1fr} }

    /* Toast / Status */
    .alert{border:1px solid #203445; background:#1B2C39; color:#D7E0EA; padding:12px 14px; border-radius:12px; margin:0 0 12px}

    /* Footer */
    .foot{padding:24px 18px; color:var(--bhs-muted); text-align:center; border-top:1px solid var(--bhs-edge); margin-top:28px}
  </style>
</head>
<body>
  <div class="wrap">
    {{-- Top bar --}}
    <div class="topbar">
      <div class="topbar-inner">
        <div class="brand">
          <span class="brand-badge">BHS</span>
          <span class="brand-title">APX Console</span>
        </div>
        <nav class="nav">
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('cp.index') }}" class="{{ request()->routeIs('cp.*') ? 'active' : '' }}">Codeplugs</a>
          <a href="{{ route('access.index') }}" class="{{ request()->routeIs('access.*') ? 'active' : '' }}">Access IDs</a>
          <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>

          <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="btn btn-link" title="Sign out">Sign out</button>
          </form>
        </nav>
      </div>
    </div>

    {{-- page --}}
    <div class="container">
      @if(session('status'))
        <div class="alert">{{ session('status') }}</div>
      @endif

      @yield('content')
    </div>

    <div class="foot">
      <small>© {{ date('Y') }} BHS • All rights reserved.</small>
    </div>
  </div>
</body>
</html>
