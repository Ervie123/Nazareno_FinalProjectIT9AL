<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('teams');

        if ($request->search) {
            $query->where('name','like','%'.$request->search.'%');
        }
        if ($request->winrate) {
            // Filter after fetch (computed column)
        }

        match($request->sort ?? 'points') {
            'wins' => $query->orderByDesc('wins'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('points'),
        };

        $total = DB::table('teams')->count();
        $all   = $query->get()->map(fn($t) => (array)$t)->toArray();

        // Win-rate filter (computed)
        if ($request->winrate) {
            $all = array_values(array_filter($all, function($t) use ($request) {
                $played = $t['wins'] + $t['losses'];
                $wr = $played > 0 ? $t['wins'] / $played * 100 : 0;
                return $request->winrate === 'high' ? $wr > 60 : $wr < 40;
            }));
        }

        $totalPlayers = array_sum(array_column($all, 'players'));
        $stats = [
            'total'        => $total,
            'totalPlayers' => $totalPlayers,
            'avgPlayers'   => $total > 0 ? round($totalPlayers / $total, 1) : 0,
        ];

        return view('pages.teams.index', compact('all','total','stats'))
            ->with('teams', $all);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        DB::table('teams')->insert([
            'name'       => $request->name,
            'players'    => (int)($request->players ?? 0),
            'wins'       => (int)($request->wins    ?? 0),
            'losses'     => (int)($request->losses  ?? 0),
            'points'     => (int)($request->points  ?? 0),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        return redirect()->route('teams.index')->with('success','Team created!');
    }

    public function update(Request $request, int $id)
    {
        $request->validate(['name' => 'required']);
        DB::table('teams')->where('id',$id)->update([
            'name'       => $request->name,
            'players'    => (int)($request->players ?? 0),
            'wins'       => (int)($request->wins    ?? 0),
            'losses'     => (int)($request->losses  ?? 0),
            'points'     => (int)($request->points  ?? 0),
            'updated_at' => now(),
        ]);
        return redirect()->route('teams.index')->with('success','Team updated!');
    }

    public function destroy(int $id)
    {
        DB::table('teams')->where('id',$id)->delete();
        return redirect()->route('teams.index')->with('success','Team deleted.');
    }
}
