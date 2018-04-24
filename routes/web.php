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




Route::get('admin/display','AdminController@display')->name('admin.display');
Route::get('admin/{id}/edit','AdminController@edit')->name('admin.edit');



Route::resource('restaurantfinder','RestaurantController');


Auth::routes();
//
// Route::POST('update', function () {
//     dd('asd');
// });


Route::POST('update','AdminController@update');
Route::POST('destroy','AdminController@destroy');

Route::get('/home/{name}', ['uses' => 'HomeController@index','as' => 'home']);

//Routes for "Muti Auth"

//Route for showing the admin's dashboard after login
Route::get('admin/home','AdminController@index')->name('admin.home');
Route::get('admin/create','AdminController@create')->name('admin.create');
Route::post('admin/store','AdminController@store')->name('admin.store');

Route::get('admin','Admin\LoginController@showLoginForm')->name('admin.login');

Route::POST('admin','Admin\LoginController@login')->name('admin.login');

Route::get('logout', '\App\Http\Controllers\Admin\LoginController@logout');
Route::POST('logout', 'Admin\LoginController@logout')->name('logout');


Route::get('profile','RestaurantController@profile')->name('profile');
Route::get('editprofile','RestaurantController@editprofile')->name('editprofile');
Route::post('updateprofile','RestaurantController@updateprofile')->name('updateprofile');

Route::get('adminprofile','AdminController@adminprofile')->name('adminprofile');
Route::get('editadminprofile','AdminController@editadminprofile')->name('editadminprofile');
Route::post('updateadminprofile','AdminController@updateadminprofile')->name('updateadminprofile');


Route::POST('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::GET('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

Route::POST('admin-password/reset','Admin\ResetPasswordController@reset');
Route::GET('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::GET('trainee-register','TraineeRegisterController@showRegistrationForm')->name('trainee.register');
Route::POST('trainee-register','TraineeRegisterController@register')->name('trainee.registered');




// Routes for Login with google
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

// Routes for Adding Comments on the person activities
Route::get('addreview','RestaurantController@addreview')->name('addreview');

Route::get('updatereviewcount','RestaurantController@updatereviewcount')->name('updatereviewcount');
Route::get('updatecommentcountall','RestaurantController@commentcountall')->name('updatecommentcountall');

Route::get('updateratings','RestaurantController@updateratings')->name('updateratings');
Route::get('updatelikeshow','RestaurantController@updatelikeshow')->name('updatelikeshow');
Route::get('reducelikeshow','RestaurantController@reducelikeshow')->name('reducelikeshow');
Route::get('updatelikeshowall','RestaurantController@updatelikeshowall')->name('updatelikeshowall');
Route::get('reducelikeshowall','RestaurantController@reducelikeshowall')->name('reducelikeshowall');
Route::get('updatelikesall','RestaurantController@updatelikesall')->name('updatelikesall');
Route::get('reducelikes','RestaurantController@reducelikes')->name('reducelikes');
Route::get('reducelikesall','RestaurantController@reducelikesall')->name('reducelikesall');

Route::get('userchangepassword', 'UpdatePasswordController@traineeindex')->name('userchangepassword');
Route::post('userchangepassword', 'UpdatePasswordController@traineeupdate')->name('userchangepassword');

Route::get('adminchangepassword', 'UpdatePasswordController@adminindex')->name('adminchangepassword');
Route::post('adminchangepassword', 'UpdatePasswordController@adminupdate')->name('adminchangepassword');
