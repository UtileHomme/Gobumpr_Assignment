<?php

namespace App\Http\Controllers\Auth;

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

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'workout';

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
            $name = DB::table('admins')->where('name', $user->name)->value('name');
        }
        else
        {
        $adminModel = new Admin;

        $adminModel->name = $user->name;
        $adminModel->email = $user->getEmail();
        $name = $user->name;
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
            Auth::login($adminModel, true);
            return redirect()->route('home',['name'=>$name]);
    }

}
