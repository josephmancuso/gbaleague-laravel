@extends('leagues.single')

@section('content-right')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Teams</div>
                    <div class="panel-body">
                    @if(session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                    @endif
                        @forelse($teams as $team)
                            <div class="col-xs-12 col-md-6">
                                <div class="card text-center">
                                    <img class="img-responsive" src="{{ asset($team->picture) }}"><br>
                                    <h3>{{ $team->name }}</h3>
                                    <h4>Owner: {{ $team->owners->name }}</h4>
                                    <h4>Points: {{ $team->points }}</h4>
                                    @auth
                                        @if ($league->userIsHost() || $team->owner == Auth::user()->id)
                                        <form action="/league/{{ $league->slug }}/teams/remove" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="team" value="{{ $team->id }}">
                                            <button type="submit" class="btn btn-danger"><span class="fa fa-times"></span> Remove Team</button>
                                        </form>
                                        @endif
                                    @endauth

                                    <hr>
                                    <h3>Pokemon</h3>
                                    @forelse($team->getPokemon() as $pokemon)
                                        <div class="form-group">
                                        <h4>{{ $pokemon->getPokemon->name }}</h4>
                                        
                                        @if ($league->userIsHost())
                                        <form action="/league/{{ $league->slug }}/pokemon/remove" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $pokemon->id }}" name="pokemon">
                                            <button type="submit" class="btn btn-primary">Remove Pokemon</button>
                                        </form>
                                        @endif
                                        </div><hr>
                                    @empty
                                        This team has no pokemon
                                    @endforelse
                                </div>
                            </div>
                        @empty
                        <div class="form-group">This league has no teams. </div>
                        <a href="/league/{{ $league->slug }}/join" class="btn btn-success"><span class="fa fa-plus"></span> Join</a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection