<!-- This is the individual restaurant details page -->

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


    <div class="row ">
        <div class="col-md-6 col-md-offset-3">
            <!-- Box Comment -->
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block text-center">
                        <span class="username"><h2>{{$restaurant_name}}</h2></span>
                        <span class="description"><h3>{{$restaurant_description}}</h3></span>
                    </div>
                    <!-- /.user-block -->

                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <img class="img-responsive pad" src="{{ asset(Storage::disk('local')->url($restaurant_image)) }}" alt="Photo">
                    <label for="input-1" class="control-label">Give a rating for Skill:</label>
                    <input id="input-1 {{$id}}ratings" name="input-1" class="{{$id}} rating rating-loading star_ratings" data-min="0" data-max="5" data-step="1" value="{{$logged_in_user_rating}}" data-size="xs">

                    <span class="pull-right text-muted">
                        <div class="updateratings{{$id}} " style="float:left"> {{$restaurant_ratings}} ratings - </div>

                        <div class="updatereviews{{$id}} " style="float:left"> {{$restaurant_review_count}} reviews </div>


                    </span>
                </div>
                <!-- /.box-body -->

                <div class="box-footer box-comments review{{$id}}">


                    @for($k=0;$k<$count_of_reviews;$k++)
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="{{ asset(Storage::disk('local')->url($reviews_on_restaurants[$k]['user_image'])) }}" alt="User Image">

                        <div class="comment-text">
                            <span class="username">
                                {{$reviews_on_restaurants[$k]['user_name']}}
                                <span class="text-muted pull-right">{{$reviews_on_restaurants[$k]['created_at']}}</span>
                            </span><!-- /.username -->
                            {{$reviews_on_restaurants[$k]['review']}}
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    @endfor

                </div>
                <div class="box-footer">
                    <form action="#" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="workout_number" value="">
                        <div class="img-push">
                            <input type="text" class="{{$id}} form-control input-sm review" placeholder="Please post you comment here" id="{{$id}}review">
                            <input type="button" name="" value="Post Comment" class="{{$id}} submit btn btn-success btn-sm pull-right {{$id}}submits" style="margin-top:10px;">
                        </div>
                    </form>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

    </div>


</div>
@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function() {

    $(".errors").hide();
    $(".submit").prop('disabled', 'true');

    $('.review').on('keyup keypress', function(e) {
        var restaurant_class= $(this).attr("class");
        var restaurant_class_array=restaurant_class.split(" ");

        var restaurant_id = restaurant_class_array[0];

        var valueofreview=$("#"+restaurant_id+"review").val();
        if(valueofreview == '')
        {
            $(".submit").prop('disabled', 'true');
        }
        else
        {
            $("."+restaurant_id+"submits").removeAttr('disabled');
        }

    });

    $(".submit").click(function(){
        $(".submit").prop('disabled', 'true');
        var restaurant_class= $(this).attr("class");
        // console.log(restaurant_class);
        var restaurant_class_array=restaurant_class.split(" ");
        var restaurant_id = restaurant_class_array[0];
        var review=$("#"+restaurant_id+"review").val();

        $("#"+restaurant_id+"review").val('');
        $("#"+restaurant_id+"review").attr("placeholder", "Please post your comment here");
        console.log(review);

        $.get("{{ URL::to('addreview') }}",{ review1 : review,id: restaurant_id, }
        ,function(data){
            $('.review'+restaurant_id).html(data);


        });
        $.get("{{ URL::to('updatereviewcount') }}",{ review1 : review,id: restaurant_id, }
        ,function(data){
            $('.updatereviews'+restaurant_id).html(data);


        });


        $(".error").hide();
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

    $(".likeall").click(function(){
        console.log('like all clicked');
        if($(this).hasClass('likecolourchangeall'))
        {
            console.log('like has colour');

            var like_class= $(this).attr("class");
            var like_class_array = like_class.split(" ");
            // console.log(like_class_array);
            var post_id = like_class_array[0];
            console.log(post_id)
            $.get("{{ URL::to('reducelikesall') }}",{id: post_id}
            ,function(data){
                $('.reducelikesall'+post_id).html(data);
                $('.'+post_id+'likestatusall').removeClass("likecolourchangeall");
                $('.'+post_id+'likestatusall').css('background-color', '#f4f4f4');
                $('.'+post_id+'likestatusall').css('border-color', '#ddd');
                $('.'+post_id+'likestatus').removeClass("likecolourchange");
                $('.'+post_id+'likestatus').css('background-color', '#f4f4f4');
                $('.'+post_id+'likestatus').css('border-color', '#ddd');
                $('.reducelikeshowall'+post_id).html(data);
            });

            $.get("{{ URL::to('reducelikeshowall') }}",{id: post_id}
            ,function(data){
                $('.reducelikeshowall'+post_id).html(data);

            });

            // $('.'+post_id+'likestatus').attr("disabled", true);
        }
        else
        {
            console.log('like doesnt have colour');

            var like_class= $(this).attr("class");
            var like_class_array = like_class.split(" ");
            // console.log(like_class_array);
            var post_id = like_class_array[0];
            console.log(post_id)
            $.get("{{ URL::to('updatelikesall') }}",{id: post_id}
            ,function(data){
                $('.updatelikesall'+post_id).html(data);
                $('.'+post_id+'likestatusall').addClass("likecolourchangeall");
                $('.'+post_id+'likestatusall').css('background-color', '#AAAACA');
                $('.'+post_id+'likestatusall').css('border-color', 'black');
                $('.'+post_id+'likestatus').addClass("likecolourchange");
                $('.'+post_id+'likestatus').css('background-color', '#AAAACA');
                $('.'+post_id+'likestatus').css('border-color', 'black');
                $('.reducelikeshowall'+post_id).html(data);

            });

            $.get("{{ URL::to('reducelikeshowall') }}",{id: post_id}
            ,function(data){
                $('.reducelikeshowall'+post_id).html(data);

            });
        }
    });

});
</script>

@endsection
