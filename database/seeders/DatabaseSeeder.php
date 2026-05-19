<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Demo User ──────────────────────────────────
        DB::table('users')->insertOrIgnore([
            'name'       => 'Admin User',
            'email'      => 'admin@demo.com',
            'password'   => Hash::make('demo123'),
            'role'       => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Tournaments ────────────────────────────────
        DB::table('tournaments')->insertOrIgnore([
            ['name' => 'National Basketball League 2025', 'sport' => 'Basketball', 'start_date' => '2025-01-10', 'end_date' => '2025-03-30', 'status' => 'ongoing',   'teams' => 12, 'matches' => 48, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Volleyball Championship',         'sport' => 'Volleyball',  'start_date' => '2025-02-15', 'end_date' => '2025-04-20', 'status' => 'ongoing',   'teams' => 8,  'matches' => 28, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Summer Soccer Cup',               'sport' => 'Soccer',      'start_date' => '2025-06-01', 'end_date' => '2025-08-15', 'status' => 'upcoming',  'teams' => 16, 'matches' => 64, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Badminton Invitational',          'sport' => 'Badminton',   'start_date' => '2024-09-01', 'end_date' => '2024-11-30', 'status' => 'completed', 'teams' => 10, 'matches' => 40, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Teams ──────────────────────────────────────
        DB::table('teams')->insertOrIgnore([
            ['name' => 'Phoenix Fuel Masters',  'players' => 12, 'wins' => 18, 'losses' => 4,  'points' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Barangay Ginebra',       'players' => 12, 'wins' => 16, 'losses' => 6,  'points' => 48, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TNT Tropang Giga',       'players' => 11, 'wins' => 14, 'losses' => 8,  'points' => 42, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meralco Bolts',          'players' => 12, 'wins' => 13, 'losses' => 9,  'points' => 39, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'San Miguel Beermen',     'players' => 13, 'wins' => 12, 'losses' => 10, 'points' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NLEX Road Warriors',     'players' => 11, 'wins' => 10, 'losses' => 12, 'points' => 30, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Matches ────────────────────────────────────
        DB::table('matches')->insertOrIgnore([
            ['team_a' => 'Phoenix Fuel Masters', 'team_b' => 'Barangay Ginebra',  'score_a' => 98,  'score_b' => 92, 'status' => 'live',      'date' => '2025-04-15', 'time' => '19:00:00', 'venue' => 'Smart Araneta Coliseum', 'tournament' => 'National Basketball League 2025', 'created_at' => now(), 'updated_at' => now()],
            ['team_a' => 'TNT Tropang Giga',     'team_b' => 'Meralco Bolts',     'score_a' => 0,   'score_b' => 0,  'status' => 'scheduled', 'date' => '2025-04-16', 'time' => '16:30:00', 'venue' => 'Ynares Center',          'tournament' => 'National Basketball League 2025', 'created_at' => now(), 'updated_at' => now()],
            ['team_a' => 'San Miguel Beermen',   'team_b' => 'NLEX Road Warriors', 'score_a' => 0,  'score_b' => 0,  'status' => 'scheduled', 'date' => '2025-04-17', 'time' => '18:00:00', 'venue' => 'PhilSports Arena',       'tournament' => 'National Basketball League 2025', 'created_at' => now(), 'updated_at' => now()],
            ['team_a' => 'Phoenix Fuel Masters', 'team_b' => 'TNT Tropang Giga',  'score_a' => 105, 'score_b' => 88, 'status' => 'completed', 'date' => '2025-04-10', 'time' => '19:00:00', 'venue' => 'Smart Araneta Coliseum', 'tournament' => 'National Basketball League 2025', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
