@if($count_of_restaurants>0)
@for($j=0;$j<$count_of_restaurants;$j++)
<div class="col-md-4 col-md-offset-1">
    <!-- Widget: user widget style 1 -->
    <a href="{{route('restaurantfinder.show',$all_restaurant_details[$j]['id'])}}">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('{{ asset(Storage::disk('local')->url($all_restaurant_details[$j]['restaurant_image'])) }}');
                background-repeat: no-repeat;
                background-size: 450px 150px;">

            </div>

            <div class="box-footer">
                <div class="row">
                    <h3 class="widget-user-username text-center">{{$all_restaurant_details[$j]['restaurant_name']}}</h3>
                    <h5 class="widget-user-desc text-center">{{$all_restaurant_details[$j]['restaurant_description']}}</h5>

                    <div class="col-sm-6 border-right">


                        <div class="description-block">
                            <h5 class="description-header">{{$all_restaurant_details[$j]['reviews_on_restaurants']}}</h5>
                            <span class="description-text">Reviews</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{$all_restaurant_details[$j]['ratings_on_restaurant']}}</h5>
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
@else

<div class="row">
    <div class="col-md-6 pull-right " style="margin-top:2px;">

        <p class="text-danger"> Sorry we couldn't find the data you are looking for</p>

    </div>
</div>

@endif
