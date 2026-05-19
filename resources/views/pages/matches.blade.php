@extends('layouts.app')

@section('title', 'Matches')
@section('page-title', 'Matches')

@section('content')
<div class="page-header">
  <div>
    <h1>Matches</h1>
    <p>Schedule and manage all matches</p>
  </div>
  <button class="btn-new" onclick="document.getElementById('matchModal').classList.remove('hidden')">+ New Match</button>
</div>

<!-- TOOLBAR — horizontal row -->
<div class="toolbar">
  <div class="search-box">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="matchSearch" placeholder="Search by team name or venue..." oninput="filterMatches()"/>
  </div>
  <select class="filter-sel" id="matchStatus" onchange="filterMatches()">
    <option value="">All Statuses</option>
    <option value="live">Live</option>
    <option value="scheduled">Scheduled</option>
    <option value="completed">Completed</option>
  </select>
  <select class="filter-sel" id="matchTourn" onchange="filterMatches()">
    <option value="">All Tournaments</option>
    @foreach($tournaments as $t)
      <option value="{{ strtolower($t->name) }}">{{ $t->name }}</option>
    @endforeach
  </select>
  <button class="btn-clear" onclick="clearMatchFilters()">✕ Clear</button>
</div>

<div class="results-count" id="matchCount">
  Showing {{ $matches->count() }} of {{ $matches->count() }} results
</div>

<!-- STATUS TABS — horizontal tabs -->
<div class="match-tabs">
  <button class="match-tab active" onclick="setMatchTab(this, 'all')">All ({{ $matches->count() }})</button>
  <button class="match-tab" onclick="setMatchTab(this, 'live')">Live ({{ $matches->where('status','live')->count() }})</button>
  <button class="match-tab" onclick="setMatchTab(this, 'scheduled')">Scheduled ({{ $matches->where('status','scheduled')->count() }})</button>
  <button class="match-tab" onclick="setMatchTab(this, 'completed')">Completed ({{ $matches->where('status','completed')->count() }})</button>
</div>

<!-- MATCH CARDS GRID — horizontal 3-column layout -->
<div class="match-grid" id="matchGrid">
  @forelse($matches as $match)
    <div class="match-card" data-status="{{ $match->status }}"
         data-teams="{{ strtolower($match->team_a . ' ' . $match->team_b) }}"
         data-venue="{{ strtolower($match->venue) }}"
         data-tournament="{{ strtolower($match->tournament) }}">
      <div class="match-card-top">
        <span class="badge badge-{{ $match->status }}">{{ $match->status === 'live' ? 'LIVE' : strtoupper($match->status) }}</span>
        <div class="match-meta">
          <span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            {{ $match->match_date }}
          </span>
          <span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            {{ $match->match_time }}
          </span>
        </div>
        <div class="match-card-btns">
          <button class="btn-tbl-edit" onclick="openEditMatch({{ $match->id }})" title="Edit">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </button>
          <form method="POST" action="{{ route('matches.destroy', $match->id) }}"
                onsubmit="return confirm('Delete this match?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn-tbl-del" title="Delete">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
              </svg>
            </button>
          </form>
        </div>
      </div>

      <div class="score-row">
        <div class="match-team-name">{{ $match->team_a }}</div>
        @if($match->status !== 'scheduled')
          <div class="score-center">
            <span class="score-num">{{ $match->score_a }}</span>
            <span class="score-vs">vs</span>
            <span class="score-num">{{ $match->score_b }}</span>
          </div>
        @else
          <div class="score-vs" style="font-size:14px;font-weight:600;color:var(--gray-400)">VS</div>
        @endif
        <div class="match-team-name" style="text-align:right">{{ $match->team_b }}</div>
      </div>

      @if($match->venue)
        <div class="match-venue-row">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
          </svg>
          {{ $match->venue }}
        </div>
      @endif
    </div>
  @empty
    <div class="empty-state" style="grid-column:1/-1">
      <div class="empty-icon">⚡</div>
      <h3>No matches found</h3>
      <p>Try adjusting your filters or schedule a new match</p>
    </div>
  @endforelse
</div>

