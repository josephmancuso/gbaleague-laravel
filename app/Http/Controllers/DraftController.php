<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Leagues;
use App\Teams;
use App\Pokemon;
use App\DraftedPokemon;

class DraftController extends Controller
{
    public function show($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        return view('leagues.draft', compact('league'));
    }

    public function store(Request $request, $slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        // put pokemon inside drafted pokemon table
        $draftedPokemon = new DraftedPokemon;
        $draftedPokemon->team = $request->input('team');
        $draftedPokemon->pokemon = $request->input('pokemon');
        $draftedPokemon->league = $league->id;

        $draftedPokemon->save();



        // take away points from team
        $team = Teams::find($request->input('team'));
        $pokemon = Pokemon::find($request->input('pokemon'));

        $team->points -= $pokemon->points;
        $team->save();

        

        // remove pokemon from queue
        DraftedPokemon::where('queue', $request->input('pokemon'))->delete();

        // put next person in draft
        $league->nextDrafter();

        $league->broadcast(
            $draftedPokemon->getTeam->name. ', owned by '
            . $team->owners->name .', has just drafted '
            . $draftedPokemon->getPokemon->name. ' for '
            . $draftedPokemon->getPokemon->points . ' points. They have '
            . $team->points . ' points left and '
            . $team->countPokemon() .' Pokemon total. It is now '
            . $league->currentDrafter->name . "'s turn to draft"    
        );

        return redirect()->back()->with(['slug' => $slug, '', 'msg' => 'You have drafted a Pokemon']);

    }

    public function storeStatus(Request $request, $slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        if ($request->has('start')) {
            $league->startDraft();
            $msg = 'You have started the draft';
            $league->broadcast('The draft has started!');
        } elseif ($request->has('close')) {
            $league->closeDraft();
            $msg = 'You have closed the draft';
            $league->broadcast('The draft has closed!');
        }

        return redirect()->back()->with(['slug' => $slug, '', 'msg' => $msg]);
    }

    public function storeSkip($slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        $previousDrafter = $league->currentDrafter->name;
        $league->nextDrafter();

        $league = Leagues::where('slug', $slug)->first();

        $league->broadcast(
            $previousDrafter . ' has been skipped, it is now '
            . $league->currentDrafter->name . "'s turn to draft"
        );

        

        return redirect()->back()->with(['slug' => $slug, '', 'msg' => 'User has been skipped. They will not be able to draft again this round.']);
    }

    public function queue($slug, Request $request)
    {
        $league = Leagues::where('slug', $slug)->first();
        // queue
        if ($request->has('queue')) {
            $queue = new DraftedPokemon;

            $queue->team = $league->getUserTeam()->id;
            $queue->pokemon = null;
            $queue->queue = $request->input('queuedPokemon');
            $queue->league = $league->id;

            $queue->save();

            $msg = 'You have successfully queued a Pokemon';
        } else {
            DraftedPokemon::where('league', $league->id)->where('team', $league->getUserTeam()->id)->where('queue', $request->input('queuedPokemon'))->delete();
            $msg = 'You have unqueued a Pokemon';
        }
        
        return redirect()->back()->with(['slug' => $slug, 'msg' => $msg]);
    }
}
