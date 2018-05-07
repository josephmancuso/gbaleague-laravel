<?php

namespace App;

use Laravel\Spark\User as SparkUser;

use App\Teams;

class User extends SparkUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function getTeams()
    {
        return Teams::where('owner', $this->id)->where('league', null)->get();
    }

    public function getTeamsRegardless()
    {
        return Teams::where('owner', $this->id)->get();
    }

    public function getLeagues()
    {
        return Teams::where('owner', $this->id)->whereNotNull('league')->get();
    }

    public function canCreateTeams()
    {
        // can create if they have less than 3 teams or a subscriber
        if ($this->subscribed('default')) {
            return true;
        } 

        if ($this->getTeamsRegardless()->count() < 3) {
            return true;
        }

        return false;
    }
    
    public function canCreateLeagues()
    {
        if ($this->subscribed('default')) {
            return true;
        } 

        if ($this->getLeagues()->count() < 3) {
            return true;
        }

        return false;
    }


}
