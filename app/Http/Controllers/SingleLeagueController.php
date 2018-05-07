<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Leagues;
use App\Teams;
use App\Requests;
use App\Schedules;
use App\DraftedPokemon;

class SingleLeagueController extends Controller
{
    public function join($slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        if (Auth::user()) {
            $teams = Auth::user()->getTeams();
        } else {
            $teams = [];
        }
        
        return view('leagues.join', compact('league', 'teams'));
    }

    public function storeJoin(Request $request, $slug)
    {
        $team = Teams::find($request->input('team'));
        $league = Leagues::where('slug', $slug)->first();

        // store inside request
        $requests = new Requests;

        $requests->team = $team->id;
        $requests->owner = Auth::user()->id;
        $requests->league = $league->id;

        $requests->save();

        $league->broadcast(
            $requests->teams->name . ', owned by '
            . $requests->owners->name .', has requested to be in your league'
        );

        return redirect()->back()->with(['slug' => $slug, '', 'msg' => 'Your request is pending acceptance by the league host']);
    }

    public function teams($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        $teams = Teams::where('league', $league->id)->get();
        return view('leagues.teams', compact('league', 'teams'));
    }

    public function storeRemoveTeam(Request $request, $slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        $team = Teams::find($request->input('team'));
        $team->league = null;
        $team->points = 1000;
        $team->save();

        $league->broadcast(
            $team->name . ' has been removed from this league'
        );

        // remove any drafted pokemon
        DraftedPokemon::where('team', $team->id)->delete();

        if ($team->owner == $league->current) {
            $league->nextDrafter();
        }

        if ($team->owner == $league->current) {
            $league->nextDrafter();
        }

        $league->setDraftOrder();
        return redirect()->back()->with(['slug' => $slug, '', 'msg' => 'You have removed this team']);
    }

    public function requests($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        $requests = Requests::where('league', $league->id)->get();
        return view('leagues.requests', compact('league', 'requests'));
    }

    public function storeRequest(Request $request)
    {
        $leagueRequest = Requests::find($request->input('request'));
        $slug = $leagueRequest->leagues->slug;
        $league = Leagues::where('slug', $slug)->first();
        // Delete Request
        if ($request->has('decline')) {
            $league->broadcast(
                $leagueRequest->teams->name . ' has been declined to join this league'
            );

            $leagueRequest->delete();

            return redirect()->back()->with(['slug' => $slug, '', 'msg' => 'You have declined this user']);
        }

        // Accept Request
        $team = Teams::find($leagueRequest->team);

        $team->league = $leagueRequest->league;

        $team->save();
        $leagueRequest->delete();

        $league->broadcast(
            $team->name . ' has been accepted into your league!'
        );

        $league->setDraftOrder();

        return redirect()->back()->with(['slug' => $slug, 'msg' => 'You have accepted this user']);
    }

    public function chat($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        return view('leagues.chat', compact('league'));
    }

    public function schedule($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        $teams = Teams::where('league', $league->id)->get();
        $schedules = Schedules::where('league', $league->id)->get();
        return view('leagues.schedule', compact('league', 'teams', 'schedules'));
    }

    public function storeSchedule($slug, Request $request)
    {
        $schedule = new Schedules;

        $league = Leagues::where('slug', $slug)->first();

        $schedule->league = $league->id;
        $schedule->team1 = $request->input('team1');
        $schedule->team2 = $request->input('team2');
        $schedule->date = new Carbon($request->input('date'));

        $schedule->save();

        $league->broadcast(
            'A schedule has been set for '
            . $schedule->getTeam1->name . ' vs '
            . $schedule->getTeam2->name. ' on '
            . (new Carbon($schedule->date))->toFormattedDateString()
        );

        return redirect()->back()->with(['msg' => 'Schedule Saved']);
    }

    public function removeSchedule($slug, Request $request)
    {
        Schedules::find($request->input('schedule'))->delete();
        return redirect()->back()->with(['msg' => 'Schedule Removed']);
    }

    public function removePokemon(Request $request)
    {
        DraftedPokemon::find($request->input('pokemon'))->delete();
        return redirect()->back()->with(['msg' => 'Pokemon removed']);
    }
}
