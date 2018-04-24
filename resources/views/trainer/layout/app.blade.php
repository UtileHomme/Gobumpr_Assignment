<!DOCTYPE html>
<html lang="en">
<head>

    @include('trainer.layout.head')

    <style media="screen">
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
        background-color: #1B1617;
    }

    .skin-purple .main-header .navbar
    {
        background-color: #222d32 !important;
    }

    .main-header .logo .logo-lg
    {
        background-color: #222d32 !important;

    }

    .skin-purple .main-header .logo
    {
        background-color: #222d32 !important;

    }
    </style>

</head>
<body class="hold-transition skin-purple sidebar-mini style-3">

<div class="wrapper">
    @include('partial/_errors')
    @include('trainer.layout.header')

    @include('trainer.layout.sidebar')

    @section('main-content')

    @show


    @include('trainer.layout.footer')

</div>

@section('scripts')


@show
</body>
</html>
