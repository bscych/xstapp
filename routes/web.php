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
//Route::resource('/constantName', 'ConstantNameController')->middleware('auth');
//Route::resource('/constantValue', 'ConstantValueController')->middleware('auth');
Route::resource('/spend', 'SpendController')->middleware('auth');
Route::get('/refund/{student_id}', 'SpendController@refund')->middleware('auth');
Route::post('/returnFee', 'SpendController@returnFee')->middleware('auth');

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
Route::get('/detail/{year}/{month}/{table_name}/{category_id}', 'StatisticsController@getDetailByCategory')->middleware('auth');

Route::get('/getScheduleByMonthClass/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass')->middleware('auth');
Route::get('/getScheduleByMonthClass_detail/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass_detail')->middleware('auth');

Route::resource('/class', 'ClassController')->middleware('auth');
Route::post('/divide', 'ClassController@divide')->middleware('auth');
Route::get('/quitClass/{course_id}/{student_id}', 'ClassController@quitClass')->middleware('auth');

Route::resource('/schedule', 'ScheduleController')->middleware('auth');
Route::resource('/classroom', 'ClassRoomController')->middleware('auth');
Route::resource('/teacher', 'TeacherController')->middleware('auth');
Route::resource('/enroll', 'EnrollController')->middleware('auth');

Route::resource('/holiday', 'HolidayController')->middleware('auth');

Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList')->middleware('auth');
Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth')->middleware('auth');
Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday')->middleware('auth');

Route::group(['middleware' => ['wechat.oauth:default,snsapi_userinfo']], function () {
    Route::get('/classroom', function () {

        $wechat_user = session('wechat.oauth_user.default');
        if (!Auth::check()) {
            $wechat_info = $wechat_user->original;
            $user = User::where('openid', $wechat_info['openid'])->first();
            if (is_null($user)) {
                $wechat_info = $wechat_user->original;
                $user = new User;
                $user->openid = $wechat_info['opoenid'];
                $user->nickname = $wechat_info['nickname'];
                $user->sex = $wechat_info['sex'];
                $user->city = $wechat_info['city'];
                $user->province = $wechat_info['province'];
                $user->country = $wechat_info['country'];
                $user->avatar = $wechat_info['avatar'];
                $user->password = bcrypt('123456');
                $match = [];
                $url = $request->url;
                preg_match('/\w+([1-9]\d*)/', $url, $match);
                $user->weixin_id = $match[1] ?? 0;
                $user->recommend_id = 0;
                $user->save();
                Auth::login($user);
            } else {
                Auth::login($user);
            }
        }
    });
});
