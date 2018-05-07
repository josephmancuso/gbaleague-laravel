<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Messaging\Slack;
use App\Helpers\Messaging\Discord;

use App\Leagues;

class IntegrationsController extends Controller
{
    public function slack(Request $request)
    {
        $integration = Slack::acceptIntegration($request);

        $league = Leagues::find($request->input('state'));

        $league->slackwebhook = $integration->incoming_webhook->url;
        $league->slackchannel = $integration->incoming_webhook->channel;

        $league->save();

        $league->broadcast('Slack integration successful. You will now see information like requests, trades, schedules, drafts and skips in this channel.');

        return redirect()->route('league.chat', ['slug' => $league->slug]);
    }

    public function slackRemove($slug)
    {
        $league = Leagues::where('slug', $slug)->first();
        $league->broadcast('Slack integration removed. You will no longer receive notifications');

        $league->slackwebhook = '';
        $league->slackchannel = '';

        $league->save();

        return redirect()->route('league.chat', ['slug' => $league->slug]);
    }

    public function discord(Request $request)
    {
        $integration = Discord::acceptIntegration($request);
        $league = Leagues::find($request->input('state'));
        $league->discordid = $integration->webhook->id;
        $league->discordtoken = $integration->webhook->token;
        $league->discordchannel = $integration->webhook->channel_id;
        $league->save();
        $league->broadcast("Discord integration successful! You will now see information like requests, trades, schedules, drafts and skips in this channel.");

        return redirect()->route('league.chat', ['slug' => $league->slug]);
    }

    public function discordRemove($slug)
    {
        $league = Leagues::where('slug', $slug)->first();

        $league->broadcast('Discord integration removed. You will no longer receive notifications');

        $league->discordid = '';
        $league->discordtoken = '';
        $league->discordchannel = '';

        $league->save();

        return redirect()->route('league.chat', ['slug' => $league->slug]);
    }
}
