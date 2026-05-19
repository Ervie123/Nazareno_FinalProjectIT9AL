<?php $t = $team ?? []; ?>

<div class="form-group">
  <label>Team Name</label>
  <input type="text" name="name" value="<?php echo e($t['name'] ?? old('name')); ?>"
         placeholder="e.g. Japan Womens Volleyball" required/>
</div>

<div class="form-group">
  <label>Number of Players</label>
  <input type="number" name="players" value="<?php echo e($t['players'] ?? 0); ?>" min="0"/>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Wins</label>
    <input type="number" name="wins" value="<?php echo e($t['wins'] ?? 0); ?>" min="0"/>
  </div>
  <div class="form-group">
    <label>Losses</label>
    <input type="number" name="losses" value="<?php echo e($t['losses'] ?? 0); ?>" min="0"/>
  </div>
</div>

<div class="form-group">
  <label>Points</label>
  <input type="number" name="points" value="<?php echo e($t['points'] ?? 0); ?>" min="0"/>
</div>
<?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/partials/team-form.blade.php ENDPATH**/ ?>