@extends('layouts.auth')
@section('title', 'Reset Password')

@section('auth-left')
<div>
    <div class="reset-label">RESET PASSWORD</div>

    <div class="reset-steps">

        <div class="reset-step">
            <div class="step-num on">✓</div>

            <div class="step-text">
                <h4>Email verified</h4>
                <p>Reset link opened</p>
            </div>
        </div>

        <div class="reset-step">
            <div class="step-num on">2</div>

            <div class="step-text">
                <h4>Create password</h4>
                <p>Enter your new password</p>
            </div>
        </div>

    </div>
</div>
@endsection

@section('auth-form')

<div class="auth-icon-box">🔒</div>

<div class="auth-title">
    Create new password
</div>

<div class="auth-subtitle">
    Your new password must be different from the previous one.
</div>

@if($errors->any())
    <div class="alert-error">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">

    @csrf

    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="form-group">
        <label>New Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter new password"
            required
        />
    </div>

    <div class="form-group">
        <label>Confirm Password</label>

        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm password"
            required
        />
    </div>

    <button type="submit" class="btn-black">
        Reset Password
    </button>

</form>

<div class="auth-footer">
    <a href="{{ route('auth.login') }}">
        Back to sign in
    </a>
</div>

@endsection