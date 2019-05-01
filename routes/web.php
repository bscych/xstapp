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

Route::get('/brandStory', function () {
    return view('frontend.dashboard.index');
});

//微信路由
Route::any('/wechat', 'WeChatController@serve');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::resource('/constant', 'ConstantController');

    Route::resource('/spend', 'SpendController');
    Route::get('/refund/{student_id}', 'SpendController@refund');
    Route::post('/returnFee', 'SpendController@returnFee');

    Route::resource('/student', 'StudentController');
    Route::get('/getMykids', 'StudentController@getKids')->name('getMyKids');
    Route::get('/getKidsCourse/{student_id}', 'StudentController@getActiveCourses');

    Route::get('/studentJson', 'StudentController@indexJson');
    Route::resource('/coursePlan', 'CoursePlanController');
    Route::resource('/course', 'CourseController');
    Route::get('/getStudentList/{course_id}', 'CourseController@getStudentList');


    Route::get('/getCourseList/{student_id}', 'StudentController@getCourseList');
    Route::resource('/income', 'IncomeController');
    Route::resource('/statistics', 'StatisticsController');
    Route::get('/monthList', 'StatisticsController@getMonthList');
    Route::get('/detail/{year}/{month}', 'StatisticsController@detail');
    Route::get('/detail/{year}/{month}/{table_name}/{category_id}', 'StatisticsController@getDetailByCategory');

    Route::get('/getScheduleStatistics', 'StatisticsController@getScheduleStatistics')->name('getScheduleStatistics');
    Route::get('/getScheduleByMonthClass_detail/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass_detail');



    Route::resource('/class', 'ClassController');
    Route::post('/divide', 'ClassController@divide');
    Route::get('/quitClass/{course_id}/{student_id}', 'ClassController@quitClass');

    Route::resource('/schedule', 'ScheduleController');
    Route::resource('/classroom', 'ClassRoomController');
    Route::resource('/user', 'UserController');
    Route::resource('/enroll', 'EnrollController');

    Route::resource('/holiday', 'HolidayController');
    Route::resource('/menuItem', 'MenuItemController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/code', 'RegisterCodeController');
    Route::resource('/role', 'RoleController');

    Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList');
    Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth');
    Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday');
    Route::get('/getClassId', 'ScheduleController@getClassId')->name('studentScheduleList_API');
    Route::get('/getMenu/{date}', 'MenuController@getMenuByDate')->name('getMenu_API');
    Route::get('/get/thisweek/menu', 'MenuController@getThisweekMenu')->name('menu.thisweek');
});



Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

    Route::get('wechat/home', 'WeChatController@index')->name('wechat.home');
    Route::get('api/auth/role', 'WeChatSelfAuthController@showRoleSelectionForm')->name('showRoleSelectionForm');
    Route::get('api/auth/show/form/teacher', 'WeChatSelfAuthController@showTeacherRegisterForm')->name('showTeacherRegisterForm');
    Route::get('api/auth/show/form/parent', 'WeChatSelfAuthController@showParentRegisterForm')->name('showParentRegisterForm');
    Route::post('api/auth/register/parent', 'WeChatSelfAuthController@registerTeacher')->name('registerTeacher');
    Route::post('api/auth/register/teacher', 'WeChatSelfAuthController@registerParent')->name('registerParent');

    Route::get('api/auth/login', 'WeChatSelfAuthController@autoLogin')->name('apiAuthLogin');

});




Route::group([
    'prefix' => 'auth',
    'namespace' => 'api'
        ], function () {


//    Route::group(['middleware' => 'auth:api'], function() {
//        Route::get('logout', 'UserController@logout');
//        Route::get('user', 'UserController@user');
//    });
});




