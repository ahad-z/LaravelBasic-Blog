<?php

use App\Notifications\PostNotification;
use Illuminate\Support\Facades\Route;
use Nexmo\Laravel\Facade\Nexmo;

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

/*Route::get('test', function () {
	echo "<pre>";
	echo mime2ext('image/jpeg') .'<br>';

	echo mime2ext('application/x-pkcs7-signature') .'<br>';

	echo mime2ext('application/json') .'<br>';
});*/
/*Testing file email to send*/
Route::get('my-demo-mail','TestController@myDemoMail');

Route::get('/','PageController@index')->name('home');
/* for Verify Email Router*/
Route::get('/verifyEmail','PageController@verifyEmail')->name('verifyEmail');
/*For change Pass LoginVerify*/
Route::get('/verifyLoginEmail','PageController@verifyLoginEmail')->name('verifyLoginEmail');

Route::prefix('BasicRecap')->group(function () {
	Route::resource('users', 'UserController');
	Route::post('users/login', 'UserController@login')->name('users.login');
});

Route::prefix('BasicRecap/admin')->group(function () {
	Route::get('users/dashboard', 'UserController@adminDashboard')->name('users.dashboard');
	Route::get('users/logout', 'UserController@logout')->name('users.logout');
	         /* Chnage pass View*/
	Route::get('users/changepassView', 'UserController@changepassView')->name('users.changepassView');
	         /*Initally Forget Pass view*/
	Route::get('users/passwordView', 'UserController@passwordView')->name('users.passwordView');
	/*     Send Email verifiction      */
    Route::post('users/sendEmail', 'UserController@sendVerification')->name('users.sendEmail');
                    /* UpdatePassword*/
    Route::put('users/UpdatePassword','UserController@updatePass')->name('users.UpdatePassword');
    Route::get('users/User-index','UserController@usersIndex')->name('users.usersIndex');
    Route::post('users/User-create','UserController@usersCreate')->name('users.usersCreate');
	Route::resource('users', 'UserController');
					/* Job Handiling*/
	Route::get('import', 'ImportController@index')->name('import.index');
	Route::get('import/{id}/start', 'ImportController@start')->name('import.start');
});

Route::prefix('Basic-Recap/')->group(function(){
	Route::resource('categories', 'CategoryController');
});

Route::prefix('Basic-Recap/')->group(function(){
	Route::get('posts/admin-post-see', 'PostController@adminSeePost')->name('posts.adminPosts');
	Route::get('posts/postStatus/{id}/{status}', 'PostController@postStatus')->name('postStatus');
	Route::resource('posts', 'PostController');
});

			/* All search Route is here */
Route::get('posts/search','PageController@searchPost')->name('searchPost');
Route::get('posts/adminSearch','PostController@adminSearchPost')->name('adminSearchPost');
Route::get('users/searchUsers','PostController@searchUsers')->name('searchUsers');
Route::resource('comments','CommentController');
/*For Excel Download File Route*/
Route::get('users/exportData','UsersExportController@export')->name('users.excel');
/*User Data Import into database*/
Route::post('users/ImportData','UsersImportController@import')->name('importUser.excel');
/*                           SocialLight                    */

/* This is one for to send user into github*/
Route::get('/sign-in/github','UserController@github')->name('github');
/*This one for redirect user into login page*/
Route::get('/sign-in/github/redirect','UserController@githubRedirect');

/* This is one for to send user into facebook*/

Route::get('/sign-in/facebook', 'UserController@facebook')->name('facebook');

/*This one for redirect user into login page*/

Route::get('/sign-in/facebook/redirect', 'UserController@facebookRedirect');

/*This route for user redirect into google*/

Route::get('/sign-in/google', 'UserController@google')->name('google');

/*This one for redirect user into login page*/

Route::get('/sign-in/google/redirect', 'UserController@googleRedirect');


Route::group(['prefix' => 'admin'],function (){
	route::get('/basic-recap/admin-dashboard', 'adminController@index')->name('admin.dashboard');
	route::resource('roles', 'RolesController');
});


