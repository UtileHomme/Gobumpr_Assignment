<!-- For the Registration page -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Yoga Tracking Website') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon/yoga_awesome.ico">
    <link rel="apple-touch-icon" sizes="144x144" type="image/x-icon" href="images/favicon/yoga_awesome.png">

    <link rel="stylesheet" type="text/css" href="css/plugin.css">

    <link rel="stylesheet" type="text/css" href="css/style1.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <style>


    /*--
    Author: W3layouts
    Author URL: http://w3layouts.com
    License: Creative Commons Attribution 3.0 Unported
    License URL: http://creativecommons.org/licenses/by/3.0/
    --*/
    html,body{
        padding:0;
        margin:0;
        background:#fff;
        font-family: 'Poiret One', cursive;
    }
    body a{
        transition:0.5s all;
        -webkit-transition:0.5s all;
        -moz-transition:0.5s all;
        -o-transition:0.5s all;
        -ms-transition:0.5s all;
        text-decoration:none;
    }
    body a:hover {
        text-decoration: none;
    }

    body a:focus, a:hover {
        text-decoration: none;
    }
    input[type="email"],input[type="text"],input[type="password"],
    input[type="button"],input[type="submit"],textarea{
        font-family: 'Poiret One', cursive;
        transition:0.5s all;
        -webkit-transition:0.5s all;
        -moz-transition:0.5s all;
        -o-transition:0.5s all;
        -ms-transition:0.5s all;
    }
    h1,h2,h3,h4,h5,h6{
        margin:0;
        padding:0;
        font-family: 'Poiret One', cursive;
        letter-spacing:1px;
    }
    p{
        margin:0;
        padding:0;
        letter-spacing:1px;
        font-family: 'Poiret One', cursive;
    }
    ul{
        margin:0;
        padding:0;
    }
    body {
        position: relative;
        height: 100%;
        background: url(../images/yogaimages/yoga9.jpg);
        background-position: center center;
        background-repeat:  no-repeat;
        background-attachment: fixed;
        background-size:  cover;
        z-index: 1;
    }

    .appointment-w3{
        width: 30%;
        margin: 40px auto 40px;
        background-color:rgba(0, 0, 0, 0.52);
        padding: 40px 40px;
    }
    h1.header-w3ls {
        text-align: center;
        font-size: 50px;
        font-weight: 600;
        text-transform: uppercase;
        color: #fff;
        letter-spacing: 11px;
        text-shadow: 2px 3px rgba(0, 0, 0, 0.42);
    }

    ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #fff;
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: #fff;
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: #fff;
    }
    :-moz-placeholder { /* Firefox 18- */
        color: #fff;
    }
    .form-control-w3l{display:flex;
        display: -webkit-flex;}
        input#name, input#email,input#password,input#password_confirmation, input#orgn, input#timepicker, textarea,#datepicker1  {
            padding: 12px 15px;
            -webkit-flex-basis:100%;
            flex-basis:100%;
        }


        input#name, input#email,input#password,input#password_confirmation, input#orgn, textarea#message, input#timepicker,#datepicker1 {
            color: #fff;
            outline: none;
            letter-spacing: 1px;
            font-family: 'Muli', sans-serif;
            font-size: 15px;
            font-weight: normal;
            margin-bottom: 16px;
            border: none;
            border-right: 1px solid #fff;
            background: rgba(249, 249, 249, 0.31);
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
            -ms-transition: 0.5s all;
        }


        textarea#message{
            height: 134px;
            padding: 1em;
            overflow: hidden;
        }
        input#name:hover, input#email:hover, input#password:hover, input#password_confirmation:hover,input#orgn:hover, textarea#message:hover, input#timepicker:hover,#datepicker1:hover{border-right: 1px solid #841642;}
        input[type="submit"] {
            text-transform: uppercase;
            background: #f1f1f1;
            color: #000000;
            padding: .7em 0em;
            border: none;
            font-size: 1em;
            outline: none;
            width: 100%;
            font-family: 'Muli', sans-serif;
            letter-spacing: 1px;
            font-weight: 600;
            margin-top: 1em;
            cursor: pointer;
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
            -ms-transition: 0.5s all;
        }

        .reg
        {
            text-transform: uppercase;
            color: white;
            padding: .7em 0em;
            border: none;
            font-size: 2em;
            outline: none;
            width: 100%;
            font-family: 'Muli', sans-serif;
            letter-spacing: 1px;
            font-weight: 600;
            margin-top: 1em;
            cursor: pointer;
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
            -ms-transition: 0.5s all;
        }
        input[type="submit"]:hover {
            color: #fff;
            background: #000;
        }
        .copy{padding:0em 0 1em;}
        .copy p{
            margin:0em;
            text-align: center;
            font-size: 14px;
            color: white;
            letter-spacing: 1px;
        }
        .copy p a{
            color:#33e8ff;
            text-decoration:none;
        }
        .copy p a:hover{color:#fff;}

        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 12px;
            text-align: center;
        }

        .navigation-menu .navbar-nav li a
        {
            font-size: 15px !important;
        }
        /*--responsive--*/



        @media(max-width:1920px){
            h1.header-w3ls {
                padding-top: 80px;
            }
            .appointment-w3 {
                margin: 40px auto 70px;
            }
        }
        @media(max-width:1680px){
            .appointment-w3 {
                width: 36%;
            }
        }
        @media(max-width:1600px){
            h1.header-w3ls {
                padding-top: 31px;
            }
            .appointment-w3 {
                width: 30%;
                margin: 30px auto 30px;
            }


            ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                color: #CECACA;
                opacity: 1; /* Firefox */
                font-size: 16px;
                text-align: center;
            }
        }
        @media(max-width:1440px){
            .appointment-w3 {
                width: 35%;
            }

            ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                color: #CECACA;
                opacity: 1; /* Firefox */
                font-size: 18px;
                text-align: center;
            }
        }
        @media(max-width:1366px){
            .appointment-w3 {
                width: 32%;
                padding: 34px;
            }
            h1.header-w3ls {
                padding-top: 35px;
            }
            textarea {
                height: 111px;
            }
            ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                color: #CECACA;
                opacity: 1; /* Firefox */
                font-size: 17px;
                text-align: center;
            }
        }
        @media(max-width:1280px){
            .appointment-w3 {
                width: 45%;
            }
        }
        @media(max-width:1080px){
            .appointment-w3 {
                width: 50%;
            }
            h1.header-w3ls {
                letter-spacing: 8px;
            }
        }
        @media(max-width:1050px){
            .appointment-w3 {
                width:53%;
            }

        }
        @media(max-width:1024px){
            .appointment-w3 {
                width:56%;
                margin: 23px auto 23px;
            }
            h1.header-w3ls {
                font-size: 35px;
                padding-top: 30px;
            }
            input[type="submit"] {
                margin-top: .5em;
            }
            textarea {
                height: 80px;
            }
        }

        @media(min-width:800px) and (max-width:1280px) and (orientation:portrait)
        {
            .appointment-w3 {
                width: 69%;
                padding: 135px;
                margin-top: -30px;
            }

            ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                color: #CECACA;
                opacity: 1; /* Firefox */
                font-size: 17px;
                text-align: center;
            }

            .inputregister
            {
                width: 371px !important;
                margin-left: -68px;
                height: 88px;
            }

            input[type="submit"]
            {
                width: 373px !important;
                margin-left: -68px;
            }

            .reg
            {
                position: absolute;
                top:-1px;
                left:6px;

                text-transform: uppercase;
                color: white;
                border: none;
                font-size: 36px;
                outline: none;
                width: 100%;
                font-family: 'Muli', sans-serif;
                letter-spacing: 1px;
                font-weight: 600;
                cursor: pointer;
                -webkit-transition: 0.5s all;
                padding: .7em 0em;
                margin-top: 1em;
            }

        }


        /* @media(max-width:991px){
        .appointment-w3 {
        width: 57%;
    }
    } */
    @media(max-width:900px){

    }

    @media(max-width:768px){
        .appointment-w3 {
            width: 74%;
        }
    }
    @media(max-width:767px){
        .appointment-w3 {
            width: 76%;
        }


        .reg
        {
            margin-top:-20px;
            color:white;
        }
    }
    @media(max-width:736px){
        .appointment-w3 {
            width: 78%;
        }
    }
    @media(max-width:667px){
        h1.header-w3ls {
            letter-spacing: 5px;
        }
        .appointment-w3 {
            width: 78%;
        }
    }

    @media(max-width:640px) and (orientation:landscape)
    {
        .appointment-w3 {
            width: 69%;
            padding: 135px;
            margin-top: -197px;
        }

        .inputregister
        {
            width: 371px !important;
            margin-left: -68px;
            height: 88px;
        }

        input[type="submit"]
        {
            width: 373px !important;
            margin-left: -68px;
        }

        .reg
        {
            position: absolute;
            top:-1px;
            left:6px;

            text-transform: uppercase;
            color: white;
            border: none;
            font-size: 36px;
            outline: none;
            width: 100%;
            font-family: 'Muli', sans-serif;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
            -webkit-transition: 0.5s all;
            padding: .7em 0em;
            margin-top: 1em;
        }

    }
    @media(max-width:640px){
        h1.header-w3ls {
            font-size: 33px;
        }
        .copy p {
            margin: 0em 1em;
        }

        .reg
        {
            font-size: 21px !important;
        }
    }
    @media(max-width:600px){
        .appointment-w3 {
            padding: 25px;
            width:60%;
            height:70%;
            margin-top: -114px;
        }
        h1.header-w3ls {
            font-size: 30px;
        }
        .copy p {
            line-height: 22px;
        }

        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 17px;
            text-align: center;
        }
    }
    @media(max-width:568px){
        h1.header-w3ls {
            letter-spacing:3px;
        }
        input[type="submit"] {
            font-size:0.8em;
        }
    }
    @media(max-width:480px){
        h1.header-w3ls {
            letter-spacing:2px;
            font-size: 28px;
        }
    }
    @media(max-width:440px){
        h1.header-w3ls {
            font-size: 25px;
        }
    }
    @media(max-width:414px){
        h1.header-w3ls {
            font-size: 22px;
            padding-top: 21px;
        }
        .appointment-w3 {
            padding: 40px;
            margin: 15px auto 15px;
            width: 79%;
        }
        textarea {
            height: 72px;
        }


        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 12px;
            text-align: center;
        }
        .inputregister
        {
            width: 100px !important;
            margin-left: 5px;
        }

        input[type="submit"]
        {
            width: 221px !important;
            margin-left: 5px;

        }
        .copy {
            padding: 0em 0 0.5em;
        }
    }
    @media(max-width:384px){
        h1.header-w3ls {
            font-size: 22px;
            padding-top: 21px;
        }
        .appointment-w3 {
            padding: 21px;
            margin: 15px auto 15px;
            width: 79%;
        }
        textarea {
            height: 72px;
        }


        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 12px;
            text-align: center;
        }
        .inputregister
        {
            width: 100px !important;
            margin-left: 5px;
        }

        input[type="submit"]
        {
            width: 223px !important;
            margin-left: -8px;
        }
        .copy {
            padding: 0em 0 0.5em;
        }
    }
    @media(max-width:360px){
        h1.header-w3ls {
            font-size: 22px;
            padding-top: 21px;
        }
        .appointment-w3 {
            padding: 21px;
            margin: 15px auto 15px;
            width: 79%;
        }
        textarea {
            height: 72px;
        }

        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 12px;
            text-align: center;
        }
        .inputregister
        {
            width: 100px !important;
            margin-left: 1px;
        }

        input[type="submit"]
        {
            width: 223px !important;
                margin-left: 0px;
        }
        .copy {
            padding: 0em 0 0.5em;
        }
    }
    @media(max-width:320px){
        h1.header-w3ls {
            font-size: 22px;
            padding-top: 21px;
        }
        .appointment-w3 {
            padding: 21px;
            margin: 15px auto 15px;
            width: 90%;
        }
        textarea {
            height: 72px;
        }

        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #F7EDEB;
            opacity: 1; /* Firefox */
            font-size: 12px;
            text-align: center;
        }
        .inputregister
        {
            width: 100px !important;
            margin-left: 1px;
        }

        input[type="submit"]
        {
            width: 223px !important;
                margin-left: 0px;
        }
        .copy {
            padding: 0em 0 0.5em;
        }
    }
    /* @media(max-width:375px){
    .appointment-w3 {
    width: 80%;
}
}
@media(max-width:320px){
h1.header-w3ls {
font-size: 20px;
letter-spacing: 1px;
}
textarea {
height: 66px;
}
input#name, input#email, input#orgn, textarea#message, input#timepicker, #datepicker1 {
font-size: 14px;
}
.copy p {
font-size: 13px;
}
} */
/*--//responsive--*/



</style>
</head>
<body>

    @include('partial/_message')
    @include('partial/_errors')
    <header id="home" class="home-section">

        <div class="header-top-area">
            <div class="container">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="logo">
                            <a href="{{url('/')}}">Restaurant Finder</a>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        <div class="navigation-menu">
                            <div class="navbar">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a class="smoth-scroll" href="{{ route('admin.login') }}">Login</a>
                                        </li>
                                        <li><a class="smoth-scroll" href="{{ route('trainee.register') }}">Register</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-section-background" data-stellar-background-ratio="0.6">
            <div class="display-table">
                <div class="display-table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center register">
                                @yield('content')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- <div class="">
    @if (Route::has('login'))

    <div class="top-left links">
    <a href="{{ url('/') }}" class="navbar_style yoga_style top_left">Restaurant Finder</a>
</div>
<div class="top-right links">
@if (Auth::check())
<a href="{{ url('/home') }}">Home</a>
@else
<a href="{{ route('admin.login') }}" class="navbar_style">Login</a>
<a href="{{ route('trainee.register') }}"class="navbar_style">Register</a>
@endif
</div>
@endif
</div> -->



</div>
</body>
</html>
