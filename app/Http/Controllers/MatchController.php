<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    // ✅ NORMALIZE + CLEAN DATA FOR BLADE
    private function mapMatch(object $m): array
    {
        return [
            'id'            => $m->id,
            'teamA'         => $m->team_a,
            'teamB'         => $m->team_b,
            'scoreA'        => $m->score_a,
            'scoreB'        => $m->score_b,

            // ✅ IMPORTANT FIX (for badge classes)
            'status'        => strtolower($m->status),

            'date'          => $m->date,
            'time'          => $m->time,
            'venue'         => $m->venue,

            // ✅ always safe string
            'tournament'    => $m->tournament_name ?? '—',

            'tournament_id' => $m->tournament_id,
        ];
    }

    public function index(Request $request)
    {
        $query = DB::table('matches')
            ->leftJoin('tournaments', 'matches.tournament_id', '=', 'tournaments.id')
            ->select(
                'matches.*',
                'tournaments.name as tournament_name'
            );

        // ✅ TAB FILTER (safe lowercase)
        $tab = strtolower($request->get('tab', 'all'));
        if ($tab !== 'all') {
            $query->whereRaw('LOWER(matches.status) = ?', [$tab]);
        }

        // ✅ SEARCH
        if ($request->filled('search')) {
            $q = '%' . $request->search . '%';
            $query->where(function ($w) use ($q) {
                $w->where('matches.team_a', 'like', $q)
                  ->orWhere('matches.team_b', 'like', $q)
                  ->orWhere('matches.venue', 'like', $q);
            });
        }

        // ✅ STATUS FILTER (dropdown)
        if ($request->filled('status')) {
            $query->whereRaw('LOWER(matches.status) = ?', [
                strtolower($request->status)
            ]);
        }

        // ✅ TOURNAMENT FILTER
        if ($request->filled('tournament')) {
            $query->where('matches.tournament_id', $request->tournament);
        }

        // ✅ SORT
        if ($request->get('sort') === 'status') {
            $query->orderBy('matches.status');
        } else {
            $query->orderBy('matches.date', 'asc');
        }

        // ✅ FETCH DATA
        $matchesRaw = $query->get();

        // ✅ GLOBAL STATS (case-safe)
        $allMatches = DB::table('matches')->get();

        $stats = [
            'total'     => $allMatches->count(),
            'live'      => $allMatches->filter(fn($m) => strtolower($m->status) === 'live')->count(),
            'scheduled' => $allMatches->filter(fn($m) => strtolower($m->status) === 'scheduled')->count(),
            'completed' => $allMatches->filter(fn($m) => strtolower($m->status) === 'completed')->count(),
        ];

        // ✅ MAP FOR VIEW
        $matches = $matchesRaw
            ->map(fn($m) => $this->mapMatch($m))
            ->toArray();

        // ✅ TOURNAMENT DROPDOWN
        $tournaments = DB::table('tournaments')
            ->select('id', 'name')
            ->get();

        return view('pages.matches.index', [
            'matches'     => $matches,
            'total'       => count($matches),
            'stats'       => $stats,
            'tournaments' => $tournaments,
            'tab'         => $tab
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'teamA' => 'required',
            'teamB' => 'required'
        ]);

        DB::table('matches')->insert([
            'team_a'        => $request->teamA,
            'team_b'        => $request->teamB,
            'score_a'       => (int)($request->scoreA ?? 0),
            'score_b'       => (int)($request->scoreB ?? 0),

            // ✅ normalize before saving
            'status'        => strtolower($request->status ?? 'scheduled'),

            'date'          => $request->date ?? null,
            'time'          => $request->time ?? null,
            'venue'         => $request->venue ?? '',
            'tournament_id' => $request->tournament ?: null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('matches.index')->with('success', 'Match created!');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'teamA' => 'required',
            'teamB' => 'required'
        ]);

        DB::table('matches')->where('id', $id)->update([
            'team_a'        => $request->teamA,
            'team_b'        => $request->teamB,
            'score_a'       => (int)($request->scoreA ?? 0),
            'score_b'       => (int)($request->scoreB ?? 0),

            // ✅ normalize again
            'status'        => strtolower($request->status ?? 'scheduled'),

            'date'          => $request->date ?? null,
            'time'          => $request->time ?? null,
            'venue'         => $request->venue ?? '',
            'tournament_id' => $request->tournament ?: null,
            'updated_at'    => now(),
        ]);

        return redirect()->route('matches.index')->with('success', 'Match updated!');
    }

    public function destroy(int $id)
    {
        DB::table('matches')->where('id', $id)->delete();

        return redirect()->route('matches.index')->with('success', 'Match deleted.');
    }
}