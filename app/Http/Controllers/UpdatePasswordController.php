<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Auth;

class UpdatePasswordController extends Controller
{
    public function traineeindex()
    {
        $logged_in_user = Auth::guard('admin')->user()->name;

        $adminid = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_id = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainee_image = DB::table('trainee_details')->where('id',$trainee_id)->value('profile_image');

        return view('traineee/password/change-password',compact('trainee_image','logged_in_user'));
    }

    public function traineeupdate(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $logged_in_user = Auth::guard('admin')->user()->name;

        $admin = DB::table('admins')->where('name',$logged_in_user)->value('password');

        $hashedPassword = $admin;

        $newpassword = Hash::make($request->password);

        // dd($hashedPassword, $newpassword);

        if(Hash::check($request->old, $hashedPassword))
        {
            DB::table('admins')->where('name',$logged_in_user)->update(['password'=>$newpassword]);

            $request->session()->flash('success', 'Your password has been changed.');

            //destroy the session of that user so that he/she cannot do the process again
            $request->session()->flush();

            return redirect()->route('admin.login');
        }
        else
        {
            $request->session()->flash('failure', 'Your password has not been changed.');

            return redirect('traineechangepassword');
        }
    }

    public function adminindex()
    {
        $logged_in_user = Auth::guard('admin')->user()->name;
        // dd($logged_in_user);
        $adminid = DB::table('admins')->where('name',$logged_in_user)->value('id');


        $admin_image = DB::table('admin_details')->where('id',$adminid)->value('profile_image');
        return view('admin/password/change-password',compact('admin_image','logged_in_user'));

    }

    public function adminupdate(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $logged_in_user = Auth::guard('admin')->user()->name;

        $admin = DB::table('admins')->where('name',$logged_in_user)->value('password');

        $hashedPassword = $admin;

        $newpassword = Hash::make($request->password);

        // dd($hashedPassword, $newpassword);

        if(Hash::check($request->old, $hashedPassword))
        {
            DB::table('admins')->where('name',$logged_in_user)->update(['password'=>$newpassword]);

            $request->session()->flash('success', 'Your password has been changed.');

            //destroy the session of that user so that he/she cannot do the process again
            $request->session()->flush();

            return redirect()->route('admin.login');
        }
        else
        {
            $request->session()->flash('failure', 'Your password has not been changed.');

            return redirect('adminchangepassword');
        }
    }

    public function trainerindex()
    {
        $logged_in_user = Auth::guard('admin')->user()->name;

        $trainerid = DB::table('admins')->where('name',$logged_in_user)->value('id');

        $trainer_image = DB::table('trainer_details')->where('id',$trainerid)->value('profile_image');
        return view('trainer/password/change-password',compact('trainer_image','logged_in_user'));
    }

    public function trainerupdate(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $logged_in_user = Auth::guard('admin')->user()->name;

        $admin = DB::table('admins')->where('name',$logged_in_user)->value('password');

        $hashedPassword = $admin;

        $newpassword = Hash::make($request->password);

        // dd($hashedPassword, $newpassword);

        if(Hash::check($request->old, $hashedPassword))
        {
            DB::table('admins')->where('name',$logged_in_user)->update(['password'=>$newpassword]);

            $request->session()->flash('success', 'Your password has been changed.');

            //destroy the session of that user so that he/she cannot do the process again
            $request->session()->flush();

            return redirect()->route('admin.login');
        }
        else
        {
            $request->session()->flash('failure', 'Your password has not been changed.');

            return redirect('trainerchangepassword');
        }
    }
}
