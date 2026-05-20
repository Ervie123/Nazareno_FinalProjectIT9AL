<?php $__env->startSection('title', 'Create Account'); ?>

<?php $__env->startSection('auth-left'); ?>
<div class="auth-hero">
  <h2>Join thousands of<br><span>tournament organizers.</span></h2>
  <p>Create your free account and start managing tournaments, teams, and matches in minutes.</p>
  <ul class="auth-features">
    <li><div class="feat-check"></div>Full tournament lifecycle management</li>
    <li><div class="feat-check"></div>Real-time standings &amp; match tracking</li>
    <li><div class="feat-check"></div>Team and player management</li>
  </ul>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth-form'); ?>
<a class="back-link" href="<?php echo e(route('login')); ?>">← Back to sign in</a>
<div class="auth-title">Create an account</div>
<div class="auth-subtitle">Fill in the details below to get started.</div>

<?php if($errors->any()): ?>
  <div class="alert-error">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <p><?php echo e($error); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('register')); ?>">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label>Full name</label>
    <input type="text" name="name" placeholder="John Doe"
      value="<?php echo e(old('name')); ?>" required autofocus/>
  </div>
  <div class="form-group">
    <label>Email address</label>
    <input type="email" name="email" placeholder="you@example.com"
      value="<?php echo e(old('email')); ?>" required/>
  </div>
  <div class="form-group">
    <label>Password</label>
    <div class="input-wrap">
      <input type="password" name="password" id="regPw" placeholder="••••••••" required/>
      <button type="button" class="pw-toggle" onclick="togglePw('regPw',this)">👁</button>
    </div>
  </div>
  <div class="form-group">
    <label>Confirm password</label>
    <div class="input-wrap">
      <input type="password" name="password_confirmation" id="regPw2" placeholder="••••••••" required/>
      <button type="button" class="pw-toggle" onclick="togglePw('regPw2',this)">👁</button>
    </div>
  </div>
  <button type="submit" class="btn-black">👤 Create account</button>
</form>

<div class="auth-footer">
  Already have an account? <a href="<?php echo e(route('login')); ?>">Sign in</a>
</div>

<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\register.blade.php ENDPATH**/ ?>