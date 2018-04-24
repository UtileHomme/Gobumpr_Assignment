<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\restaurant_reviews;
use App\ratings_details;
use App\Admin;
use Session;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('user');
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $logged_in_user = Auth::user()->name;

        $user_image = DB::table('user_details')->where('user_name',$logged_in_user)->value('profile_image');

        $city_names = DB::table('cities')->get();

        $city_names = json_decode($city_names,true);

        $restaurant_details = DB::table('restaurant_details')->get();

        $restaurant_details = json_decode($restaurant_details,true);

        $count_of_restaurants = count($restaurant_details);

        // dd($restaurant_details);
        $count_of_cities = count($city_names);

        return view('restaurant.search',compact('logged_in_user','user_image','count_of_cities','city_names','restaurant_details','count_of_restaurants'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $logged_in_user = Auth::user()->name;

        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $trainer_id = DB::table('trainee_details')->where('id',$trainee_id)->value('trainer_id');

        // dd($trainer_id);
        $trainer_names = DB::table('trainer_details')->select('trainer_name')->get();

        $trainee_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->get();
        $trainee_workouts = json_decode($trainee_workouts,true);
        $trainee_workout_count = count($trainee_workouts);


        // dd($trainee_workout_count);

        $workout_id = array();

        for($i=0;$i<$trainee_workout_count;$i++)
        {
            $workout_id[] = $trainee_workouts[$i]['id'];
        }

        for($i=0;$i<$trainee_workout_count;$i++)
        {
            $comments_per_id = DB::table('workout_comments')->where('workout_id',$workout_id[$i])->get();
            $comments_per_id = json_decode($comments_per_id,true);
            $count_comments = count($comments_per_id);

            $comments[] = $comments_per_id;
            $counts[] = $count_comments;
        }

        return view('traineee/workout/create',compact('logged_in_user','trainer_names','trainer_id','trainee_image'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // dd($request->workout_image);
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $trainer_id = DB::table('trainer_details')->where('trainer_name',$request->trainer_name)->value('id');

        if($trainer_id==NULL)
        {
            $trainer_id = DB::table('trainee_details')->where('id',$trainee_id)->value('trainer_id');
        }
        // dd($trainer_id);
        //backend validations
        $this->validate($request,[
            'workout_name'=>'required|string',
            'workout_date'=>'required|date',
            'workout_start_time'=>'required',
            'workout_end_time'=>'required',
        ]);

        if($trainer_id==NULL)
        {
            $this->validate($request,[
                'trainer_name'=>'required',
            ]);
        }


        $date = $request->workout_date;

        $date = date("Y-m-d",strtotime($date));



        $start_time = $request->workout_start_time;

        $start_time_timeofday = substr($start_time,6,2);

        $start_time = substr($start_time, 0,5);
        $start_time = $start_time.":00";



        $end_time = $request->workout_end_time;

        $end_time_timeofday = substr($end_time,6,2);

        $end_time = substr($end_time, 0,5);
        $end_time = $end_time.":00";

        $imageName1 = NULL;
        if($request->hasFile('workout_image'))
        {

            $imageName1 = $request->workout_image->store('public');
        }


        $workout = new Workout;
        $workout->workout_name = $request->workout_name;
        $workout->workout_date = $date;
        $workout->workout_start_time = $start_time;
        $workout->workout_start_timeofday = $start_time_timeofday;
        $workout->workout_end_time = $end_time;
        $workout->workout_end_timeofday = $end_time_timeofday;
        $workout->comments = $request->comments;
        $workout->trainee_id = $trainee_id;
        $workout->workout_image = $imageName1;
        $workout->save();

        $workout_id_max = DB::table('workouts')->max('id');
        // dd($workout_id_max);

        $like_detail = new like_detail;
        $like_detail->workout_id = $workout_id_max;
        $like_detail->trainee_name = $logged_in_user;
        $like_detail->save();


        DB::table('trainee_details')
        ->where('id',$trainee_id)
        ->update(['trainer_id'=> $trainer_id]);


        $trainee_workouts_show = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        // dd($like_status_all);
        Session::flash('message','Your Workout has been successfully Logged');
        // return view('traineee.workout.show',compact('trainee_workouts_show','logged_in_user','trainee_image'));
        return redirect()->route('workout.display');

    }

    public function display()
    {
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        // dd($trainee_id);


        $trainee_workouts_show = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        // dd($trainee_workouts);
        // dd($logged_in_user);
        return view('traineee.workout.show',compact('logged_in_user','trainee_workouts_show','trainee_image'));
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        // dd($id);
        $logged_in_user = Auth::user()->name;

        $user_image = DB::table('user_details')->where('user_name',$logged_in_user)->value('profile_image');


        $restaurant_name = DB::table('restaurant_details')->where('id',$id)->value('restaurant_name');
        $restaurant_image = DB::table('restaurant_details')->where('id',$id)->value('restaurant_image');
        $restaurant_review_count = DB::table('restaurant_details')->where('id',$id)->value('reviews_on_restaurants');
        $restaurant_ratings = DB::table('restaurant_details')->where('id',$id)->value('ratings_on_restaurant');
        $restaurant_description = DB::table('restaurant_details')->where('id',$id)->value('restaurant_description');

        $reviews_on_restaurants = DB::table('restaurant_reviews')->where('restaurant_id',$id)->get();
        $reviews_on_restaurants = json_decode($reviews_on_restaurants,true);

        $count_of_reviews = count($reviews_on_restaurants);

        for($i=0;$i<$count_of_reviews;$i++)
        {
            $reviews_on_restaurants[$i]['created_at'] = substr($reviews_on_restaurants[$i]['created_at'],11,5);

            if($reviews_on_restaurants[$i]['created_at']>="12:00")
            {
                $reviews_on_restaurants[$i]['created_at'] = "0".($reviews_on_restaurants[$i]['created_at']-12).":00 PM";
            }
            else
            {
                $reviews_on_restaurants[$i]['created_at'] = ($reviews_on_restaurants[$i]['created_at'])." AM";
            }


        }

        $logged_in_user_rating = DB::table('ratings_details')->where('user_name',$logged_in_user)->where('restaurant_id',$id)->value('rating');

        if($logged_in_user_rating==NULL)
        {
            $logged_in_user_rating = 0;
        }



        return view('restaurant.restaurant_details.show',compact('logged_in_user','user_image','restaurant_name','restaurant_image','restaurant_review_count','restaurant_ratings'
        ,'restaurant_description','count_of_reviews','reviews_on_restaurants','id','logged_in_user_rating'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $workouts = DB::table('workouts')->where('id',$id)->get();

        // dd($workouts);
        return view('traineee/workout/edit',compact('workouts','id','trainee_image','logged_in_user'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        // dd($id);
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $workout_image = DB::table('workouts')->where('id',$id)->value('workout_image');

        $trainee_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        $trainer_id = DB::table('trainers')->where('name',$request->trainer_name)->value('id');

        $this->validate($request,[
            'workout_name'=>'required|string',
            'workout_date'=>'required|date',
            'workout_start_time'=>'required',
            'workout_end_time'=>'required',
        ]);

        $imageName = $workout_image;
        // dd($request->hasFile('profile_image'));
        if($request->hasFile('workout_image'))
        {
            $imageName = $request->workout_image->store('public');
            $workout_image = $request->workout_image->store('public');
        }

        $date = $request->workout_date;
        $date = date("Y-m-d",strtotime($date));

        $start_time = $request->workout_start_time;

        $start_time_timeofday = substr($start_time,6,2);
        $start_time = substr($start_time, 0,5);
        $start_time = $start_time.":00";

        $end_time = $request->workout_end_time;

        $end_time_timeofday = substr($end_time,6,2);

        $end_time = substr($end_time, 0,5);
        $end_time = $end_time.":00";

        // dd($imageName);

        $workout = Workout::find($id);
        $workout->workout_name = $request->workout_name;
        $workout->workout_date = $date;
        $workout->workout_start_time = $start_time;
        $workout->workout_start_timeofday = $start_time_timeofday;
        $workout->workout_end_time = $end_time;
        $workout->workout_end_timeofday = $end_time_timeofday;
        $workout->comments = $request->comments;
        $workout->workout_image = $imageName;
        $workout->trainee_id = $trainee_id;
        $workout->save();

        $trainee_workouts_show = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        // dd($id);
        Session::flash('message','Your Workout changes have been updated');
        return redirect()->route('workout.display');
        // return view('traineee.workout.show',compact('trainee_workouts_show','logged_in_user','trainee_image','trainee_workouts'));

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        // dd($id);
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        // dd($trainee_id);

        $trainee_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        // DB::table('workouts')->where('id',$id)->delete();

        Workout::where('id',$id)->delete();
        Session::flash('message','Your Workout has been Deleted');
        return redirect()->back();

        // return view('traineee.workout.show',compact('logged_in_user','trainee_image','trainee_workouts'));
    }

    public function profile()
    {
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $total_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->count();

        $trainee_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        $trainer_id = DB::table('trainee_details')->where('id',$trainee_id)->value('trainer_id');

        $trainer_name = DB::table('trainer_details')->where('id',$trainer_id)->value('trainer_name');
        $trainee_workouts = json_decode($trainee_workouts,true);
        // dd($trainee_workouts);
        $trainee_workouts_count = count($trainee_workouts);
        // dd($trainee_workouts_count);

        $total_mins = 0;
        for($i=0;$i<$trainee_workouts_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM"  && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            // dd($diff_hours);
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins_per_workout = $diff_hours + $diff_mins;


            $total_mins = $total_mins + $total_mins_per_workout;
        }

        // dd($total_mins);
        $total_hours = ($total_mins/60);
        // dd($total_hours);

        $total_hours = number_format((float)$total_hours,2,'.','');


        $mins = explode('.', $total_hours);
        // dd($total_hours);
        if(!array_key_exists(1, $mins))
        {
            array_push($mins, "00");
        }
        // dd($mins);
        $minutes = ($mins[1]*60)/100;
        // $minutes = intval($minutes);

        $total_hours = intval($total_hours);
        // dd($total_hours);

        return view('traineee/profile/profile',compact('logged_in_user','trainee_image','total_workouts','total_hours','minutes','trainer_name'));
    }

    public function editprofile()
    {
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $trainer_id = DB::table('trainee_details')->where('id',$trainee_id)->value('trainer_id');

        $trainer_names = DB::table('trainer_details')->select('trainer_name')->get();

        $trainee_details = trainee_detail::find($trainee_id);

        $trainer_name = DB::table('trainer_details')->where('id',$trainer_id)->value('trainer_name');

        // dd($trainer_name);
        return view('traineee/profile/editprofile',compact('logged_in_user','trainer_id','trainer_names','trainee_details','trainee_image','trainer_name'));
    }

    public function updateprofile(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'trainee_name'=>'required|string',
            'trainee_emailid'=>'required|email',
            // 'trainee_trainer_name'=>'required',
        ]);

        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $trainer_id = DB::table('trainee_details')->where('id',$trainee_id)->value('trainer_id');

        $trainer_name = DB::table('trainer_details')->where('id',$trainer_id)->value('trainer_name');

        $trainee_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->get();

        $total_workouts = DB::table('workouts')->where('trainee_id',$trainee_id)->count();

        $trainee_workouts = json_decode($trainee_workouts,true);
        // dd($trainee_workouts);
        $trainee_workouts_count = count($trainee_workouts);
        // dd($trainee_workouts_count);

        $total_mins = 0;
        for($i=0;$i<$trainee_workouts_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM"  && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins = $total_mins + $total_mins;
        }

        $total_hours = ($total_mins/60);
        $total_hours = number_format((float)$total_hours,2,'.','');
        // echo numbermat((float)$foo, 2, '.', '');
        // dd($total_hours);
        $mins = explode('.', $total_hours);
        // dd($total_hours);
        if(!array_key_exists(1, $mins))
        {
            array_push($mins, "00");
        }
        // dd($mins);
        $minutes = ($mins[1]*60)/100;
        // $minutes = intval($minutes);

        $total_hours = intval($total_hours);

        // dd($request->all());
        $imageName = $trainee_image;
        // dd($request->hasFile('profile_image'));
        if($request->hasFile('profile_image'))
        {
            $imageName = $request->profile_image->store('public');
            $trainee_image = $request->profile_image->store('public');
            // dd($imageName);
        }
        // dd($imageName);

        // dd($imageName, $trainee_image);
        $logged_in_user = Auth::user()->name;


        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        // dd($trainee_id);
        $date = $request->trainee_dob;
        $date = date("Y-m-d",strtotime($date));

        // dd($request->trainee_mobilenumber);
        $trainee_detail = trainee_detail::find($trainee_id);
        $trainee_detail->trainee_name = $request->trainee_name;
        $trainee_detail->trainee_emailid = $request->trainee_emailid;
        $trainee_detail->trainee_dob = $date;
        $trainee_detail->trainee_mobilenumber = $request->trainee_mobilenumber;
        $trainee_detail->profile_image = $imageName;

        $trainer_name = $request->trainer_name;

        $admin_details = Admin::find($trainee_id);
        $admin_details->name = $request->trainee_name;
        $admin_details->email = $request->trainee_emailid;
        $admin_details->save();

        $trainer_id =DB::table('trainers')->where('name',$trainer_name)->value('id');
        DB::table('trainee_details')
        ->where('id',$trainee_id)
        ->update(['trainer_id'=> $trainer_id]);

        // dd($imageName, $trainee_image);
        $trainee_detail->save();

        Session::flash('message','Your Profile Settings have been changed');
        return redirect()->route('profile');
        // return view('traineee/profile/profile',compact('trainee_image','total_hours','minutes','trainee_workouts','total_workouts','trainer_name','logged_in_user'));
    }

    public function addreview(Request $request)
    {

        $restaurant_id = $request->id;
        $review_for_restaurant = $request->review1;

        $logged_in_user = Auth::user()->name;

        // dd($logged_in_user);

        $user_id = DB::table('user_details')->where('user_name',$logged_in_user)->value('id');

        $user_image = DB::table('user_details')->where('user_name',$logged_in_user)->value('profile_image');

        if($review_for_restaurant!=NULL)
        {
            $restaurant_review = new restaurant_reviews;
            $restaurant_review->review = $review_for_restaurant;
            $restaurant_review->restaurant_id = $restaurant_id;
            $restaurant_review->user_id = $user_id;
            $restaurant_review->user_name = $logged_in_user;
            $restaurant_review->user_image = $user_image;
            $restaurant_review->save();
        }




        $reviews_for_restaurant = DB::table('restaurant_reviews')->where('restaurant_id',$restaurant_id)->get();
        $reviews_for_restaurant = json_decode($reviews_for_restaurant,true);

        $count_for_reviews = count($reviews_for_restaurant);

        for($i=0;$i<$count_for_reviews;$i++)
        {
            $reviews_for_restaurant[$i]['created_at'] = substr($reviews_for_restaurant[$i]['created_at'],11,5);

            if($reviews_for_restaurant[$i]['created_at']>="12:00")
            {
                $reviews_for_restaurant[$i]['created_at'] = "0".($reviews_for_restaurant[$i]['created_at']-12).":00 PM";
            }
            else
            {
                $reviews_for_restaurant[$i]['created_at'] = ($reviews_for_restaurant[$i]['created_at'])." AM";
            }


        }



        return view('restaurant.restaurant_details.allreviews',compact('reviews_for_restaurant','count_for_reviews'));
    }

    public function addcommentall(Request $request)
    {
        // dd($request->comment1,$request->id);

        $workout_id = $request->id2;
        $comment_for_workout = $request->comment2;
        // dd($workout_id,$comment_for_workout);

        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('trainee_details')->where('trainee_name',$logged_in_user)->value('id');
        // dd($trainee_id);

        $trainee_name = DB::table('trainee_details')->where('id',$trainee_id)->value('trainee_name');
        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');
        // dd($trainee_image);
        $workout_comment = new workout_comment;
        $workout_comment->comment = $comment_for_workout;
        $workout_comment->workout_id = $workout_id;
        $workout_comment->trainee_id = $trainee_id;
        $workout_comment->trainee_name = $trainee_name;
        $workout_comment->trainee_image = $trainee_image;
        $workout_comment->save();


        //specific to workout code

        $comments_for_workoutid = DB::table('workout_comments')->where('workout_id',$workout_id)->get();
        $comments_for_workoutid = json_decode($comments_for_workoutid,true);
        // dd($comments_for_workoutid);
        $count_for_workout_comments = count($comments_for_workoutid);

        $comments_per_workout = array();
        for($i=0;$i<$count_for_workout_comments;$i++)
        {
            $comments_per_workout[] = $comments_for_workoutid[$i]['comment'];
        }

        $names_for_comments = DB::table('workout_comments')->where('workout_id',$workout_id)->get();
        $names_for_comments = json_decode($names_for_comments,true);
        // dd($comments_for_workoutid);
        $count_for_names = count($names_for_comments);

        $names_per_comments = array();

        for($i=0;$i<$count_for_names;$i++)
        {
            $names_per_comments[] = $names_for_comments[$i]['trainee_name'];
        }

        $time_for_comments = DB::table('workout_comments')->where('workout_id',$workout_id)->get();
        $time_for_comments = json_decode($time_for_comments,true);
        // dd($time_for_comments);
        $time_per_comments = array();
        for($i=0;$i<$count_for_names;$i++)
        {
            $time_per_comments[] = $time_for_comments[$i]['created_at'];
        }

        $image_for_comments = DB::table('workout_comments')->where('workout_id',$workout_id)->get();
        $image_for_comments = json_decode($image_for_comments,true);
        // dd($image_for_comments);
        $image_per_comments = array();
        for($i=0;$i<$count_for_names;$i++)
        {
            $image_per_comments[] = $image_for_comments[$i]['trainee_image'];
        }
        // dd($time_per_comments);
        for($j=0;$j<$count_for_names;$j++)
        {
            $time_per_comments[$j] = substr($time_per_comments[$j],11,5);
            if(date($time_per_comments[$j])<12)
            {
                $time_per_comments[$j] = $time_per_comments[$j]." AM";
            }
            else
            {
                $time_per_comments[$j] =  date('H:i', strtotime('-12 hour', strtotime($time_per_comments[$j])))." PM";
            }

        }
        // dd($time_per_comments,$count_for_names,$comments_per_workout,$names_per_comments);


        // dd($counts,$name,$comments);
        return view('traineee.workout.allcomments',compact('time_per_comments','count_for_names','comments_per_workout','names_per_comments','image_per_comments'));
    }

    public function updatereviewcount(Request $request)
    {
        $restaurant_id = $request->id;
        $reviews_for_restaurant = DB::table('restaurant_reviews')->where('restaurant_id',$restaurant_id)->get();
        $reviews_for_restaurant = json_decode($reviews_for_restaurant,true);

        $count_for_reviews = count($reviews_for_restaurant);

        DB::table('restaurant_details')->where('id',$restaurant_id)->update(['reviews_on_restaurants'=>$count_for_reviews]);

        return view('restaurant/restaurant_details/updatereviewcount',compact('count_for_reviews'));

    }
    public function commentcountall(Request $request)
    {
        // dd($workout_id);
        $workout_id = $request->id;
        $commentcount = DB::table('workout_comments')->where('workout_id',$workout_id)->count();

        return view('traineee/workout/commentcount',compact('commentcount'));

    }

    public function updateratings(Request $request)
    {
        // dd($request->id);
        $restaurant_id = $request->id;
        $rating_value = $request->rating_value1;

        $logged_in_user = Auth::user()->name;

        $restaurant_id_exist = DB::table('ratings_details')->where('restaurant_id',$restaurant_id)->value('restaurant_id');
        if($restaurant_id_exist!=NULL)
        {
            $user_name_exist = DB::table('ratings_details')->where('restaurant_id',$restaurant_id)->where('user_name',$logged_in_user)->value('id');
            if($user_name_exist!=NULL)
            {
                DB::table('ratings_details')->where('restaurant_id',$restaurant_id)->where('user_name',$logged_in_user)->update(['rating'=>$rating_value]);
            }
        }
        else
        {
            $ratings_details = new ratings_details;
            $ratings_details->restaurant_id = $restaurant_id;
            $ratings_details->user_name = $logged_in_user;
            $ratings_details->rating = $rating_value;
            $ratings_details->save();
        }

        $all_ratings_for_restaurant = DB::table('ratings_details')->where('restaurant_id',$restaurant_id)->get();

        $all_ratings_for_restaurant = json_decode($all_ratings_for_restaurant,true);

        $count_of_ratings = count($all_ratings_for_restaurant);
        // dd($count_of_ratings);
        $sum_of_ratings = 0;


        for($i=0;$i<$count_of_ratings;$i++)
        {
            $sum_of_ratings = $sum_of_ratings + $all_ratings_for_restaurant[$i]['rating'];
        }


        $restaurant_ratings = $sum_of_ratings/$count_of_ratings;


        DB::table('restaurant_details')->where('id',$restaurant_id)->update(['ratings_on_restaurant'=>$restaurant_ratings]);

        return view('restaurant/restaurant_details/updateratings',compact('restaurant_ratings'));
    }
    public function reducelikes(Request $request)
    {
        // dd($request->id);
        $workout_id = $request->id;
        $likes_on_workout = DB::table('workouts')->where('id',$workout_id)->value('likes_on_workout');

        $likes_on_workout = $likes_on_workout - 1;

        DB::table('workouts')->where('id',$workout_id)->update(['likes_on_workout'=>$likes_on_workout]);

        $trainee_name = Auth::user()->name;
        DB::table('like_details')->where('workout_id',$workout_id)->where('trainee_name',$trainee_name)->update(['like_status'=>0,'trainee_name'=>$trainee_name]);


        // return view('traineee/workout/updatelikes',compact('likes_on_workout'));
    }


    public function updatelikesall(Request $request)
    {
        // dd($request->id);
        $workout_id = $request->id;
        $likes_on_workout = DB::table('workouts')->where('id',$workout_id)->value('likes_on_workout');

        $likes_on_workout = $likes_on_workout + 1;
        // dd($workout_id);

        DB::table('workouts')->where('id',$workout_id)->update(['likes_on_workout'=>$likes_on_workout]);

        $trainee_name = Auth::user()->name;
        // dd($trainee_name);
        $workout_id_exist = DB::table('like_details')->where('workout_id',$workout_id)->value('id');
        // dd($workout_id_exist);
        if($workout_id_exist!=NULL)
        {
            $trainee_name_exist = DB::table('like_details')->where(['workout_id'=>$workout_id,'trainee_name'=>$trainee_name])->value('trainee_name');
            // dd($trainee_name_exist);
            if($trainee_name_exist!=NULL)
            {
                DB::table('like_details')->where('workout_id',$workout_id)->where('trainee_name',$trainee_name)->update(['like_status'=>1,'trainee_name'=>$trainee_name]);
            }
            else
            {
                $like_detail = new like_detail;
                $like_detail->workout_id = $workout_id;
                $like_detail->trainee_name = $trainee_name;
                $like_detail->like_status = 1;
                $like_detail->save();
            }
        }

        return view('traineee/workout/updatelikes',compact('likes_on_workout'));
    }
    public function reducelikesall(Request $request)
    {
        // dd($request->id);
        $workout_id = $request->id;
        $likes_on_workout = DB::table('workouts')->where('id',$workout_id)->value('likes_on_workout');
        // dd($likes_on_workout);
        $likes_on_workout = $likes_on_workout - 1;

        DB::table('workouts')->where('id',$workout_id)->update(['likes_on_workout'=>$likes_on_workout]);

        $trainee_name = Auth::user()->name;
        DB::table('like_details')->where('workout_id',$workout_id)->where('trainee_name',$trainee_name)->update(['like_status'=>0,'trainee_name'=>$trainee_name]);

        return view('traineee/workout/updatelikes',compact('likes_on_workout'));
    }


    public function reducelikeshowall(Request $request)
    {
        $workout_id = $request->id;
        $likes_on_workout = DB::table('workouts')->where('id',$workout_id)->value('likes_on_workout');
        return view('traineee/workout/updatelikes',compact('likes_on_workout'));

    }

    public function statistics()
    {
        $logged_in_user = Auth::user()->name;

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        // dd($trainee_id);


        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        $todays_date = date("Y-m-d");

        $trainee_workouts_today = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date',$todays_date)->get();

        $trainee_workouts_today = json_decode($trainee_workouts_today,true);
        // dd($trainee_workouts_today);
        $trainee_workouts_count = count($trainee_workouts_today);
        // dd($trainee_workouts_count);

        $total_mins_for_today = 0;
        for($i=0;$i<$trainee_workouts_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts_today[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts_today[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts_today[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts_today[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts_today[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts_today[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM"  && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_today = $total_mins_for_today + $total_mins;
        }

        $total_hours_for_today = ($total_mins_for_today/60);
        $total_hours_for_today = number_format((float)$total_hours_for_today,2,'.','');
        // echo number_format((float)$foo, 2, '.', '');
        // dd($total_hours_for_today);
        $mins_for_this_today = explode('.', $total_hours_for_today);

        if(!array_key_exists(1, $mins_for_this_today))
        {
            array_push($mins_for_this_today, "00");
        }
        // dd($mins_for_this_today);
        $minutes_for_this_today = ($mins_for_this_today[1]*60)/100;
        $minutes_for_this_today = intval($minutes_for_this_today);

        $total_hours_for_today = intval($total_hours_for_today);
        // dd($minutes_for_this_today);


        $todays_date = date("Y-m-d");
        $date_one_week_before = date("Y-m-d", strtotime ( '-1 week' , strtotime ( $todays_date) ) );
        // dd($date_one_week_before);
        $trainee_workouts_this_week = DB::table('workouts')->where('trainee_id',$trainee_id)->whereBetween('workout_date', [$date_one_week_before, $todays_date])->get();
        $trainee_workouts_this_week = json_decode($trainee_workouts_this_week,true);
        $trainee_workouts_this_week_count = count($trainee_workouts_this_week);

        $total_mins_for_this_week = 0;
        for($i=0;$i<$trainee_workouts_this_week_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts_this_week[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts_this_week[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts_this_week[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts_this_week[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts_this_week[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts_this_week[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_start_time_min,$workout_end_time_hour,$workout_end_time_min);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_week = $total_mins_for_this_week + $total_mins;
        }

        $total_hours_for_this_week = ($total_mins_for_this_week/60);
        $total_hours_for_this_week = number_format((float)$total_hours_for_this_week,2,'.','');
        // dd($total_hours_for_this_week);
        $mins_for_this_week = explode('.', $total_hours_for_this_week);

        if(!array_key_exists(1, $mins_for_this_week))
        {
            array_push($mins_for_this_week, "00");
        }
        // dd($mins_for_this_week);
        $minutes_for_this_week = ($mins_for_this_week[1]*60)/100;
        $minutes_for_this_week = intval($minutes_for_this_week);

        $total_hours_for_this_week = intval($total_hours_for_this_week);
        // dd($minutes_for_this_week);

        $todays_date = date("Y-m-d");
        $date_one_month_before = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $todays_date) ) );
        // dd($date_one_month_before);
        $trainee_workouts_this_month = DB::table('workouts')->where('trainee_id',$trainee_id)->whereBetween('workout_date', [$date_one_month_before, $todays_date])->get();
        $trainee_workouts_this_month = json_decode($trainee_workouts_this_month,true);

        // dd($trainee_workouts_this_month);
        $trainee_workouts_this_month_count = count($trainee_workouts_this_month);

        $total_mins_for_this_month = 0;
        for($i=0;$i<$trainee_workouts_this_month_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts_this_month[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts_this_month[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts_this_month[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts_this_month[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts_this_month[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts_this_month[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_start_time_min,$workout_end_time_hour,$workout_end_time_min);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_month = $total_mins_for_this_month + $total_mins;
        }

        $total_hours_for_this_month = ($total_mins_for_this_month/60);
        $total_hours_for_this_month = number_format((float)$total_hours_for_this_month,2,'.','');

        $mins_for_this_month = explode('.', $total_hours_for_this_month);

        if(!array_key_exists(1, $mins_for_this_month))
        {
            array_push($mins_for_this_month, "00");
        }
        // dd($mins_for_this_month);
        $minutes_for_this_month = ($mins_for_this_month[1]*60)/100;
        $minutes_for_this_month = intval($minutes_for_this_month);

        $total_hours_for_this_month = intval($total_hours_for_this_month);
        // dd($minutes_for_this_month);
        $present_year = date("Y");

        $trainee_workouts_this_year = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."%" )->get();
        $trainee_workouts_this_year = json_decode($trainee_workouts_this_year,true);
        // dd($trainee_workouts_this_year);

        // dd($trainee_workouts_this_year);
        $trainee_workouts_this_year_count = count($trainee_workouts_this_year);

        $total_mins_for_this_year = 0;
        for($i=0;$i<$trainee_workouts_this_year_count;$i++)
        {
            $workout_start_time_hour = substr($trainee_workouts_this_year[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($trainee_workouts_this_year[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $trainee_workouts_this_year[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($trainee_workouts_this_year[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($trainee_workouts_this_year[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $trainee_workouts_this_year[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_year = $total_mins_for_this_year + $total_mins;
        }

        $total_hours_for_this_year = ($total_mins_for_this_year/60);
        $total_hours_for_this_year = number_format((float)$total_hours_for_this_year,2,'.','');

        $mins_for_this_year = explode('.', $total_hours_for_this_year);

        if(!array_key_exists(1, $mins_for_this_year))
        {
            array_push($mins_for_this_year, "00");
        }
        $minutes_for_this_year = ($mins_for_this_year[1]*60)/100;
        $minutes_for_this_year = intval($minutes_for_this_year);

        $total_hours_for_this_year = intval($total_hours_for_this_year);

        $first_month = "01";
        $workout_hours_for_January = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$first_month."-%" )->get();
        $workout_hours_for_January = json_decode($workout_hours_for_January,true);

        $workout_hours_for_January_count = count($workout_hours_for_January);
        // dd($workout_hours_for_January);
        $total_mins_for_this_January_month = 0;
        for($i=0;$i<$workout_hours_for_January_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_January[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_January[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_January[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_January[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_January[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_January[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_January_month = $total_mins_for_this_January_month + $total_mins;
        }
        $total_hours_for_this_January_month = ($total_mins_for_this_January_month/60);
        $total_hours_for_this_January_month = number_format((float)$total_hours_for_this_January_month,2,'.','');

        $mins_for_this_January_month = explode('.', $total_hours_for_this_January_month);

        if(!array_key_exists(1, $mins_for_this_January_month))
        {
            array_push($mins_for_this_January_month, "00");
        }

        $minutes_for_this_January_month = ($mins_for_this_January_month[1]*60)/100;

        $minutes_for_this_January_month = intval($minutes_for_this_January_month);

        $total_hours_for_this_January_month = intval($total_hours_for_this_January_month);


        $second_month = "02";
        $workout_hours_for_February = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$second_month."-%" )->get();
        $workout_hours_for_February = json_decode($workout_hours_for_February,true);


        $workout_hours_for_February_count = count($workout_hours_for_February);

        $total_mins_for_this_February_month = 0;
        for($i=0;$i<$workout_hours_for_February_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_February[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_February[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_February[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_February[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_February[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_February[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_February_month = $total_mins_for_this_February_month + $total_mins;
        }
        $total_hours_for_this_February_month = ($total_mins_for_this_February_month/60);
        $total_hours_for_this_February_month = number_format((float)$total_hours_for_this_February_month,2,'.','');

        $mins_for_this_February_month = explode('.', $total_hours_for_this_February_month);


        if(!array_key_exists(1, $mins_for_this_February_month))
        {
            array_push($mins_for_this_February_month, "00");
        }
        $minutes_for_this_February_month = ($mins_for_this_February_month[1]*60)/100;

        $minutes_for_this_February_month = intval($minutes_for_this_February_month);

        $total_hours_for_this_February_month = intval($total_hours_for_this_February_month);

        $third_month = "03";
        $workout_hours_for_March = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$third_month."-%" )->get();
        $workout_hours_for_March = json_decode($workout_hours_for_March,true);

        $workout_hours_for_March_count = count($workout_hours_for_March);

        $total_mins_for_this_March_month = 0;
        for($i=0;$i<$workout_hours_for_March_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_March[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_March[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_March[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_March[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_March[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_March[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_March_month = $total_mins_for_this_March_month + $total_mins;
        }
        $total_hours_for_this_March_month = ($total_mins_for_this_March_month/60);
        $total_hours_for_this_March_month = number_format((float)$total_hours_for_this_March_month,2,'.','');


        $mins_for_this_March_month = explode('.', $total_hours_for_this_March_month);

        if(!array_key_exists(1, $mins_for_this_March_month))
        {
            array_push($mins_for_this_March_month, "00");
        }
        $minutes_for_this_March_month = ($mins_for_this_March_month[1]*60)/100;
        $minutes_for_this_March_month = intval($minutes_for_this_March_month);

        $total_hours_for_this_March_month = intval($total_hours_for_this_March_month);

        $fourth_month = "04";
        $workout_hours_for_April = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$fourth_month."-%" )->get();
        $workout_hours_for_April = json_decode($workout_hours_for_April,true);

        $workout_hours_for_April_count = count($workout_hours_for_April);

        $total_mins_for_this_April_month = 0;
        for($i=0;$i<$workout_hours_for_April_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_April[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_April[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_April[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_April[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_April[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_April[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_April_month = $total_mins_for_this_April_month + $total_mins;
        }
        $total_hours_for_this_April_month = ($total_mins_for_this_April_month/60);
        $total_hours_for_this_April_month = number_format((float)$total_hours_for_this_April_month,2,'.','');


        $mins_for_this_April_month = explode('.', $total_hours_for_this_April_month);

        if(!array_key_exists(1, $mins_for_this_April_month))
        {
            array_push($mins_for_this_April_month, "00");
        }
        $minutes_for_this_April_month = ($mins_for_this_April_month[1]*60)/100;
        $minutes_for_this_April_month = intval($minutes_for_this_April_month);

        $total_hours_for_this_April_month = intval($total_hours_for_this_April_month);

        $fifth_month = "05";
        $workout_hours_for_May = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$fifth_month."-%" )->get();
        $workout_hours_for_May = json_decode($workout_hours_for_May,true);

        $workout_hours_for_May_count = count($workout_hours_for_May);

        $total_mins_for_this_May_month = 0;
        for($i=0;$i<$workout_hours_for_May_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_May[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_May[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_May[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_May[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_May[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_May[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_May_month = $total_mins_for_this_May_month + $total_mins;
        }
        $total_hours_for_this_May_month = ($total_mins_for_this_May_month/60);
        $total_hours_for_this_May_month = number_format((float)$total_hours_for_this_May_month,2,'.','');


        $mins_for_this_May_month = explode('.', $total_hours_for_this_May_month);

        if(!array_key_exists(1, $mins_for_this_May_month))
        {
            array_push($mins_for_this_May_month, "00");
        }
        $minutes_for_this_May_month = ($mins_for_this_May_month[1]*60)/100;
        $minutes_for_this_May_month = intval($minutes_for_this_May_month);

        $total_hours_for_this_May_month = intval($total_hours_for_this_May_month);

        $sixth_month = "06";
        $workout_hours_for_June = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$sixth_month."-%" )->get();
        $workout_hours_for_June = json_decode($workout_hours_for_June,true);

        $workout_hours_for_June_count = count($workout_hours_for_June);

        $total_mins_for_this_June_month = 0;
        for($i=0;$i<$workout_hours_for_June_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_June[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_June[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_June[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_June[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_June[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_June[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_June_month = $total_mins_for_this_June_month + $total_mins;
        }
        $total_hours_for_this_June_month = ($total_mins_for_this_June_month/60);
        $total_hours_for_this_June_month = number_format((float)$total_hours_for_this_June_month,2,'.','');


        $mins_for_this_June_month = explode('.', $total_hours_for_this_June_month);

        if(!array_key_exists(1, $mins_for_this_June_month))
        {
            array_push($mins_for_this_June_month, "00");
        }
        $minutes_for_this_June_month = ($mins_for_this_June_month[1]*60)/100;
        $minutes_for_this_June_month = intval($minutes_for_this_June_month);

        $total_hours_for_this_June_month = intval($total_hours_for_this_June_month);

        $seventh_month = "07";
        $workout_hours_for_July = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$seventh_month."-%" )->get();
        $workout_hours_for_July = json_decode($workout_hours_for_July,true);

        $workout_hours_for_July_count = count($workout_hours_for_July);

        $total_mins_for_this_July_month = 0;
        for($i=0;$i<$workout_hours_for_July_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_July[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_July[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_July[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_July[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_July[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_July[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_July_month = $total_mins_for_this_July_month + $total_mins;
        }
        $total_hours_for_this_July_month = ($total_mins_for_this_July_month/60);
        $total_hours_for_this_July_month = number_format((float)$total_hours_for_this_July_month,2,'.','');

        $mins_for_this_July_month = explode('.', $total_hours_for_this_July_month);

        if(!array_key_exists(1, $mins_for_this_July_month))
        {
            array_push($mins_for_this_July_month, "00");
        }
        $minutes_for_this_July_month = ($mins_for_this_July_month[1]*60)/100;
        $minutes_for_this_July_month = intval($minutes_for_this_July_month);

        $total_hours_for_this_July_month = intval($total_hours_for_this_July_month);

        $eighth_month = "08";
        $workout_hours_for_August = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$eighth_month."-%" )->get();
        $workout_hours_for_August = json_decode($workout_hours_for_August,true);
        // dd($workout_hours_for_August);
        $workout_hours_for_August_count = count($workout_hours_for_August);

        $total_mins_for_this_August_month = 0;
        for($i=0;$i<$workout_hours_for_August_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_August[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_August[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_August[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_August[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_August[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_August[$i]['workout_end_timeofday'];

            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }


            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            $total_mins_for_this_August_month = $total_mins_for_this_August_month + $total_mins;
        }
        $total_hours_for_this_August_month = ($total_mins_for_this_August_month/60);
        $total_hours_for_this_August_month = number_format((float)$total_hours_for_this_August_month,2,'.','');

        $mins_for_this_August_month = explode('.', $total_hours_for_this_August_month);

        if(!array_key_exists(1, $mins_for_this_August_month))
        {
            array_push($mins_for_this_August_month, "00");
        }

        $minutes_for_this_August_month = ($mins_for_this_August_month[1]*60)/100;
        $minutes_for_this_August_month = intval($minutes_for_this_August_month);

        $total_hours_for_this_August_month = intval($total_hours_for_this_August_month);
        // dd($total_hours_for_this_August_month,$minutes_for_this_August_month);

        $ninth_month = "09";
        $workout_hours_for_September = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$ninth_month."-%" )->get();
        $workout_hours_for_September = json_decode($workout_hours_for_September,true);
        // dd($workout_hours_for_September);
        $workout_hours_for_September_count = count($workout_hours_for_September);
        // dd($workout_hours_for_September_count);

        $total_mins_for_this_September_month = 0;
        for($i=0;$i<$workout_hours_for_September_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_September[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_September[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_September[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_September[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_September[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_September[$i]['workout_end_timeofday'];


            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_end_time_hour);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            // dd($diff_hours);
            $total_mins_for_this_September_month = $total_mins_for_this_September_month + $total_mins;
        }
        // dd($total_mins_for_this_September_month);
        $total_hours_for_this_September_month = ($total_mins_for_this_September_month/60);
        // dd($total_hours_for_this_September_month);
        $total_hours_for_this_September_month = number_format((float)$total_hours_for_this_September_month,2,'.','');
        // dd($total_hours_for_this_September_month);
        $mins_for_this_September_month = explode('.', $total_hours_for_this_September_month);

        if(!array_key_exists(1, $mins_for_this_September_month))
        {
            array_push($mins_for_this_September_month, "00");
        }

        $minutes_for_this_September_month = ($mins_for_this_September_month[1]*60)/100;
        $minutes_for_this_September_month = intval($minutes_for_this_September_month);

        $total_hours_for_this_September_month = intval($total_hours_for_this_September_month);
        // dd($total_hours_for_this_September_month, $minutes_for_this_September_month);

        $tenth_month = "10";
        $workout_hours_for_October = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$tenth_month."-%" )->get();
        $workout_hours_for_October = json_decode($workout_hours_for_October,true);
        // dd($workout_hours_for_October);
        $workout_hours_for_October_count = count($workout_hours_for_October);
        // dd($workout_hours_for_October_count);

        $total_mins_for_this_October_month = 0;
        for($i=0;$i<$workout_hours_for_October_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_October[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_October[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_October[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_October[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_October[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_October[$i]['workout_end_timeofday'];


            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_end_time_hour);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            // dd($diff_hours);
            $total_mins_for_this_October_month = $total_mins_for_this_October_month + $total_mins;
        }
        // dd($total_mins_for_this_October_month);
        $total_hours_for_this_October_month = ($total_mins_for_this_October_month/60);
        // dd($total_hours_for_this_October_month);
        $total_hours_for_this_October_month = number_format((float)$total_hours_for_this_October_month,2,'.','');
        // dd($total_hours_for_this_October_month);
        $mins_for_this_October_month = explode('.', $total_hours_for_this_October_month);

        if(!array_key_exists(1, $mins_for_this_October_month))
        {
            array_push($mins_for_this_October_month, "00");
        }

        $minutes_for_this_October_month = ($mins_for_this_October_month[1]*60)/100;
        $minutes_for_this_October_month = intval($minutes_for_this_October_month);
        $total_hours_for_this_October_month = intval($total_hours_for_this_October_month);
        // dd($total_hours_for_this_October_month, $minutes_for_this_October_month);

        $eleventh_month = "11";
        $workout_hours_for_November = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$eleventh_month."-%" )->get();
        $workout_hours_for_November = json_decode($workout_hours_for_November,true);
        // dd($workout_hours_for_November);
        $workout_hours_for_November_count = count($workout_hours_for_November);
        // dd($workout_hours_for_November_count);

        $total_mins_for_this_November_month = 0;
        for($i=0;$i<$workout_hours_for_November_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_November[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_November[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_November[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_November[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_November[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_November[$i]['workout_end_timeofday'];


            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_end_time_hour);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            // dd($diff_hours);
            $total_mins_for_this_November_month = $total_mins_for_this_November_month + $total_mins;
        }
        // dd($total_mins_for_this_November_month);
        $total_hours_for_this_November_month = ($total_mins_for_this_November_month/60);
        // dd($total_hours_for_this_November_month);
        $total_hours_for_this_November_month = number_format((float)$total_hours_for_this_November_month,2,'.','');
        // dd($total_hours_for_this_November_month);
        $mins_for_this_November_month = explode('.', $total_hours_for_this_November_month);

        if(!array_key_exists(1, $mins_for_this_November_month))
        {
            array_push($mins_for_this_November_month, "00");
        }

        $minutes_for_this_November_month = ($mins_for_this_November_month[1]*60)/100;
        $minutes_for_this_November_month = intval($minutes_for_this_November_month);

        $total_hours_for_this_November_month = intval($total_hours_for_this_November_month);
        // dd($total_hours_for_this_November_month, $minutes_for_this_November_month);

        $twelfth_month = "12";
        $workout_hours_for_December = DB::table('workouts')->where('trainee_id',$trainee_id)->where('workout_date', 'like', $present_year."-".$twelfth_month."-%" )->get();
        $workout_hours_for_December = json_decode($workout_hours_for_December,true);
        // dd($workout_hours_for_December);
        $workout_hours_for_December_count = count($workout_hours_for_December);
        // dd($workout_hours_for_December_count);

        $total_mins_for_this_December_month = 0;
        for($i=0;$i<$workout_hours_for_December_count;$i++)
        {
            $workout_start_time_hour = substr($workout_hours_for_December[$i]['workout_start_time'],0,2);
            $workout_start_time_min= substr($workout_hours_for_December[$i]['workout_start_time'],3,2);
            $workout_start_timeofday = $workout_hours_for_December[$i]['workout_start_timeofday'];
            $workout_end_time_hour = substr($workout_hours_for_December[$i]['workout_end_time'],0,2);
            $workout_end_time_min = substr($workout_hours_for_December[$i]['workout_end_time'],3,2);
            $workout_end_timeofday = $workout_hours_for_December[$i]['workout_end_timeofday'];


            if($workout_end_timeofday=="PM" && $workout_end_time_hour!=12)
            {
                $workout_end_time_hour = $workout_end_time_hour+"12";
            }
            if($workout_start_timeofday=="PM" && $workout_start_time_hour!=12)
            {
                $workout_start_time_hour = $workout_start_time_hour+"12";
            }

            // dd($workout_start_time_hour,$workout_end_time_hour);

            $diff_hours = abs($workout_end_time_hour - $workout_start_time_hour) * 60;
            $diff_mins = $workout_end_time_min - $workout_start_time_min;
            $total_mins = $diff_hours + $diff_mins;

            // dd($diff_hours);
            $total_mins_for_this_December_month = $total_mins_for_this_December_month + $total_mins;
        }
        // dd($total_mins_for_this_December_month);
        $total_hours_for_this_December_month = ($total_mins_for_this_December_month/60);
        // dd($total_hours_for_this_December_month);
        $total_hours_for_this_December_month = number_format((float)$total_hours_for_this_December_month,2,'.','');
        // dd($total_hours_for_this_December_month);
        $mins_for_this_December_month = explode('.', $total_hours_for_this_December_month);
        // dd($mins_for_this_December_month);
        if(!array_key_exists(1, $mins_for_this_December_month))
        {
            array_push($mins_for_this_December_month, "00");
        }
        // dd($mins_for_this_December_month[1  ]*60);
        $minutes_for_this_December_month = ($mins_for_this_December_month[1]*60)/100;
        $minutes_for_this_December_month = intval($minutes_for_this_December_month);
        $total_hours_for_this_December_month = intval($total_hours_for_this_December_month);
        // dd($total_hours_for_this_December_month, $minutes_for_this_December_month);
        // dd($total_ho urs_for_this_January_month,$mins_for_this_January_month);
        // dd($January_total);
        return view('traineee.workout.statistics',compact('logged_in_user','trainee_id','trainee_image','total_hours_for_today','total_hours_for_this_week','total_hours_for_this_month','total_hours_for_this_year','present_year'
        ,'minutes_for_this_today','minutes_for_this_week','minutes_for_this_month','minutes_for_this_year','total_hours_for_this_January_month','minutes_for_this_January_month','total_hours_for_this_February_month','mins_for_this_February_month'
        ,'total_hours_for_this_March_month','mins_for_this_March_month','total_hours_for_this_April_month','mins_for_this_April_month','total_hours_for_this_May_month','mins_for_this_May_month'
        ,'total_hours_for_this_June_month','mins_for_this_June_month','total_hours_for_this_July_month','mins_for_this_July_month','total_hours_for_this_August_month','mins_for_this_August_month'
        ,'total_hours_for_this_September_month','mins_for_this_September_month','total_hours_for_this_October_month','mins_for_this_October_month','total_hours_for_this_November_month','mins_for_this_November_month'
        ,'total_hours_for_this_December_month','mins_for_this_December_month','January_total'));
    }
}
