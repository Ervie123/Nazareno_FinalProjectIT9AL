<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tournament Pro — <?php echo $__env->yieldContent('title', 'Sign In'); ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>

 
 <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

</head>

<body>

  <div class="auth-wrapper">

    <div class="auth-left">
      <div class="auth-brand">
        <div class="brand-logo-box">🏆</div>
        <div>
          <div class="auth-brand-name">Tournament Pro</div>
          <div class="auth-brand-sub">Management System</div>
        </div>
      </div>

      <div class="auth-left-content">
        <?php echo $__env->yieldContent('auth-left'); ?>
      </div>
    </div>

    <div class="auth-right">
      <div class="auth-form-wrap">
        <?php echo $__env->yieldContent('auth-form'); ?>
      </div>
    </div>

  </div>

  <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/layouts/auth.blade.php ENDPATH**/ ?>