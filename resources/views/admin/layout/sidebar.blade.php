<head>
    <style media="screen">



    </style>
</head>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset(Storage::disk('local')->url($admin_image)) }}" class="img-circle" alt="User Image" style="margin-left:60px; ">
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="active treeview">
          <li class=""><a href="{{route('admin.create')}}"><i class="fa fa-circle-o"></i> Add a new Trainer</a></li>
          <li class=""><a href="{{route('admin.display')}}"><i class="fa fa-circle-o"></i> View All Trainers</a></li>
      </li>
      <li>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
