<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\role;
use App\role_admin;
use DB;
use Session;

class TraineeRegisterController extends Controller
{
    public function showRegistrationForm()
   {
       return view('traineee.trainee_register');
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

       $trainee_default_image = 'public/'.rand(1,3).'.png';

       // dd($trainee_default_image);
    //    Admin::create([
    //        'name' => $name,
    //        'email' => $email,
    //        'password' => $password,
    //    ]);

    DB::table('admins')->insert(
    ['name' => $name, 'email' => $email,'password'=>$password]);

    $trainee_id = DB::table('admins')->max('id');

       // $roles = new role;
       // $roles->name = "Trainee";
       // $roles->save();

       $role_id = 2;
       $admin_id = DB::table('admins')->max('id');

       $role_admin = new role_admin;
       $role_admin->role_id = $role_id;
       $role_admin->admin_id = $admin_id;
       $role_admin->save();


       DB::table('trainee_details')->insert(
       ['trainee_name' => $name, 'trainee_emailid' => $email,'id'=>$trainee_id,'profile_image'=>$trainee_default_image]);

       Session::flash('message','You have been Registered Successfully!! Please Login Now!!');
       return redirect()->route('admin.login');


   }

   public function validation($request)
   {
       return $this->validate($request, [
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:admins',
           'password' => 'required|string|min:6|confirmed',
       ]);
   }
}
