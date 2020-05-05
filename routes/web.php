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
Route::post('signup','api\User\UserController@signUp');
Route::get('/staff/login',function(){ return view('staffLogin');});
Route::get('/user/signup/',function() {return view('userSignup');});
Route::get('/reset/password',function() {return view('passwordReset');});
Route::get('/forgot/password',function() {return view('forgotPassword');});
Route::post('sent/password/reset/link','MailController@sendPasswordResetLink');

Route::group(['middleware' => ['app.access']], function() {
    //dashboard related RouteServiceProvider
    Route::get('/dashboard',function(){ return view('dashboard');});
    Route::get('data','api\Content\DashboardController@getDashboardData');
    //user related routes
    Route::get('/logout','api\User\UserController@logout');
    Route::get('/profile','api\User\UserController@getProfile');
    Route::get('/mailbox','api\User\UserController@getMailbox');
    Route::get('/notifications','api\User\UserController@getNotifications');
    //school releated routes
    Route::post('add/year','api\Content\SchoolController@addYear');
    Route::get('/add/school',function(){ return view('addSchool');});
    Route::post('add/school','api\Content\SchoolController@addSchool');
    Route::get('/add/institute',function(){ return view('addInstitute');});
    Route::get('edit/school/{id}','api\Content\SchoolController@editSchool');
    Route::get('view/school/{id}','api\Content\SchoolController@viewSchool');
    Route::get('get/classes/{id}','api\Content\SchoolController@getClasses');
    Route::get('manage/schools','api\Content\SchoolController@manageSchools');
    Route::get('delete/school/{id}','api\Content\SchoolController@deleteSchool');
    Route::get('add/studying/year','api\Content\SchoolController@addYearOfStudy');
    Route::post('update/school/{id}','api\Content\SchoolController@updateSchool');
    Route::get('get/departs-grades/{id}','api\Content\SchoolController@getDepartsAndGradesBySchoolId');
    //department related routes
    Route::get('/add/department','api\Content\DepartmentController@getSchools');
    Route::post('/add/department','api\Content\DepartmentController@storeDepartment');
    Route::get('/edit/department/{id}','api\Content\DepartmentController@editDepartment');
    Route::get('/view/department/{id}','api\Content\DepartmentController@viewDepartment');
    Route::get('/manage/departments','api\Content\DepartmentController@manageDepartments');
    Route::get('/delete/department/{id}','api\Content\DepartmentController@deleteDepartment');
    Route::post('/update/department/{id}','api\Content\DepartmentController@updateDepartment');
    //staff releated routes
    Route::get('add/staff','api\Content\StaffController@getSchools');
    Route::POST('manage/staff','api\Content\StaffController@addStaff');
    Route::get('manage/staff','api\Content\StaffController@manageStaff');
    Route::get('edit/staff/{id}','api\Content\StaffController@editStaff');
    Route::get('view/staff/{id}','api\Content\StaffController@viewStaff');
    Route::get('delete/staff/{id}','api\Content\StaffController@deleteStaff');
    Route::post('update/staff/{id}','api\Content\StaffController@updateStaff');

    //class releated routes
    Route::get('add/class','api\Content\ClassController@getSchools');
    Route::get('manage/class','api\Content\ClassController@manageClass');
    Route::post('add/time-table','api\Content\ClassController@storeClass');
    Route::get('/edit/class/{id}','api\Content\ClassController@editClass');
    Route::get('/view/class/{id}','api\Content\ClassController@viewClass');
    Route::post('add/timetable','api\Content\ClassController@storeTimetable');
    Route::post('update/class/{id}','api\Content\ClassController@updateClass');
    Route::get('/delete/class/{id}','api\Content\ClassController@deleteClass');
    Route::get('/view/timetable/{id}','api\Content\ClassController@viewTimetable');
    //Articles related routes
    Route::get('/add/article',function() {return view('addArticle');});
    Route::get('/view/article/',function() {return view('viewArticle');});
    Route::get('/manage/articles','api\Content\ArticlesController@manageArticles');
    Route::post('/publish/article','api\Content\ArticlesController@publishArticle');
    Route::get('/delete/article/{id}','api\Content\ArticlesController@deleteArticle');
    //onlines classes
    Route::get('/webrtc',function(){ return view('onlineClasses');});
    //student related routes
    Route::get('/add/student','api\Content\StudentController@addStudent');
    Route::POST('/add/student','api\Content\StudentController@storeStudent');
    Route::get('/edit/student/{id}','api\Content\StudentController@editStudent');
    Route::get('/view/student/{id}','api\Content\StudentController@viewStudent');
    Route::get('/manage/students','api\Content\StudentController@manageStudents');
    Route::get('/delete/student/{id}','api\Content\StudentController@deleteStudent');
    Route::post('/update/student/{id}','api\Content\StudentController@updateStudent');
    //routes related to lab
    Route::get('/add/lab','api\Content\LabsController@addLab');
    Route::post('/store/lab','api\Content\LabsController@storeLab');
    Route::get('/edit/lab/{id}','api\Content\LabsController@editLab');
    Route::get('/manage/labs','api\Content\LabsController@manageLabs');
    Route::get('/delete/lab/{id}','api\Content\LabsController@deleteLab');
    Route::post('/update/lab/{id}','api\Content\LabsController@updateLab');
    Route::get('/manage/employees',function(){ return view('csoon');});
    Route::get('/manage/leaves',function(){ return view('csoon');});

    Route::get('/coming/soon',function(){ return view('csoon');});

    Route::get('/add/notification','api\Content\NotificationsController@addNotification');
});


Route::post('/pusher/auth','api\User\UserController@studentAccess');
//mail testing
Route::get('/mail',function(){ return view('mailings.passwordResetMail');});
