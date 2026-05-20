<?php $__env->startSection('title', 'Teams'); ?>

<?php $__env->startSection('content'); ?>
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
      <div class="stat-box-val" style="text-align:right;"><?php echo e($stats['total']); ?></div>
    </div>

    <div class="stat-box" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="stat-box-label">Total Players</div>
      <div class="stat-box-val" style="text-align:right;"><?php echo e($stats['totalPlayers']); ?></div>
    </div>

    <div class="stat-box" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="stat-box-label">Avg Players per Team</div>
      <div class="stat-box-val" style="text-align:right;"><?php echo e($stats['avgPlayers']); ?></div>
    </div>
  </div>

  <!-- Toolbar -->
  <form method="GET" action="<?php echo e(route('teams.index')); ?>" class="toolbar">
    <div class="search-box">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" name="search" placeholder="Search teams by name..."
             value="<?php echo e(request('search')); ?>" oninput="this.form.submit()"/>
    </div>

    <select class="filter-sel" name="winrate" onchange="this.form.submit()">
      <option value="">All Win Rates</option>
      <option value="high" <?php echo e(request('winrate') === 'high' ? 'selected' : ''); ?>>High (&gt;60%)</option>
      <option value="low"  <?php echo e(request('winrate') === 'low'  ? 'selected' : ''); ?>>Low (&lt;40%)</option>
    </select>

    <select class="filter-sel" name="sort" onchange="this.form.submit()">
      <option value="points" <?php echo e(request('sort','points') === 'points' ? 'selected' : ''); ?>>Sort: Points</option>
      <option value="wins"   <?php echo e(request('sort') === 'wins'   ? 'selected' : ''); ?>>Sort: Wins</option>
      <option value="name"   <?php echo e(request('sort') === 'name'   ? 'selected' : ''); ?>>Sort: Name</option>
    </select>

    <?php if(request()->hasAny(['search','winrate','sort'])): ?>
      <a href="<?php echo e(route('teams.index')); ?>" class="btn-clear">✕ Clear</a>
    <?php endif; ?>
  </form>

  <div class="results-count">Showing <?php echo e(count($teams)); ?> of <?php echo e($total); ?> results</div>

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
        <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php 
            $wr = ($t['wins'] + $t['losses'] > 0) 
              ? round($t['wins'] / ($t['wins'] + $t['losses']) * 100) 
              : 0; 
          ?>

          <tr>
            <td style="text-align:right;color:var(--gray-500);font-weight:500">
              <?php echo e($i + 1); ?>

            </td>

            <td>
              <div class="team-name-cell">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="2">
                  <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                  <circle cx="9" cy="7" r="4"/>
                  <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                  <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
                <?php echo e($t['name']); ?>

              </div>
            </td>

            <td style="text-align:right"><?php echo e($t['players']); ?></td>

            <td style="text-align:right">
              <span class="stat-g">↗<?php echo e($t['wins']); ?></span>
            </td>

            <td style="text-align:right">
              <span class="stat-r">↘<?php echo e($t['losses']); ?></span>
            </td>

            <td style="text-align:right"><?php echo e($wr); ?>%</td>

            <td style="text-align:right">
              <strong><?php echo e($t['points']); ?></strong>
            </td>

            <td style="text-align:right">
              <div class="tbl-actions">
                <button class="btn-tbl-edit"
                        onclick="document.getElementById('editTeamModal<?php echo e($t['id']); ?>').classList.remove('hidden')"
                        title="Edit">
                  ✎
                </button>

                <form method="POST"
                      action="<?php echo e(route('teams.destroy', $t['id'])); ?>"
                      style="display:inline"
                      onsubmit="return confirm('Delete this team?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-tbl-del" title="Delete">
                    🗑
                  </button>
                </form>
              </div>
            </td>
          </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h3>No teams found</h3>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Create Modal -->
  <div class="modal-backdrop hidden" id="createTeamModal">
    <div class="modal-box">
      <button class="modal-x" onclick="document.getElementById('createTeamModal').classList.add('hidden')">✕</button>
      <div class="modal-title">Create New Team</div>
      <form method="POST" action="<?php echo e(route('teams.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('partials.team-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('createTeamModal').classList.add('hidden')">Cancel</button>
          <button type="submit" class="btn-submit">Create</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modals -->
  <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="modal-backdrop hidden" id="editTeamModal<?php echo e($t['id']); ?>">
    <div class="modal-box">
      <button class="modal-x" onclick="document.getElementById('editTeamModal<?php echo e($t['id']); ?>').classList.add('hidden')">✕</button>
      <div class="modal-title">Edit Team</div>
      <form method="POST" action="<?php echo e(route('teams.update', $t['id'])); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('partials.team-form', ['team' => $t], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="document.getElementById('editTeamModal<?php echo e($t['id']); ?>').classList.add('hidden')">Cancel</button>
          <button type="submit" class="btn-submit">Update</button>
        </div>
      </form>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\teams\index.blade.php ENDPATH**/ ?>