<?php $__env->startSection('title', 'Standings'); ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <div>
      <h1>Standings</h1>
      <p>Team rankings and statistics</p>
    </div>
  </div>

  <!-- Toolbar -->
  <form method="GET" action="<?php echo e(route('standings.index')); ?>" class="toolbar">
    <div class="search-box">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" name="search" placeholder="Search teams by name..."
             value="<?php echo e(request('search')); ?>" oninput="this.form.submit()"/>
    </div>
    <select class="filter-sel" name="sort" onchange="this.form.submit()">
      <option value="points" <?php echo e(request('sort','points') === 'points' ? 'selected' : ''); ?>>Sort: Points</option>
      <option value="wins"   <?php echo e(request('sort') === 'wins'   ? 'selected' : ''); ?>>Sort: Wins</option>
      <option value="name"   <?php echo e(request('sort') === 'name'   ? 'selected' : ''); ?>>Sort: Name</option>
    </select>
    <?php if(request()->hasAny(['search','sort'])): ?>
      <a href="<?php echo e(route('standings.index')); ?>" class="btn-clear">✕ Clear</a>
    <?php endif; ?>
  </form>

  <div class="results-count">Showing <?php echo e(count($teams)); ?> of <?php echo e(count($teams)); ?> results</div>

  <!-- Top 3 Podium — Horizontal 3-Column -->
  <div class="top3-grid">
    <?php $__currentLoopData = array_slice($teams, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $trophies = ['🥇','🥈','🥉']; ?>
      <div class="top3-card <?php echo e($i === 0 ? 'gold' : ''); ?>">
        <div class="top3-rank">#<?php echo e($i + 1); ?></div>
        <div class="top3-trophy"><?php echo e($trophies[$i]); ?></div>
        <div class="top3-name"><?php echo e($t['name']); ?></div>
        <div class="top3-pts"><?php echo e($t['points']); ?></div>
        <div class="top3-wl">
          <span class="stat-g">Wins: <?php echo e($t['wins']); ?></span>
          <span class="stat-r">Losses: <?php echo e($t['losses']); ?></span>
        </div>
        <div class="top3-players">Players: <?php echo e($t['players']); ?></div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- View Tabs -->
  <div class="stngs-tabs">
    <button class="stngs-tab <?php echo e(request('view','table') === 'table' ? 'active' : ''); ?>"
            onclick="switchView('table')">Table View</button>
    <button class="stngs-tab <?php echo e(request('view') === 'stats' ? 'active' : ''); ?>"
            onclick="switchView('stats')">Statistics</button>
  </div>

  <!-- TABLE VIEW -->
  <div id="viewTable" class="<?php echo e(request('view','table') !== 'stats' ? '' : 'hidden'); ?>">
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
          <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $wr = ($t['wins'] + $t['losses'] > 0) ? round($t['wins'] / ($t['wins'] + $t['losses']) * 100) : 0; ?>
            <tr>
              <td>
                <strong style="<?php echo e($i === 0 ? 'color:var(--yellow)' : ''); ?>">
                  <?php echo e($i < 3 ? ['🥇','🥈','🥉'][$i] : '#'.($i+1)); ?>

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
                  <?php echo e($t['name']); ?>

                </div>
              </td>
              <td><?php echo e($t['wins'] + $t['losses']); ?></td>
              <td><span class="stat-g">↗<?php echo e($t['wins']); ?></span></td>
              <td><span class="stat-r">↘<?php echo e($t['losses']); ?></span></td>
              <td><?php echo e($wr); ?>%</td>
              <td><strong><?php echo e($t['points']); ?></strong></td>
              <td>
                <div class="form-bars">
                  <?php for($f = 0; $f < min(5, $t['wins'] + $t['losses']); $f++): ?>
                    <div class="form-bar <?php echo e($f < $t['wins'] ? 'w' : 'l'); ?>"></div>
                  <?php endfor; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8">
              <div class="empty-state"><div class="empty-icon">🏅</div><h3>No standings data</h3></div>
            </td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- STATISTICS VIEW -->
  <div id="viewStats" class="<?php echo e(request('view') === 'stats' ? '' : 'hidden'); ?>">
    <!-- Summary boxes — Horizontal 4-Column Row -->
    <div class="summary-grid" style="margin-bottom:22px">
      <div class="summary-box">
        <div class="summary-lbl">Total Teams</div>
        <div class="summary-val"><?php echo e(count($teams)); ?></div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Total Matches</div>
        <div class="summary-val"><?php echo e($matchStats['total']); ?></div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Overall Win %</div>
        <div class="summary-val"><?php echo e($matchStats['winPct']); ?>%</div>
      </div>
      <div class="summary-box">
        <div class="summary-lbl">Avg Points</div>
        <div class="summary-val"><?php echo e($matchStats['avgPts']); ?></div>
      </div>
    </div>

    <!-- Charts — Horizontal 2-Column -->
    <div class="chart-grid">
      <div class="chart-panel">
        <div class="chart-title">Team Points Comparison</div>
        <div class="bar-chart" id="pointsChart">
          <?php $__currentLoopData = array_slice($teams, 0, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $pct = $matchStats['maxPoints'] > 0 ? round($t['points'] / $matchStats['maxPoints'] * 100) : 0; ?>
            <div class="bar-item">
              <div class="bar-stacks">
                <div class="bar blue" style="height:<?php echo e($pct); ?>%"></div>
              </div>
              <div class="bar-lbl"><?php echo e(Str::limit($t['name'], 8)); ?></div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="chart-legend">
          <div class="legend-item"><div class="legend-dot" style="background:var(--blue)"></div>Points</div>
        </div>
      </div>

      <div class="chart-panel">
        <div class="chart-title">Wins vs Losses</div>
        <div class="bar-chart">
         <?php $__currentLoopData = array_slice($teams, 0, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
    $maxWLArray = array_map(fn($x) => $x['wins'] + $x['losses'], $teams);
    $maxWL = max(count($maxWLArray) ? $maxWLArray : [1]);

    $wp = $maxWL > 0 ? round($t['wins'] / $maxWL * 100) : 0;
    $lp = $maxWL > 0 ? round($t['losses'] / $maxWL * 100) : 0;
  ?>

  <div class="bar-item">
    <div class="bar-stacks">
      <div class="bar green" style="height:<?php echo e($wp); ?>%"></div>
      <div class="bar red"   style="height:<?php echo e($lp); ?>%"></div>
    </div>
    <div class="bar-lbl"><?php echo e(Str::limit($t['name'], 8)); ?></div>
  </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="chart-legend">
          <div class="legend-item"><div class="legend-dot" style="background:var(--green)"></div>Wins</div>
          <div class="legend-item"><div class="legend-dot" style="background:var(--red)"></div>Losses</div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function switchView(v) {
  document.getElementById('viewTable').classList.toggle('hidden', v !== 'table');
  document.getElementById('viewStats').classList.toggle('hidden', v !== 'stats');
  document.querySelectorAll('.stngs-tab').forEach((btn, i) => {
    btn.classList.toggle('active', (i === 0 && v === 'table') || (i === 1 && v === 'stats'));
  });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\standings\index.blade.php ENDPATH**/ ?>