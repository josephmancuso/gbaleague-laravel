<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

use App\Helpers\Messaging\Slack;
use App\Helpers\Messaging\Discord;

use App\Requests;
use App\Pokemon;
use App\DraftedPokemon;
use App\Teams;

class Leagues extends Model
{
    protected $table = 'leagues';

    public function owners() 
    {
        return $this->belongsTo('App\User', 'owner');
    }

    public function currentDrafter()
    {
        return $this->belongsTo('App\User', 'current');
    }

    public function isDraftOpen()
    {
        return $this->status;
    }

    public function canCurrentUserDraft()
    {
        if (Auth::user()) {
           if (($this->current || $this->owner) == Auth::user()->id || $this->owner == Auth::user()->id) {
                return true;
            } 
        }

        return false;
    }

    public function canStartDraft()
    {
        // if there are at least 2 teams
        if (Teams::where('league', $this->id)->count() >= 2) {
            return true;
        }

        return false;
    }

    public function currentDraftTeam()
    {
        return Teams::where('owner', $this->current)->where('league', $this->id)->first();
    }

    public function getUserTeam()
    {
        return Teams::where('owner', Auth::user()->id)->where('league', $this->id)->first();
    }

    public function getCurrentDraftTeamQueuedPokemon()
    {
        if ($this->currentDraftTeam()) {
            return DraftedPokemon::where('team', $this->currentDraftTeam()->id)->where('league', $this->id)->whereNotNull('queue')->get();
        }

        return [];
    }

    public function getUserTeamQueuedPokemon()
    {
        if (Auth::user()) {
            return DraftedPokemon::where('team', Auth::user()->id)->where('league', $this->id)->whereNotNull('queue')->get();
        }   

        return [];
    }

    public function userIsHost()
    {
        if (Auth::user()) {
            if ($this->owners->id == Auth::user()->id) {
                return true;
            }
        }
        return false;
    }

    public function userInLeague()
    {
        if (Auth::user()) {
            return Teams::where('owner', Auth::user()->id)->where('league', $this->id)->exists();
        }

        return false;
        
    }

    public function getRequests() 
    {
        return Requests::where('league', $this->id)->get();
    }

    public function getDraftablePokemon()
    {
        return Pokemon::whereNotIn('id', DraftedPokemon::where('league', $this->id)->whereNotNull('pokemon')->select('pokemon')->get())->orderBy('name', 'ASC')->get();
    }

    public function startDraft()
    {
        // set status
        $this->status = 1;
        $this->save();
    }

    public function closeDraft()
    {
        $this->status = 0;
        $this->save();
    }

    public function setDraftOrder()
    {
        // set ordering
        $teams = Teams::where('league', $this->id)->get();
        $draftOrder = '';
        foreach($teams as $team) {
            $draftOrder .= $team->owner . ',';
        }

        $draftOrder = rtrim($draftOrder, ',');

        $this->draftorder = $draftOrder;
        $this->save();
    }

    public function nextDrafter()
    {
        // if the order is 0 ----->
        // if the order is 1 <-----

        // get the ordering as an array
        $order = explode(',', $this->draftorder);
        // find the index of the drafter
        $currentDrafter = array_search($this->current, $order);

        // this works. need to account for ordering

        if ($this->ordering == 0) {

            if (isset($order[$currentDrafter + 1])) {
                $nextDrafter = $order[$currentDrafter + 1];
            } else {
                $nextDrafter = $order[$currentDrafter];
                $this->ordering = 1;
            }

        } else {

            if (isset($order[$currentDrafter - 1])) {
                $nextDrafter = $order[$currentDrafter - 1];
            } else {
                $nextDrafter = $order[$currentDrafter];
                $this->ordering = 0;
            }
        }

        $this->current = $nextDrafter;

        return $this->save();
    }

    public function broadcast($message)
    {
        if ($this->slackwebhook) {
            $slack = new Slack(\App\Leagues::find(1));
            $slack->client()->send($message);
        }

        if ($this->discordid) {
            $discord = new Discord(\App\Leagues::find(1));
            $discord->send($message);
        }
        
    }

}
