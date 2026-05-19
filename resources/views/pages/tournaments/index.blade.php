@extends('layouts.app')
@section('title', 'Tournaments')

@section('content')
<div class="page-header">
  <div>
    <h1>Tournaments</h1>
    <p>Manage all your tournaments</p>
  </div>
  <button class="btn-new" onclick="openModal()">+ New Tournament</button>
</div>

<!-- Toolbar -->
<form method="GET" action="{{ route('tournaments.index') }}" class="toolbar">
  <div class="search-box">
    <input type="text" name="search" placeholder="Search by name or sport..."
           value="{{ request('search') }}" oninput="this.form.submit()"/>
    @if(request('search'))
      <a href="{{ route('tournaments.index') }}" class="search-clear">✕</a>
    @endif
  </div>

  <select class="filter-sel" name="status" onchange="this.form.submit()">
    <option value="">All Statuses</option>
    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
  </select>

  <select class="filter-sel" name="sport" onchange="this.form.submit()">
    <option value="">All Sports</option>
    @foreach($sports as $sport)
      <option value="{{ $sport }}" {{ request('sport') === $sport ? 'selected' : '' }}>
        {{ $sport }}
      </option>
    @endforeach
  </select>

  <select class="filter-sel" name="sort" onchange="this.form.submit()">
    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Sort: Name</option>
    <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>Sort: Date</option>
    <option value="teams" {{ request('sort') === 'teams' ? 'selected' : '' }}>Sort: Teams</option>
  </select>

  @if(request()->hasAny(['search','status','sport','sort']))
    <a href="{{ route('tournaments.index') }}" class="btn-clear">✕ Clear</a>
  @endif
</form>

<!-- Results -->
<div class="results-count">
  @if($tournaments->count())
    Showing {{ $tournaments->firstItem() }} to {{ $tournaments->lastItem() }} of {{ $tournaments->total() }} results
  @else
    Showing 0 results
  @endif
</div>

<!-- Cards -->
<div class="card-grid">
  @forelse($tournaments as $t)
    <div class="t-card kpi-card"
         onclick="window.location='{{ route('tournaments.show', $t['id']) }}'">

      <div class="t-card-top">
        <div class="t-card-name">🏆 {{ $t['name'] }}</div>
        <span class="badge badge-{{ $t['status'] }}">{{ $t['status'] }}</span>
      </div>

      <div class="t-card-meta">
        <div class="t-meta-item">
          <label>Sport</label>
          <span>{{ $t['sport'] }}</span>
        </div>

        <div></div>

        <div class="t-meta-item">
          <label>Start</label>
          <span>{{ $t['startDate'] }}</span>
        </div>

        <div class="t-meta-item">
          <label>End</label>
          <span>{{ $t['endDate'] }}</span>
        </div>
      </div>

      <div class="t-card-foot">
        <span>Teams: <strong>{{ $t['teams'] }}</strong></span>
        <span>Matches: <strong>{{ $t['matches'] }}</strong></span>
      </div>

      <!-- ACTIONS -->
      <div class="t-card-actions">

        <!-- EDIT -->
        <button class="btn-edit-outline"
                onclick="event.stopPropagation(); openEditTournament({{ $t['id'] }})">
          Edit
        </button>

        <!-- DELETE -->
        <form method="POST"
              action="{{ route('tournaments.destroy', $t['id']) }}"
              onsubmit="event.stopPropagation(); return confirm('Delete this tournament?')">
          @csrf @method('DELETE')
          <button type="submit" class="btn-del-red">
            Delete
          </button>
        </form>

      </div>

    </div>
  @empty
    <div class="empty-state" style="grid-column:1/-1">
      <div class="empty-icon">🏆</div>
      <h3>No tournaments found</h3>
      <p>Try adjusting your filters or add a new tournament</p>
    </div>
  @endforelse
</div>

<!-- Pagination -->
<div style="display:flex; justify-content:flex-end; margin-top:30px;">
  {{ $tournaments->links('vendor.pagination.tailwind') }}
</div>

<!-- Create Modal -->
<div class="modal-backdrop hidden" id="createTournamentModal">
  <div class="modal-box">
    <button class="modal-x" onclick="closeModal('createTournamentModal')">✕</button>
    <div class="modal-title">Create New Tournament</div>
    <form method="POST" action="{{ route('tournaments.store') }}">
      @csrf
      @include('partials.tournament-form')
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeModal('createTournamentModal')">Cancel</button>
        <button type="submit" class="btn-submit">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modals -->
@foreach($tournaments as $t)
<div class="modal-backdrop hidden" id="editTournamentModal{{ $t['id'] }}">
  <div class="modal-box">
    <button class="modal-x" onclick="closeModal('editTournamentModal{{ $t['id'] }}')">✕</button>
    <div class="modal-title">Edit Tournament</div>
    <form method="POST" action="{{ route('tournaments.update', $t['id']) }}">
      @csrf @method('PUT')
      @include('partials.tournament-form', ['tournament' => $t])
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeModal('editTournamentModal{{ $t['id'] }}')">Cancel</button>
        <button type="submit" class="btn-submit">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
function openModal() {
  document.getElementById('createTournamentModal').classList.remove('hidden');
}
function openEditTournament(id) {
  document.getElementById('editTournamentModal' + id).classList.remove('hidden');
}
function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-backdrop:not(.hidden)')
      .forEach(m => m.classList.add('hidden'));
  }
});
</script>
@endpush