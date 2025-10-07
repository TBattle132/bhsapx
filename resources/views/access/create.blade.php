<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>BHS • New Access ID</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--bg:#0E141A;--edge:#0A0F14;--muted:#9AA5B1;--accent:#00D3A7;}
    *{box-sizing:border-box;font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif}
    body{margin:0;background:var(--bg);color:#E6E6E6}
    .wrap{max-width:820px;margin:0 auto;padding:28px}
    .btn{border:1px solid #33404E;background:#1B2330;color:#ECECEC;padding:9px 14px;border-radius:10px;font-weight:700;text-decoration:none}
    .btn:hover{background:#232F3E}
    .field{margin-bottom:12px}
    label{display:block;color:var(--muted);margin-bottom:6px}
    input,select,textarea{width:100%;background:#0B1117;border:1px solid var(--edge);color:#E6E6E6;border-radius:10px;padding:10px}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .badge{display:inline-block;background:var(--accent);color:#041216;font-weight:800;padding:2px 8px;border-radius:8px}
    .err{color:#FCA5A5;font-size:13px;margin-top:6px}
  </style>
</head>
<body>
  <div class="wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px">
      <h2 style="margin:0"><span class="badge">BHS</span> New Access ID</h2>
      <div>
        <a href="{{ route('access.index') }}" class="btn">← Back</a>
      </div>
    </div>

    @if ($errors->any())
      <div class="err">Please fix the errors below.</div>
    @endif

    <form method="POST" action="{{ route('access.store') }}">
      @csrf

      <div class="field">
        <label>Label</label>
        <input name="label" value="{{ old('label') }}" required>
        @error('label') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div class="row">
        <div class="field">
          <label>Token (optional, auto-generated if blank)</label>
          <input name="token" value="{{ old('token') }}">
          @error('token') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div class="field">
          <label>TX Allowed</label>
          <select name="tx_allowed">
            <option value="0" @selected(old('tx_allowed')==='0')>No</option>
            <option value="1" @selected(old('tx_allowed')==='1')>Yes</option>
          </select>
          @error('tx_allowed') <div class="err">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="row">
        <div class="field">
          <label>Codeplug</label>
          <select name="codeplug_id">
            <option value="">— None —</option>
            @foreach ($codeplugs as $cp)
              <option value="{{ $cp->id }}" @selected(old('codeplug_id')==$cp->id)>{{ $cp->name }}</option>
            @endforeach
          </select>
          @error('codeplug_id') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
          <label>Expires At (optional)</label>
          <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}">
          @error('expires_at') <div class="err">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="field">
        <label>Notes</label>
        <textarea name="notes" rows="4">{{ old('notes') }}</textarea>
        @error('notes') <div class="err">{{ $message }}</div> @enderror
      </div>

      <button class="btn" type="submit" style="background:#0E2E27;border-color:#0BAE87">Create</button>
    </form>
  </div>
</body>
</html>
