@extends('layouts.app')
@section('title', 'Matches')

@section('content')
<div class="page-header">
  <div>
    <h1>Matches</h1>
    <p>Schedule and manage all matches</p>
  </div>

  <button class="btn-new"
    onclick="document.getElementById('createMatchModal').classList.remove('hidden')">
    + New Match
  </button>
</div>

<!-- TOOLBAR -->
<form method="GET" action="{{ route('matches.index') }}" class="toolbar">

  <div class="search-box">
    <input
      type="text"
      name="search"
      placeholder="Search by team or venue..."
      value="{{ request('search') }}"
      oninput="this.form.submit()"
    />
  </div>

  <select class="filter-sel" name="status" onchange="this.form.submit()">
    <option value="">All Statuses</option>

    <option value="live"
      {{ request('status') === 'live' ? 'selected' : '' }}>
      Live
    </option>

    <option value="scheduled"
      {{ request('status') === 'scheduled' ? 'selected' : '' }}>
      Scheduled
    </option>

    <option value="completed"
      {{ request('status') === 'completed' ? 'selected' : '' }}>
      Completed
    </option>
  </select>

  <!-- FIXED TOURNAMENT FILTER -->
  <select class="filter-sel" name="tournament" onchange="this.form.submit()">
    <option value="">All Tournaments</option>

    @foreach($tournaments as $t)
      <option
        value="{{ $t->id }}"
        {{ request('tournament') == $t->id ? 'selected' : '' }}>
        {{ $t->name }}
      </option>
    @endforeach
  </select>

  <select class="filter-sel" name="sort" onchange="this.form.submit()">
    <option value="date"
      {{ request('sort','date') === 'date' ? 'selected' : '' }}>
      Sort: Date
    </option>

    <option value="status"
      {{ request('sort') === 'status' ? 'selected' : '' }}>
      Sort: Status
    </option>
  </select>

  @if(request()->hasAny(['search','status','tournament','sort']))
    <a href="{{ route('matches.index') }}" class="btn-clear">
      ✕ Clear
    </a>
  @endif
</form>

<div class="results-count">
  Showing {{ count($matches) }} of {{ $total }} results
</div>

<!-- MATCH GRID -->
<div class="match-grid">

  @forelse($matches as $m)

    <div class="match-card">

      <div class="match-card-top">

        <span class="badge badge-{{ $m->status }}">
          {{ strtoupper($m->status) }}
        </span>

        <div class="match-meta">
          <span>{{ $m->date }}</span>
          <span>{{ $m->time }}</span>
        </div>

        <div class="match-card-btns">

          <button
            class="btn-tbl-edit"
            onclick="document.getElementById('editMatchModal{{ $m->id }}').classList.remove('hidden')">
            ✎
          </button>

          <form
            method="POST"
            action="{{ route('matches.destroy', $m->id) }}"
            onsubmit="return confirm('Delete this match?')">

            @csrf
            @method('DELETE')

            <button class="btn-tbl-del">
              🗑
            </button>
          </form>

        </div>
      </div>

      <div class="score-row">

        <div class="match-team-name">
          {{ $m->team_a }}
        </div>

        <div class="score-center">
          <span class="score-num">{{ $m->score_a }}</span>
          <span class="score-vs">vs</span>
          <span class="score-num">{{ $m->score_b }}</span>
        </div>

        <div class="match-team-name" style="text-align:right">
          {{ $m->team_b }}
        </div>

      </div>

      <div class="match-venue-row">
        {{ $m->venue }}
        ·
        {{ $m->tournament->name ?? '-' }}
      </div>

    </div>

  @empty

    <div class="empty-state" style="grid-column:1/-1">
      <div class="empty-icon">⚡</div>
      <h3>No matches found</h3>
    </div>

  @endforelse

</div>

<!-- CREATE MATCH MODAL -->
<div class="modal-backdrop hidden" id="createMatchModal">

  <div class="modal-box">

    <button
      class="modal-x"
      onclick="document.getElementById('createMatchModal').classList.add('hidden')">
      ✕
    </button>

    <div class="modal-title">
      New Match
    </div>

    <form method="POST" action="{{ route('matches.store') }}">

      @csrf

      @include('partials.match-form', [
        'tournaments' => $tournaments
      ])

      <div class="modal-actions">

        <button
          type="button"
          class="btn-cancel"
          onclick="document.getElementById('createMatchModal').classList.add('hidden')">
          Cancel
        </button>

        <button type="submit" class="btn-submit">
          Create
        </button>

      </div>

    </form>

  </div>

</div>

<!-- EDIT MODALS -->
@foreach($matches as $m)

<div class="modal-backdrop hidden" id="editMatchModal{{ $m->id }}">

  <div class="modal-box">

    <button
      class="modal-x"
      onclick="document.getElementById('editMatchModal{{ $m->id }}').classList.add('hidden')">
      ✕
    </button>

    <div class="modal-title">
      Edit Match
    </div>

    <form method="POST" action="{{ route('matches.update', $m->id) }}">

      @csrf
      @method('PUT')

      @include('partials.match-form', [
        'match' => $m,
        'tournaments' => $tournaments
      ])

      <div class="modal-actions">

        <button
          type="button"
          class="btn-cancel"
          onclick="document.getElementById('editMatchModal{{ $m->id }}').classList.add('hidden')">
          Cancel
        </button>

        <button type="submit" class="btn-submit">
          Update
        </button>

      </div>

    </form>

  </div>

</div>

@endforeach

@endsection

@push('scripts')
<script>
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document
      .querySelectorAll('.modal-backdrop:not(.hidden)')
      .forEach(m => m.classList.add('hidden'));
  }
});
</script>
@endpush