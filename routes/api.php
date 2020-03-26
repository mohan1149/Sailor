<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('sent/password/reset/link','MailController@sendPasswordResetLink');
Route::post('signup','api\User\UserController@signUp');
Route::post('login','api\User\UserController@login');
Route::group(['middleware' => ['app.access']], function() {
    //school releated routes
    Route::post('add/school','api\Content\SchoolController@addSchool');
    Route::get('manage/schools','api\Content\SchoolController@manageSchools');
    Route::get('edit/school/{id}','api\Content\SchoolController@editSchool');
    Route::post('update/school/{id}','api\Content\SchoolController@updateSchool');
    Route::get('view/school/{id}','api\Content\SchoolController@viewSchool');
    //staff releated routes
    Route::get('add/staff','api\Content\StaffController@getSchools');
    Route::POST('manage/staff','api\Content\StaffController@addStaff');
    Route::get('manage/staff','api\Content\StaffController@manageStaff');
    //class releated routes
    Route::get('add/class','api\Content\ClassController@getSchools');
    Route::post('add/time-table','api\Content\ClassController@storeClass');
    Route::get('manage/class','api\Content\ClassController@manageClass');
    Route::post('add/timetable','api\Content\ClassController@storeTimetable');

    //Articles related routes 
    Route::post('publish/article','api\Content\ArticlesController@publishArticle');
    Route::get('manage/articles','api\Content\ArticlesController@manageArticles');
});