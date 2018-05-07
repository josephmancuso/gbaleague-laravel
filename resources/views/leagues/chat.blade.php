@extends('leagues.single')

@section('content-right')
    <div class="panel panel-default">
        <div class="panel-heading">
            Chat Integrations
        </div>

        <div class="panel-body">

                <div>
                    @if($league->slackwebhook)
                        <button class="btn btn-success">
                            <img src="{{ asset('img/slack-mono.svg') }}" height="35px">
                            Slack Integrated Successfully
                        </button>
                        
                        <form action="/integration/oauth/slack/{{ $league->slug }}/remove" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-danger" type="submit">
                                <img src="{{ asset('img/slack-mono.svg') }}" height="35px">
                                Remove
                            </button>
                        </form>
                        

                    @else
                        <a href="https://slack.com/oauth/authorize?scope=incoming-webhook&client_id={{ getenv('SLACK_CLIENT_ID') }}&state={{ $league->id }}&redirect_uri=http://b7c2357a.ngrok.io/integration/oauth/slack">
                            <button class="btn btn-default">
                                <img src="{{ asset('img/slack-mono.svg') }}" height="35px">
                                Add to <b>Slack</b>
                            </button>


                        </a>
                    @endif

                    
                </div>

                <br>
                <div>
                    @if($league->discordid)
                        <button class="btn btn-success">
                            <img src="{{ asset('img/discord-mono.png') }}" height="35px">
                            Discord Integrated Successfully
                        </button>

                        <form action="/integration/oauth/discord/{{ $league->slug }}/remove" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-danger">
                                <img src="{{ asset('img/discord-mono.png') }}" height="35px">
                                Remove
                            </button>
                        </form>
                    @else
                        <a href="https://discordapp.com/api/oauth2/authorize?response_type=code&client_id={{ getenv('DISCORD_CLIENT_ID') }}&scope=webhook.incoming&state={{$league->id}}&redirect_uri=http://b7c2357a.ngrok.io/integration/oauth/discord">
                        
                            <button class="btn btn-default">
                            <img src="{{ asset('img/discord-mono.png') }}" height="35px">
                            Add to <b>Discord</b>
                            </button>
                            
                        </a>
                    @endif
                    
                </div>
        </div>
    </div>
@endsection