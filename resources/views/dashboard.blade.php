<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>BHS • Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --bg:#0E141A;--card:#111A22;--edge:#0A0F14;--muted:#9AA5B1;--accent:#00D3A7;
    }
    *{box-sizing:border-box;font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif}
    body{margin:0;background:var(--bg);color:#E6E6E6}
    .wrap{max-width:1100px;margin:0 auto;padding:28px}
    .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
    .badge{display:inline-block;background:var(--accent);color:#041216;font-weight:800;padding:3px 10px;border-radius:8px;margin-right:8px}
    .muted{color:var(--muted)}
    .card{background:linear-gradient(#182028,#0F151C);border:1px solid var(--edge);border-radius:16px;padding:22px;box-shadow:0 10px 30px rgba(0,0,0,.35)}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px}
    .tile{display:block;text-decoration:none;color:#EAEAEA;background:#16202A;border:1px solid #27323F;border-radius:12px;padding:16px}
    .tile:hover{background:#1D2935}
    .tile .k{color:#B6C0CA;font-size:13px;margin-bottom:4px}
    .tile .v{font-size:20px;font-weight:700}
    .tile .d{color:#9AA5B1;margin-top:6px;font-size:13px}
    .foot{color:#9AA5B1;font-size:13px;margin-top:16px}
    .ok{color:#6EE7B7}
    .warn{color:#FBBF24}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <div>
        <span class="badge">BHS</span>
        <span class="muted">APX Console</span>
      </div>
      <div class="muted" style="font-size:14px;">
        Signed in as <strong style="color:#EAEAEA">{{ auth()->user()->name ?? 'User' }}</strong>
      </div>
    </div>

    <div class="card">
      <div class="grid">
        <a class="tile" href="{{ route('cp.index') }}">
          <div class="k">Manage</div>
          <div class="v">Codeplugs</div>
          <div class="d">Rooms, ordering, metadata</div>
        </a>

        <a class="tile" href="{{ route('access.index') }}">
          <div class="k">Manage</div>
          <div class="v">Access IDs</div>
          <div class="d">Grant visibility and TX permission</div>
        </a>

        <a class="tile"
           href="{{ route('admin.index') }}"
           @if(!(auth()->user()->is_superuser ?? false)) title="Requires superuser" @endif
           style="@if(auth()->user()->is_superuser ?? false) border-color:#0BAE87;background:#0E2E27; @endif">
          <div class="k">Site</div>
          <div class="v">Admin</div>
          <div class="d">
            @if(auth()->user()->is_superuser ?? false)
              <span class="ok">Superuser access</span>
            @else
              Requires superuser
            @endif
          </div>
        </a>
      </div>

      <div class="foot">
        Need help? <a href="mailto:support@battlehostingsolutions.com" style="color:#00D3A7">Contact BHS</a>
      </div>
    </div>
  </div>
</body>
</html>
