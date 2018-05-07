@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Navigation -->
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>{{ $league->name }}</h4></div>
                <div class="panel-body">
                    @include('leagues.partials.league-nav')
                </div>
            </div>

            @yield('content-left')
        </div>

        <!-- Right Content -->
        <div class="col-xs-12 col-sm-8">

            @yield('content-right')
        </div>
    </div>

</div>
@endsection