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
  <a href="{{route('restaurantfinder.index')}}" class="logo">

    <span class="logo-lg"><b>Restaurant </b>Finder</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset(Storage::disk('local')->url($user_image)) }}" class="user-image" alt="User Image">

    <span class="hidden-xs">Hello {{$logged_in_user}}</span>


          </a>
          <ul class="dropdown-menu" style="width: 300px;">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ asset(Storage::disk('local')->url($user_image)) }}" class="img-circle" alt="User Image">

              <p>
                {{$logged_in_user}}
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left sameline">
                  <a href="{{route('profile')}}" class="btn btn-default" style="color:black">Profile</a>
              </div>
              <div class="sameline">
                <a href="{{route('userchangepassword')}}" class="btn btn-default" style="color:black; margin-left: 5px;">Change Password</a>
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
