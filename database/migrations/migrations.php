<?php
// database/migrations/2024_01_01_000001_create_tournaments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sport');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->integer('teams_count')->default(8);
            $table->integer('matches_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};

// ─────────────────────────────────────────────────────────────────────────────

// database/migrations/2024_01_01_000002_create_teams_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('players')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};

// ─────────────────────────────────────────────────────────────────────────────

// database/migrations/2024_01_01_000003_create_matches_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('tournament')->nullable();
            $table->string('team_a');
            $table->string('team_b');
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);
            $table->date('match_date');
            $table->time('match_time')->default('12:00:00');
            $table->string('venue')->nullable();
            $table->enum('status', ['scheduled', 'live', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
