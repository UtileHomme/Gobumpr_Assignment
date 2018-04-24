@extends('layouts.login_register_common2')

@section('content')
<div class="appointment-w3" style="opacity:0.7;">
    <form action="{{ route('trainee.registered')}}" method="post">
        {{ csrf_field() }}

        <h3 class="header-w3ls reg">
            Registration Form</h3>
            <br>
            <div class="form-control-w3l inputregister">
                <input type="text" id="name" name="name" placeholder="Please enter your name">
            </div>
            <div class="form-control-w3l inputregister">

                <input type="email" id="email" name="email" placeholder="Please enter a valid email" title="" >
            </div>

            <div class="form-control-w3l inputregister">

                <input type="password" id="password" name="password" placeholder="Please enter password">
            </div>

            <div class="form-control-w3l inputregister">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Please confirm your password" >
            </div>
            <input type="submit" value="Register">
        </form>
    </div>



    @endsection
