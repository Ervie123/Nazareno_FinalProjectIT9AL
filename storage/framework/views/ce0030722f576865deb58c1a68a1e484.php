
<?php $__env->startSection('title', 'Tournament Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
  <h1><?php echo e($tournament->name); ?></h1>
  <p><?php echo e($tournament->sport); ?></p>
</div>

<div class="data-card">
  <p><strong>Status:</strong> <?php echo e($tournament->status); ?></p>
  <p><strong>Teams:</strong> <?php echo e($tournament->teams); ?></p>
  <p><strong>Matches:</strong> <?php echo e($tournament->matches); ?></p>
  <p><strong>Start:</strong> <?php echo e($tournament->start_date); ?></p>
  <p><strong>End:</strong> <?php echo e($tournament->end_date); ?></p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\tournaments\show.blade.php ENDPATH**/ ?>