<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\Admin;
use DB;
use App\role;
use App\role_admin;
use App\User;
use Illuminate\Http\Request;

class GoogleLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
    * Where to redirect users after login.
    *
    * @var string
    */
    protected $redirectTo = '/home';

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
    * Obtain the user information from GitHub.
    *
    * @return Response
    */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $adminModel = Admin::where('email', $user->getEmail())->first();

        if($adminModel)
        {
            $adminModel = Admin::where('email', $user->getEmail())->first();
        }
        else
        {
        $adminModel = new Admin;

        $adminModel->name = $user->name;
        $adminModel->email = $user->getEmail();

        // echo $user->getAvatar();
        $adminModel->save();

        $roles = new role;
        $roles->name = "Trainee";
        $roles->save();

        $role_id = DB::table('roles')->max('id');
        $admin_id = DB::table('admins')->max('id');

        $role_admin = new role_admin;
        $role_admin->role_id = $role_id;
        $role_admin->admin_id = $admin_id;
        $role_admin->save();
    }
    // dd($adminModel);
            Auth::login($adminModel, true);
            return redirect()->route('admin.trainee');
    }
}
