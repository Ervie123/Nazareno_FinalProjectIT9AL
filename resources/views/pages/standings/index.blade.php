@extends('layouts.app')
@section('title', 'Standings')

@section('content')
  <div class="page-header">
    <div>
      <h1>Standings</h1>
      <p>Team rankings and statistics</p>
    </div>
  </div>

  <!-- Toolbar -->
  <form method="GET" action="{{ route('standings.index') }}" class="toolbar">
    <div class="search-box">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" name="search" placeholder="Search teams by name..."
             value="{{ request('search') }}" oninput="this.form.submit()"/>
    </div>
    <select class="filter-sel" name="sort" onchange="this.form.submit()">
      <option value="points" {{ request('sort','points') === 'points' ? 'selected' : '' }}>Sort: Points</option>
      <option value="wins"   {{ request('sort') === 'wins'   ? 'selected' : '' }}>Sort: Wins</option>
      <option value="name"   {{ request('sort') === 'name'   ? 'selected' : '' }}>Sort: Name</option>
    </select>
    @if(request()->hasAny(['search','sort']))
      <a href="{{ route('standings.index') }}" class="btn-clear">✕ Clear</a>
    @endif
  </form>

  <div class="results-count">Showing {{ count($teams) }} of {{ count($teams) }} results</div>

  <!-- Top 3 Podium — Horizontal 3-Column -->
  <div class="top3-grid">
    @foreach(array_slice($teams, 0, 3) as $i => $t)
      @php $trophies = ['🥇','🥈','🥉']; @endphp
      <div class="top3-card {{ $i === 0 ? 'gold' : '' }}">
        <div class="top3-rank">#{{ $i + 1 }}</div>
        <div class="top3-trophy">{{ $trophies[$i] }}</div>
        <div class="top3-name">{{ $t['name'] }}</div>
        <div class="top3-pts">{{ $t['points'] }}</div>
        <div class="top3-wl">
          <span class="stat-g">Wins: {{ $t['wins'] }}</span>
          <span class="stat-r">Losses: {{ $t['losses'] }}</span>
        </div>
        <div class="top3-players">Players: {{ $t['players'] }}</div>
      </div>
    @endforeach
  </div>

  <!-- View Tabs -->
  <div class="stngs-tabs">
    <button class="stngs-tab {{ request('view','table') === 'table' ? 'active' : '' }}"
            onclick="switchView('table')">Table View</button>
    <button class="stngs-tab {{ request('view') === 'stats' ? 'active' : '' }}"
            onclick="switchView('stats')">Statistics</button>
  </div>

  <!-- TABLE VIEW -->
  <div id="viewTable" class="{{ request('view','table') !== 'stats' ? '' : 'hidden' }}">
    <div class="data-card">
      <div class="data-card-head">Full Standings</div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Rank</th>
            <th>Team</th>
            <th>Played</th>
            <th>Wins</th>
            <th>Losses</th>
            <th>Win Rate</th>
            <th>Points</th>
            <th>Form</th>
          </tr>
        </thead>
        <tbody>
          @forelse($teams as $i => $t)
            @php $wr = ($t['wins'] + $t['losses'] > 0) ? round($t['wins'] / ($t['wins'] + $t['losses']) * 100) : 0; @endphp
            <tr>
              <td>
                <strong style="{{ $i === 0 ? 'color:var(--yellow)' : '' }}">
                  {{ $i < 3 ? ['🥇','🥈','🥉'][$i] : '#'.($i+1) }}
                </strong>
              </td>
              <td>
                <div class="team-name-cell">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                  </svg>
                  {{ $t['name'] }}
                </div>
              </td>
              <td>{{ $t['wins'] + $t['losses'] }}</td>
              <td><span class="stat-g">↗{{ $t['wins'] }}</span></td>
              <td><span class="stat-r">↘{{ $t['losses'] }}</span></td>
              <td>{{ $wr }}%</td>
              <td><strong>{{ $t['points'] }}</strong></td>
              <td>
                <div class="form-bars">
                  @for($f = 0; $f < min(5, $t['wins'] + $t['losses']); $f++)
                    <div class="form-bar {{ $f < $t['wins'] ? 'w' : 'l' }}"></div>
                  @endfor
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="8">
              <div class="empty-state"><div class="empty-icon">🏅</div><h3>No standings data</h3></div>
            </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- STATISTICS VIEW -->
  <div id="viewStats" class="{{ request('view') === 'stats' ? '' : 'hidden' }}">
    <!-- Summary boxes — Horizontal 4-Column Row -->
    <div class="summary-grid" style="margin-bottom:22px">
      <div class="summary-box">
        <div class="summary-lbl">Total Teams</div>
        <div class="summary-val">{{ count($teams) }}</div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Total Matches</div>
        <div class="summary-val">{{ $matchStats['total'] }}</div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Overall Win %</div>
        <div class="summary-val">{{ $matchStats['winPct'] }}%</div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Avg Points</div>
        <div class="summary-val">{{ $matchStats['avgPts'] }}</div>
      </div>
    </div>

    <!-- Charts — Horizontal 2-Column -->
    <div class="chart-grid">
      <div class="chart-panel">
        <div class="chart-title">Team Points Comparison</div>
        <div class="bar-chart" id="pointsChart">
          @foreach(array_slice($teams, 0, 6) as $t)
            @php $pct = $matchStats['maxPoints'] > 0 ? round($t['points'] / $matchStats['maxPoints'] * 100) : 0; @endphp
            <div class="bar-item">
              <div class="bar-stacks">
                <div class="bar blue" style="height:{{ $pct }}%"></div>
              </div>
              <div class="bar-lbl">{{ Str::limit($t['name'], 8) }}</div>
            </div>
          @endforeach
        </div>
        <div class="chart-legend">
          <div class="legend-item"><div class="legend-dot" style="background:var(--blue)"></div>Points</div>
        </div>
      </div>

      <div class="chart-panel">
        <div class="chart-title">Wins vs Losses</div>
        <div class="bar-chart">
         @foreach(array_slice($teams, 0, 6) as $t)
  @php
    $maxWLArray = array_map(fn($x) => $x['wins'] + $x['losses'], $teams);
    $maxWL = max(count($maxWLArray) ? $maxWLArray : [1]);

    $wp = $maxWL > 0 ? round($t['wins'] / $maxWL * 100) : 0;
    $lp = $maxWL > 0 ? round($t['losses'] / $maxWL * 100) : 0;
  @endphp

  <div class="bar-item">
    <div class="bar-stacks">
      <div class="bar green" style="height:{{ $wp }}%"></div>
      <div class="bar red"   style="height:{{ $lp }}%"></div>
    </div>
    <div class="bar-lbl">{{ Str::limit($t['name'], 8) }}</div>
  </div>
      @endforeach
        </div>
        <div class="chart-legend">
          <div class="legend-item"><div class="legend-dot" style="background:var(--green)"></div>Wins</div>
          <div class="legend-item"><div class="legend-dot" style="background:var(--red)"></div>Losses</div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
function switchView(v) {
  document.getElementById('viewTable').classList.toggle('hidden', v !== 'table');
  document.getElementById('viewStats').classList.toggle('hidden', v !== 'stats');
  document.querySelectorAll('.stngs-tab').forEach((btn, i) => {
    btn.classList.toggle('active', (i === 0 && v === 'table') || (i === 1 && v === 'stats'));
  });
}
</script>
@endpush
