@extends('layouts.auth')

@section('title', 'Create Account')

@section('auth-left')
<div class="auth-hero">
  <h2>Join thousands of<br><span>tournament organizers.</span></h2>
  <p>Create your free account and start managing tournaments, teams, and matches in minutes.</p>
  <ul class="auth-features">
    <li><div class="feat-check"></div>Full tournament lifecycle management</li>
    <li><div class="feat-check"></div>Real-time standings &amp; match tracking</li>
    <li><div class="feat-check"></div>Team and player management</li>
  </ul>
</div>
@endsection

@section('auth-form')
<a class="back-link" href="{{ route('login') }}">← Back to sign in</a>
<div class="auth-title">Create an account</div>
<div class="auth-subtitle">Fill in the details below to get started.</div>

@if($errors->any())
  <div class="alert-error">
    @foreach($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
@endif

<form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="form-group">
    <label>Full name</label>
    <input type="text" name="name" placeholder="John Doe"
      value="{{ old('name') }}" required autofocus/>
  </div>
  <div class="form-group">
    <label>Email address</label>
    <input type="email" name="email" placeholder="you@example.com"
      value="{{ old('email') }}" required/>
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
  Already have an account? <a href="{{ route('login') }}">Sign in</a>
</div>

<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}
</script>
@endsection
