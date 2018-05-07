@extends('leagues.single')

@section('content-right')
    <div class="panel panel-default">
        <div class="panel-heading">
            Team Schedules
        </div>

        <div class="panel-body">
        @if(session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif

        @if($league->userIsHost())
            <form action="/league/{{ $league->slug }}/schedule" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">Team 1</label>
                    <select name="team1" class="form-control">
                        @foreach($teams as $team)
                            <option value="{{$team->id}}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="">Team 2</label>
                    <select name="team2" class="form-control">
                        @foreach($teams as $team)
                            <option value="{{$team->id}}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="Date" name="date">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Schedule</button>
                </div>
            </form>
        @endif
        <h3>Scheduled Matches</h3>
        <div class="row">

            <div class="col-xs-3">
                <h4>Team 1</h4>
            </div>

            <div class="col-xs-3">
                <h4>Team 2</h4>
            </div>
            
            <div class="col-xs-3">
                <h4>Date</h4>
            </div>
            
            <div class="col-xs-3">
            &nbsp;
            </div>
        </div>
        
        




        
            @forelse($schedules as $schedule)
            <div class="row">
                <div class="col-xs-3">
                    {{ $schedule->getTeam1->name }}
                </div>
                
                <div class="col-xs-3">
                    {{ $schedule->getTeam2->name }}
                </div>
                
                <div class="col-xs-3">
                    {{ $schedule->date->toFormattedDateString() }}
                </div>

                <div class="col-xs-3">
                @if($league->userIsHost())
                <form action="/league/{{ $league->slug }}/schedule/remove" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $schedule->id }}" name="schedule">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
                    
                @else
                    &nbsp;
                @endif
                </div>
            </div>
            <br>
            @empty
               <div class="row"><div class="col-xs-12"> No matches are scheduled</div></div>
            @endforelse
        </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="{{ asset('js/bootstrap-date-picker/js/bootstrap-datepicker.min.js') }}"></script>
@endsection

@section('css')
<link href="{{ asset('js/bootstrap-date-picker/css/bootstrap-datepicker.css') }}" rel="stylesheet">
@endsection