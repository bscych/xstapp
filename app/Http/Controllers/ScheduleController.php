<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Arr;

class ScheduleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $class_id = $request->input('class_id');
        $student_id = $request->input('student_id');
        $agent = $request->input('AGENT');
        $class = \App\Model\Classmodel::find($class_id);

        if ($agent == 'WECHAT') {
            return View::make('backend.schedule.wechatIndex')->with('calendar', $this->getScheduleDates($class))->with('class_id', $class_id)->with('student_id', $student_id);
//            return View::make('backend.schedule.wechatIndex')->with('calendar', $date)->with('class_id', $class_id)->with('holidays', $holidays)->with('workingdays', $workingdays)->with('class',$class)->with('student_id', $student_id)->with('isTG',$isTG);
        } else {
//            return View::make('backend.schedule.index')->with('calendar', $date)->with('class_id', $class_id)->with('holidays', $holidays)->with('workingdays', $workingdays)->with('class',$class)->with('isTG',$isTG);
            return View::make('backend.schedule.index')->with('calendar', $this->getScheduleDates($class))->with('class_id', $class_id);
        }
    }

    function getScheduleDates($class) {
        $data = collect();
        $DATE_STRING_KEY = 'date';
        $SUBMITTABLE_STRING_KEY = 'submittable';
        $constant = Constant::find(\App\Model\Course::find($class->course_id)->course_category_id);
        if ($constant->name != '托管') {
            foreach (json_decode($class->which_day_1) as $day) {
                if (now()->dayOfWeek === $day) {
                    $dateArray = Arr::add(Arr::add([], $DATE_STRING_KEY, now()->format('Y-m-d')), $SUBMITTABLE_STRING_KEY, $this->canDisplay(now()->format('Y-m-d'), $class));
                    $data->push($dateArray);
                }
            }
        } else {
            for ($i = 0; $i < 7; $i++) {
                $date = now()->addDays($i - (now()->dayOfWeek))->format('Y-m-d');
                $dateArray = Arr::add(Arr::add([], $DATE_STRING_KEY, $date), $SUBMITTABLE_STRING_KEY, $this->canDisplay($date, $class));
                $data->push($dateArray);
            }
        }

        return $data;
    }

    /*
     * 是否显示订餐考勤按钮，
     */

    function canDisplay($theDate, $class) {
        $date = \Illuminate\Support\Carbon::make($theDate);
        $holidays = \App\Model\Holiday::where('type', 0)->get();
        $workingdays = \App\Model\Holiday::where('type', 1)->get();
        $constant = Constant::find(\App\Model\Course::find($class->course_id)->course_category_id);
        //周6，周日，国家法定假日，课程的开始的第一天，课程结束的最后一天
        $classStart_date = \Illuminate\Support\Carbon::make($class->start_date)->format('Y-m-d');
        $ClassClosed_date = \Illuminate\Support\Carbon::make($class->end_date)->format('Y-m-d');
//        非托管的课程只显示当天，并且节假日都能打卡
        if ($constant->name != '托管') {
            return true;
        } else {
//        托管类的周日周六，国家法定节假日都不能打卡订餐
            if ($date->dayOfWeek === 6 or $date->dayOfWeek === 0 or $holidays->where('which_day', $theDate)->count() === 1 or $ClassClosed_date <= $date or $classStart_date >= $date) {
                if ($workingdays->where('which_day', $theDate)->count() === 0) {
                    return false;
                } else {
                return true;
                }
            } else {
                //                    如果选择特定的哪一天托管，那么检查which_day_1是否为空
                    $whichDays = collect(json_decode($class->which_day_1));
                    if ($whichDays->isEmpty()) {
                        //            如果每周正常托管，class的上课频率一周内每天都没勾选，就返回true
                        return true;
                    } else {
//              which_day_1不为空则说明，特定某天托管，只允许订当天的餐
                        return $whichDays->contains($date->dayOfWeek);
                    }
            }
        }
    }

    /*
     * to get schedule id in 2 cases:
     * 1. to get existing schedule id
     * 2. to create a new schedule and fetch the id
     */

    function getScheduleIdByClassIdAndDate($class_id, $date) {
        $schedules = DB::table('schedules')->where([
                    ['classmodel_id', '=', $class_id],
                    ['date', '=', $date],
                ])->get();
        // $schedule_student = collect([]);
        $schedule_id = -1;  // init schedule id;
        if ($schedules->count() == 1) {
            $schedule_id = $schedules->first()->id;
            // check if there is student join the class newly 
        }
        // there is no existing schedule, create a new schedule
        if ($schedules->count() == 0) {
            $schedule_id = $this->createNewSchedule($class_id, $date);
            //为每天都吃饭的学生报餐
            $this->autoBookMeal($schedule_id, $class_id);
        }
        return $schedule_id;
    }

    /*
     * 打卡日期已经过了，超级管理员和管理员可以补打卡
     */

    public function reCheckIn(Request $request) {
        if (auth()->user()->hasanyrole('admin|superAdmin')) {
            $class_id = $request->input('class_id');
            $date = $request->input('date');
            $schedule_id = $this->getScheduleIdByClassIdAndDate($class_id, $date);
            $attendance = $this->getAttendanceData($schedule_id, null);
            return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
        } else {
            return '404';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $class_id = $request->input('class_id');
        $student_id = $request->input('student_id');
        $date = $request->input('date');
        // get the schedule 
        $schedule_id = $this->getScheduleIdByClassIdAndDate($class_id, $date);
        $attendance = $this->getAttendanceData($schedule_id, $student_id);

        if ($this->canEditByDateTime($date)) {
            if ($request->input('AGENT') == 'WECHAT') {
                //parents would like to see the menu when they book meal for their kids
                $menu = App::call('App\Http\Controllers\MenuController@getMenuByDate', [$date]);
                return View::make('backend.schedule.wechatCreate')->with('student', $attendance)->with('date', $date)->with('class_id', $class_id)->with('menu', $menu)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            } else {
                return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            }
        } else {
            if ($request->input('AGENT') == 'WECHAT') {
                //parents would like to see the menu when they book meal for their kids
                $menu = App::call('App\Http\Controllers\MenuController@getMenuByDate', [$date]);
                return View::make('backend.schedule.wechatDetail')->with('student', $attendance)->with('date', $date)->with('class_id', $class_id)->with('menu', $menu)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            } else {
                return View::make('backend.schedule.detail')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
                //电脑版的特长课可以修改
//                 return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags', $this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            }
        }
    }

    function canEditByDateTime($date) {
        $currentDate = date('Y-m-d', time());
        //比当天晚的餐，可以
        if ($date > $currentDate) {
            return true;
        }
        //今天的餐，家长9点前可以，9点后不可以，老师今天都可以
        if ($date == $currentDate) {
            if (\Illuminate\Support\Facades\Auth::user()->hasRole('parent') and \Illuminate\Support\Carbon::now()->greaterThan(\Illuminate\Support\Carbon::createFromTime(9, 0, 0))) {
                return false;
            }
            return true;
        }
        //比今天晚的餐，只能查看，不能编辑
        return false;
    }

    function createNewSchedule($class_id, $date) {
        // create a new schedule and fetch the ID
        $schedule = new \App\Model\Schedule;
        $schedule->classmodel_id = $class_id;
        $schedule->date = $date;
        $schedule->save();
        $schedule_id = $schedule->id;
        // form schedule_student data
        $schedule_students = [];
        $students = DB::table('course_student')
                ->join('students', 'students.id', 'course_student.student_id')
                ->select('students.id', 'students.name')
                ->where('course_student.classmodel_id', $class_id)
                ->get();
        for ($i = 0; $i < $students->count(); $i++) {
            $schedule_students[$i] = ['schedule_id' => $schedule_id, 'student_id' => $students[$i]->id];
        }
        //save schedule_student relationship accordingly 
        DB::table('schedule_student')->insert($schedule_students);
        return $schedule_id;
    }

    function getAttendanceData($schedule_id, $student_id) {
        if ($student_id == null) {
            return DB::table('schedule_student')
                            ->join('students', 'schedule_student.student_id', 'students.id')
                            ->select('schedule_student.id', 'schedule_student.student_id', 'students.name', 'schedule_student.attended', 'schedule_student.lunch', 'schedule_student.dinner')
                            ->where('schedule_student.schedule_id', $schedule_id)
                            ->get();
        } else {
            return DB::table('schedule_student')
                            ->join('students', 'schedule_student.student_id', 'students.id')
                            ->select('schedule_student.id', 'schedule_student.student_id', 'students.name', 'schedule_student.attended', 'schedule_student.lunch', 'schedule_student.dinner')
                            ->where('schedule_student.schedule_id', $schedule_id)
                            ->where('schedule_student.student_id', $student_id)
                            ->first();
        }
    }

    function getMealFlags($class_id) {
        return DB::table('courses')
                        ->join('classmodels', 'classmodels.course_id', 'courses.id')
                        ->where('classmodels.id', $class_id)
                        ->select('courses.has_dinner', 'courses.has_lunch')
                        ->first();
    }

    /*
     * 目前幼小衔接班里有报幼儿园托管的同学，所i有幼儿园托管需要订晚餐，凡是在幼儿园托管在籍的在此列
     */

    function getDinnerExceptions() {
        return DB::table('course_student')
                        ->join('courses', 'courses.id', 'course_student.course_id')
                        ->where([['courses.course_category_id', 12], ['courses.deleted_at', null], ['course_student.classmodel_id', '<>', null], ['courses.name', 'like', '%幼儿园托管%'], ['course_student.classmodel_id', '<>', null]])
                        ->select('course_student.student_id')
                        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $schedule_student_id = $request->input('schedule_student_id');
        $field = $request->input('field');
        $value = $request->input('value') == 'true' ? 1 : 0;

        if ($field == 'attended') {
            $student_id = DB::table('schedule_student')->where('id', $schedule_student_id)->get()->first()->student_id;
            $course_student = DB::table('course_student')->join('schedules', 'schedules.classmodel_id', 'course_student.classmodel_id')->join('schedule_student', 'schedule_student.schedule_id', 'schedules.id')->where([['schedule_student.id', $schedule_student_id], ['course_student.student_id', '=', $student_id]])->select('course_student.id', 'course_student.how_many_left')->get()->first();

            $how_many_left = $course_student->how_many_left == null ? 0 : $course_student->how_many_left;
            if ($value > 0) {
                //如果值為1 則剩餘次數上-1
                $how_many_left--;
            } else {
                //如果值為0 則剩餘次數上+1
                $how_many_left++;
            }
            DB::table('course_student')
                    ->where('id', $course_student->id)
                    ->update(['how_many_left' => $how_many_left]);
        }
        DB::table('schedule_student')
                ->where('id', $schedule_student_id)
                ->update([$field => $value]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function getClassId(Request $request) {
        $classIds = DB::table('course_student')
                ->select('classmodel_id')
                ->where([
                    ['course_id', '=', $request->input('course_id')],
                    ['student_id', '=', $request->input('student_id')],])
                ->get();
        return response()->json($classIds);
    }

    function autoBookMeal($schedule_id, $class_id) {
        $students = DB::table('auto_book_meal_students')
                ->where('class_id', $class_id)
                ->get();
        if ($students->count() > 0) {
            foreach ($students as $student) {
                DB::table('schedule_student')
                        ->where('schedule_id', $schedule_id)
                        ->where('student_id', $student->student_id)
                        ->update(['attended' => $student->attended, 'lunch' => $student->lunch, 'dinner' => $student->dinner]);
            }
        }
    }

}
