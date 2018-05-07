<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Teams;

class TeamController extends Controller
{
    public function show()
    {
        return view('Teams.create');
    }

    public function store(Request $request, Teams $team)
    {
        $team->name = $request->input('name');
        $team->owner = Auth::user()->id;
        $team->points = 1000;
        if ($request->file('logo')) {
            $team->picture = $request->file('logo')->store('logos');
        }

        $team->save();

        if ($request->input('redirect')) {
            return redirect($request->input('redirect'))->with('msg', "Your team was created successfully");
        }

        return redirect()->route('dashboard');
    }


}
