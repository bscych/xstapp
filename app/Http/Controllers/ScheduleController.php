<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;

class ScheduleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {


//        $dates = collect([]);
//
//        $holidays = collect(['2018-3-1', '2018-3-1', '2018-3-1']);
//
//
//        ////means it is a 托管类,will happen every working day
//        // get start date and the end date
//        $startdate = date_create('2018-3-1');
//        $enddate = date_create('2018-3-1');
//        date_add($enddate, date_interval_create_from_date_string("365 days"));
//
//        while ($startdate < $enddate) {
//            $nextday = date_add($startdate, date_interval_create_from_date_string("1 day"));
//            $ss = date('w', strtotime($nextday->format('Y-m-d')));
//            if (($ss != 6) && ($ss != 0)) {
//                $dates->push(date_create($nextday->format('Y-m-d')));
//            }
//        }
        $class_id = $request->input('class_id');
        $class = \App\Model\Classmodel::find($class_id);
        $constant = Constant::find(\App\Model\Course::find($class->course_id)->course_category_id);
        //托管类
        $date = [];
        $time = time();
        $week = date('w', $time);
        if ($constant->name == '托管') {
            //获取当前周几
            for ($i = 1; $i <= 7; $i++) {
                $date[$i] = date('Y-m-d', strtotime('+' . $i - $week . ' days', $time));
            }
        } else {
            //其他特长课类，只返回当前天
            if ($week == $class->which_day_1 || $week == $class->which_day_2) {
                $date = [date('Y-m-d', $time)];
            }
        }
        $holidays = \App\Model\Holiday::where('type', 0)->get();
        return View::make('backend.schedule.index')->with('calendar', $date)->with('class_id', $class_id)->with('holidays', $holidays);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $class_id = $request->input('class_id');
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
            $this->createNewSchedule($class_id, $date);
        }
        $student_id = $request->input('student_id');
        $attendance = $this->getAttendanceData($schedule_id, $student_id);
        $currentDate = date('Y-m-d', time());
        if ($date >= $currentDate) {
            return View::make('backend.schedule.create')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id);
        } else {
            return View::make('backend.schedule.detail')->with('students', $attendance)->with('date', $date)->with('class_id', $class_id);
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
                            ->get();
        }
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

}