<!-- MATCH MODAL -->
<div class="modal-backdrop hidden" id="matchModal">
  <div class="modal-box">
    <button class="modal-x" onclick="document.getElementById('matchModal').classList.add('hidden')">✕</button>
    <div class="modal-title" id="matchModalTitle">Schedule New Match</div>
    <form method="POST" id="matchForm" action="{{ route('matches.store') }}">
      @csrf
      <input type="hidden" name="_method" id="matchMethod" value="POST"/>
      <div class="form-group">
        <label>Tournament</label>
        <select name="tournament" id="fm_tourn">
          @foreach($tournaments as $t)
            <option value="{{ $t->name }}">{{ $t->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Team A</label>
          <select name="team_a" id="fm_teamA">
            @foreach($teams as $t)
              <option value="{{ $t->name }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Team B</label>
          <select name="team_b" id="fm_teamB">
            @foreach($teams as $t)
              <option value="{{ $t->name }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Score A</label>
          <input type="number" name="score_a" id="fm_scoreA" value="0" min="0"/>
        </div>
        <div class="form-group">
          <label>Score B</label>
          <input type="number" name="score_b" id="fm_scoreB" value="0" min="0"/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Date</label>
          <input type="date" name="match_date" id="fm_date" required/>
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="time" name="match_time" id="fm_time" value="12:00"/>
        </div>
      </div>
      <div class="form-group">
        <label>Venue</label>
        <input type="text" name="venue" id="fm_venue" placeholder="e.g. Main Arena"/>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" id="fm_status">
          <option value="scheduled">Scheduled</option>
          <option value="live">Live</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel"
          onclick="document.getElementById('matchModal').classList.add('hidden')">Cancel</button>
        <button type="submit" class="btn-submit" id="matchSubmitBtn">Schedule</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
let activeTab = 'all';
function setMatchTab(btn, tab) {
  activeTab = tab;
  document.querySelectorAll('.match-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  filterMatches();
}
function filterMatches() {
  const search  = document.getElementById('matchSearch').value.toLowerCase();
  const status  = document.getElementById('matchStatus').value;
  const tourn   = document.getElementById('matchTourn').value;
  const cards   = document.querySelectorAll('.match-card');
  let count = 0;
  cards.forEach(card => {
    const matchTab    = activeTab === 'all' || card.dataset.status === activeTab;
    const matchSearch = !search || card.dataset.teams.includes(search) || card.dataset.venue.includes(search);
    const matchStatus = !status || card.dataset.status === status;
    const matchTourn  = !tourn  || card.dataset.tournament.includes(tourn);
    const show = matchTab && matchSearch && matchStatus && matchTourn;
    card.style.display = show ? '' : 'none';
    if (show) count++;
  });
  document.getElementById('matchCount').textContent = `Showing ${count} results`;
}
function clearMatchFilters() {
  document.getElementById('matchSearch').value = '';
  document.getElementById('matchStatus').value = '';
  document.getElementById('matchTourn').value = '';
  setMatchTab(document.querySelector('.match-tab'), 'all');
}
function openEditMatch(id) {
  fetch(`/matches/${id}/edit-data`)
    .then(r => r.json())
    .then(m => {
      document.getElementById('matchModalTitle').textContent = 'Edit Match';
      document.getElementById('matchMethod').value = 'PUT';
      document.getElementById('matchForm').action = `/matches/${id}`;
      document.getElementById('matchSubmitBtn').textContent = 'Update';
      document.getElementById('fm_tourn').value   = m.tournament;
      document.getElementById('fm_teamA').value   = m.team_a;
      document.getElementById('fm_teamB').value   = m.team_b;
      document.getElementById('fm_scoreA').value  = m.score_a;
      document.getElementById('fm_scoreB').value  = m.score_b;
      document.getElementById('fm_date').value    = m.match_date;
      document.getElementById('fm_time').value    = m.match_time;
      document.getElementById('fm_venue').value   = m.venue;
      document.getElementById('fm_status').value  = m.status;
      document.getElementById('matchModal').classList.remove('hidden');
    });
}
document.getElementById('matchModal').addEventListener('click', function(e) {
  if (e.target === this) this.classList.add('hidden');
});
</script>
@endpush
