<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    protected $dates = ['date'];
    public function getTeam1()
    {
        return $this->belongsTo('App\Teams', 'team1');
    }

    public function getTeam2()
    {
        return $this->belongsTo('App\Teams', 'team2');
    }

    public function getWinner()
    {
        return $this->belongsTo('App\Teams', 'winner');
    }
}
