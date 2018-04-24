@extends('admin.layout.app')

@section('main-content')

@section('headSection')

<link rel="stylesheet" href="{{ asset('traineee/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}">

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

    </style>
</head>

@endsection

@section('main-content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Workout Logs
            <small></small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <!-- <h3 class="box-title">Workouts</h3> -->

                <a href=" {{ route('admin.create')}}" class="btn btn-success col-lg-offset-5 pull-left"> Add New Trainer</a>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Trainer Name</th>
                                        <th>Trainer EmailId</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($trainer_details as $details)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$details->trainer_name}}</td>
                                        <td>{{$details->trainer_emailid}}</td>
                                        <td><a href="{{$details->id}}/edit"><span class="glyphicon glyphicon-edit"></span></a></td>
                                        <td>
                                            <form id="delete-form-{{$details->id}}" class="" style="display:none" action="{{ url('destroy')}}" method="POST">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                            </form>
                                            <a href="" onclick="
                                            if(confirm('Are you sure, You want to Delete this'))
                                            {
                                                event.preventDefault(); document.getElementById('delete-form-{{$details->id}}').submit();}
                                                else
                                                {
                                                    event.preventDefault();
                                                }
                                                "><span class="glyphicon glyphicon-trash"></span></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>

                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            @include('partial._message')

            @endsection

            @section('footerSection')

            <script type="text/javascript" src=" {{ asset('traineee/bower_components/datatables.net/js/jquery.dataTables.min.js')}}">

            </script>
            <script type="text/javascript" src=" {{ asset('traineee/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}">

            </script>

            <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                })
            })
            </script>
            @endsection

            @endsection
