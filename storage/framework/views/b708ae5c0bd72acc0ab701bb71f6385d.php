<?php $__env->startSection('title', 'Tournaments'); ?>
<?php $__env->startSection('page-title', 'Tournaments'); ?>

<?php $__env->startSection('topbar-actions'); ?>
  <button class="btn-new" onclick="openModal('create-tournament')">+ New Tournament</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <h1>Tournaments</h1>
    <p>Manage all your tournaments</p>
  </div>
  <button class="btn-new" onclick="openModal('create-tournament')">+ New Tournament</button>
</div>

<!-- FILTERS TOOLBAR — horizontal row -->
<div class="toolbar">
  <div class="search-box">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="tSearch" placeholder="Search by name or sport..."
      oninput="filterTournaments()"/>
    <button class="search-clear" id="tClear" onclick="clearTournamentSearch()">✕</button>
  </div>
  <select class="filter-sel" id="tStatus" onchange="filterTournaments()">
    <option value="">All Statuses</option>
    <option value="upcoming">Upcoming</option>
    <option value="ongoing">Ongoing</option>
    <option value="completed">Completed</option>
  </select>
  <select class="filter-sel" id="tSport" onchange="filterTournaments()">
    <option value="">All Sports</option>
    <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($sport); ?>"><?php echo e($sport); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <select class="filter-sel" id="tSort" onchange="filterTournaments()">
    <option value="name">Sort: Name</option>
    <option value="date">Sort: Date</option>
    <option value="teams">Sort: Teams</option>
  </select>
  <button class="btn-clear" onclick="clearTournamentFilters()">✕ Clear</button>
</div>

<div class="results-count" id="tCount">
  Showing <?php echo e($tournaments->count()); ?> of <?php echo e($total); ?> results
</div>

<!-- CARDS GRID — horizontal 3-column layout -->
<div class="card-grid" id="tGrid">
  <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="t-card" data-name="<?php echo e(strtolower($tournament->name)); ?>"
         data-sport="<?php echo e(strtolower($tournament->sport)); ?>"
         data-status="<?php echo e($tournament->status); ?>">
      <div class="t-card-top">
        <div class="t-card-name">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 9H4.5a2.5 2.5 0 010-5H6"/><path d="M18 9h1.5a2.5 2.5 0 000-5H18"/>
            <path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
            <path d="M18 2H6v7a6 6 0 0012 0V2z"/>
          </svg>
          <?php echo e($tournament->name); ?>

        </div>
        <span class="badge badge-<?php echo e($tournament->status); ?>"><?php echo e(ucfirst($tournament->status)); ?></span>
      </div>

      <div class="t-card-meta">
        <div class="t-meta-item">
          <label>Sport</label>
          <span><?php echo e($tournament->sport); ?></span>
        </div>
        <div></div>
        <div class="t-meta-item">
          <label>Start</label>
          <span><?php echo e($tournament->start_date); ?></span>
        </div>
        <div class="t-meta-item">
          <label>End</label>
          <span><?php echo e($tournament->end_date); ?></span>
        </div>
      </div>

      <div class="t-card-foot">
        <span>Teams: <strong><?php echo e($tournament->teams_count); ?></strong></span>
        <span>Matches: <strong><?php echo e($tournament->matches_count); ?></strong></span>
      </div>

      <div class="t-card-actions">
        <button class="btn-edit-outline" onclick="openEditTournament(<?php echo e($tournament->id); ?>)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit
        </button>
        <form method="POST" action="<?php echo e(route('tournaments.destroy', $tournament->id)); ?>"
              onsubmit="return confirm('Delete this tournament?')" style="display:inline">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button type="submit" class="btn-del-red" title="Delete">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
              <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
              <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
          </button>
        </form>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="grid-column:1/-1">
      <div class="empty-icon">🏆</div>
      <h3>No tournaments found</h3>
      <p>Try adjusting your filters or add a new tournament</p>
    </div>
  <?php endif; ?>
</div>

