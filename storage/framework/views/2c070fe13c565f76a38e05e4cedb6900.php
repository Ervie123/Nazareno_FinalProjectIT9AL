<?php $__env->startSection('title', 'Sign In'); ?>

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
<div class="auth-title">Sign in</div>
<div class="auth-subtitle">Welcome back! Enter your details.</div>

<?php if($errors->any()): ?>
  <div class="alert-error">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <p><?php echo e($error); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('auth.login.post')); ?>">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label>Email address</label>
    <input type="email" name="email" placeholder="you@example.com"
      value="<?php echo e(old('email')); ?>" required autofocus/>
  </div>
  <div class="form-group">
    <label>Password</label>
    <div class="input-wrap">
      <input type="password" name="password" id="loginPw" placeholder="••••••••" required/>
      <button type="button" class="pw-toggle" onclick="togglePw('loginPw',this)">👁</button>
    </div>
  </div>
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
    <label style="display:flex;align-items:center;gap:7px;font-size:13px;color:var(--gray-600);cursor:pointer">
      <input type="checkbox" name="remember" style="width:auto"/>
      Remember me
    </label>
    <a href="<?php echo e(route('password.request')); ?>" style="font-size:13px;color:var(--gray-500)">
      Forgot password?
    </a>
  </div>
  <button type="submit" class="btn-black">Sign in →</button>
</form>

<div class="auth-footer">
  Don't have an account? <a href="<?php echo e(route('auth.register')); ?>">>Sign up</a>
</div>

<div class="demo-hint">
  Demo: <strong>ervie@demo.com</strong> / <strong>demo123</strong>
</div>

<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Default.DESKTOP-RDM1A2L\Downloads\IT9AL\laravel-tournament\resources\views\pages\login.blade.php ENDPATH**/ ?>