@extends('layouts.auth')
@section('title', 'Sign In')

@section('auth-left')
  <div class="auth-hero">
    <h2>Join thousands of<br><span>tournament organizers.</span></h2>
    <p>Create your free account and start managing<br>tournaments, teams, and matches in minutes.</p>
    <ul class="auth-features">
      <li><div class="feat-check"></div>Full tournament lifecycle management</li>
      <li><div class="feat-check"></div>Real-time standings &amp; match tracking</li>
      <li><div class="feat-check"></div>Team and player management</li>
    </ul>
  </div>
@endsection

@section('auth-form')
  <div class="auth-title">Sign in</div>
  <div class="auth-subtitle">Welcome back! Enter your details.</div>

  @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('auth.login.post') }}">
    @csrf
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" id="email" name="email" placeholder="you@example.com"
             value="{{ old('email') }}" required/>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="input-wrap">
        <input type="password" id="password" name="password" placeholder="••••••••" required/>
        <button type="button" class="pw-toggle" onclick="togglePw('password', this)">👁</button>
      </div>
    </div>

    <div style="text-align:right;margin-bottom:16px">
      <a href="{{ route('auth.forgot') }}" style="font-size:13px;color:var(--gray-500)">Forgot password?</a>
    </div>

    <button type="submit" class="btn-black">Sign in</button>
  </form>

  <div class="auth-footer">Don't have an account? <a href="{{ route('auth.register') }}">Sign up</a></div>
  <div class="demo-hint">Demo: <strong>admin@demo.com</strong> / <strong>demo123</strong></div>
@endsection

@push('scripts')
<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}
</script>
@endpush
