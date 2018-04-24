<!-- This blade is for the main screen of the website -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Restaurant Finder') }}</title>


    <link rel="stylesheet" type="text/css" href="css/plugin.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style type="text/css">

    .style-3::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5  ;
    }

    .style-3::-webkit-scrollbar
    {
        width: 6px;
        background-color: #F5F5F5  ;
    }

    .style-3::-webkit-scrollbar-thumb
    {
        background-color: #1B1617  ;
    }

    @media only screen and (min-width:960px) and (orientation:landscape){
        .navbar-right
        {
            margin-right: -37px !important;
        }
    }



    @media only screen and (min-width:768px) and (orientation:portrait){
        .navbar-right
        {
            margin-right: -37px !important;
        }
    }


    </style>
</head>

<body class="style-3">



    <div id="preloader">
        <div class="loader"></div>
    </div>



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
                                    <ul class="nav navbar-nav navbar-right nav-layout">
                                        <!-- <li class="active"><a class="smoth-scroll" href="#home">Home <div class="ripple-wrapper"></div></a>
                                        </li> -->
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
                            <div class="col-md-12 text-center">
                                <div class="header-text">
                                    <h2 style="font-size:30px;"><span class="typing"></span></h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>









    <!-- Back to Top Start -->
    <a href="#" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- Back to Top End -->


    <!-- All Javascript Plugins  -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/plugin.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyC0HAKwKinpoFKNGUwRBgkrKhF-sIqFUNA"></script>

    <!-- Main Javascript File  -->
    <script type="text/javascript" src="js/scripts.js"></script>


</body>
</html>
