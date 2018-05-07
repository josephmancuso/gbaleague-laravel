<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Leagues;

class LeagueController extends Controller
{
    public function show()
    {
        $leagues = (new Leagues)->all();
        return view('leagues.show', compact('leagues'));
    }

    public function single($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        return view('leagues.overview', compact('league'));
    }

    public function create()
    {
        return view('leagues.create');
    }

    public function store(Request $request, Leagues $league)
    {
        $league->name = $request->input('name');
        $league->owner = Auth::user()->id;
        $league->overview = $request->input('overview');
        $league->slug = str_slug($league->name, '-');
        $league->tournament = 0;
        $league->current = Auth::user()->id;
        $league->status = 0;
        $league->ordering = 1;
        $league->draftorder = 0;
        $league->round = 1;

        $league->save();

        return redirect("/league/$league->slug");
    }
}
