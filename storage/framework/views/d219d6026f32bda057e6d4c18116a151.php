<?php $t = $tournament ?? []; ?>

<div class="form-group">
  <label>Tournament Name</label>
  <input type="text" name="name" value="<?php echo e($t['name'] ?? old('name')); ?>"
         placeholder="e.g. Spring Championship" required/>
</div>

<div class="form-group">
  <label>Sport</label>
  <select name="sport">
    <?php $__currentLoopData = ['Basketball','Soccer','Volleyball','Baseball','Tennis','Badminton','Swimming','Athletics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($sport); ?>" <?php echo e(($t['sport'] ?? '') === $sport ? 'selected' : ''); ?>><?php echo e($sport); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Start Date</label>
    <input type="date" name="startDate" value="<?php echo e($t['startDate'] ?? old('startDate')); ?>"/>
  </div>
  <div class="form-group">
    <label>End Date</label>
    <input type="date" name="endDate" value="<?php echo e($t['endDate'] ?? old('endDate')); ?>"/>
  </div>
</div>

<div class="form-group">
  <label>Status</label>
  <select name="status">
    <option value="upcoming" <?php echo e(($t['status'] ?? '') === 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
    <option value="ongoing"  <?php echo e(($t['status'] ?? '') === 'ongoing'  ? 'selected' : ''); ?>>Ongoing</option>
    <option value="completed"<?php echo e(($t['status'] ?? '') === 'completed'? 'selected' : ''); ?>>Completed</option>
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Number of Teams</label>
    <input type="number" name="teams" value="<?php echo e($t['teams'] ?? 8); ?>" min="2"/>
  </div>
  <div class="form-group">
    <label>Number of Matches</label>
    <input type="number" name="matches" value="<?php echo e($t['matches'] ?? 0); ?>" min="0"/>
  </div>
</div>
<?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/partials/tournament-form.blade.php ENDPATH**/ ?>