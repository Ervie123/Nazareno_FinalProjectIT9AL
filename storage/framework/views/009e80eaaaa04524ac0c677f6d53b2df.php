<?php $__env->startSection('title', 'Tournaments'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <h1>Tournaments</h1>
    <p>Manage all your tournaments</p>
  </div>
  <button class="btn-new" onclick="openModal()">+ New Tournament</button>
</div>

<!-- Toolbar -->
<form method="GET" action="<?php echo e(route('tournaments.index')); ?>" class="toolbar">
  <div class="search-box">
    <input type="text" name="search" placeholder="Search by name or sport..."
           value="<?php echo e(request('search')); ?>" oninput="this.form.submit()"/>
    <?php if(request('search')): ?>
      <a href="<?php echo e(route('tournaments.index')); ?>" class="search-clear">✕</a>
    <?php endif; ?>
  </div>

  <select class="filter-sel" name="status" onchange="this.form.submit()">
    <option value="">All Statuses</option>
    <option value="upcoming" <?php echo e(request('status') === 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
    <option value="ongoing" <?php echo e(request('status') === 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
    <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
  </select>

  <select class="filter-sel" name="sport" onchange="this.form.submit()">
    <option value="">All Sports</option>
    <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($sport); ?>" <?php echo e(request('sport') === $sport ? 'selected' : ''); ?>>
        <?php echo e($sport); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>

  <select class="filter-sel" name="sort" onchange="this.form.submit()">
    <option value="name" <?php echo e(request('sort') === 'name' ? 'selected' : ''); ?>>Sort: Name</option>
    <option value="date" <?php echo e(request('sort') === 'date' ? 'selected' : ''); ?>>Sort: Date</option>
    <option value="teams" <?php echo e(request('sort') === 'teams' ? 'selected' : ''); ?>>Sort: Teams</option>
  </select>

  <?php if(request()->hasAny(['search','status','sport','sort'])): ?>
    <a href="<?php echo e(route('tournaments.index')); ?>" class="btn-clear">✕ Clear</a>
  <?php endif; ?>
</form>

<!-- Results -->
<div class="results-count">
  <?php if($tournaments->count()): ?>
    Showing <?php echo e($tournaments->firstItem()); ?> to <?php echo e($tournaments->lastItem()); ?> of <?php echo e($tournaments->total()); ?> results
  <?php else: ?>
    Showing 0 results
  <?php endif; ?>
</div>

<!-- Cards -->
<div class="card-grid">
  <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="t-card kpi-card"
         onclick="window.location='<?php echo e(route('tournaments.show', $t['id'])); ?>'">

      <div class="t-card-top">
        <div class="t-card-name">🏆 <?php echo e($t['name']); ?></div>
        <span class="badge badge-<?php echo e($t['status']); ?>"><?php echo e($t['status']); ?></span>
      </div>

      <div class="t-card-meta">
        <div class="t-meta-item">
          <label>Sport</label>
          <span><?php echo e($t['sport']); ?></span>
        </div>

        <div></div>

        <div class="t-meta-item">
          <label>Start</label>
          <span><?php echo e($t['startDate']); ?></span>
        </div>

        <div class="t-meta-item">
          <label>End</label>
          <span><?php echo e($t['endDate']); ?></span>
        </div>
      </div>

      <div class="t-card-foot">
        <span>Teams: <strong><?php echo e($t['teams']); ?></strong></span>
        <span>Matches: <strong><?php echo e($t['matches']); ?></strong></span>
      </div>

      <!-- ACTIONS -->
      <div class="t-card-actions">

        <!-- EDIT -->
        <button class="btn-edit-outline"
                onclick="event.stopPropagation(); openEditTournament(<?php echo e($t['id']); ?>)">
          Edit
        </button>

        <!-- DELETE -->
        <form method="POST"
              action="<?php echo e(route('tournaments.destroy', $t['id'])); ?>"
              onsubmit="event.stopPropagation(); return confirm('Delete this tournament?')">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button type="submit" class="btn-del-red">
            Delete
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

<!-- Pagination -->
<div style="display:flex; justify-content:flex-end; margin-top:30px;">
  <?php echo e($tournaments->links('vendor.pagination.tailwind')); ?>

</div>

<!-- Create Modal -->
<div class="modal-backdrop hidden" id="createTournamentModal">
  <div class="modal-box">
    <button class="modal-x" onclick="closeModal('createTournamentModal')">✕</button>
    <div class="modal-title">Create New Tournament</div>
    <form method="POST" action="<?php echo e(route('tournaments.store')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo $__env->make('partials.tournament-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeModal('createTournamentModal')">Cancel</button>
        <button type="submit" class="btn-submit">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modals -->
<?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal-backdrop hidden" id="editTournamentModal<?php echo e($t['id']); ?>">
  <div class="modal-box">
    <button class="modal-x" onclick="closeModal('editTournamentModal<?php echo e($t['id']); ?>')">✕</button>
    <div class="modal-title">Edit Tournament</div>
    <form method="POST" action="<?php echo e(route('tournaments.update', $t['id'])); ?>">
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
      <?php echo $__env->make('partials.tournament-form', ['tournament' => $t], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeModal('editTournamentModal<?php echo e($t['id']); ?>')">Cancel</button>
        <button type="submit" class="btn-submit">Update</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/pages/tournaments/index.blade.php ENDPATH**/ ?>