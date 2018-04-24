@extends('traineee.layout.app')

@section('scripts')

@include('partial/_errors')
<script type="text/javascript">

$(document).ready(function() {

    var workout_name = $('#wname').val();
    var length = workout_name.length;
    var reg = /^[a-zA-Z\s]+$/;
    var test = reg.test(workout_name);


    // console.log
    // console.log(workout_name);
    if(length==0)
    {
        $(".error").hide();
    }

    $("#wname").blur(function(){

        var workout_name = $('#wname').val();
        var length = workout_name.length;
        var reg = /^[a-zA-Z\s]+$/;
        var test = reg.test(workout_name);

        if(reg.test(workout_name)==false)
        {
            $(".error").show();
            $("#submit").prop("disabled",true);
        }
        else
        {
            $(".error").hide();
            $("#submit").prop("disabled",false);

        }
    });
});
</script>

@endsection

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
}
</style>


</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create Your Workout Log Here
        </h1>
        <br>


    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Workout Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('workout.store')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="wname">Workout Name</label>
                                    <input type="text" class="form-control" id="wname" name="workout_name" placeholder="Give a name to your workout">
                                    <p style="color:red" class="error">Please enter Characters only</p>
                                </div>

                                <div class="form-group">
                                    <label>Workout Date:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="workout_date" placeholder="Enter your workout date">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Workout Start Time:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="workout_start_time">

                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Workout End Time:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="workout_end_time">

                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                @if($trainer_id==NULL)
                                <div class="form-group">
                                    <label>Select Your Trainer:</label>

                                    <div class="input-group">

                                        <select class="form-control select2" style="width: 100%;" name="trainer_name">
                                            <option selected="selected"></option>
                                            @foreach($trainer_names as $trainer)
                                            <option value="{{$trainer->trainer_name}}">{{$trainer->trainer_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                @endif

                                <div class="form-group">
                                    <label for="workout_image">Upload an Image for Your Workout</label>
                                    <input type="file" id="workout_image" name="workout_image">
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"> Text for your Workout Post
                                </h3>
                                <!-- tools box -->
                                <!-- <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            </div> -->
                            <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body pad">
                            <textarea name="comments"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col-->
    </div>
    <!-- ./row -->
</section>
<!-- /.content -->
</div>


@endsection
