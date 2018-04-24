<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Admin;
use App\role;
use App\role_admin;
use DB;
use Session;
use App\admin_detail;

class AdminController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        //to make the authentication work for admin do this
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }

    public function index()
    {
        $logged_in_user = Auth::user()->name;

        $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

        $trainer_details = DB::table('trainer_details')->get();

        foreach($trainer_details as $detail)
        {
            $detail->created_at = substr($detail->created_at,0,11);
        }

        $trainer_count = count($trainer_details);

        // dd($admin_image);
        return view('admin.home',compact('admin_image','trainer_count','trainer_details','logged_in_user'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $logged_in_user = Auth::user()->name;

        $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

        return view('admin/trainer/create',compact('logged_in_user','admin_image'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $logged_in_user = Auth::user()->name;

        // dd($request->all());

        $this->validate($request,[
            'trainer_name'=>'required|string',
            'email'=>'required|string|email|max:255|unique:admins',
            'password'=>'required|string|min:6|confirmed',
        ]);

        $name = $request->trainer_name;
        $email = $request->email;
        $password = bcrypt($request->password);

        DB::table('admins')->insert(
            ['name' => $name, 'email' => $email,'password'=>$password]);

            $trainer_id = DB::table('admins')->max('id');

            $trainer_default_image = 'public/'.rand(1,3).'.png';

            $role_id = 3;
            $admin_id = DB::table('admins')->max('id');

            $role_admin = new role_admin;
            $role_admin->role_id = $role_id;
            $role_admin->admin_id = $admin_id;
            $role_admin->save();


            DB::table('trainer_details')->insert(
                ['trainer_name' => $name, 'trainer_emailid' => $email,'id'=>$trainer_id,'profile_image'=>$trainer_default_image]);

                $trainer_details = DB::table('trainer_details')->get();

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                Session::flash('message','The New Trainer has Been added successfully!!');
                return redirect()->route('admin.display');
                // return view('admin.trainer.show',compact('trainer_details','admin_image','logged_in_user'));
            }

            /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function show($id)
            {
                //
            }

            public function display()
            {
                $logged_in_user = Auth::user()->name;

                $trainer_details = DB::table('trainer_details')->get();

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                return view('admin.trainer.show',compact('trainer_details','admin_image','logged_in_user'));

            }
            /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function edit($id)
            {
                // $id = $_GET['id'];
                // dd($id);

                $logged_in_user = Auth::user()->name;

                $trainer_detail = DB::table('trainer_details')->where('id',$id)->get();

                // dd($trainer_detail);
                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                return view('admin.trainer.edit',compact('trainer_detail','id','admin_image','logged_in_user'));
            }

            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request)
            {
                // dd($request->all());

                $id = $request->id;
                $this->validate($request,[
                    'trainer_name'=>'required|string',
                    'email'=>'required|string|email|max:255',
                ]);

                $name = $request->trainer_name;
                $email = $request->email;

                DB::table('trainer_details')->where('id',$id)->update(['trainer_name'=>$name, 'trainer_emailid'=>$email]);
                DB::table('admins')->where('id',$id)->update(['name'=>$name, 'email'=>$email]);

                Session::flash('message','The Trainer Details have been Updated Successfully!!');
                return redirect()->route('admin.display');
            }

            public function adminprofile()
            {
                $logged_in_user = Auth::user()->name;

                $admin_id = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('id');

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                return view('admin/profile/adminprofile',compact('logged_in_user','admin_image'));
            }

            public function editadminprofile()
            {

                $logged_in_user = Auth::user()->name;

                $admin_name = $logged_in_user;
                $admin_id = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('id');

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                $admin_details = admin_detail::find($admin_id);

                // dd($admin_details);

                return view('admin/profile/editadminprofile',compact('logged_in_user','admin_id','admin_image','admin_details','admin_name'));

            }

            public function updateadminprofile(Request $request)
            {

                $this->validate($request,[
                    'admin_name'=>'required|string',
                    'admin_emailid'=>'required|email',
                    // 'trainee_trainer_name'=>'required',
                ]);
                // dd($request->all());
                $logged_in_user = Auth::user()->name;

                $admin_name = $logged_in_user;
                $admin_id = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('id');

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                $imageName = $admin_image;
                // dd($request->hasFile('profile_image'));
                if($request->hasFile('profile_image'))
                {
                    $imageName = $request->profile_image->store('public');
                    $admin_image = $request->profile_image->store('public');
                    // dd($imageName);

                }

                $date = $request->admin_dob;
                $date = date("Y-m-d",strtotime($date));

                $admin_detail = admin_detail::find($admin_id);
                $admin_detail->admin_name = $request->admin_name;
                $admin_detail->admin_emailid = $request->admin_emailid;
                $admin_detail->admin_dob = $date;
                $admin_detail->profile_image = $imageName;


                $admin_details = Admin::find($admin_id);
                $admin_details->name = $request->admin_name;
                $admin_details->email = $request->admin_emailid;
                $admin_details->save();

                $admin_detail->save();

                Session::flash('message','Your Profile Settings have been changed');
                // return view('admin/profile/adminprofile',compact('admin_image'));
                return redirect()->route('adminprofile');
            }
            /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function destroy()
            {
                dd('hello');
                $logged_in_user = Auth::user()->name;

                $trainer_id = $id;

                admin_detail::where('id',$id)->delete();

                $admin_image = DB::table('admin_details')->where('admin_name',$logged_in_user)->value('profile_image');

                return redirect()->back();
            }
        }
