<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>BHS • Access Denied</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --bg:#0E141A; --card:#111A22; --muted:#9AA5B1; --accent:#00D3A7; --danger:#FF7A00; --edge:#0A0F14;
    }
    *{box-sizing:border-box;font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif}
    body{margin:0;background:var(--bg);color:#E6E6E6;display:grid;min-height:100dvh;place-items:center}
    .wrap{width:min(860px,92vw)}
    .card{
      background:linear-gradient(#182028,#0F151C);
      border:1px solid var(--edge);
      border-radius:16px;padding:28px;box-shadow:0 10px 30px rgba(0,0,0,.35);
    }
    .badge{display:inline-block;background:var(--accent);color:#041216;font-weight:800;padding:3px 10px;border-radius:8px;margin-right:8px}
    .title{display:flex;align-items:center;gap:10px;margin:0 0 6px}
    .muted{color:var(--muted)}
    .row{display:flex;gap:14px;flex-wrap:wrap;margin-top:18px}
    .btn{
      appearance:none;border:1px solid #33404E;background:#1B2330;color:#ECECEC;
      padding:10px 16px;border-radius:10px;font-weight:700;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px
    }
    .btn:hover{background:#232F3E}
    .btn-accent{border-color:var(--accent);color:#012119}
    .btn-danger{background:#7A1E1E;border-color:#7A1E1E}
    .sep{height:1px;background:#12202A;margin:18px 0}
    .led{width:12px;height:12px;border-radius:50%;background:var(--danger);box-shadow:0 0 10px var(--danger)}
    .hint{font-size:14px}
    code{background:#0B1117;border:1px solid #0A0F14;padding:2px 6px;border-radius:6px}
  </style>
</head>
<body>
  <main class="wrap">
    <div class="card">
      <h1 class="title">
        <span class="badge">BHS</span>
        Access Denied
        <span class="led" aria-hidden="true"></span>
      </h1>
      <p class="muted">You’re signed in, but your account doesn’t have permission to use the Admin area.</p>

      <div class="sep"></div>

      <div class="row">
        <a class="btn btn-accent" href="{{ route('dashboard') }}">← Back to Dashboard</a>
        <a class="btn" href="{{ url()->previous() }}">⤺ Go Back</a>
        <a class="btn" href="mailto:support@battlehostingsolutions.com?subject=BHS%20APX%20Admin%20Access">Request Access</a>
      </div>

      @auth
        <p class="muted hint" style="margin-top:18px">
          If you believe this is an error, an owner can set your flag:
          <code>users.is_superuser = 1</code>.
        </p>
      @endauth
    </div>
  </main>
</body>
</html>
@extends('layouts.app')

@section('title','Access denied')

@section('content')
<div class="card">
  <h2 style="margin-top:0">403 — Access denied</h2>
  <p class="muted">You don’t have permission to view this page.</p>
  <p class="muted">If you think this is a mistake, contact a BHS superuser.</p>
  <p style="margin-top:10px"><a class="btn" href="{{ route('dashboard') }}">Back to Dashboard</a></p>
</div>
@endsection
