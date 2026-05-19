<?php $__env->startSection('title', 'Matches'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div>
    <h1>Matches</h1>
    <p>Schedule and manage all matches</p>
  </div>
  <button class="btn-new" onclick="document.getElementById('createMatchModal').classList.remove('hidden')">
    + New Match
  </button>
</div>

<!-- Toolbar -->
<form method="GET" action="<?php echo e(route('matches.index')); ?>" class="toolbar">

  <div class="search-box">
    <input type="text" name="search"
           placeholder="Search by team or venue..."
           value="<?php echo e(request('search')); ?>"
           oninput="this.form.submit()"/>
  </div>

  <select class="filter-sel" name="status" onchange="this.form.submit()">
    <option value="">All Statuses</option>
    <option value="live" <?php echo e(request('status') === 'live' ? 'selected' : ''); ?>>Live</option>
    <option value="scheduled" <?php echo e(request('status') === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
    <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
  </select>

  <!-- ✅ FIXED TOURNAMENT DROPDOWN -->
  <select class="filter-sel" name="tournament" onchange="this.form.submit()">
    <option value="">All Tournaments</option>
    <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $value = is_object($t) ? $t->name : $t;
      ?>
      <option value="<?php echo e($value); ?>"
        <?php echo e(request('tournament') === $value ? 'selected' : ''); ?>>
        <?php echo e($value); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>

  <select class="filter-sel" name="sort" onchange="this.form.submit()">
    <option value="date" <?php echo e(request('sort','date') === 'date' ? 'selected' : ''); ?>>Sort: Date</option>
    <option value="status" <?php echo e(request('sort') === 'status' ? 'selected' : ''); ?>>Sort: Status</option>
  </select>

  <?php if(request()->hasAny(['search','status','tournament','sort'])): ?>
    <a href="<?php echo e(route('matches.index')); ?>" class="btn-clear">✕ Clear</a>
  <?php endif; ?>
</form>

<div class="results-count">
  Showing <?php echo e(count($matches)); ?> of <?php echo e($total); ?> results
</div>

<!-- MATCH CARDS -->
<div class="match-grid">
  <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="match-card">

      <div class="match-card-top">
        <span class="badge badge-<?php echo e($m['status']); ?>">
          <?php echo e(strtoupper($m['status'])); ?>

        </span>

        <div class="match-meta">
          <span><?php echo e($m['date']); ?></span>
          <span><?php echo e($m['time']); ?></span>
        </div>

        <div class="match-card-btns">
          <button class="btn-tbl-edit"
            onclick="document.getElementById('editMatchModal<?php echo e($m['id']); ?>').classList.remove('hidden')">
            ✎
          </button>

          <form method="POST" action="<?php echo e(route('matches.destroy',$m['id'])); ?>"
                onsubmit="return confirm('Delete this match?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="btn-tbl-del">🗑</button>
          </form>
        </div>
      </div>

      <div class="score-row">
        <div class="match-team-name"><?php echo e($m['teamA']); ?></div>

        <div class="score-center">
          <span class="score-num"><?php echo e($m['scoreA']); ?></span>
          <span class="score-vs">vs</span>
          <span class="score-num"><?php echo e($m['scoreB']); ?></span>
        </div>

        <div class="match-team-name" style="text-align:right">
          <?php echo e($m['teamB']); ?>

        </div>
      </div>

      <!-- ✅ FIXED TOURNAMENT DISPLAY -->
      <div class="match-venue-row">
        <?php echo e($m['venue']); ?> · 
        <?php echo e(is_object($m['tournament']) ? $m['tournament']->name : ($m['tournament'] ?? '-')); ?>

      </div>

    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="grid-column:1/-1">
      <div class="empty-icon">⚡</div>
      <h3>No matches found</h3>
    </div>
  <?php endif; ?>
</div>

<!-- CREATE MODAL -->
<div class="modal-backdrop hidden" id="createMatchModal">
  <div class="modal-box">
    <button class="modal-x"
      onclick="document.getElementById('createMatchModal').classList.add('hidden')">✕</button>

    <div class="modal-title">New Match</div>

    <form method="POST" action="<?php echo e(route('matches.store')); ?>">
      <?php echo csrf_field(); ?>
      <?php echo $__env->make('partials.match-form', ['tournaments'=>$tournaments], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <div class="modal-actions">
        <button type="button" class="btn-cancel"
          onclick="document.getElementById('createMatchModal').classList.add('hidden')">
          Cancel
        </button>
        <button type="submit" class="btn-submit">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT MODALS -->
<?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal-backdrop hidden" id="editMatchModal<?php echo e($m['id']); ?>">
  <div class="modal-box">
    <button class="modal-x"
      onclick="document.getElementById('editMatchModal<?php echo e($m['id']); ?>').classList.add('hidden')">✕</button>

    <div class="modal-title">Edit Match</div>

    <form method="POST" action="<?php echo e(route('matches.update',$m['id'])); ?>">
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
      <?php echo $__env->make('partials.match-form', ['match'=>$m,'tournaments'=>$tournaments], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <div class="modal-actions">
        <button type="button" class="btn-cancel"
          onclick="document.getElementById('editMatchModal<?php echo e($m['id']); ?>').classList.add('hidden')">
          Cancel
        </button>
        <button type="submit" class="btn-submit">Update</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-backdrop:not(.hidden)')
      .forEach(m => m.classList.add('hidden'));
  }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/pages/matches/index.blade.php ENDPATH**/ ?>