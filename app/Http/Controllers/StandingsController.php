<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StandingsController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('teams');

        if ($request->search) {
            $query->where('name','like','%'.$request->search.'%');
        }

        match($request->sort ?? 'points') {
            'wins' => $query->orderByDesc('wins'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('points'),
        };

        $teams = $query->get()->map(fn($t) => (array)$t)->toArray();

        $allMatches = DB::table('matches')->get();
        $allPts     = array_column($teams, 'points');
        $allWins    = array_sum(array_column($teams, 'wins'));
        $allLoss    = array_sum(array_column($teams, 'losses'));
        $totG       = ($allWins + $allLoss) ?: 1;

        $matchStats = [
            'total'     => $allMatches->count(),
            'live'      => $allMatches->where('status','live')->count(),
            'winPct'    => round($allWins / $totG * 100),
            'avgPts'    => count($teams) > 0 ? round(array_sum($allPts) / count($teams), 1) : 0,
            'maxPoints' => count($allPts) ? max($allPts) : 1,
        ];

        return view('pages.standings.index', compact('teams','matchStats'));
    }
}
