<?php $__env->startSection('title', 'Teams'); ?>
<?php $__env->startSection('page-title', 'Teams'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <h1>Teams</h1>
    <p>Manage all registered teams</p>
  </div>
  <button class="btn-new" onclick="document.getElementById('teamModal').classList.remove('hidden')">+ New Team</button>
</div>

<!-- 3 STAT BOXES — horizontal row -->
<div class="stat-grid stat-grid-3">

  <a href="<?php echo e(route('teams.index')); ?>" class="stat-box">
    <div class="stat-box-label">Total Teams</div>
    <div class="stat-box-val"><?php echo e($stats['total']); ?></div>
  </a>

  <a href="<?php echo e(route('teams.index')); ?>" class="stat-box">
    <div class="stat-box-label">Total Players</div>
    <div class="stat-box-val"><?php echo e($stats['totalPlayers']); ?></div>
  </a>

  <a href="<?php echo e(route('teams.index')); ?>" class="stat-box">
    <div class="stat-box-label">Avg Players per Team</div>
    <div class="stat-box-val"><?php echo e($stats['avgPlayers']); ?></div>
  </a>

</div>

<!-- TOOLBAR — horizontal row -->
<div class="toolbar">
  <div class="search-box">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="teamSearch" placeholder="Search teams by name..." oninput="filterTeams()"/>
  </div>
  <select class="filter-sel" id="teamWR" onchange="filterTeams()">
    <option value="">All Win Rates</option>
    <option value="high">High (&gt;60%)</option>
    <option value="low">Low (&lt;40%)</option>
  </select>
  <select class="filter-sel" id="teamSort" onchange="sortTeams()">
    <option value="points">Sort: Points</option>
    <option value="wins">Sort: Wins</option>
    <option value="name">Sort: Name</option>
  </select>
  <button class="btn-clear" onclick="clearTeamFilters()">✕ Clear</button>
</div>

<div class="results-count" id="teamCount">
  Showing <?php echo e($teams->count()); ?> of <?php echo e($teams->count()); ?> results
</div>

<!-- DATA TABLE — horizontally scrollable if needed -->
<div class="data-card">
  <div class="data-card-head">All Teams</div>
  <table class="data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Team Name</th>
        <th>Players</th>
        <th>Wins</th>
        <th>Losses</th>
        <th>Win Rate</th>
        <th>Points</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody id="teamBody">
      <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $wr = ($team->wins + $team->losses) > 0
            ? round($team->wins / ($team->wins + $team->losses) * 100) : 0;
        ?>
        <tr data-name="<?php echo e(strtolower($team->name)); ?>" data-wins="<?php echo e($team->wins); ?>"
            data-losses="<?php echo e($team->losses); ?>" data-wr="<?php echo e($wr); ?>">
          <td style="color:var(--gray-500);font-weight:500"><?php echo e($i + 1); ?></td>
          <td>
            <div class="team-name-cell">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
              </svg>
              <?php echo e($team->name); ?>

            </div>
          </td>
          <td><?php echo e($team->players); ?></td>
          <td><span class="stat-g">↗<?php echo e($team->wins); ?></span></td>
          <td><span class="stat-r">↘<?php echo e($team->losses); ?></span></td>
          <td><?php echo e($wr); ?>%</td>
          <td><strong><?php echo e($team->points); ?></strong></td>
          <td>
            <div class="tbl-actions">
              <button class="btn-tbl-edit" onclick="openEditTeam(<?php echo e($team->id); ?>)" title="Edit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                  <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
              </button>
              <form method="POST" action="<?php echo e(route('teams.destroy', $team->id)); ?>"
                    onsubmit="return confirm('Delete this team?')" style="display:inline">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-tbl-del" title="Delete">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                  </svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="8">
          <div class="empty-state"><div class="empty-icon">👥</div><h3>No teams found</h3></div>
        </td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- TEAM MODAL -->
<div class="modal-backdrop hidden" id="teamModal">
  <div class="modal-box">
    <button class="modal-x" onclick="document.getElementById('teamModal').classList.add('hidden')">✕</button>
    <div class="modal-title" id="teamModalTitle">Create New Team</div>
    <form method="POST" id="teamForm" action="<?php echo e(route('teams.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="_method" id="teamMethod" value="POST"/>
      <div class="form-group">
        <label>Team Name</label>
        <input type="text" name="name" id="ft_name" placeholder="e.g. Japan Womens Volleyball" required/>
      </div>
      <div class="form-group">
        <label>Number of Players</label>
        <input type="number" name="players" id="ft_players" value="0" min="0"/>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Wins</label>
          <input type="number" name="wins" id="ft_wins" value="0" min="0"/>
        </div>
        <div class="form-group">
          <label>Losses</label>
          <input type="number" name="losses" id="ft_losses" value="0" min="0"/>
        </div>
      </div>
      <div class="form-group">
        <label>Points</label>
        <input type="number" name="points" id="ft_points" value="0" min="0"/>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel"
          onclick="document.getElementById('teamModal').classList.add('hidden')">Cancel</button>
        <button type="submit" class="btn-submit" id="teamSubmitBtn">Create</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openEditTeam(id) {
  fetch(`/teams/${id}/edit-data`)
    .then(r => r.json())
    .then(t => {
      document.getElementById('teamModalTitle').textContent = 'Edit Team';
      document.getElementById('teamMethod').value = 'PUT';
      document.getElementById('teamForm').action = `/teams/${id}`;
      document.getElementById('teamSubmitBtn').textContent = 'Update';
      document.getElementById('ft_name').value    = t.name;
      document.getElementById('ft_players').value = t.players;
      document.getElementById('ft_wins').value    = t.wins;
      document.getElementById('ft_losses').value  = t.losses;
      document.getElementById('ft_points').value  = t.points;
      document.getElementById('teamModal').classList.remove('hidden');
    });
}
function filterTeams() {
  const search = document.getElementById('teamSearch').value.toLowerCase();
  const wr     = document.getElementById('teamWR').value;
  const rows   = document.querySelectorAll('#teamBody tr[data-name]');
  let count = 0;
  rows.forEach(row => {
    const matchSearch = !search || row.dataset.name.includes(search);
    const wrVal = parseInt(row.dataset.wr) || 0;
    const matchWR = !wr ||
      (wr === 'high' && wrVal > 60) ||
      (wr === 'low' && wrVal < 40);
    const show = matchSearch && matchWR;
    row.style.display = show ? '' : 'none';
    if (show) count++;
  });
  document.getElementById('teamCount').textContent = `Showing ${count} results`;
}
function clearTeamFilters() {
  document.getElementById('teamSearch').value = '';
  document.getElementById('teamWR').value = '';
  filterTeams();
}
document.getElementById('teamModal').addEventListener('click', function(e) {
  if (e.target === this) this.classList.add('hidden');
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\teams.blade.php ENDPATH**/ ?>