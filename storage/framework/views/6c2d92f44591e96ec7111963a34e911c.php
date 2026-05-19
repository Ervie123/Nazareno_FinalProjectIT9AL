<?php $__env->startSection('title', 'Forgot Password'); ?>

<?php $__env->startSection('auth-left'); ?>
  <div>
    <div class="reset-label">PASSWORD RESET</div>
    <div class="reset-steps">
      <div class="reset-step">
        <div class="step-num on">1</div>
        <div class="step-text"><h4>Enter your email</h4><p>We'll send a reset code</p></div>
      </div>
      <div class="reset-step">
        <div class="step-num off">2</div>
        <div class="step-text" style="opacity:.4"><h4>Verify the code</h4><p>Enter the 6-digit code</p></div>
      </div>
      <div class="reset-step">
        <div class="step-num off">3</div>
        <div class="step-text" style="opacity:.4"><h4>Set new password</h4><p>Choose a strong password</p></div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth-form'); ?>
  <a class="back-link" href="<?php echo e(route('auth.login')); ?>">← Back to sign in</a>
  <div class="auth-icon-box">✉️</div>
  <div class="auth-title">Forgot password?</div>
  <div class="auth-subtitle">No worries. Enter your account email and we'll send you a reset code.</div>

  <?php if(session('success')): ?>
    <div class="alert-success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e(route('auth.forgot')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" placeholder="you@example.com" required/>
    </div>
    <button type="submit" class="btn-black">Send reset code</button>
  </form>

  <div class="auth-footer">Remembered it? <a href="<?php echo e(route('auth.login')); ?>">Sign in</a></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views/auth/forgot.blade.php ENDPATH**/ ?>