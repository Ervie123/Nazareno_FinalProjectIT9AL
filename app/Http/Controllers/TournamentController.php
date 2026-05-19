<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('tournaments');

        if ($request->filled('search')) {
            $q = '%' . $request->search . '%';
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', $q)
                  ->orWhere('sport', 'like', $q);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sport')) {
            $query->where('sport', $request->sport);
        }

        switch ($request->sort) {
            case 'date':
                $query->orderBy('start_date');
                break;
            case 'teams':
                $query->orderByDesc('teams');
                break;
            default:
                $query->orderBy('name');
        }

        $tournaments = $query->paginate(6)->withQueryString();

        $tournaments->getCollection()->transform(function ($t) {
            return [
                'id'        => $t->id,
                'name'      => trim($t->name),
                'sport'     => $t->sport,
                'status'    => $t->status,
                'teams'     => $t->teams,
                'matches'   => $t->matches,
                'startDate' => $t->start_date,
                'endDate'   => $t->end_date,
            ];
        });

        $sports = DB::table('tournaments')
            ->distinct()
            ->pluck('sport')
            ->toArray();

        return view('pages.tournaments.index', compact('tournaments', 'sports'));
    }

    public function show($id)
    {
        $tournament = DB::table('tournaments')->where('id', $id)->first();

        if (!$tournament) abort(404);

        return view('pages.tournaments.show', compact('tournament'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'sport' => 'required'
        ]);

        DB::table('tournaments')->insert([
            'name'       => trim($request->name),
            'sport'      => $request->sport,
            'start_date' => $request->startDate ?? null,
            'end_date'   => $request->endDate ?? null,
            'status'     => $request->status ?? 'upcoming',
            'teams'      => (int)($request->teams ?? 8),
            'matches'    => (int)($request->matches ?? 0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tournaments.index')->with('success', 'Tournament created!');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'  => 'required',
            'sport' => 'required'
        ]);

        $newName = trim($request->name);
        $status  = $request->status ?? 'upcoming';

        $old = DB::table('tournaments')->where('id', $id)->first();

        DB::table('tournaments')->where('id', $id)->update([
            'name'       => $newName,
            'sport'      => $request->sport,
            'start_date' => $request->startDate ?? null,
            'end_date'   => $request->endDate ?? null,
            'status'     => $status,
            'teams'      => (int)($request->teams ?? 8),
            'matches'    => (int)($request->matches ?? 0),
            'updated_at' => now(),
        ]);

        // ✅ FIX: rename matches if needed
        if ($old && trim($old->name) !== $newName) {
            DB::table('matches')
                ->whereRaw('TRIM(tournament) = ?', [trim($old->name)])
                ->update(['tournament' => $newName]);
        }

        // ✅ FIX: force matches to completed
        if ($status === 'completed') {
            DB::table('matches')
                ->whereRaw('TRIM(tournament) = ?', [$newName])
                ->update(['status' => 'completed']);
        }

        return redirect()->route('tournaments.index')->with('success', 'Tournament updated!');
    }

    public function destroy(int $id)
    {
        DB::table('tournaments')->where('id', $id)->delete();

        return redirect()->route('tournaments.index')->with('success', 'Tournament deleted.');
    }
}