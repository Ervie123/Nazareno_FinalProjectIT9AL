@extends('layouts.auth')
@section('title', 'Create Account')

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
  <a class="back-link" href="{{ route('auth.login') }}">← Back to sign in</a>
  <div class="auth-title">Create an account</div>
  <div class="auth-subtitle">Fill in the details below to get started.</div>

  @if($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('auth.register') }}">
    @csrf
    <div class="form-group">
      <label for="name">Full name</label>
      <input type="text" id="name" name="name" placeholder="John Doe"
             value="{{ old('name') }}" required/>
    </div>

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

    <div class="form-group">
      <label for="password_confirmation">Confirm password</label>
      <div class="input-wrap">
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required/>
        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)">👁</button>
      </div>
    </div>

    <button type="submit" class="btn-black">👤 Create account</button>
  </form>

  <div class="auth-footer">Already have an account? <a href="{{ route('auth.login') }}">Sign in</a></div>
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
