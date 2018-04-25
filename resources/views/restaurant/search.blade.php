<!-- This is the user dashboard -->

@extends('restaurant.layout.app')

@section('main-content')

<head>
    <style media="screen">

    .content-wrapper
    {
        background-color: #F4F1EA;
        margin-left: 0px;
    }
</style>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="text-center">
            Order food online
        </h1>

    </section>

    <div class="row">

        <div class="col-md-4 col-lg-offset-1 pull-left" style="margin-top:20px;">

            <div class="form-group text-center">
                <label>Select Your City</label>
                <select class="form-control cityname" id="city" name="city">
                    <option value="No City Selected yet">No City Selected yet</option>
                    @for($i=0;$i<$count_of_cities;$i++)
                    <option value="{{$city_names[$i]['city_name']}}">{{$city_names[$i]['city_name']}}</option>
                    @endfor
                </select>
            </div>

        </div>

        <div class="col-md-4 col-lg-offset-1 pull-left" style="margin-top:20px;">

            <div class="form-group text-center">
                <label>Search by City Name</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control searchname" placeholder="Search by Name" id="citysearch">
            </div>
        </div>

        </div>

    </div>

    <div class="row">
        <div class="dropdown_select">

            @for($j=0;$j<$count_of_restaurants;$j++)
            <div class="col-md-4 col-md-offset-1">
                <!-- Widget: user widget style 1 -->
                <a href="{{route('restaurantfinder.show',$restaurant_details[$j]['id'])}}">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-black" style="background: url('{{ asset(Storage::disk('local')->url($restaurant_details[$j]['restaurant_image'])) }}');
                            background-repeat: no-repeat;
                            background-size: 450px 150px;">

                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <h3 class="widget-user-username text-center">{{$restaurant_details[$j]['restaurant_name']}}</h3>
                                <h5 class="widget-user-desc text-center">{{$restaurant_details[$j]['restaurant_description']}}</h5>

                                <div class="col-sm-6 border-right">


                                    <div class="description-block">
                                        <h5 class="description-header">{{$restaurant_details[$j]['reviews_on_restaurants']}}</h5>
                                        <span class="description-text">Reviews</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{$restaurant_details[$j]['ratings_on_restaurant']}}</h5>
                                        <span class="description-text">Ratings</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->

                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </a>
                <!-- /.widget-user -->
            </div>
            @endfor
        </div>

    </div>


</div>
@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function() {



    $(".cityname").click(function()
    {
        var city_name = $("#city option:selected").val();


        $.get("{{ URL::to('restaurantsearch') }}",{ city_name1 : city_name }
        ,function(data){
            $('.dropdown_select').html(data);


        });


    });

    $(".searchname").on('keyup keypress', function(e) {

        var keyword = $("#citysearch").val();

        $.get("{{ URL::to('restaurantsearchname') }}",{ keyword1 : keyword }
        ,function(data){
            $('.dropdown_select').html(data);


        });


    });

    $(".cityname").click(function()
    {
        var city_name = $("#city option:selected").val();


        $(".searchname").on('keyup keypress', function(e) {

            var keyword = $("#citysearch").val();

            $.get("{{ URL::to('restaurantdropname') }}",{city_name :city_name, keyword1 : keyword }
            ,function(data){
                $('.dropdown_select').html(data);


            });


        });

        $.get("{{ URL::to('restaurantsearch') }}",{ city_name1 : city_name }
        ,function(data){
            $('.dropdown_select').html(data);


        });


    });






    $(".star_ratings").change(function()
    {
        var rating_class= $(this).attr("class");
        var rating_class_array = rating_class.split(" ");
        // console.log(rating_class_array);
        var restaurant_id = rating_class_array[0];

        console.log(restaurant_id);
        var rating=$('.label').text();

        var rating_class_value = rating.split(" ");

        var rating_value = rating_class_value[0];

        if(rating_value=="One")
        {
            rating_value=1;
        }
        else if(rating_value=="Two")
        {
            rating_value = 2;
        }
        else if(rating_value=="Three")
        {
            rating_value = 3;
        }
        else if(rating_value=="Four")
        {
            rating_value = 4;
        }
        else if(rating_value=="Five")
        {
            rating_value = 5;
        }
        else
        {
            rating_value=0;
        }

        $.get("{{ URL::to('updateratings') }}",{ rating_value1 : rating_value,id: restaurant_id, }
        ,function(data){
            $('.updateratings'+restaurant_id).html(data);


        });
    });


});
</script>

@endsection
