@extends('leagues.single')

@section('content-right')
    <div class="panel panel-default">
        <div class="panel-heading">Join {{ $league->name }}</div>
        <div class="panel-body">
        @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif

        @auth
            @unless($league->userInLeague())
                <form action="/league/{{ $league->slug }}/join" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="team">Choose Your Team</label>
                        <select id="team" name="team" class="form-control">
                            @foreach($teams as $team)
                                @unless($team->isRequestPending(1))
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endunless
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><span class="fa fa-plus"></span> Join</button>
                        <a href="/teams/create?redirect=/league/{{ $league->slug }}/join" class="btn btn-primary"><span class="fa fa-send"></span> Create New Team</a>
                    </div>
                </form>
            @endunless
        @endauth

        @guest
            <div class="alert alert-warning">Please sign in to join this league</div>
        @endguest

        @if ($league->userInLeague())
            <div class="alert alert-success">
                You are already in this league
            </div>
        @endif
        </div>
    </div>
@endsection


