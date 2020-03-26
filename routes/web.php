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
Route::get('/user/signup/',function() {return view('userSignup');});
Route::get('/forgot/password',function() {return view('forgotPassword');});
Route::get('/reset/password',function() {return view('passwordReset');});

Route::group(['middleware' => ['app.access']], function() {
    Route::get('/add/school',function(){ return view('addSchool');});
    Route::get('/dashboard',function(){ return view('dashboard');});
    Route::get('/add/article',function() {return view('addArticle');});
});
