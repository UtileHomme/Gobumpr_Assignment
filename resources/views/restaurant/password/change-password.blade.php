@extends('traineee.layout.app')


@section('scripts')


@endsection

@section('main-content')

<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="login-box">
                  <div class="login-logo">
                    <a href=""><b>Change</b> Your <b> Password </b></a>
                  </div>

                  @if (Session::has('success'))
                  <div class="alert alert-success">{!! Session::get('success') !!}</div>
                  @endif
                  @if (Session::has('failure'))
                  <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                  @endif

                  <!-- /.login-logo -->
                  <div class="login-box-body">

                    <form action="{{route('traineechangepassword')}}" method="post" role="form" class="form-horizontal">
                        {{csrf_field()}}
                        <input type="hidden" name="name" value="{{ Auth::guard('admin')->user()->name }}" >

                      <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Enter Your Old Password Here" name="old">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>

                      <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Enter Your new Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>

                      <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Confirm Your Password" name="password_confirmation">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                        </div>
                        <!-- /.col -->
                    </form>
                  </div>
                  <!-- /.login-box-body -->
                </div>
                <!-- /.login-box -->


    </div>

</div>
<!-- /.col-->
</div>
<!-- ./row -->
</section>
</div>

@endsection
