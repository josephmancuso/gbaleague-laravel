<?php

namespace App\Helpers\Messaging;

use Illuminate\Http\Request;

class Slack
{
    public function __construct(\App\Leagues $league)
    {
        $this->webhook = $league->slackwebhook;
        $this->channel = $league->slackchannel ?: '#general';
    }

    public function client() {
        $settings = [
            'username' => 'GBA.League.com',
            'channel' => $this->channel,
            'link_names' => true
        ];
        return new \Maknz\Slack\Client($this->webhook, $settings);
    }

    public static function acceptIntegration(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://slack.com/api/oauth.access', [
            'form_params' => [
                'client_id' => getenv('SLACK_CLIENT_ID'),
                'client_secret' => getenv('SLACK_CLIENT_SECRET'),
                'redirect_uri' => $request->url(),
                'code' => $_GET['code']
            ]
        ]);

        return json_decode($res->getBody());
    }
}
