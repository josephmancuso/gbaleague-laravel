<?php

namespace App\Helpers\Messaging;

use App\Leagues;

class Discord
{
    public function __construct(Leagues $league)
    {
        $this->id = $league->discordid;
        $this->token = $league->discordtoken;
    }

    public function send($message)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', "https://discordapp.com/api/webhooks/$this->id/$this->token", [
            'form_params' => [
                'content' => $message,
                'username' => 'GBALeague.com'
            ]
        ]);
    }

    public static function acceptIntegration($request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://discordapp.com/api/oauth2/token', [
            'form_params' => [
                'client_id' => getenv('DISCORD_CLIENT_ID'),
                'client_secret' => getenv('DISCORD_CLIENT_SECRET'),
                'code' => $request->input('code'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => $request->url()
            ]
        ]);

        return json_decode($res->getBody());
    }
}
