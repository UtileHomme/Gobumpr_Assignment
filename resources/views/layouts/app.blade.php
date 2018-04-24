<!-- This is the generalized view for dashboard -->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant Finder') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">
    <link href="../css/panel.css" rel="stylesheet">

    <style media="screen">
    body
    {
        background-color: #fff ;
    }
    #dash
    {
        position: relative;
        top:50%;
    }

    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-fixed-top navbar-custom ">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand " href="{{ url('/') }}" style="margin-left: -80px;">
                        <div class="yoga_tracker">
                            <strong>{{ config('app.name', 'Restaurant Finder') }}</strong>
                        </div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ route('admin.login') }}" >Login</a></li>
                        <li style="margin-right: -204px;"><a href="{{ route('trainee.register') }}" >Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="padding-left: 16px; padding-right: 14px; width:160px" id="login_name">
                            <span class="login_name" ><strong class="text-center">{{ Auth::user()->name }} </span> <span class="caret"></span> </strong>
                            </a>

                            <ul class="dropdown-menu" role="menu" style="width:130px !important">
                                <li >
                                    <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" >
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="../js/jquery.js"> </script>
<script type="text/javascript" src="../js/login_name_hover_color.js"> </script>
</body>
</html>
