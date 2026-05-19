<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <div>
      <h1>Dashboard</h1>
      <p>Overview of your tournament management system</p>
    </div>
  </div>

  <!-- 4 Stat Cards — Horizontal Row -->
  <div class="stat-grid">
    <div class="stat-box">
      <div>
        <div class="stat-box-label">Total Tournaments</div>
        <div class="stat-box-val"><?php echo e($stats['totalTournaments']); ?></div>
      </div>
      <div class="stat-box-icon" style="background:#fef3c7;color:#d97706;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 9H4.5a2.5 2.5 0 010-5H6"/>
          <path d="M18 9h1.5a2.5 2.5 0 000-5H18"/>
          <path d="M4 22h16"/>
          <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
          <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
          <path d="M18 2H6v7a6 6 0 0012 0V2z"/>
        </svg>
      </div>
    </div>

    <div class="stat-box">
      <div>
        <div class="stat-box-label">Total Teams</div>
        <div class="stat-box-val"><?php echo e($stats['totalTeams']); ?></div>
      </div>
      <div class="stat-box-icon" style="background:#dcfce7;color:#16a34a;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87"/>
          <path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
      </div>
    </div>

    <div class="stat-box">
      <div>
        <div class="stat-box-label">Total Matches</div>
        <div class="stat-box-val"><?php echo e($stats['totalMatches']); ?></div>
      </div>
      <div class="stat-box-icon" style="background:#e0e7ff;color:#4f46e5;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
    </div>

    <div class="stat-box">
      <div>
        <div class="stat-box-label">Live Matches</div>
        <div class="stat-box-val"><?php echo e($stats['liveMatches']); ?></div>
      </div>
      <div class="stat-box-icon" style="background:#fee2e2;color:#dc2626;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
      </div>
    </div>
  </div>

  <!-- Two Panels Side by Side — Horizontal Layout -->
  <div class="dash-grid">
    <div class="panel">
      <div class="panel-head">Ongoing Tournaments</div>
      <div class="panel-body">
        <?php $__empty_1 = true; $__currentLoopData = $ongoingTournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="ongoing-item">
            <div>
              <div class="ongoing-name"><?php echo e($t['name']); ?></div>
              <div class="ongoing-sport"><?php echo e($t['sport']); ?></div>
            </div>
            <span class="badge badge-ongoing">Ongoing</span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state" style="padding:30px 0">
            <div class="empty-icon">🏆</div>
            <p>No ongoing tournaments</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">Live Matches</div>
      <div class="panel-body">
        <?php $__empty_1 = true; $__currentLoopData = $liveMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="live-card">
            <div class="live-card-top">
              <span class="badge badge-live">LIVE</span>
              <span class="live-venue"><?php echo e($m['venue']); ?></span>
            </div>
            <div class="live-score-row">
              <div class="live-team">
                <div class="live-team-name"><?php echo e($m['teamA']); ?></div>
                <div class="live-score"><?php echo e($m['scoreA']); ?></div>
              </div>
              <div class="live-vs">vs</div>
              <div class="live-team" style="text-align:right">
                <div class="live-team-name"><?php echo e($m['teamB']); ?></div>
                <div class="live-score"><?php echo e($m['scoreB']); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state" style="padding:30px 0">
            <div class="empty-icon">⚡</div>
            <p>No live matches right now</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Upcoming Matches Full Width -->
  <div class="panel">
    <div class="panel-head">Upcoming Matches</div>
    <div class="panel-body">
      <?php $__empty_1 = true; $__currentLoopData = $upcomingMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="upcoming-item">
          <div class="upcoming-dt">
            <div class="upcoming-date"><?php echo e($m['date']); ?></div>
            <div class="upcoming-time"><?php echo e($m['time']); ?></div>
          </div>
          <div style="flex:1">
            <div class="upcoming-match"><?php echo e($m['teamA']); ?> vs <?php echo e($m['teamB']); ?></div>
            <div class="upcoming-venue"><?php echo e($m['venue']); ?></div>
          </div>
          <span class="badge badge-scheduled">Scheduled</span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="padding:30px 0">
          <p>No upcoming matches scheduled</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>