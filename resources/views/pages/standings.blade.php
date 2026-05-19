@extends('layouts.app')

@section('title', 'Standings')
@section('page-title', 'Standings')

@section('content')
<div class="page-header">
  <div>
    <h1>Standings</h1>
    <p>Team rankings and statistics</p>
  </div>
</div>

<!-- TOOLBAR — horizontal row -->
<div class="toolbar">
  <div class="search-box">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="standSearch" placeholder="Search teams by name..." oninput="filterStandings()"/>
  </div>
  <select class="filter-sel" id="standSort" onchange="sortStandings(this.value)">
    <option value="points">Sort: Points</option>
    <option value="wins">Sort: Wins</option>
    <option value="name">Sort: Name</option>
  </select>
  <button class="btn-clear" onclick="clearStandingFilters()">✕ Clear</button>
</div>

<div class="results-count">Showing {{ $teams->count() }} teams</div>

<!-- TOP 3 PODIUM CARDS — horizontal 3-column -->
<div class="top3-grid">
  @php $trophies = ['🥇','🥈','🥉']; @endphp
  @foreach($teams->take(3) as $i => $team)
    <div class="top3-card {{ $i === 0 ? 'gold' : '' }}">
      <div class="top3-rank">#{{ $i + 1 }}</div>
      <div class="top3-trophy">{{ $trophies[$i] }}</div>
      <div class="top3-name">{{ $team->name }}</div>
      <div class="top3-pts">{{ $team->points }}</div>
      <div class="top3-wl">
        <span class="stat-g">Wins: {{ $team->wins }}</span>
        <span class="stat-r">Losses: {{ $team->losses }}</span>
      </div>
      <div class="top3-players">Players: {{ $team->players }}</div>
    </div>
  @endforeach
</div>

<!-- TABLE / STATS TABS -->
<div class="stngs-tabs">
  <button class="stngs-tab active" onclick="switchTab(this,'standTableView','standStatsView')">Table View</button>
  <button class="stngs-tab"       onclick="switchTab(this,'standStatsView','standTableView')">Statistics</button>
</div>

