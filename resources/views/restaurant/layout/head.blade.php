<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Restaurant Finder</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/font-awesome/css/font-awesome.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('traineee/dist/css/AdminLTE.min.css') }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('traineee/dist/css/skins/_all-skins.min.css') }}">
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('sb-admin/css/sb-admin.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/jvectormap/jquery-jvectormap.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('traineee/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('traineee/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('traineee/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('traineee/mdtimepicker.css') }}">

<link href="{{ asset('traineee/footable.core.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('traineee/footable.metro.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style media="screen">


.block
{
    display: inline-block;

}

.align
{
    margin-left:20px;
}

.skin-purple .main-header li.user-header
{
    background-color: #222d32 !important;
}

/* IPhone 5s */
@media only screen and (max-width: 767px)
{
    .align
    {
        margin-left:3px;
    }
    .info-box
    {
        width: 200px !important;
    }
    .info-box-text
    {
        font-size: 12px !important;
    }
}

@media only screen and (min-width: 360px ) and (max-width: 420px){

    .align
    {
        margin-left:3px;
    }
    .info-box
    {
        width: 400px !important;
    }
    .info-box-text
    {
        font-size: 12px !important;
    }

}

/* IPAD Pro */
@media screen and (max-width: 1200px) {

    .align
    {
        margin-left:3px;
    }
    .info-box
    {
        width: 700px !important;
    }
    .info-box-text
    {
        font-size: 20px !important;
    }

}


/*Galaxy S5 */
@media only screen and (min-width: 360px ) and (max-width: 700px) {
    .align
    {
        margin-left:3px;
    }
    .info-box
    {
        width: 325px !important;
    }
}
</style>



@section('headSection')

@show
