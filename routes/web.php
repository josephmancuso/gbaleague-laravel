<?php

use App\Helpers\Messaging\Slack;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show')->name('dashboard');
Route::post('/login', 'Auth\LoginController@authenticate');

/*
|-------------------------------------------------------------------------
| League Routes
|-------------------------------------------------------------------------
*/
Route::get('leagues', 'LeagueController@show');
Route::get('leagues/create', 'LeagueController@create');
Route::post('leagues/create', 'LeagueController@store');
Route::get('league/{slug}', 'LeagueController@single');

/*
|-------------------------------------------------------------------------
| Single League Routes
|-------------------------------------------------------------------------
*/
Route::get('league/{slug}/join', 'SingleLeagueController@join')->name('league-join');
Route::get('league/{slug}/teams', 'SingleLeagueController@teams');
Route::get('league/{slug}/requests', 'SingleLeagueController@requests');
Route::get('league/{slug}/chat', 'SingleLeagueController@chat')->name('league.chat');
Route::get('league/{slug}/draft', 'DraftController@show');
Route::get('league/{slug}/schedule', 'SingleLeagueController@schedule');

Route::post('league/{slug}/join', 'SingleLeagueController@storeJoin');
Route::post('league/{slug}/requests', 'SingleLeagueController@storeRequest');
Route::post('league/{slug}/teams/remove', 'SingleLeagueController@storeRemoveTeam');
Route::post('league/{slug}/draft', 'DraftController@store');
Route::post('league/{slug}/draft/status', 'DraftController@storeStatus');
Route::post('league/{slug}/draft/skip', 'DraftController@storeSkip');
Route::post('league/{slug}/schedule', 'SingleLeagueController@storeSchedule');
Route::post('league/{slug}/schedule/remove', 'SingleLeagueController@removeSchedule');
Route::post('league/{slug}/queue', 'DraftController@queue');
Route::post('league/{slug}/pokemon/remove', 'SingleLeagueController@removePokemon');

/*
|-------------------------------------------------------------------------
| Team Routes
|-------------------------------------------------------------------------
*/
Route::get('teams/create', 'TeamController@show');
Route::post('teams/create', 'TeamController@store');

Route::get('integration/oauth/slack', 'IntegrationsController@slack');
Route::post('integration/oauth/slack/{slug}/remove', 'IntegrationsController@slackRemove');
Route::get('integration/oauth/discord', 'IntegrationsController@discord');
Route::post('integration/oauth/discord/{slug}/remove', 'IntegrationsController@discordRemove');
