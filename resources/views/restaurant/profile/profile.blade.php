<!-- This is the trainee dashboard -->

@extends('restaurant.layout.app')

@section('main-content')

<head>

    <style media="screen">

    .alert-success
    {
        color: #3c763d !important;
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;

    }

    .alert
    {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .modal-content2
    {
        height: 52px !important;
        margin-top: 87% !important;

        border-radius: 7px;
    }

    .widget-user .widget-user-header
    {
        height: 371px !important;
    }

    .content-wrapper
    {
        min-height: 639px !important;
        margin-left: 0px;
    }

    .widget-user .widget-user-image
    {
        top: 329px !important;
    }

    .home-section-background
    {
        position: relative;
        height: 100% !important;
        width: 100%;
        background: url(../images/superhero.jpg);
        background-position: center center;
        background-repeat:  no-repeat;
        background-attachment: fixed;
        background-size:  cover;
    }

    .row
    {
        margin-top: 24px;
    }

    .widget-user-username
    {
        color: #34495E;
        font-family: 'Harabara Bold', Arial, sans-serif;
    }

    .link
    {
        font-size: 10px;
        text-decoration: underline;
    }

    .widget-user .widget-user-image>img
    {
        width: 114px;
        height: 93px;
    }
</style>

</head>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-black home-section-background" >
                    <div class="">
                        <h2 class="widget-user-username">{{Auth::user()->name}} <span><a class="link" href="{{route('editprofile')}}" >(Edit Profile)</a></span></h2>

                    </div>

                    <!-- <h5 class="widget-user-desc">Web Designer</h5> -->
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ asset(Storage::disk('local')->url($user_image)) }}" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$ratings_counts}}</h5>
                                <span class="description-text">Total Restaurants Rated</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$review_counts}}</h5>
                                <span class="description-text">Total Restaurants Reviewed</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>

    </section>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('partial._message')
@endsection
