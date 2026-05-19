@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('auth-left')
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
@endsection

@section('auth-form')
  <a class="back-link" href="{{ route('auth.login') }}">← Back to sign in</a>
  <div class="auth-icon-box">✉️</div>
  <div class="auth-title">Forgot password?</div>
  <div class="auth-subtitle">No worries. Enter your account email and we'll send you a reset code.</div>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('auth.forgot') }}">
    @csrf
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" placeholder="you@example.com" required/>
    </div>
    <button type="submit" class="btn-black">Send reset code</button>
  </form>

  <div class="auth-footer">Remembered it? <a href="{{ route('auth.login') }}">Sign in</a></div>
@endsection
