@extends('layouts.login_register_common')

@section('content')

<div class="main" style="opacity:1.5;">
    <div class="main-w3lsrow">
        <!-- login form -->
        <div class="login-form login-form-left">
            <div class="agile-row">
                <h2 class="login-f">Login Form</h2>
                <div class="login-agileits-top">
                    <form action="{{ route('admin.login') }}" method="post" >
                        {{ csrf_field() }}


                    <div class="form-group">
                        <p class="email">Email Id:</p>

                        <div class="input-group">
                        </span>
                            <input type="email" class="email" name="email" value="{{ old('email') }}" required />
                        </div>
                        <!-- /.input group -->
                    </div>
                    </div>

                    <div class="form-group">
                    <p>Password</p>
                    <div class="input-group">
                    <!-- </span> -->
                    <input type="password" class="password" name="password" required=""/>
                    </div>
                </div>
                <input type="submit" value="Login">
            </form>
        </div>
        <div class="login-agileits-bottom">
            <h6 class="forgot-password"><a href="{{ route('admin.password.request') }}">Forgot password?</a></h6>
        </div>

    </div>

</div>
</div>
</div>


@endsection
