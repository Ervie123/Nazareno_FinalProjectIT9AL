# Tournament Pro — Management System (Laravel)

A full-featured tournament management system converted from a vanilla JS MVC app into a **Laravel 10** application. Features a **left vertical sidebar** with horizontal page content, full CRUD for tournaments, teams, matches, and standings.

---

## ✅ Features

- 🔐 Auth — Login, Register, Forgot Password (session-based)
- 🏆 Tournaments — Create, Read, Update, Delete + search/filter/sort
- 👥 Teams — Full CRUD with win-rate stats + data table
- ⚡ Matches — Full CRUD with live/scheduled/completed tabs
- 🥇 Standings — Podium cards, full table, bar chart statistics
- 📊 Dashboard — Live stat cards, live matches, upcoming matches
- 🎨 Left sidebar navigation (vertical) + horizontal content layout

---

## 🚀 Quick Setup

### Requirements
- PHP >= 8.1
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Steps

```bash
# 1. Clone / extract this folder
cd laravel-tournament

# 2. Install PHP dependencies
composer install

# 3. Copy and configure environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5a. For SQLite (easiest — no database setup needed):
touch database/database.sqlite
# Make sure .env has: DB_CONNECTION=sqlite  (already set by default)

# 5b. For MySQL — edit .env:
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_PORT=3306
#   DB_DATABASE=tournament_pro
#   DB_USERNAME=root
#   DB_PASSWORD=your_password

# 6. Run migrations
php artisan migrate

# 7. Seed demo data
php artisan db:seed

# 8. Start the development server
php artisan serve
```

Then open **http://localhost:8000** in your browser.

### Demo Login
| Field    | Value            |
|----------|------------------|
| Email    | admin@demo.com   |
| Password | demo123          |

---

## 📁 Project Structure

```
laravel-tournament/
├── app/
│   ├── Console/Kernel.php
│   ├── Exceptions/Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        ← Login / Register / Logout
│   │   │   ├── DashboardController.php   ← Dashboard stats
│   │   │   ├── TournamentController.php  ← Tournament CRUD
│   │   │   ├── TeamController.php        ← Team CRUD
│   │   │   ├── MatchController.php       ← Match CRUD
│   │   │   └── StandingsController.php   ← Rankings & charts
│   │   ├── Kernel.php                    ← Middleware registration
│   │   └── Middleware/
│   │       └── AuthSessionMiddleware.php ← Protects app routes
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── RouteServiceProvider.php
│
├── bootstrap/app.php
├── artisan
├── composer.json
│
├── config/
│   ├── app.php
│   ├── cache.php
│   ├── database.php
│   ├── session.php
│   └── view.php
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_tournaments_table.php
│   │   ├── ..._create_teams_table.php
│   │   └── ..._create_matches_table.php
│   └── seeders/
│       └── DatabaseSeeder.php            ← Demo data
│
├── public/
│   ├── index.php                         ← Laravel entry point
│   ├── .htaccess                         ← Apache URL rewriting
│   ├── css/app.css                       ← All styles
│   └── js/app.js                         ← UI helpers
│
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                 ← LEFT SIDEBAR layout
│   │   └── auth.blade.php               ← Auth split layout
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   └── forgot.blade.php
│   ├── pages/
│   │   ├── dashboard.blade.php
│   │   ├── tournaments/index.blade.php
│   │   ├── teams/index.blade.php
│   │   ├── matches/index.blade.php
│   │   └── standings/index.blade.php
│   └── partials/
│       ├── tournament-form.blade.php
│       ├── team-form.blade.php
│       └── match-form.blade.php
│
└── routes/
    ├── web.php                           ← All routes
    ├── api.php
    └── console.php
```

---

## 🎨 Layout Architecture

The key CSS that drives the **left sidebar + horizontal content** layout:

```css
/* Outer shell: sidebar LEFT, content RIGHT — side by side */
.app-wrapper {
  display: flex;        /* horizontal flex container */
  min-height: 100vh;
}

/* Left sidebar: nav items stacked VERTICALLY */
.sidebar {
  width: 248px;
  display: flex;
  flex-direction: column;   /* vertical stacking */
  position: sticky;
  height: 100vh;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;   /* nav links go top-to-bottom */
  gap: 2px;
}

/* Right side: all horizontal content fills remaining space */
.main-area {
  flex: 1;            /* takes all remaining width */
  background: #f9fafb;
}
```

---

## 🔧 Nginx Configuration (Production)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/laravel-tournament/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## 📝 License
MIT
