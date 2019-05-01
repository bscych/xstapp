<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;
use Illuminate\Support\Facades\App;

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
        $constant = Constant::find(\App\Model\Course::find($class->course_id)->course_category_id);
        //托管类
        $date = [];
        $time = time();

        $week = date('w', $time);
        if ($constant->name == '托管') {
            //获取当前周几
            for ($i = 0; $i <= 7; $i++) {
                $date[$i] = date('Y-m-d', strtotime('+' . $i - $week . ' days', $time));
            }
        } else {
            //其他特长课类，只返回当前天
            if ($week == $class->which_day_1 || $week == $class->which_day_2) {
                $date = [date('Y-m-d', $time)];
            }
        }
        $holidays = \App\Model\Holiday::where('type', 0)->get();
        if ($agent == 'WECHAT') {
            return View::make('backend.schedule.wechatIndex')->with('calendar', $date)->with('class_id', $class_id)->with('holidays', $holidays)->with('student_id', $student_id);
        } else {
            return View::make('backend.schedule.index')->with('calendar', $date)->with('class_id', $class_id)->with('holidays', $holidays);
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
        }
        $attendance = $this->getAttendanceData($schedule_id, $student_id);

        $currentDate = date('Y-m-d', time());

        if ($date >= $currentDate) {
            if ($request->input('AGENT') == 'WECHAT') {
                $menu = App::call('App\Http\Controllers\MenuController@getMenuByDate', [$date]);
                return View::make('backend.schedule.wechatCreate')->with('student', $attendance)->with('date', $date)->with('class_id', $class_id)->with('menu', $menu)->with('meal_flags',$this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            } else {
               return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags',$this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            }
        } else {
            if ($request->input('AGENT') == 'WECHAT') {
                $menu = App::call('App\Http\Controllers\MenuController@getMenuByDate', [$date]);
                return View::make('backend.schedule.wechatDetail')->with('student', $attendance)->with('date', $date)->with('class_id', $class_id)->with('menu', $menu)->with('meal_flags',$this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            } else {
                return View::make('backend.schedule.detail')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id)->with('meal_flags',$this->getMealFlags($class_id))->with('exception', $this->getDinnerExceptions());
            }
        }
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
                ->join('courses','courses.id','course_student.course_id')
                ->where([['courses.course_category_id',12],['courses.deleted_at',null],['course_student.classmodel_id','<>',null],['courses.name','like','%幼儿园托管%'],['classmodel_id','<>',null]])
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
        //
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

}
