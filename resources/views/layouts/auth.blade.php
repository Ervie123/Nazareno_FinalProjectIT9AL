<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tournament Pro — @yield('title', 'Sign In')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>

  {{-- ✅ FIXED --}}
 <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>

<body>

<div class="auth-wrapper">

  <!-- LEFT -->
  <div class="auth-left">
    <div class="auth-brand">
      <div class="brand-logo-box">🏆</div>
      <div>
        <div class="auth-brand-name">Tournament Pro</div>
        <div class="auth-brand-sub">Management System</div>
      </div>
    </div>

    <div class="auth-left-content">
      @yield('auth-left')
    </div>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <div class="auth-form-wrap">
      @yield('auth-form')
    </div>
  </div>

</div>

<script src="{{ url('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>