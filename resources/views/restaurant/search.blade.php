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
                <select class="form-control">
                    @for($i=0;$i<$count_of_cities;$i++)
                    <option>{{$city_names[$i]['city_name']}}</option>
                    @endfor
                </select>
            </div>

        </div>


    </div>

    <div class="row">

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
@endsection
