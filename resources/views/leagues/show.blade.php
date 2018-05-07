@extends('spark::layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <a href="/leagues/create" class="btn btn-success"><span class="fa fa-plus"></span> Create A League</a>
        </div>
    </div>
    <div class="row">
    @foreach($leagues as $league)
        <div class="col-xs-12 col-sm-4">
            <div class="card bg-white">
            
                <h3>{{ $league->name }}</h3>
                <hr>
                <h4> Owner: {{ $league->owners->name }} </h4>
                <a class="btn btn-primary" href="league/{{ $league->slug }}">Go To League</a>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection