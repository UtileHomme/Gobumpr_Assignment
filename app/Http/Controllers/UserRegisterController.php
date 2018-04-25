<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\role;
use App\role_admin;
use DB;
use Session;

class UserRegisterController extends Controller
{
    public function showRegistrationForm()
   {
       return view('restaurant.user_register');
   }

   public function register(Request $request)
   {
       $this->validate($request,
array(
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:admins',
    'password' => 'required|string|min:6|confirmed',
));

       $name = $request->name;
       $email = $request->email;
       $password = bcrypt($request->password);

       $user_default_image = 'public/'.rand(1,3).'.png';



    DB::table('admins')->insert(
    ['name' => $name, 'email' => $email,'password'=>$password]);



       $role_id = 2;
       $admin_id = DB::table('admins')->max('id');

       $role_admin = new role_admin;
       $role_admin->role_id = $role_id;
       $role_admin->admin_id = $admin_id;
       $role_admin->save();


       DB::table('user_details')->insert(
       ['user_name' => $name, 'user_emailid' => $email,'profile_image'=>$user_default_image,'user_id'=>$admin_id]);

       Session::flash('message','You have been Registered Successfully!! Please Login Now!!');
       return redirect()->route('admin.login');


   }

   // public function validation($request)
   // {
   //     return $this->validate($request, [
   //         'name' => 'required|string|max:255',
   //         'email' => 'required|string|email|max:255|unique:admins',
   //         'password' => 'required|string|min:6|confirmed',
   //     ]);
   // }
}
