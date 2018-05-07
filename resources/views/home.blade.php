@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        Welcome to your dashboard!
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">My Leagues</div>
                    <div class="panel-body">
                        @forelse (Auth::user()->getLeagues() as $league)
                            <h4>{{ $league->leagues->name }}</h4>
                            <a href="/league/{{ $league->leagues->slug }}" class="btn btn-primary">View</a>
                        @empty
                            <div>You are not in any leagues</div>
                            <a href="/leagues" class="btn btn-primary">Find Some</a>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">My Teams</div>
                    <div class="panel-body text-center">
                        @forelse (Auth::user()->getTeamsRegardless() as $team)
                            <img src="{{ asset($team->picture) }}" class="img-responsive">
                            <h4>{{ $team->name }}</h4>
                            <div><a href="/teams/create" class="btn btn-primary"><span class="fa fa-plus"></span> Create More</a></div>
                        @empty
                            <div>You do not have any teams</div>

                            <div><a href="/teams/create" class="btn btn-primary"><span class="fa fa-plus"></span> Create</a></div>

                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
