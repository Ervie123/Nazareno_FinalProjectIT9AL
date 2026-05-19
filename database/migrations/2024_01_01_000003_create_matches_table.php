<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('team_a');
            $table->string('team_b');
            $table->unsignedInteger('score_a')->default(0);
            $table->unsignedInteger('score_b')->default(0);
            $table->string('tournament')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
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
