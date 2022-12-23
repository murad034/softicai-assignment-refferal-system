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
    if(\Illuminate\Support\Facades\Auth::user()){
        return redirect('adminUser');
    }
   return view('auth.login');
});

//Roles
Route::group(['prefix' => ''], function () {
    Route::resource('roles', 'RolesController');
});


Route::get('/adminUser', 'WelcomeController@displayWelcome')->name('adminUser');

Route::get('logout','LogoutController@displayLogout');

//users
Route::group(['prefix' => 'users'], function () {
    Route::get('/','UserController@listUser')->name('userlist');
    Route::get('/add','UserController@addUser')->name('adduser');
    Route::get('/edit','UserController@editUser')->name('user.edit');
    Route::get('/delete','UserController@deleteUser')->name('user.delete');
    Route::post('/save','UserController@saveUser')->name('user.save');
});

// profiles

Route::get('refer','ReferController@displayRefer')->name('refer');
Route::get('referList','ReferController@displayReferList')->name('referList');

Auth::routes([
    'reset' => false,
    'verify' => false,
]);
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

