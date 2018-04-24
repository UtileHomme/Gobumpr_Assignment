<!-- This is the trainee dashboard -->

@extends('trainer.layout.app')

@section('main-content')

<head>

    <style media="screen">

    .users-list>li img
    {
        max-width: 121px;
        height: 121px;
    }

    .content-wrapper
    {
        background-color: #dddfeb !important;
    }

    .colors
    {
        color: #00635d;
        margin-top: 32px;
    }

    .center
    {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
    </style>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="text-center colors">
            Welcome to your dashboard!! You are Logged in as Trainer!!
            <small></small>
        </h1>
        <br>
    </section>

    <!-- Main content -->
    <section class="content">

        @if($trainee_count>0)
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="box ">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Your Current Trainees</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding" >
                    <ul >
                        <div class="container">
                            <div class="row users-list clearfix">
                                @foreach($trainee_details as $detail)
                                <div class="col-sm-4">
                                    <a href="{{route('trainer.show',$detail->id)}}" data-toggle="tooltip" title="Click to see your Trainee Workouts" data-placement="bottom"><img src="{{ asset(Storage::disk('local')->url($detail->profile_image)) }}" alt="User Image"
                                        style="width: 131px;
    height: 131px;"></a>
                                        <a class="users-list-name" href="#">{{$detail->trainee_name}}</a>
                                        <span class="users-list-date">{{$detail->created_at}}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                </div>
                <!--/.box -->
            </div>

            @else

            <img src="{{ asset('images/sad_face/sad_face.jpg') }}" class="center" alt="User Image">

            <h1 class="text-center colors">
                You currently have NO TRAINEES under you!!
                <small></small>
            </h1>        @endif
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    @endsection

    @section('scripts')
    @endsection
