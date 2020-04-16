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
Route::get('/', function () {return view('welcome');});

//user releated routes
Route::post('login','api\User\UserController@login');
Route::get('/user/signup/',function() {return view('userSignup');});
Route::post('signup','api\User\UserController@signUp');

Route::get('/forgot/password',function() {return view('forgotPassword');});
Route::get('/reset/password',function() {return view('passwordReset');});
Route::post('sent/password/reset/link','MailController@sendPasswordResetLink');

Route::get('/staff/login',function(){ return view('staffLogin');});

Route::group(['middleware' => ['app.access']], function() {
    //dashboard related RouteServiceProvider
    Route::get('data','api\Content\DashboardController@getDashboardData');
    Route::get('/dashboard',function(){ return view('dashboard');});
    //school releated routes
    Route::get('/add/school',function(){ return view('addSchool');});
    Route::get('/add/institute',function(){ return view('addInstitute');});
    Route::post('add/school','api\Content\SchoolController@addSchool');
    Route::get('manage/schools','api\Content\SchoolController@manageSchools');
    Route::get('edit/school/{id}','api\Content\SchoolController@editSchool');
    Route::post('update/school/{id}','api\Content\SchoolController@updateSchool');
    Route::get('view/school/{id}','api\Content\SchoolController@viewSchool');

    //department related routes
    Route::get('/add/department','api\Content\DepartmentController@addDepartment');
    Route::post('/add/department','api\Content\DepartmentController@storeDepartment');
    Route::get('/manage/departments','api\Content\DepartmentController@manageDepartments');
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
    Route::get('/add/article',function() {return view('addArticle');});
    Route::post('publish/article','api\Content\ArticlesController@publishArticle');
    Route::get('manage/articles','api\Content\ArticlesController@manageArticles');
    //onlines classes
    Route::get('/webrtc',function(){ return view('onlineClasses');});
});


Route::post('/pusher/auth','api\User\UserController@studentAccess');
//mail testing
Route::get('/mail',function(){ return view('mailings.passwordResetMail');});
