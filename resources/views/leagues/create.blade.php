@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create A New League</div>

                <div class="panel-body">
                    @include('spark::shared.errors')

                    <form class="form-horizontal" role="form" method="POST" action="/leagues/create">
                        {{ csrf_field() }}

                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">League Name</label>

                            <div class="col-md-6">
                                <input type="type" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">League Overview</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="overview"></textarea>
                            </div>
                        </div>

                        <!-- Create Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">

                            @auth
                            
                            @if(Auth::user()->canCreateLeagues())
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa m-r-xs fa-plus"></i>
                                    Create
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa m-r-xs fa-close"></i>
                                    Please Subscribe
                                </button>
                            @endif
                            @endauth
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
