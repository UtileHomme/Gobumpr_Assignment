@extends('layouts.login_register_common1')


@section('content')


<div class="main" style="opacity:1.5;">
    <div class="main-w3lsrow">
        <!-- login form -->
        <div class="login-form login-form-left">
            <div class="agile-row">
                <h2 class="login-f">Forgot Password</h2>
                <div class="login-agileits-top">
                    <form action="{{ route('admin.password.email') }}" method="post" >
                        {{ csrf_field() }}


                    <div class="form-group">
                        <p class="email email1" style="text-align:center">Enter your Registered </p>
                        <p class="email email1" style="text-align:center; margin-top:-2px;">Email Id: </p>


                        <div class="input-group">
                        </span>
                            <input type="email" class="email" name="email" value="{{ old('email') }}" required />
                        </div>
                        <!-- /.input group -->
                    </div>
                    </div>


                <input type="submit" value="Submit">
            </form>
        </div>

    </div>

</div>
</div>
</div>


@endsection
