<?php

use App\department;

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
});

Route::get('/search', function() {
    return view('search', ["departments" => Department::All()]);
});


Route::get('/user/{account}/works/{workID}', 'WorkController@index');

Auth::routes();

Route::get('/logOut', function(){
	if(Auth::check()) {
		Auth::logout();
	}
    return redirect('/pigether');
});

Route::get('/home', 'HomeController@index');

Route::get('/user/{account}', 'UserController@index');

Route::post('/review', 'CommentController@add');
