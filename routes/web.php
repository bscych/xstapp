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
Route::resource('/constant', 'ConstantController')->middleware('auth');

Route::resource('/spend', 'SpendController')->middleware('auth');
Route::get('/refund/{student_id}', 'SpendController@refund')->middleware('auth');
Route::post('/returnFee', 'SpendController@returnFee')->middleware('auth');

Route::resource('/student', 'StudentController')->middleware('auth');
Route::get('/getMykids','StudentController@getKids')->middleware('auth');
Route::get('/getKidsCourse/{student_id}','StudentController@getActiveCourses')->middleware('auth');

Route::get('/studentJson', 'StudentController@indexJson')->middleware('auth');
Route::resource('/coursePlan', 'CoursePlanController')->middleware('auth');
Route::resource('/course', 'CourseController')->middleware('auth');
Route::get('/getStudentList/{course_id}', 'CourseController@getStudentList')->middleware('auth');


Route::get('/getCourseList/{student_id}', 'StudentController@getCourseList')->middleware('auth');
Route::resource('/income', 'IncomeController')->middleware('auth');
Route::resource('/statistics', 'StatisticsController')->middleware('auth');
Route::get('/monthList', 'StatisticsController@getMonthList')->middleware('auth');
Route::get('/detail/{year}/{month}', 'StatisticsController@detail')->middleware('auth');
Route::get('/detail/{year}/{month}/{table_name}/{category_id}', 'StatisticsController@getDetailByCategory')->middleware('auth');

Route::get('/getScheduleByMonthClass/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass')->middleware('auth');
Route::get('/getScheduleByMonthClass_detail/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass_detail')->middleware('auth');

Route::resource('/class', 'ClassController')->middleware('auth');
Route::post('/divide', 'ClassController@divide')->middleware('auth');
Route::get('/quitClass/{course_id}/{student_id}', 'ClassController@quitClass')->middleware('auth');

Route::resource('/schedule', 'ScheduleController')->middleware('auth');
//Route::resource('/classroom', 'ClassRoomController')->middleware('auth');
Route::resource('/teacher', 'TeacherController')->middleware('auth');
Route::resource('/enroll', 'EnrollController')->middleware('auth');

Route::resource('/holiday', 'HolidayController')->middleware('auth');

Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList')->middleware('auth');
Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth')->middleware('auth');
Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday')->middleware('auth');
//
//Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
//
////    Route::get('/classroom', function () {
////        $wechat_user = session('wechat.oauth_user');
////        return view('home');
////    });
//    Route::get('/login', 'WeChatSelfAuthController@autoLogin')->name('login');
//    Route::get('/register', 'WeChatSelfAuthController@autoRegister')->name('register');
//});
