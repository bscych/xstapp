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
});
//微信路由
Route::any('/wechat', 'WeChatController@serve');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/constantName', 'ConstantNameController')->middleware('auth');
Route::resource('/constantValue', 'ConstantValueController')->middleware('auth');
Route::resource('/spend', 'SpendController')->middleware('auth');
Route::resource('/dashboard', 'DashboardController')->middleware('auth');
Route::resource('/student', 'StudentController')->middleware('auth');
Route::get('/studentJson', 'StudentController@indexJson')->middleware('auth');
Route::resource('/coursePlan', 'CoursePlanController')->middleware('auth');
Route::resource('/course', 'CourseController')->middleware('auth');
Route::get('/getStudentList/{course_id}', 'CourseController@getStudentList')->middleware('auth');


Route::get('/getCourseList/{student_id}', 'StudentController@getCourseList')->middleware('auth');
Route::resource('/income', 'IncomeController')->middleware('auth');
Route::resource('/statistics', 'StatisticsController')->middleware('auth');
Route::get('/monthList', 'StatisticsController@getMonthList')->middleware('auth');
Route::get('/detail/{year}/{month}', 'StatisticsController@detail')->middleware('auth');
Route::get('/detail/{year}/{month}/{category_id}', 'StatisticsController@getDetailByCategory')->middleware('auth');

Route::resource('/class', 'ClassController')->middleware('auth');
Route::post('/divide', 'ClassController@divide')->middleware('auth');

Route::resource('/schedule', 'ScheduleController')->middleware('auth');
Route::resource('/classroom', 'ClassRoomController')->middleware('auth');
Route::resource('/teacher', 'TeacherController')->middleware('auth');
Route::resource('/enroll', 'EnrollController')->middleware('auth');

Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList')->middleware('auth');
Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth')->middleware('auth');
Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday')->middleware('auth');