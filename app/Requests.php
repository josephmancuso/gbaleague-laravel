<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    public function owners()
    {
        return $this->belongsTo('App\User', 'owner');
    }

    public function teams()
    {
        return $this->belongsTo('App\Teams', 'team');
    }

    public function leagues()
    {
        return $this->belongsTo('App\Leagues', 'league');
    }
}
