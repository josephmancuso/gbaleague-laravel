@extends('leagues.single')

@section('content-right')
    <div class="panel panel-default">
        <div class="panel-heading">Overview</div>
        <div class="panel-body">
        @if(session('msg'))
        <div class="alert alert-success">
            {{ session('msg')}}
        </div>
        @endif

        {{ $league->overview }}
            
        </div>
    </div>
@endsection