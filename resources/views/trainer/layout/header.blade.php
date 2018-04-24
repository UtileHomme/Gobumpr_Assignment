<head>
    <style media="screen">

        .sameline
        {
            display: inline-block;
        }
    </style>
</head>

<header class="main-header">
  <!-- Logo -->
  <a href="{{route('trainer.index')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>YT</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Yoga </b>Tracker</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- <img src="{{ asset('traineee/dist/img/spiderman.jpg') }}" class="user-image" alt="User Image"> -->
            <img src="{{ asset(Storage::disk('local')->url($trainer_image)) }}" class="user-image" alt="User Image">

    <span class="hidden-xs">Hello {{Auth::guard('admin')->user()->name}}</span>


          </a>
          <ul class="dropdown-menu" style="width:300px;">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ asset(Storage::disk('local')->url($trainer_image)) }}" class="img-circle" alt="User Image">

              <p>
                {{Auth::guard('admin')->user()->name}}
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                  <a href="{{route('trainerprofile')}}" class="btn btn-default" style="color:black">Profile</a>
              </div>
              <div class="sameline">
                <a href="{{route('trainerchangepassword')}}" class="btn btn-default" style="color:black; margin-left: 5px;">Change Password</a>
              </div>
              <div class="sameline">
                <a href="{{ route('logout') }}" class="btn btn-default" style="color:black; margin-left:2px;">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
