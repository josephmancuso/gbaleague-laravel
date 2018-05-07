<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DraftedPokemon extends Model
{
    protected $table = 'draftedpokemon';

    public function getTeam()
    {
        return $this->belongsTo('App\Teams', 'team');
    }

    public function getPokemon()
    {
        return $this->belongsTo('App\Pokemon', 'pokemon');
    }

    public function getQueuedPokemon()
    {
        return $this->belongsTo('App\Pokemon', 'queue');
    }
}
