<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\StandingsController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login',  [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/register',[AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register',[AuthController::class, 'register'])->name('auth.register.post');
Route::get('/forgot',  [AuthController::class, 'showForgot'])->name('auth.forgot');
Route::post('/forgot', [AuthController::class, 'sendReset'])->name('auth.forgot.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ TOURNAMENTS (FIXED)
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournaments.show'); // ⭐ REQUIRED
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::put('/tournaments/{id}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    // TEAMS
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');

    // MATCHES
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
    Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');
    Route::put('/matches/{id}', [MatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{id}', [MatchController::class, 'destroy'])->name('matches.destroy');

    // STANDINGS
    Route::get('/standings', [StandingsController::class, 'index'])->name('standings.index');

});