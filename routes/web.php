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
Route::get('/shell','User\SiteCreateController@createSite');
Route::get('/admin', function () {return view('welcome');});
Route::get('/', function () {return view('userLogin');});
//user releated routes
Route::post('login','User\UserController@login');
Route::post('signup','User\UserController@signUp');
Route::get('/staff/login',function(){ return view('staffLogin');});
Route::get('/user/signup/',function() {return view('userSignup');});
Route::get('/reset/password',function() {return view('passwordReset');});
Route::get('/forgot/password',function() {return view('forgotPassword');});
Route::post('sent/password/reset/link','Mailings\MailController@sendPasswordResetLink');

Route::group(['middleware' => ['app.access']], function() {
    //dashboard related RouteServiceProvider
    Route::get('/school/dashboard','Content\DashboardController@getPostsAndNotif');    
    Route::get('/college/dashboard',function(){ return view('college.dashboard');});
    //graph
    Route::get('/get/institute/graph-data','Content\DashboardController@getInstituteGraphData');
    Route::get('/get/school/graph-data','Content\DashboardController@getInstituteGraphData');
      
    //user related routes
    Route::get('/logout','User\UserController@logout');
    Route::get('/profile','User\UserController@getProfile');
    Route::get('/mailbox','User\UserController@getMailbox');
    Route::get('/notifications','User\UserController@getNotifications');    
    
    //college releated routes

    Route::get('/add/college',function(){ return view('college.addCollege');});
    Route::post('add/college','Content\College\CollegeController@addCollege');
    Route::get('manage/colleges','Content\College\CollegeController@manageColleges');
    Route::get('view/college/{id}','Content\College\CollegeController@viewCollege');
    Route::get('edit/college/{id}','Content\College\CollegeController@editCollege');
    Route::post('update/college/{id}','Content\College\CollegeController@updateCollege');
    Route::get('delete/college/{id}','Content\College\CollegeController@deleteCollege');
    Route::get('get/classes/{id}','Content\College\CollegeController@getClasses');

    //school related routes

    Route::get('/add/school',function(){ return view('school.addSchool');});
    Route::post('/add/school','Content\School\SchoolController@addSchool');
    Route::get('/manage/schools','Content\School\SchoolController@manageSchools');
    Route::get('edit/school/{id}','Content\School\SchoolController@editSchool');
    Route::post('update/school/{id}','Content\School\SchoolController@updateSchool');
    Route::get('view/school/{id}','Content\School\SchoolController@viewSchool');
    Route::get('delete/school/{id}','Content\School\SchoolController@deleteSchool');

    //department related routes
    Route::get('/add/department','Content\Departments\DepartmentController@addDepartment');
    Route::post('/add/department','Content\Departments\DepartmentController@storeDepartment');
    Route::get('/manage/departments','Content\Departments\DepartmentController@manageDepartments');
    Route::get('/edit/department/{id}','Content\Departments\DepartmentController@editDepartment');
    Route::post('/update/department/{id}','Content\Departments\DepartmentController@updateDepartment');
    Route::get('/view/department/{id}','Content\Departments\DepartmentController@viewDepartment');
    Route::get('/delete/department/{id}','Content\Departments\DepartmentController@deleteDepartment');
    Route::get('/depts/{ins}/{id}','Content\Departments\DepartmentController@deptsByIns');

    //staff releated routes
    Route::get('add/staff','Content\TeachingStaff\StaffController@addStaff');
    Route::POST('add/staff','Content\TeachingStaff\StaffController@storeStaff');
    Route::get('manage/staff','Content\TeachingStaff\StaffController@manageStaff');
    Route::get('edit/staff/{id}','Content\TeachingStaff\StaffController@editStaff');
    Route::get('view/staff/{id}','Content\TeachingStaff\StaffController@viewStaff');
    Route::get('delete/staff/{id}','Content\TeachingStaff\StaffController@deleteStaff');
    Route::post('update/staff/{id}','Content\TeachingStaff\StaffController@updateStaff');
    Route::get('staff/{ins}/{id}','Content\TeachingStaff\StaffController@staffByIns');

    //grades or studying years related routes
    Route::get('add/studying/year','Content\Grades\GradesController@addYearOfStudy');
    Route::post('add/year','Content\Grades\GradesController@addYear');
    Route::get('/manage/years','Content\Grades\GradesController@manageYears');
    Route::get('/list/students/{gid}','Content\Grades\GradesController@listStudentsByGrade');
    Route::get('/delete/grade/{gid}','Content\Grades\GradesController@deleteGrade');
    Route::get('/edit/grade/{gid}','Content\Grades\GradesController@editGrade');
    Route::post('/update/year/{gid}','Content\Grades\GradesController@updateYear');    
    
    //class releated routes
    Route::get('/add/class','Content\InsClass\ClassController@addClass');
    Route::post('/store/class','Content\InsClass\ClassController@storeClass');
    Route::post('add/timetable','Content\InsClass\ClassController@storeTimetable');
    Route::get('manage/classes','Content\InsClass\ClassController@manageClass');
    Route::get('/view/class/{id}','Content\InsClass\ClassController@viewClass');
    Route::get('/edit/class/{id}','Content\InsClass\ClassController@editClass');
    Route::post('update/class/{id}','Content\InsClass\ClassController@updateClass');
    Route::get('/delete/class/{id}','Content\InsClass\ClassController@deleteClass');
    Route::get('/view/timetable/{id}','Content\InsClass\ClassController@viewTimetable');
    Route::get('/update/syllabus/{class_id}/{subject_index}/{sub_percent}','Content\InsClass\ClassController@updateSyllabus');
    Route::post('/add/chapters/{class_id}/{subject_index}','Content\InsClass\ClassController@addChaptersToSubject');
    Route::get('/classes/{ins}/{id}','Content\InsClass\ClassController@classesByIns');

    //Articles related routes
    Route::get('/add/article',function() {return view('addArticle');});
    Route::get('/view/article/',function() {return view('viewArticle');});
    Route::get('/manage/articles','api\Content\ArticlesController@manageArticles');
    Route::post('/publish/article','api\Content\ArticlesController@publishArticle');
    Route::get('/delete/article/{id}','api\Content\ArticlesController@deleteArticle');
    //onlines classes
    Route::get('/webrtc',function(){ return view('onlineClasses');});
    //student related routes
    Route::get('/add/student','Content\Student\StudentController@addStudent');
    Route::POST('/add/student','Content\Student\StudentController@storeStudent');
    Route::get('/manage/students','Content\Student\StudentController@manageStudents');
    Route::get('/edit/student/{id}','Content\Student\StudentController@editStudent');
    Route::post('/update/student/{id}','Content\Student\StudentController@updateStudent');
    Route::get('/view/student/{id}','Content\Student\StudentController@viewStudent');
    Route::get('/delete/student/{id}','Content\Student\StudentController@deleteStudent');
    Route::get('/students/{ins}/{id}','Content\Student\StudentController@studentsByIns');

    //routes related to lab
    Route::get('/add/lab','Content\Labs\LabsController@addLab');
    Route::post('/store/lab','Content\Labs\LabsController@storeLab');
    Route::get('/edit/lab/{id}','Content\Labs\LabsController@editLab');
    Route::get('/manage/labs','Content\Labs\LabsController@manageLabs');
    Route::get('/delete/lab/{id}','Content\Labs\LabsController@deleteLab');
    Route::post('/update/lab/{id}','Content\Labs\LabsController@updateLab');
    Route::get('/labs/{ins}/{id}','Content\Labs\LabsController@labsByIns');
    //routes related roles and permissions
    Route::get('/permissions','User\UserController@getPermissions');
    Route::post('/assign/user/role','api\User\UserController@assignUserRole');

    //routes related to employee
    Route::get('/add/employee','Content\Employee\EmployeeController@addEmployee');
    Route::post('/store/employee','Content\Employee\EmployeeController@storeEmployee');
    Route::get('/manage/employees','Content\Employee\EmployeeController@manageEmployees');
    Route::get('/edit/employee/{id}','Content\Employee\EmployeeController@editEmployee');
    Route::post('/update/employee/{id}','Content\Employee\EmployeeController@updateEmployee');
    Route::get('/delete/employee/{id}','Content\Employee\EmployeeController@deleteEmployee');
    Route::get('/employees/{ins}/{id}','Content\Employee\EmployeeController@employeesByIns');

    //data import 
    Route::get('/import/students','Content\Student\StudentController@importStudentView');
    Route::post('/import/students','Content\Student\StudentController@importStudents');
    Route::get('/import/staff','Content\TeachingStaff\StaffController@importStaffView');
    Route::post('/import/staff','Content\TeachingStaff\StaffController@importStaff');

    Route::get('/manage/leaves',function(){ return view('csoon');});
    Route::get('/coming/soon',function(){ return view('csoon');});
    Route::get('/add/notification','api\Content\NotificationsController@addNotification');
});

Route::group(['prefix'=>'hod','middleware' => ['HoDAccess']], function() {
    Route::get('/dashboard',function(){ return view('csoon');});
});
Route::group(['prefix'=>'class/teacher','middleware' => ['ClassTeacherAccess']], function() {
    Route::get('/dashboard',function(){ return view('csoon');});
});
Route::group(['prefix'=>'teacher','middleware' => ['TeacherAccess']], function() {
    Route::get('/dashboard',function(){ return view('csoon');});
});



Route::get('db','Content\CommonController@dbtest');

Route::get('/password/reset/success',function(){ return view('mobileViews.passwordResetSuccess');});