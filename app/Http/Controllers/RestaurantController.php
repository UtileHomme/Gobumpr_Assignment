<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\restaurant_reviews;
use App\ratings_details;
use App\user_details;
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

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

    }

    public function display()
    {

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

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
    }

    public function profile()
    {
        $logged_in_user = Auth::user()->name;

        $user_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $user_image = DB::table('user_details')->where('id',$user_id)->value('profile_image');

        $ratings_counts = DB::table('ratings_details')->where('user_name',$logged_in_user)->count();
        $review_counts = DB::table('restaurant_reviews')->where('user_name',$logged_in_user)->count();


        return view('restaurant/profile/profile',compact('logged_in_user','user_image','ratings_counts','review_counts'));
    }

    public function editprofile()
    {
        $logged_in_user = Auth::user()->name;

        $user_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $user_image = DB::table('user_details')->where('id',$user_id)->value('profile_image');


        $user_details = user_details::find($user_id);

        return view('restaurant/profile/editprofile',compact('logged_in_user','user_id','user_details','user_image'));
    }

    public function updateprofile(Request $request)
    {
        $this->validate($request,[
            'user_name'=>'required|string',
            'user_emailid'=>'required|email',
        ]);

        $logged_in_user = Auth::user()->name;
        $user_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $user_image = DB::table('user_details')->where('id',$user_id)->value('profile_image');


        $ratings_counts = DB::table('ratings_details')->where('user_name',$logged_in_user)->count();
        $review_counts = DB::table('restaurant_reviews')->where('user_name',$logged_in_user)->count();

        $imageName = $user_image;

        // dd($request->hasFile('profile_image'));
        if($request->hasFile('profile_image'))
        {

            $imageName = $request->profile_image->store('public');
            $user_image = $request->profile_image->store('public');

            DB::table('restaurant_reviews')->where('user_id',$user_id)->update(['user_image'=>$imageName,'user_name'=>$request->user_name]);
            DB::table('ratings_details')->where('user_name',$logged_in_user)->update(['user_name'=>$request->user_name]);
        }

        $logged_in_user = Auth::user()->name;


        $user_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        // dd($trainee_id);
        $date = $request->trainee_dob;
        $date = date("Y-m-d",strtotime($date));

        $user_detail = user_details::find($user_id);

        $user_detail->user_name = $request->user_name;
        $user_detail->user_emailid = $request->user_emailid;
        $user_detail->user_dob = $date;
        $user_detail->user_mobilenumber = $request->user_mobilenumber;
        $user_detail->profile_image = $imageName;
        $user_detail->save();

        $admin_details = Admin::find($user_id);
        $admin_details->name = $request->user_name;
        $admin_details->email = $request->user_emailid;
        $admin_details->save();

        Session::flash('message','Your Profile Settings have been changed');
        return redirect()->route('profile');
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


    public function updatereviewcount(Request $request)
    {
        $restaurant_id = $request->id;
        $reviews_for_restaurant = DB::table('restaurant_reviews')->where('restaurant_id',$restaurant_id)->get();
        $reviews_for_restaurant = json_decode($reviews_for_restaurant,true);

        $count_for_reviews = count($reviews_for_restaurant);

        DB::table('restaurant_details')->where('id',$restaurant_id)->update(['reviews_on_restaurants'=>$count_for_reviews]);

        return view('restaurant/restaurant_details/updatereviewcount',compact('count_for_reviews'));

    }

    public function restaurantsearch(Request $request)
    {
        $city_name = $request->city_name1;

        if($city_name!="No City Selected yet")
        {
            $city_id = DB::table('cities')->where('city_name',$city_name)->value('id');

            $all_restaurant_details = DB::table('restaurant_details')->where('city_id',$city_id)->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));
        }
        else
        {
            $all_restaurant_details = DB::table('restaurant_details')->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));

        }

    }

    public function restaurantsearchname(Request $request)
    {
        $keyword = $request->keyword1;

        if($keyword!=" " || $keyword!=' ')
        {
            $all_restaurant_details = DB::table('restaurant_details')->where('restaurant_name','like', $keyword.'%')->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));

        }
        else
        {
            $all_restaurant_details = DB::table('restaurant_details')->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));

        }
    }

    public function restaurantdropname(Request $request)
    {
        $keyword = $request->keyword1;
        $city_name = $request->city_name;

        if(($keyword!=" " || $keyword!=' ') && ($city_name!="No City Selected yet"))
        {
            $city_id = DB::table('cities')->where('city_name',$city_name)->value('id');
            $all_restaurant_details = DB::table('restaurant_details')->where('restaurant_name','like', $keyword.'%')->where('city_id',$city_id)->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));

        }
        else if(($city_name=="No City Selected yet") && ($keyword==" " || $keyword==' ') )
        {
            $all_restaurant_details = DB::table('restaurant_details')->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));

        }
        else
        {
            $all_restaurant_details = DB::table('restaurant_details')->where('restaurant_name','like', $keyword.'%')->get();

            $all_restaurant_details = json_decode($all_restaurant_details,true);

            $count_of_restaurants = count($all_restaurant_details);

            return view('restaurant.restaurant_details.specificrestaurants',compact('all_restaurant_details','count_of_restaurants'));
        }

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
            else
            {
                $ratings_details = new ratings_details;
                $ratings_details->restaurant_id = $restaurant_id;
                $ratings_details->user_name = $logged_in_user;
                $ratings_details->rating = $rating_value;
                $ratings_details->save();
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
        $restaurant_ratings = round($restaurant_ratings, 1);

        DB::table('restaurant_details')->where('id',$restaurant_id)->update(['ratings_on_restaurant'=>$restaurant_ratings]);

        return view('restaurant/restaurant_details/updateratings',compact('restaurant_ratings'));
    }


}
