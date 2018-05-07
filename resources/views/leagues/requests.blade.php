@extends('leagues.single')

@section('content-right')
    <div class="panel panel-default">
        <div class="panel-heading">Requests</div>
        <div class="panel-body">
        @if(session('msg'))
        <div class="alert alert-success">
            {{ session('msg')}}
        </div>
        @endif

            @forelse ($requests as $request)
            <div class="row">
                <div class="col-xs-8">{{ $request->owners->name }} owner of the {{ $request->teams->name }} wants to join</div>
                <div class="col-xs-4">
                <form action="/league/{{ $league->id }}/requests" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user" value="{{ $request->owners->id }}">
                    <input type="hidden" name="request" value="{{ $request->id }}">
                    <button type="submit" name="accept" class="btn btn-success"><span class="fa fa-check"></span> Accept</button>
                    <button type="submit" name="decline" class="btn btn-danger"><span class="fa fa-times"></span> Decline</button>
                </form>
                    
                    
                </div>
            </div>
            @empty
            No Requests
            @endforelse
            
        </div>
    </div>
@endsection