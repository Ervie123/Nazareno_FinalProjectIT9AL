<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tournament Pro — @yield('title', 'Management System')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet"/>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

  {{-- ✅ ADD THIS FOR CUSTOM PAGINATION STYLE --}}
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

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="brand-logo-box small">🏆</div>
        <div>
          <div class="sb-name">Tournament Pro</div>
          <div class="sb-sub">Management System</div>
        </div>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          Dashboard
        </a>

        <a class="nav-item {{ request()->routeIs('tournaments*') ? 'active' : '' }}" href="{{ route('tournaments.index') }}">
          Tournaments
        </a>

        <a class="nav-item {{ request()->routeIs('teams*') ? 'active' : '' }}" href="{{ route('teams.index') }}">
          Teams
        </a>

        <a class="nav-item {{ request()->routeIs('matches*') ? 'active' : '' }}" href="{{ route('matches.index') }}">
          Matches
        </a>

        <a class="nav-item {{ request()->routeIs('standings*') ? 'active' : '' }}" href="{{ route('standings.index') }}">
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

        <a href="{{ route('auth.logout') }}" class="signout-btn">
          Sign out
        </a>
      </div>
    </aside>

    <!-- MAIN -->
    <div class="main-area">
      <div class="page-content">

        {{-- FLASH --}}
        @if(session('success'))
          <div class="toast success" id="flashToast">{{ session('success') }}</div>
        @endif

        @if(session('error'))
          <div class="toast error" id="flashToast">{{ session('error') }}</div>
        @endif

        @yield('content')
      </div>
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal-backdrop hidden" id="modalBackdrop">
    <div class="modal-box">
      <button class="modal-x" id="modalX">✕</button>
      <div id="modalBody">
        @yield('modal')
      </div>
    </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')

  <script>
    // Toast auto-hide
    const toast = document.getElementById('flashToast');
    if (toast) {
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.4s';
        setTimeout(() => toast.remove(), 400);
      }, 3000);
    }

    // Modal close
    document.getElementById('modalX')?.addEventListener('click', () => {
      document.getElementById('modalBackdrop').classList.add('hidden');
    });

    document.getElementById('modalBackdrop')?.addEventListener('click', e => {
      if (e.target.id === 'modalBackdrop') {
        document.getElementById('modalBackdrop').classList.add('hidden');
      }
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        document.getElementById('modalBackdrop')?.classList.add('hidden');
      }
    });
  </script>

</body>
</html>