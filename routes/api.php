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
Route::group(['middleware' => ['app.access']], function() {

});
Route::get('/app/editor',function(){ return view('editor');});
Route::get('/app/user/reports',function(){ return view('userReports');});
Route::post('/app/user/login','api\Teacher\TeacherController@appUserLogin');
Route::post('/app/user/forgot/password','api\Teacher\TeacherController@forgotPassword');
Route::get('/app/user/forgot/password/{user_id}/{user_reg}','api\Teacher\TeacherController@teacherResetPassword');
Route::post('/app/user/update/password/{user_id}','api\Teacher\TeacherController@teacherUpdatePassword');
Route::post('/app/add/post','api\Posts\PostsController@addPost');
Route::get('/app/delete/post/{pid}','api\Posts\PostsController@deletePost');
Route::get('/app/get/user/posts/{uid}/{offset}','api\Posts\PostsController@getUserPosts');
Route::get('/app/get/shchool/posts/{sid}/{uid}','api\Posts\PostsController@getSchoolPosts');
Route::get('/app/get/user/data/{uid}','api\Teacher\TeacherController@getTeacherInstituteData');
Route::get('/app/get/user/timetable/{sid}/{uid}','api\Teacher\TeacherController@getTeacherTimetable');
Route::get('/app/get/subject/data/{cid}/{subject}','api\Subject\SubjectController@getSubjectDataBySubject');
Route::post('/app/update/subject/syllabus','api\Subject\SubjectController@updateSubjectSyllabus');
Route::get('/app/get/user/classes/{uid}/{sid}','api\Teacher\TeacherController@getTeacherClasses');
Route::post('/app/update/subject/syllabus','api\Subject\SubjectController@updateSubjectSyllabus');
Route::post('/app/post/class/attendence','api\Attendence\AttendenceController@postAttendence');
Route::get('/app/get/user/syllabus/{uid}/{sid}','api\Syllabus\SyllabusController@getUserSyllabus');
Route::get('/app/get/my/class/{uid}','api\Teacher\TeacherController@getMyClass');
Route::post('/app/update/user/profile','api\Teacher\TeacherController@updateProfile');
Route::post('/app/user/apply/leave','api\Leaves\LeavesController@applyLeave');
Route::get('/app/user/leaves/{uid}','api\Leaves\LeavesController@getUserLeaves');
Route::get('/app/user/delete/leave/{id}','api\Leaves\LeavesController@deleteLeave');
Route::post('/app/post/homework','api\Homework\HomeworkController@postHomework');
Route::get('/app/user/reports/{uid}/{sid}','api\Reports\ReportsController@getUserSyllabus');
Route::post('/app/create/exam','api\Exams\ExamsController@createExam');
Route::get('/app/get/exams/{uid}','api\Exams\ExamsController@getExams');
Route::get('/app/get/class/students/{cid}','api\Exams\ExamsController@getClassStudents');
Route::post('/app/post/studennts/marks','api\Exams\ExamsController@saveExamMarks');
Route::post('/app/user/add/notifications','api\Notifications\NotificationsController@addNotifcation');
Route::get('/app/get/my/notifications/{uid}','api\Notifications\NotificationsController@getMyNotifications');
Route::get('/app/delete/notification/{nid}','api\Notifications\NotificationsController@deleteNotification');
Route::get('/app/get/notifications/{sid}','api\Notifications\NotificationsController@getNotifications');


Route::get('/test','api\Homework\HomeworkController@test');