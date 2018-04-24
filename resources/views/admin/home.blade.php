<!-- This is the trainee dashboard -->

@extends('admin.layout.app')

@section('main-content')

<head>

<style media="screen">

.content-wrapper
{
    background-color: #dddfeb !important;
}

.content {
    height: 670px;
}

.users-list>li img
{
    max-width: 121px;
    height: 121px;
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
            Welcome to your dashboard!! You are Logged in as Admin!!
            <small></small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        @if($trainer_count>0)
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="box ">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">The Current Trainers</h3>


                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">

                        @foreach($trainer_details as $detail)
                        <li>
                            <img src="{{ asset(Storage::disk('local')->url($detail->profile_image)) }}" alt="User Image">
                            <a class="users-list-name" href="#">{{$detail->trainer_name}}</a>
                            <span class="users-list-date">{{$detail->created_at}}</span>
                        </li>
                        @endforeach
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
            You currently have NO TRAINERS under you!!
            <small></small>
        </h1>
        @endif
    </section>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection

@section('scripts')
@endsection