<!-- CREATE / EDIT MODAL -->
<div class="modal-backdrop hidden" id="tournamentModal">
  <div class="modal-box">
    <button class="modal-x" onclick="closeModal('tournamentModal')">✕</button>
    <div id="tournamentModalBody">
      <div class="modal-title" id="tournamentModalTitle">Create New Tournament</div>
      <form method="POST" id="tournamentForm" action="<?php echo e(route('tournaments.store')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="_method" id="tournamentMethod" value="POST"/>
        <div class="form-group">
          <label>Tournament Name</label>
          <input type="text" name="name" id="f_name" placeholder="e.g. Spring Championship" required/>
        </div>
        <div class="form-group">
          <label>Sport</label>
          <select name="sport" id="f_sport">
            <?php $__currentLoopData = ['Basketball','Soccer','Volleyball','Baseball','Tennis','Badminton','Swimming','Athletics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($sport); ?>"><?php echo e($sport); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" id="f_start" required/>
          </div>
          <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" id="f_end" required/>
          </div>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" id="f_status">
            <option value="upcoming">Upcoming</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Number of Teams</label>
            <input type="number" name="teams_count" id="f_teams" value="8" min="2"/>
          </div>
          <div class="form-group">
            <label>Number of Matches</label>
            <input type="number" name="matches_count" id="f_matches" value="0" min="0"/>
          </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="closeModal('tournamentModal')">Cancel</button>
          <button type="submit" class="btn-submit" id="tournamentSubmitBtn">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openModal(type) {
  if (type === 'create-tournament') {
    document.getElementById('tournamentModalTitle').textContent = 'Create New Tournament';
    document.getElementById('tournamentMethod').value = 'POST';
    document.getElementById('tournamentForm').action = '<?php echo e(route('tournaments.store')); ?>';
    document.getElementById('tournamentSubmitBtn').textContent = 'Create';
    document.getElementById('tournamentForm').reset();
    document.getElementById('tournamentModal').classList.remove('hidden');
  }
}
function openEditTournament(id) {
  fetch(`/tournaments/${id}/edit-data`)
    .then(r => r.json())
    .then(t => {
      document.getElementById('tournamentModalTitle').textContent = 'Edit Tournament';
      document.getElementById('tournamentMethod').value = 'PUT';
      document.getElementById('tournamentForm').action = `/tournaments/${id}`;
      document.getElementById('tournamentSubmitBtn').textContent = 'Update';
      document.getElementById('f_name').value    = t.name;
      document.getElementById('f_sport').value   = t.sport;
      document.getElementById('f_start').value   = t.start_date;
      document.getElementById('f_end').value     = t.end_date;
      document.getElementById('f_status').value  = t.status;
      document.getElementById('f_teams').value   = t.teams_count;
      document.getElementById('f_matches').value = t.matches_count;
      document.getElementById('tournamentModal').classList.remove('hidden');
    });
}
function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
}
function filterTournaments() {
  const search = document.getElementById('tSearch').value.toLowerCase();
  const status = document.getElementById('tStatus').value;
  const sport  = document.getElementById('tSport').value.toLowerCase();
  const cards  = document.querySelectorAll('.t-card');
  let count = 0;
  cards.forEach(card => {
    const matchSearch = !search || card.dataset.name.includes(search) || card.dataset.sport.includes(search);
    const matchStatus = !status || card.dataset.status === status;
    const matchSport  = !sport  || card.dataset.sport === sport;
    const show = matchSearch && matchStatus && matchSport;
    card.style.display = show ? '' : 'none';
    if (show) count++;
  });
  document.getElementById('tCount').textContent = `Showing ${count} of ${cards.length} results`;
}
function clearTournamentSearch() {
  document.getElementById('tSearch').value = '';
  filterTournaments();
}
function clearTournamentFilters() {
  document.getElementById('tSearch').value = '';
  document.getElementById('tStatus').value = '';
  document.getElementById('tSport').value  = '';
  document.getElementById('tSort').value   = 'name';
  filterTournaments();
}
document.getElementById('tournamentModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal('tournamentModal');
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\tournaments.blade.php ENDPATH**/ ?>