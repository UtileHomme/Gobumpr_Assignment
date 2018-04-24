@for($j=0;$j<$count_for_reviews;$j++)
<div class="box-comment ">


<!-- User image -->
<img class="img-circle img-sm" src="{{asset(Storage::disk('local')->url($reviews_for_restaurant[$j]['user_image'])) }}" alt="User Image">


<div class="comment-text">
    <span class="username">
        {{$reviews_for_restaurant[$j]['user_name']}}
        <span class="text-muted pull-right">{{$reviews_for_restaurant[$j]['created_at']}}</span>
    </span><!-- /.username -->
    {{$reviews_for_restaurant[$j]['review']}}
</div>
<!-- /.comment-text -->
</div>

@endfor
