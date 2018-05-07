@extends('leagues.single')

@section('content-right')
<div class="panel panel-default">
    <div class="panel-heading">
        Draft
    </div>

    <div class="panel-body">
    @if(session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif
    @if ($league->userIsHost())
        @if ($league->canStartDraft())
            <form action="/league/{{ $league->slug }}/draft/status" method="POST">
            {{ csrf_field() }}
            @if ($league->status == 0) 
                <button class="btn btn-success" name="start">Start Draft</button>
            @else
                <button class="btn btn-danger" name="close"> <span class="fa fa-close"></span> Close Draft</button>
            @endif
            </form>
        @else
            <div class="alert alert-danger">Can not start draft. Make sure you have at least 2 teams</div>
        @endif
    @endif
    <br>

    @if($league->isDraftOpen())
        @if ($league->userIsHost())
            <form action="/league/{{ $league->slug }}/draft/skip" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-success"><span class="fa fa-step-forward"></span> Skip User</button>
                </div>
            </form>
        @endif

        

        <div class="row col-xs-12">
            <h3>Current Drafter: {{ $league->currentDrafter->name }} </h3>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <label for="">Select Tier</label>
                        <select class="form-control" id="tier-control">
                            <option value='all'>All</option>
                            <option value='1' selected>Tier 1</option>
                            <option value='2'>Tier 2</option>
                            <option value='3'>Tier 3</option>
                            <option value='4'>Tier 4</option>
                            <option value='5'>Tier 5</option>
                            <option value='6'>Tier 6</option>
                        </select>
                    </div>
                </div>
            </div>
            @foreach($league->getDraftablePokemon() as $pokemon)
            <div class="col-xs-6 col-sm-4" tier='{{ $pokemon->tier }}'>
                <h3>{{ $pokemon->name }} </h3>
                <h4>Points: {{ $pokemon->points }} </h4>
                @if($league->canCurrentUserDraft())
                    <form action="/league/{{ $league->slug }}/draft" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="team" value="{{ $league->currentDraftTeam()->id }}">
                        <input type="hidden" name="pokemon" value="{{ $pokemon->id }}">
                        <button type="submit" class="btn btn-danger"><span class="fa fa-plus"></span> Draft</button>
                    </form>
                    <br>
                    @auth
                        @if($league->userInleague())
                        <form action="/league/{{ $league->slug }}/queue" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $pokemon->id }}" name="queuedPokemon">
                            
                            @if ($league->getUserTeamQueuedPokemon()->contains('team', $league->getUserTeam()->id) && $league->getUserTeamQueuedPokemon()->contains('queue', $pokemon->id))
                                <button type="submit" class="btn btn-success" name="unqueue"><span class="fa fa-plus"></span> Unqueue</button>
                            @else
                                <button type="submit" class="btn btn-primary" name="queue"><span class="fa fa-plus"></span> Queue</button>
                            @endif

                        </form>
                        @endif
                    @endauth
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">The draft has not started yet. The host must start the draft</div>
    @endif
    
    </div>
</div>
@endsection

@if($league->userInLeague())
    @section('content-left')
        @if ($league->userIsHost())
            <div class="panel panel-primary">
                <div class="panel-heading">Current Drafter's Queued Pokemon <br>({{ $league->currentDraftTeam()->name}})</div>
                <div class="panel-body">
                    @forelse($league->getCurrentDraftTeamQueuedPokemon() as $pokemon)
                        <h4>{{ $pokemon->getQueuedPokemon->name }} - {{ $pokemon->getQueuedPokemon->points }} Points</h4>

                        <form action="/league/{{ $league->slug }}/draft" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="team" value="{{ $league->currentDraftTeam()->id }}">
                            <input type="hidden" name="pokemon" value="{{ $pokemon->getQueuedPokemon->id }}">

                            <button type="submit" class="btn btn-danger"><span class="fa fa-plus"></span> Draft</button>
                        </form>
                        <hr>
                    @empty
                        This team does not have any queued Pokemon
                    @endforelse
                </div>
            </div>
        @endif

        @if ($league->userInLeague())
            <div class="panel panel-primary">
                <div class="panel-heading">Your Queued Pokemon</div>

                <div class="panel-body">
                    @forelse($league->getUserTeamQueuedPokemon() as $pokemon)
                        <h4>{{ $pokemon->getQueuedPokemon->name }} - {{ $pokemon->getQueuedPokemon->points }} Points</h4>

                        <form action="/league/{{ $league->slug }}/draft" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="team" value="{{ $league->currentDraftTeam()->id }}">
                            <input type="hidden" name="pokemon" value="{{ $pokemon->getQueuedPokemon->id }}">

                            <button type="submit" class="btn btn-danger"><span class="fa fa-plus"></span> Draft</button>
                            
                        </form>
                        <form action="/league/{{ $league->slug }}/queue" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $pokemon->getQueuedPokemon->id }}" name="queuedPokemon">
                            
                            <button type="submit" class="btn btn-success" name="unqueue"><span class="fa fa-plus"></span> Unqueue</button>
                            
                        </form>
                        <hr>
                    @empty
                        You do not have any queued Pokemon
                    @endforelse
                </div>
            </div>
        @endif
    @endsection
@endif

@section('javascript')
<script type="text/javascript">
function tierControl() {
    tier = $('#tier-control').val()

    if (tier == 'all') {
        $('[tier]').show();
    } else {
        $('[tier]').hide();
        $("[tier='"+tier+"']").show();
    }
}

tierControl();

$('#tier-control').on('change', function(){
    tierControl();
})
</script>
@endsection