<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Requests;
use App\DraftedPokemon;
use App\Leagues;

class Teams extends Model
{
    protected $table = 'gbateams';

    public function owners()
    {
        return $this->BelongsTo('App\User', 'owner');
    }

    public function leagues()
    {
        return $this->belongsTo('App\Leagues', 'league');
    }

    public function isRequestPending($leagueId)
    {
        return Requests::where('league', $leagueId)->where('team', $this->id)->exists();
    }

    public function getPokemon()
    {
        return DraftedPokemon::where('team', $this->id)->where('league', $this->league)->whereNotNull('pokemon')->get();
    }

    public function countPokemon()
    {
        return DraftedPokemon::where('team', $this->id)->where('league', $this->league)->whereNotNull('pokemon')->count();
    }
}
