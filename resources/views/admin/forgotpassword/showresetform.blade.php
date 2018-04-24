@extends('layouts.login_register_common1')


@section('content')


<div class="main" style="opacity:1.5;">
    <div class="main-w3lsrow">
        <!-- login form -->
        <div class="login-form login-form-left">
            <div class="agile-row">
                <h2 class="login-f">Forgot Password</h2>
                <div class="login-agileits-top">
                    <form action="{{ route('admin.password.request') }}" method="post" >
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <p class="email " style="text-align:center">Enter your Registered </p>
                        <p class="email " style="text-align:center; margin-top:-2px;">Email Id: </p>


                        <div class="input-group">
                        </span>
                            <input id="email" type="email" class="email" name="email" value="{{ old('email') }}" required />
                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                    <p>Password</p>
                    <div class="input-group">
                    <input  id="password" type="password" class="password" name="password" required=""/>
                    </div>
                </div>

                <div class="form-group">
                <p>Confirm Password</p>
                <div class="input-group">
                <input id="password-confirm" type="password" class="password" name="password_confirmation" required=""/>
                </div>
            </div>
                    </div>


                <input type="submit" value="Reset Password">
            </form>
        </div>

    </div>

</div>
</div>
</div>


@endsection
