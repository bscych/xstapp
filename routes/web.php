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
    Route::get('/getMykids', 'StudentController@getKids');
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

    Route::get('/getScheduleStatistics/{month}/{course_id}', 'StatisticsController@getScheduleStatistics');
    Route::get('/getScheduleByMonthClass_detail/{month}/{course_id}', 'StatisticsController@getScheduleByMonthClass_detail');



    Route::resource('/class', 'ClassController');
    Route::post('/divide', 'ClassController@divide');
    Route::get('/quitClass/{course_id}/{student_id}', 'ClassController@quitClass');

    Route::resource('/schedule', 'ScheduleController');
    Route::resource('/classroom', 'ClassRoomController');
    Route::resource('/teacher', 'TeacherController');
    Route::resource('/enroll', 'EnrollController');

    Route::resource('/holiday', 'HolidayController');
    Route::resource('/menuItem', 'MenuItemController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/code', 'RegisterCodeController');


    Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList');
    Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth');
    Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday');
    Route::get('/getClassId', 'ScheduleController@getClassId')->name('studentScheduleList_API');
    Route::get('/getMenu/{date}', 'MenuController@getMenuByDate')->name('getMenu_API');
    Route::get('/createMenu', 'WeChatController@menu_add');
});



//Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

    Route::get('wechat/home', 'WeChatController@index')->name('wechat_home');
    Route::get('api/auth/role', 'WeChatSelfAuthController@showRoleSelectionForm')->name('showRoleSelectionForm');
    Route::get('api/auth/register/{whichForm}', 'WeChatSelfAuthController@showRegisterForm')->name('showApiAuthRegisterForm');
    Route::post('api/auth/register/', 'WeChatSelfAuthController@autoRegister')->name('apiAuthRegister');

    Route::get('api/auth/login', 'WeChatSelfAuthController@autoLogin')->name('apiAuthLogin');

    // Route::post('api/auth/login', 'WeChatSelfAuthController@autoLogin')->name('apiAuthLogin');
//    Route::get('/classroom', function () {
//        $wechat_user = session('wechat.oauth_user');
//        return view('home');
//    });
//});




Route::group([
    'prefix' => 'auth',
    'namespace' => 'api'
        ], function () {


//    Route::group(['middleware' => 'auth:api'], function() {
//        Route::get('logout', 'UserController@logout');
//        Route::get('user', 'UserController@user');
//    });
});




