<!-- This is the trainee dashboard -->

@extends('traineee.layout.app')

@section('main-content')

<style media="screen">

.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}

.card > hr {
    margin-right: 0;
    margin-left: 0;
}

.card > .list-group:first-child .list-group-item:first-child {
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.card > .list-group:last-child .list-group-item:last-child {
    border-bottom-right-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);

}

.card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-header + .list-group .list-group-item:first-child {
    border-top: 0;
}

.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}

.mb-3,
.my-3 {
    margin-bottom: 1rem !important;
}

.hoursvalue,.hourscaption
{
    color:black;
}

.small-box
{
    height: 122px;
}

@media (min-width: 1281px) {
        .chartlook
        {
            margin-right: 31px;
        }
    }
@media (min-width: 768px and max-width:1024px) {
        .chartlook
        {
            width: 531px;
        }
    }

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="text-center">
            Your Statistics
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">



        <!-- <h2 class="page-header">Your Feed</h2> -->

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4 class="text-center hoursvalue">{{$total_hours_for_today}} Hours {{$minutes_for_this_today}} Minutes</h3>

                                    <p class="text-center hourscaption">Hours Logged in Today</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4 class="text-center hoursvalue">{{$total_hours_for_this_week}} Hours {{$minutes_for_this_week}} Minutes</h3>

                                        <p class="text-center hourscaption">Hours Logged in a Week's Time</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h4 class="text-center hoursvalue">{{$total_hours_for_this_month}} Hours {{$minutes_for_this_month}} Minutes</h3>

                                            <p class="text-center hourscaption">Hours Logged in a Month's Time</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h4 class="text-center hoursvalue">{{$total_hours_for_this_year}} Hours {{$minutes_for_this_year}} Minutes</h3>

                                                <p class="text-center hourscaption">Hours Logged in This Year</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                            </div>
                            <!-- /.col -->


                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-12 col-md-offset-1">
                            <div id="curve_chart" style="width: 900px; height: 500px"></div>
                        </div> -->

                        <!-- <div class=" col-md-12">
                        <div class="card mb-3">
                        <div class="card-header text-center">
                        <i class="fa fa-area-chart" ></i> Your Improvement Graph For The Year - {{$present_year}}</div>
                        <div class="card-body ">
                        <div id="chart_div" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div> -->

            <div class="container">
                <div class="row col-md-12 col-sm-6">
                    <!-- style="margin-left:16px; width:1079px;" -->
                    <div class="card mb-3 chartlook">
                        <div class="card-header text-center">
                            <i class="fa fa-area-chart"></i> Your Improvement Graph For The Year - {{$present_year}}
                        </div>
                        <div class="card-body">
                            <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>

                </div>
            </div>

            <!-- /.box-body -->
        </div>


    </div>


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection

@section('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

</script>

<script type="text/javascript">
Chart.defaults.global.defaultFontFamily='-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif',Chart.defaults.global.defaultFontColor="#292b2c";var ctx=document.getElementById("myAreaChart"),myLineChart=new Chart(ctx,{type:"line",data:{labels:["January","February","March","April","May","June","July","August","September","October","November","December"],datasets:[{label:"Workout Hours",lineTension:.3,backgroundColor:"rgba(2,117,216,0.2)",borderColor:"rgba(2,117,216,1)",pointRadius:5,pointBackgroundColor:"rgba(2,117,216,1)",pointBorderColor:"rgba(255,255,255,0.8)",pointHoverRadius:5,pointHoverBackgroundColor:"rgba(2,117,216,1)",pointHitRadius:20,pointBorderWidth:2,data:[{{$total_hours_for_this_January_month}},{{$total_hours_for_this_February_month}},{{$total_hours_for_this_March_month}},{{$total_hours_for_this_April_month}},{{$total_hours_for_this_May_month}},{{$total_hours_for_this_June_month}},{{$total_hours_for_this_July_month}},{{$total_hours_for_this_August_month}},{{$total_hours_for_this_September_month}},{{$total_hours_for_this_October_month}},{{$total_hours_for_this_November_month}},{{$total_hours_for_this_December_month}}]}]},options:{scales:{xAxes:[{time:{unit:"date"},gridLines:{display:!1},ticks:{maxTicksLimit:7}}],yAxes:[{ticks:{min:0,max:120,maxTicksLimit:10},gridLines:{color:"rgba(0, 0, 0, .125)"}}]},legend:{display:!1}}}),ctx=document.getElementById("myBarChart"),myLineChart=new Chart(ctx,{type:"bar",data:{labels:["January","February","March","April","May","June"],datasets:[{label:"Revenue",backgroundColor:"rgba(2,117,216,1)",borderColor:"rgba(2,117,216,1)",data:[4215,5312,6251,7841,9821,14984]}]},options:{scales:{xAxes:[{time:{unit:"month"},gridLines:{display:!1},ticks:{maxTicksLimit:6}}],yAxes:[{ticks:{min:0,max:15e3,maxTicksLimit:5},gridLines:{display:!0}}]},legend:{display:!1}}}),ctx=document.getElementById("myPieChart"),myPieChart=new Chart(ctx,{type:"pie",data:{labels:["Blue","Red","Yellow","Green"],datasets:[{data:[12.21,15.58,11.25,8.32],backgroundColor:["#007bff","#dc3545","#ffc107","#28a745"]}]}});
</script>


<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Workout Hours'],
        ['Jan',  {{$total_hours_for_this_January_month}}],
        ['Feb',  {{$total_hours_for_this_February_month}}],
        ['Mar',  {{$total_hours_for_this_March_month}}],
        ['Apr',  {{$total_hours_for_this_April_month}}],
        ['May',  {{$total_hours_for_this_May_month}}],
        ['June',  {{$total_hours_for_this_June_month}}],
        ['July',  {{$total_hours_for_this_July_month}}],
        ['Aug',  {{$total_hours_for_this_August_month}}],
        ['Sept',  {{$total_hours_for_this_September_month}}],
        ['Oct',  {{$total_hours_for_this_October_month}}],
        ['Nov',  {{$total_hours_for_this_November_month}}],
        ['Dec',  {{$total_hours_for_this_December_month}}],
    ]);

    var options = {
        title: '',
        hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
</script>

</scripts>

@endsection
