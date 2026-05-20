<?php
  $m = $match ?? [];
?>

<div class="form-row">
  <div class="form-group">
    <label>Team A</label>
    <input type="text" name="teamA"
           value="<?php echo e(old('teamA', $m['teamA'] ?? '')); ?>"
           placeholder="e.g. Philippines" required>
  </div>

  <div class="form-group">
    <label>Team B</label>
    <input type="text" name="teamB"
           value="<?php echo e(old('teamB', $m['teamB'] ?? '')); ?>"
           placeholder="e.g. Japan" required>
  </div>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Score A</label>
    <input type="number" name="scoreA"
           value="<?php echo e(old('scoreA', $m['scoreA'] ?? 0)); ?>" min="0">
  </div>

  <div class="form-group">
    <label>Score B</label>
    <input type="number" name="scoreB"
           value="<?php echo e(old('scoreB', $m['scoreB'] ?? 0)); ?>" min="0">
  </div>
</div>

<div class="form-group">
  <label>Tournament</label>
  <select name="tournament" required>
    <option value="">Select Tournament</option>
    <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $value = is_object($t) ? $t->name : $t;
      ?>
      <option value="<?php echo e($value); ?>"
        <?php echo e(old('tournament', $m['tournament'] ?? '') == $value ? 'selected' : ''); ?>>
        <?php echo e($value); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Date</label>
    <input type="date" name="date"
           value="<?php echo e(old('date', $m['date'] ?? '')); ?>">
  </div>

  <div class="form-group">
    <label>Time</label>
    <input type="time" name="time"
           value="<?php echo e(old('time', $m['time'] ?? '')); ?>">
  </div>
</div>

<div class="form-group">
  <label>Venue</label>
  <input type="text" name="venue"
         value="<?php echo e(old('venue', $m['venue'] ?? '')); ?>"
         placeholder="e.g. Rizal Memorial Stadium">
</div>

<div class="form-group">
  <label>Status</label>
  <select name="status">
    <option value="scheduled"
      <?php echo e(old('status', $m['status'] ?? '') == 'scheduled' ? 'selected' : ''); ?>>
      Scheduled
    </option>

    <option value="live"
      <?php echo e(old('status', $m['status'] ?? '') == 'live' ? 'selected' : ''); ?>>
      Live
    </option>

    <option value="completed"
      <?php echo e(old('status', $m['status'] ?? '') == 'completed' ? 'selected' : ''); ?>>
      Completed
    </option>
  </select>
</div><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\partials\match-form.blade.php ENDPATH**/ ?>