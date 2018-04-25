<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('restaurantfinder','RestaurantController');


Auth::routes();



Route::get('/home/{name}', ['uses' => 'HomeController@index','as' => 'home']);

//Routes for "Muti Auth"

Route::get('admin','Admin\LoginController@showLoginForm')->name('admin.login');

Route::POST('admin','Admin\LoginController@login')->name('admin.login');

Route::get('logout', '\App\Http\Controllers\Admin\LoginController@logout');
Route::POST('logout', 'Admin\LoginController@logout')->name('logout');


Route::get('profile','RestaurantController@profile')->name('profile');
Route::get('editprofile','RestaurantController@editprofile')->name('editprofile');
Route::post('updateprofile','RestaurantController@updateprofile')->name('updateprofile');


Route::POST('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::GET('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

Route::POST('admin-password/reset','Admin\ResetPasswordController@reset');
Route::GET('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::GET('user-register','UserRegisterController@showRegistrationForm')->name('user.register');
Route::POST('user-register','UserRegisterController@register')->name('user.registered');

Route::get('addreview','RestaurantController@addreview')->name('addreview');

Route::get('updatereviewcount','RestaurantController@updatereviewcount')->name('updatereviewcount');
Route::get('updatecommentcountall','RestaurantController@commentcountall')->name('updatecommentcountall');

Route::get('updateratings','RestaurantController@updateratings')->name('updateratings');
Route::get('restaurantsearch','RestaurantController@restaurantsearch')->name('restaurantsearch');
Route::get('restaurantsearchname','RestaurantController@restaurantsearchname')->name('restaurantsearchname');
Route::get('restaurantdropname','RestaurantController@restaurantdropname')->name('restaurantdropname');

Route::get('userchangepassword', 'UpdatePasswordController@userindex')->name('userchangepassword');
Route::post('userchangepassword', 'UpdatePasswordController@userupdate')->name('userchangepassword');

// Route::get('adminchangepassword', 'UpdatePasswordController@adminindex')->name('adminchangepassword');
// Route::post('adminchangepassword', 'UpdatePasswordController@adminupdate')->name('adminchangepassword');
