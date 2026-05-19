@extends('layouts.app')
@section('title', 'Teams')

@section('content')
  <div class="page-header">
    <div>
      <h1>Teams</h1>
      <p>Manage all registered teams</p>
    </div>
    <button class="btn-new" onclick="document.getElementById('createTeamModal').classList.remove('hidden')">+ New Team</button>
  </div>

  <!-- ✅ FIXED: Stat Boxes (numbers right) -->
  <div class="stat-grid stat-grid-3">
    <div class="stat-box" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="stat-box-label">Total Teams</div>
      <div class="stat-box-val" style="text-align:right;">{{ $stats['total'] }}</div>
    </div>

    <div class="stat-box" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="stat-box-label">Total Players</div>
      <div class="stat-box-val" style="text-align:right;">{{ $stats['totalPlayers'] }}</div>
    </div>

    <div class="stat-box" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="stat-box-label">Avg Players per Team</div>
      <div class="stat-box-val" style="text-align:right;">{{ $stats['avgPlayers'] }}</div>
    </div>
  </div>

  <!-- Toolbar -->
  <form method="GET" action="{{ route('teams.index') }}" class="toolbar">
    <div class="search-box">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" name="search" placeholder="Search teams by name..."
             value="{{ request('search') }}" oninput="this.form.submit()"/>
    </div>

    <select class="filter-sel" name="winrate" onchange="this.form.submit()">
      <option value="">All Win Rates</option>
      <option value="high" {{ request('winrate') === 'high' ? 'selected' : '' }}>High (&gt;60%)</option>
      <option value="low"  {{ request('winrate') === 'low'  ? 'selected' : '' }}>Low (&lt;40%)</option>
    </select>

    <select class="filter-sel" name="sort" onchange="this.form.submit()">
      <option value="points" {{ request('sort','points') === 'points' ? 'selected' : '' }}>Sort: Points</option>
      <option value="wins"   {{ request('sort') === 'wins'   ? 'selected' : '' }}>Sort: Wins</option>
      <option value="name"   {{ request('sort') === 'name'   ? 'selected' : '' }}>Sort: Name</option>
    </select>

    @if(request()->hasAny(['search','winrate','sort']))
      <a href="{{ route('teams.index') }}" class="btn-clear">✕ Clear</a>
    @endif
  </form>

  <div class="results-count">Showing {{ count($teams) }} of {{ $total }} results</div>

  <!-- Data Table -->
  <div class="data-card">
    <div class="data-card-head">All Teams</div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="text-align:right">#</th>
          <th>Team Name</th>
          <th style="text-align:right">Players</th>
          <th style="text-align:right">Wins</th>
          <th style="text-align:right">Losses</th>
          <th style="text-align:right">Win Rate</th>
          <th style="text-align:right">Points</th>
          <th style="text-align:right">Actions</th>
        </tr>
      </thead>

      <tbody>
        @forelse($teams as $i => $t)
          @php 
            $wr = ($t['wins'] + $t['losses'] > 0) 
              ? round($t['wins'] / ($t['wins'] + $t['losses']) * 100) 
              : 0; 
          @endphp

          <tr>
            <td style="text-align:right;color:var(--gray-500);font-weight:500">
              {{ $i + 1 }}
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

            <td style="text-align:right">{{ $t['players'] }}</td>

            <td style="text-align:right">
              <span class="stat-g">↗{{ $t['wins'] }}</span>
            </td>

            <td style="text-align:right">
              <span class="stat-r">↘{{ $t['losses'] }}</span>
            </td>

            <td style="text-align:right">{{ $wr }}%</td>

            <td style="text-align:right">
              <strong>{{ $t['points'] }}</strong>
            </td>

            <td style="text-align:right">
              <div class="tbl-actions">
                <button class="btn-tbl-edit"
                        onclick="document.getElementById('editTeamModal{{ $t['id'] }}').classList.remove('hidden')"
                        title="Edit">
                  ✎
                </button>

                <form method="POST"
                      action="{{ route('teams.destroy', $t['id']) }}"
                      style="display:inline"
                      onsubmit="return confirm('Delete this team?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-tbl-del" title="Delete">
                    🗑
                  </button>
                </form>
              </div>
            </td>
          </tr>

        @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h3>No teams found</h3>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Create Modal -->
  <div class="modal-backdrop hidden" id="createTeamModal">
    <div class="modal-box">
      <button class="modal-x" onclick="document.getElementById('createTeamModal').classList.add('hidden')">✕</button>
      <div class="modal-title">Create New Team</div>
      <form method="POST" action="{{ route('teams.store') }}">
        @csrf
        @include('partials.team-form')
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('createTeamModal').classList.add('hidden')">Cancel</button>
          <button type="submit" class="btn-submit">Create</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modals -->
  @foreach($teams as $t)
  <div class="modal-backdrop hidden" id="editTeamModal{{ $t['id'] }}">
    <div class="modal-box">
      <button class="modal-x" onclick="document.getElementById('editTeamModal{{ $t['id'] }}').classList.add('hidden')">✕</button>
      <div class="modal-title">Edit Team</div>
      <form method="POST" action="{{ route('teams.update', $t['id']) }}">
        @csrf @method('PUT')
        @include('partials.team-form', ['team' => $t])
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('editTeamModal{{ $t['id'] }}').classList.add('hidden')">Cancel</button>
          <button type="submit" class="btn-submit">Update</button>
        </div>
      </form>
    </div>
  </div>
  @endforeach
@endsection