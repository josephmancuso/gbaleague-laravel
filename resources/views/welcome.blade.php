<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
            Spark::scriptVariables(), []
        )); ?>;
    </script>
</head>
<body class="with-navbar">
    <div id="spark-app" v-cloak>
        <!-- Navigation -->
        @if (Auth::check())
            @include('spark::nav.user')
        @else
            @include('spark::nav.guest')
        @endif

        <!-- Main Content -->
        @yield('content')

        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>

    <div class="row" style="margin-top: -30px">
        <div class="col-xs-12">
            <img src="/img/space.jpg" style="width:100%">
        </div>
    </div>
    

   <div class="panel panel-primary">
   <div class="panel-heading"></div>
    <div class="panel-body">
        <h1 class="text-center">
            Start Drafting Pokemon!
        </h1>
        <hr>
        <p>
            GBALeague.com is a site where you can join Pokemon leagues with your custom teams and draft Pokemon to crush other trainers! Nearly 7,000 other trainers have joined. The GBA format is a grueling format that questions and challenges even the best trainers.
        </p>

        <div class="text-center">
            <a href="/login" class="btn btn-success">Login</a>
            <a href="/register" class="btn btn-primary">Register</a>
        </div>
    </div>
   </div>
    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/sweetalert.min.js"></script>
    @yield('javascript')
</body>
</html>
