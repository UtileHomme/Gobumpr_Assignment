<script src="{{ asset('restaurant/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('restaurant/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('restaurant/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('restaurant/bower_components/raphael/raphael.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('restaurant/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('restaurant/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('restaurant/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('restaurant/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('restaurant/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('restaurant/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('restaurant/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('restaurant/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('restaurant/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- Slimscroll -->
<script src="{{ asset('restaurant/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('restaurant/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('restaurant/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('restaurant/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('restaurant/dist/js/demo.js') }}"></script>
<script src="{{ asset('sb-admin/js/sb-admin.js') }}"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="{{ asset('restaurant/footable.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>

<script>
$(document).ready(function(){
  $('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
});
</script>
<script>
  $(function () {
    // //Initialize Select2 Elements
    // $('.select2').select2()

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
$('.timepicker').timepicker({
  showInputs: false
})
  })
</script>



@section('footerSection')

@show
