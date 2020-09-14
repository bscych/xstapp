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
})->name('welcome');

Route::get('/brandStory', function () {
    return view('frontend.brandStory')->with('text','网站在建，敬请期待！');
})->name('brandStory');
Route::get('/concept', function () {
    return view('frontend.concept')->with('text','网站在建，敬请期待！');
})->name('concept');

Route::get('/show', function () {
    return view('frontend.show')->with('text','网站在建，敬请期待！');
})->name('show');
Route::get('/trust', function () {
    return view('frontend.trust')->with('text','网站在建，敬请期待！');
})->name('trust');
Route::get('/connect', function () {
    return view('frontend.connect')->with('text','网站在建，敬请期待！');
})->name('connect');
Route::get('/training', function () {
    return view('frontend.training')->with('text','网站在建，敬请期待！');
})->name('training');

Route::get('/contact', function () {
    return view('frontend.contact')->with('text','网站在建，敬请期待！');
})->name('contact');

Route::get('/how/to/find/myKids', function () {
    return view('frontend.helpers.howto');
})->name('howto');
Route::get('/useTlog', function () {
    return view('frontend.helpers.howto2');
})->name('how_to_log');

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
    Route::resource('/visitor', 'VisitorController');
    Route::post('/addContactHistory', 'VisitorController@addContactHistory')->name('visitor.addContactHistory');
    Route::get('/convertToStudent', 'VisitorController@convertToStudent')->name('visitor.convertToStudent');
    Route::get('/getMykids', 'StudentController@getKids')->name('getMyKids');
    Route::get('/getKidsCourse/{student_id}', 'StudentController@getActiveCourses');

    Route::get('/studentJson', 'StudentController@indexJson');
    Route::resource('/coursePlan', 'CoursePlanController');
    Route::resource('/course', 'CourseController');
    Route::get('/getStudentList/{course_id}', 'CourseController@getStudentList');


    Route::get('/getCourseList/{student_id}', 'StudentController@getCourseList');
    Route::get('/registerCode/{student_id}','StudentController@getStudentRegisterCode')->name('registerCodeList');
    Route::get('/newRegisterCode/{student_id}','StudentController@createStudentRegisterCode')->name('newRegisterCode');
    Route::resource('/income', 'IncomeController');
    Route::get('/showCourseCategory','IncomeController@showCourseCategory')->name('showCourseCategory');
  
    Route::resource('/statistics', 'StatisticsController');
    Route::get('/monthList', 'StatisticsController@getMonthList');
    Route::get('/detail/{year}/{month}', 'StatisticsController@detail');
    Route::get('/detail/{year}/{month}/{table_name}/{category_id}', 'StatisticsController@getDetailByCategory');
    Route::get('/purchase_detail/{year}/{month}','StatisticsController@getPurchaseDetail')->name('get_purchase_detail');
    
    Route::get('/getScheduleStatistics', 'StatisticsController@getScheduleStatistics')->name('getScheduleStatistics');
    Route::get('/getScheduleByMonthClass_detail', 'StatisticsController@getScheduleByMonthClass_detail')->name('get_schedule_detail_by_month');
    Route::get('/getTCKStudentStatus', 'StatisticsController@getTCKStudentStatus')->name('getTCKStudentStatus');
    
    Route::resource('/class', 'ClassController');
    Route::post('/divide', 'ClassController@divide');
    Route::get('/quitClass/{course_id}/{student_id}', 'ClassController@quitClass');
    Route::get('/user/getTCKListByTeacherId','ClassController@getTCKListByTeacherId')->name('getTCKListByTeacherId');
    Route::get('/printList/{id}','ClassController@toPrintList')->name('class.printList');
    Route::get('/printHomework','ClassController@printHomework')->name('class.print');
    Route::get('/printHomeworkBatch','ClassController@printHomeworkBatch')->name('class.print_batch');
    
    Route::resource('/schedule', 'ScheduleController');
    Route::get('/reCheckIn','ScheduleController@reCheckIn')->name('reCheckIn');
    Route::resource('/classroom', 'ClassRoomController');
    Route::resource('/user', 'UserController');
    Route::get('/getMyWorkingSheet','UserController@getMyWorkingSheet')->name('getMyWorkingSheet');
    
    Route::resource('/enroll', 'EnrollController');

//    作业管理
    Route::resource('/homework', 'HomeworkController');
    
    Route::resource('/holiday', 'HolidayController');
    Route::resource('/menuItem', 'MenuItemController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/code', 'RegisterCodeController');
    Route::resource('/role', 'RoleController');
    Route::resource('/bill', 'BillController');
    Route::get('/batchBill/{year}/{month}','BillController@createBillBatch')->name('batchBillByYearMonth');
    route::get('/closeBill/{id}','BillController@confirmToClose')->name('closeBill');
    Route::get('/scheduleList/{course_id}', 'CourseController@getScheduleList');
    Route::get('/scheduleByMonth/{course_id}/{month}', 'CourseController@getScheduleByMonth');
    Route::get('/scheduleByMonthIndDay/{course_id}/{month}', 'CourseController@getScheduleByMonthInday');
    Route::get('/getClassId', 'ScheduleController@getClassId')->name('studentScheduleList_API');
    Route::get('/getMenu/{date}', 'MenuController@getMenuByDate')->name('getMenu_API');
    Route::get('/get/thisweek/menu', 'MenuController@getThisweekMenu')->name('menu.thisweek');

    Route::get('/wechat/pay', 'WeChatController@pay')->name('wechat.pay');
   // Route::get('/delete', 'WeChatController@menu_destroy');
   // Route::get('/add', 'WeChatController@menu_add');
    //Route::get('/current', 'WeChatController@menu_current');
});



Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

    Route::get('wechat/home', 'WeChatController@index')->name('wechat.home');
    Route::get('api/auth/role', 'WeChatSelfAuthController@showRoleSelectionForm')->name('showRoleSelectionForm');
    Route::get('api/auth/show/form/teacher', 'WeChatSelfAuthController@showTeacherRegisterForm')->name('showTeacherRegisterForm');
    Route::get('api/auth/show/form/parent', 'WeChatSelfAuthController@showParentRegisterForm')->name('showParentRegisterForm');
    Route::post('api/auth/register/parent', 'WeChatSelfAuthController@registerTeacher')->name('registerTeacher');
    Route::post('api/auth/register/teacher', 'WeChatSelfAuthController@registerParent')->name('registerParent');

    Route::get('api/auth/login', 'WeChatSelfAuthController@autoLogin')->name('apiAuthLogin');

    Route::any('wechat_payment_notify', 'WeChatController@notify');
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




