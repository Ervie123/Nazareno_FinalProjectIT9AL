<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('auth_user')) {
            return redirect()->route('auth.login');
        }

        $stats = [
            'totalTournaments' => DB::table('tournaments')->count(),
            'totalTeams'       => DB::table('teams')->count(),
            'totalMatches'     => DB::table('matches')->count(),
            'liveMatches'      => DB::table('matches')->where('status', 'live')->count(),
        ];

        $ongoingTournaments = DB::table('tournaments')
            ->where('status', 'ongoing')
            ->get()
            ->map(function ($t) {
                return array_merge((array)$t, [
                    'startDate' => $t->start_date,
                    'endDate'   => $t->end_date,
                ]);
            })
            ->toArray();

        $liveMatches = DB::table('matches')
            ->where('status', 'live')
            ->get()
            ->map(function ($m) {
                return array_merge((array)$m, [
                    'teamA'  => $m->team_a,
                    'teamB'  => $m->team_b,
                    'scoreA' => $m->score_a,
                    'scoreB' => $m->score_b,
                ]);
            })
            ->toArray();

        $upcomingMatches = DB::table('matches')
            ->where('status', 'scheduled')
            ->orderBy('date')
            ->get()
            ->map(function ($m) {
                return array_merge((array)$m, [
                    'teamA'  => $m->team_a,
                    'teamB'  => $m->team_b,
                    'scoreA' => $m->score_a,
                    'scoreB' => $m->score_b,
                ]);
            })
            ->toArray();

        return view('pages.dashboard', compact(
            'stats',
            'ongoingTournaments',
            'liveMatches',
            'upcomingMatches'
        ));
    }
}