<!-- TABLE VIEW -->
<div id="standTableView">
  <div class="data-card">
    <div class="data-card-head">Full Standings</div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Position</th>
          <th>Team</th>
          <th>Played</th>
          <th>Won</th>
          <th>Lost</th>
          <th>Win %</th>
          <th>Points</th>
          <th>Form</th>
        </tr>
      </thead>
      <tbody id="standBody">
        @foreach($teams as $i => $team)
          @php
            $played = $team->wins + $team->losses;
            $winPct = $played > 0 ? round($team->wins / $played * 100) : 0;
            $form   = array_slice(['w','w','l','w','l'], 0, min(5, $played));
          @endphp
          <tr data-name="{{ strtolower($team->name) }}" data-wins="{{ $team->wins }}" data-pts="{{ $team->points }}">
            <td>
              <div style="display:flex;align-items:center;gap:7px">
                <div style="width:26px;height:26px;border-radius:50%;
                  background:{{ $i < 3 ? 'var(--black)' : 'var(--gray-200)' }};
                  color:{{ $i < 3 ? '#fff' : 'var(--gray-600)' }};
                  display:flex;align-items:center;justify-content:center;
                  font-size:11px;font-weight:700;flex-shrink:0">{{ $i + 1 }}</div>
                @if($i < 3)<span style="font-size:16px">{{ $trophies[$i] }}</span>@endif
              </div>
            </td>
            <td><strong>{{ $team->name }}</strong></td>
            <td>{{ $played }}</td>
            <td><span class="stat-g">{{ $team->wins }}</span></td>
            <td><span class="stat-r">{{ $team->losses }}</span></td>
            <td>{{ $winPct }}%</td>
            <td><strong>{{ $team->points }}</strong></td>
            <td>
              <div class="form-bars">
                @foreach($form as $f)
                  <div class="form-bar {{ $f }}"></div>
                @endforeach
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- STATISTICS VIEW -->
<div id="standStatsView" style="display:none">
  <div class="chart-grid">
    <!-- Wins vs Losses Bar Chart -->
    <div class="chart-panel">
      <div class="chart-title">Wins vs Losses by Team</div>
      <div class="bar-chart">
        @php $maxW = max($teams->max('wins'), 1); @endphp
        @foreach($teams as $team)
          <div class="bar-item">
            <div class="bar-stacks">
              <div class="bar green" style="height:{{ max(round($team->wins / $maxW * 90), 2) }}px"></div>
              <div class="bar red"   style="height:{{ max(round($team->losses / $maxW * 90), 2) }}px"></div>
            </div>
            <div class="bar-lbl">{{ explode(' ', $team->name)[0] }}</div>
          </div>
        @endforeach
      </div>
      <div class="chart-legend">
        <div class="legend-item"><div class="legend-dot" style="background:var(--green)"></div>Wins</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--red)"></div>Losses</div>
      </div>
    </div>

    <!-- Win/Loss Pie -->
    <div class="chart-panel">
      <div class="chart-title">Overall Win/Loss Ratio</div>
      @php
        $totW    = $teams->sum('wins');
        $totL    = $teams->sum('losses');
        $totG    = max($totW + $totL, 1);
        $winPct  = round($totW / $totG * 100);
      @endphp
      <div class="pie-wrap">
        <div class="pie-circle"
          style="background:conic-gradient(var(--green) 0% {{ $winPct }}%, var(--red) {{ $winPct }}% 100%)">
        </div>
        <div class="pie-legend">
          <div class="pie-row">
            <div style="display:flex;align-items:center">
              <div class="pie-dot-r" style="background:var(--green)"></div>Wins
            </div>
            <strong style="color:var(--green)">{{ $totW }}</strong>
          </div>
          <div class="pie-row">
            <div style="display:flex;align-items:center">
              <div class="pie-dot-r" style="background:var(--red)"></div>Losses
            </div>
            <strong style="color:var(--red)">{{ $totL }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Summary Stat Boxes — horizontal row of 4 -->
  <div class="summary-grid">
    <div class="summary-box">
      <div class="summary-lbl">Active Tournaments</div>
      <div class="summary-val">{{ $activeTournaments }}</div>
    </div>
    <div class="summary-box">
      <div class="summary-lbl">Total Games Played</div>
      <div class="summary-val">{{ $totG }}</div>
    </div>
    <div class="summary-box">
      <div class="summary-lbl">Average Points</div>
      <div class="summary-val">{{ $teams->count() ? number_format($teams->avg('points'), 1) : 0 }}</div>
    </div>
    <div class="summary-box">
      <div class="summary-lbl">Highest Score</div>
      <div class="summary-val">{{ $highScore }}</div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(btn, showId, hideId) {
  document.querySelectorAll('.stngs-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById(showId).style.display = '';
  document.getElementById(hideId).style.display = 'none';
}
function filterStandings() {
  const search = document.getElementById('standSearch').value.toLowerCase();
  document.querySelectorAll('#standBody tr[data-name]').forEach(row => {
    row.style.display = !search || row.dataset.name.includes(search) ? '' : 'none';
  });
}
function sortStandings(by) {
  const tbody = document.getElementById('standBody');
  const rows  = Array.from(tbody.querySelectorAll('tr[data-name]'));
  rows.sort((a, b) => {
    if (by === 'name')   return a.dataset.name.localeCompare(b.dataset.name);
    if (by === 'wins')   return parseInt(b.dataset.wins) - parseInt(a.dataset.wins);
    return parseInt(b.dataset.pts) - parseInt(a.dataset.pts);
  });
  rows.forEach(r => tbody.appendChild(r));
}
function clearStandingFilters() {
  document.getElementById('standSearch').value = '';
  document.getElementById('standSort').value = 'points';
  filterStandings();
}
</script>
@endpush
