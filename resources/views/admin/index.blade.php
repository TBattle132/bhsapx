@extends('layouts.app')

@section('content')
  <div class="cards">
    <div class="card card--half">
      <h2>Admin (Superuser)</h2>
      <p class="muted">Global controls & system oversight. More modules coming soon.</p>
      <div class="hr"></div>

      <ul class="muted" style="margin:0; padding-left:16px">
        <li>View all accounts & users</li>
        <li>Audit Access IDs (active / expired / TX permission)</li>
        <li>Codeplug registry across tenants</li>
      </ul>
    </div>

    <div class="card card--half">
      <h2>Brand</h2>
      <p class="muted">BHS dark aesthetic is applied globally.</p>
      <div class="hr"></div>
      <div class="actions">
        <span class="badge ok">#00D3A7</span>
        <span class="badge">#0E141A</span>
        <span class="badge">#0F151B</span>
        <span class="badge">#9AA5B1</span>
        <span class="badge danger">#FF7A00</span>
      </div>
    </div>
  </div>
@endsection
