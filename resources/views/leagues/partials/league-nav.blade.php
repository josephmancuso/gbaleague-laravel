<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ Request::is('*/overview') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}">Overview</a></li>
    <li class="{{ Request::is('*/draft') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/draft">Draft</a></li>
    <li class="{{ Request::is('*/teams') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/teams">Teams</a></li>
    <li class="{{ Request::is('*/join') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/join">Join</a></li>
    <li class="{{ Request::is('*/trade') ? 'active' : '' }}"><a>Trade <div class="label label-default">Premium Only</div> <div class="label label-default">Coming Soon</div></a></li>
    <li class="{{ Request::is('*/schedule') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/schedule">Schedule</a></li>
    

    @if($league->userIsHost())
        @if(Auth::user()->subscribed('default'))
            <li class="{{ Request::is('*/chat') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/chat">Chat </a></li>
        @else
            <li><a>Chat <div class="label label-default">Premium Only</div></a></li>
        @endif
        <li class="{{ Request::is('*/requests') ? 'active' : '' }}"><a href="/league/{{ $league->slug}}/requests">Requests <div class="label label-success">{{ $league->getRequests()->count() }}</div></a></li>
    @endif
</ul>