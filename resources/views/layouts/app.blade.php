<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tournament Pro — @yield('title', 'Management System')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>

  {{-- Vite Assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .page-btn {
        min-width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #111;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .page-btn:hover {
        background: #1f1f1f;
    }

    .page-btn.active {
        background: #e5e5e5;
        color: #000;
    }

    .page-btn.disabled {
        opacity: 0.4;
        pointer-events: none;
    }

    .page-btn.dots {
        background: transparent;
        color: #aaa;
    }
  </style>

  @stack('styles')
</head>

<body>

  <div class="app-wrapper">

    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="brand-logo-box small">🏆</div>
        <div>
          <div class="sb-name">Tournament Pro</div>
          <div class="sb-sub">Management System</div>
        </div>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}">
          Dashboard
        </a>

        <a class="nav-item {{ request()->routeIs('tournaments*') ? 'active' : '' }}"
           href="{{ route('tournaments.index') }}">
          Tournaments
        </a>

        <a class="nav-item {{ request()->routeIs('teams*') ? 'active' : '' }}"
           href="{{ route('teams.index') }}">
          Teams
        </a>

        <a class="nav-item {{ request()->routeIs('matches*') ? 'active' : '' }}"
           href="{{ route('matches.index') }}">
          Matches
        </a>

        <a class="nav-item {{ request()->routeIs('standings*') ? 'active' : '' }}"
           href="{{ route('standings.index') }}">
          Standings
        </a>
      </nav>

      <div class="sidebar-footer">

        <div class="user-chip">
          <div class="user-avatar">AD</div>
          <div>
            <div class="user-name">Admin User</div>
            <div class="user-role">Administrator</div>
          </div>
        </div>

        {{-- FIXED LOGOUT --}}
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf

          <button type="submit" class="signout-btn">
            Sign out
          </button>
        </form>

      </div>
    </aside>

    <div class="main-area">
      <div class="page-content">

        @if(session('success'))
          <div class="toast success" id="flashToast">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="toast error" id="flashToast">
            {{ session('error') }}
          </div>
        @endif

        @yield('content')

      </div>
    </div>

  </div>

  @stack('scripts')

  <script>
    const toast = document.getElementById('flashToast');

    if (toast) {
      setTimeout(() => {
        toast.style.opacity = '0';

        setTimeout(() => {
          toast.remove();
        }, 400);

      }, 3000);
    }
  </script>

</body>
</html>