@extends('traineee.layout.app')

@section('editname',$trainee_details->trainee_name)
@section('editemailid',$trainee_details->trainee_emailid)
@section('editdob',$trainee_details->trainee_dob)
@section('editmobileno',$trainee_details->trainee_mobilenumber)
@section('edittrainer_name',$trainer_name)

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
        <br>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Edit Profile</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('updateprofile') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label for="trainee_name">Name</label>
                                    <input type="text" class="form-control" id="trainee_name" name="trainee_name" placeholder="Your Name please" value="@yield('editname')">
                                </div>

                                <div class="form-group">
                                    <label>Date of Birth</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="trainee_dob" placeholder="Select Your Date of Birth" value="@yield('editdob')">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="trainee_emailid">Email Id</label>
                                    <input type="text" class="form-control" id="trainee_emailid" name="trainee_emailid" placeholder="Your Email id please" value="@yield('editemailid')">
                                </div>

                                <div class="form-group">
                                    <label for="trainee_mobilenumber">Mobile Number</label>
                                    <input type="text" class="form-control" id="trainee_mobilenumber" name="trainee_mobilenumber" placeholder="Your Mobile Number please" value="@yield('editmobileno')">
                                </div>


                                <div class="form-group">
                                    <label>Select Your Trainer:</label>

                                    <div class="input-group">

                                        <select class="form-control select2"  name="trainer_name">
                                            <option selected="selected">@yield('edittrainer_name')</option>
                                            @foreach($trainer_names as $trainer)
                                            <option value="{{$trainer->trainer_name}}">{{$trainer->trainer_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="profile_image">Upload your Profile Image</label>
                                    <input type="file" id="profile_image" name="profile_image">
                                </div>
                                <!-- /.form group -->
                            </div>





                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
