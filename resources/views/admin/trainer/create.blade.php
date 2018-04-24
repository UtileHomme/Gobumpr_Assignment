@extends('admin.layout.app')

@section('scripts')

@include('partial/_errors')
<script type="text/javascript">

$(document).ready(function() {

    var trainer_name = $('#trainer_name').val();
    var length = trainer_name.length;
    var reg = /^[a-zA-Z\s]+$/;
    var test = reg.test(trainer_name);


    // console.log
    // console.log(trainer_name);
    if(length==0)
    {
        $(".error").hide();
    }

    $("#trainer_name").blur(function(){

        var trainer_name = $('#trainer_name').val();
        var length = trainer_name.length;
        var reg = /^[a-zA-Z\s]+$/;
        var test = reg.test(trainer_name);

        if(reg.test(trainer_name)==false)
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
        <h1 class="text-center">
            Add a New Trainer
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.store')}}" method="POST">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="trainer_name">Name</label>
                                    <input type="text" class="form-control" id="trainer_name" name="trainer_name" placeholder="Please enter the Trainer Name">
                                    <p style="color:red" class="error">Please enter Characters only</p>
                                </div>

                                <div class="form-group">
                                    <label for="trainer_email">Email Id</label>
                                    <input type="text" class="form-control" id="trainer_email" name="email" placeholder="Please enter the Trainer Email Id">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Please enter the password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Please Confirm the Password">
                                </div>


                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                            </div>

                        </div>
                        <!-- /.box-body -->


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
