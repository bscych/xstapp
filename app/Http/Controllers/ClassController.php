<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Course;
use App\Model\ClassRoom;

class ClassController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
      
        if ($request->input('course_id') != null) {
            $classes = DB::table('classmodels')
                    ->join('courses', 'classmodels.course_id', 'courses.id')
//                    ->join('class_rooms', 'classmodels.classroom_id', 'class_rooms.id')
                    ->join('users', 'classmodels.teacher_id', 'users.id')
                    ->select('classmodels.id', 'classmodels.name', 'courses.name as course_name', 'users.name as teacher_name')
                    ->where('course_id', $request->input('course_id'))
                    ->where('classmodels.deleted_at', null)
                    ->get();
        } else {
            $classes = DB::table('classmodels')
                    ->join('courses', 'classmodels.course_id', 'courses.id')
//                    ->join('class_rooms', 'classmodels.classroom_id', 'class_rooms.id')
                    ->join('users', 'classmodels.teacher_id', 'users.id')
                    ->select('classmodels.id', 'classmodels.name', 'courses.name as course_name', 'users.name as teacher_name')
                    ->where('classmodels.deleted_at', null)
                    ->where('classmodels.teacher_id', Auth::id())
                    ->get();
        }
        $course_students = DB::table('course_student')->get();

        if ($request->input('AGENT') == 'WECHAT') {
            return View::make('backend.class.wechatIndex')->with('classes', $classes)->with('students', $course_students)->with('course_id', $request->input('course_id'));
        } else {
            return View::make('backend.class.index')->with('classes', $classes)->with('students', $course_students)->with('course_id', $request->input('course_id'));
        }
    }

    function updateWhichDay() {
        foreach (\App\Model\Classmodel::all() as $class) {
            $whichDay = collect();
            $class->which_day_1 == null ?: $whichDay->push((int) $class->which_day_1);
            $class->which_day_2 == null ?: $whichDay->push((int) $class->which_day_2);
            $class->which_day_1 = $whichDay->toJson();
            $class->save();
        }
    }

    /*
     * get 特长课 list by user id, year, month
     */

    public function getTCKListByTeacherId(Request $request) {
        $claz = DB::table('classmodels')->join('courses', 'classmodels.course_id', 'courses.id')->join('schedules', 'schedules.classmodel_id', 'classmodels.id')
                        ->where([['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.course_category_id', '<>', 12], ['classmodels.teacher_id', $request->input('teacher_id')]])
                        ->whereYear('schedules.date', $request->input('year'))->whereMonth('schedules.date', $request->input('month'))
                        ->select('classmodels.name', 'classmodels.id')->distinct()->get();
        return View::make('backend.user.my_class_list')->with('classes', $claz);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $course = Course::find($request->input('course_id'));
        $teachers = DB::table('users')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->where('model_has_roles.role_id', 2)
                ->select('users.name', 'users.id')
                ->get();
        return View::make('backend.class.create')
                        ->with('course', $course)
                        ->with('courseCategories', DB::table('constants')->where('parent_id', 2)->get())
                        ->with('teachers', $teachers)
                        ->with('classrooms', ClassRoom::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('class/create')
                            ->withErrors($validator);
        } else {
            $course = Course::find($request->input('course_id'));
            $claz = new \App\Model\Classmodel;
            $claz->course_id = $course->id;
            $claz->name = $request->input('name');
            $claz->teacher_id = $request->input('teacher_id');

            $claz->start_date = $course->start_date;
            $claz->end_date = $course->end_date;

            $weekdays = collect();
            for ($i = 0; $i < 7; $i++) {
                if ($request->input('' . $i) == 'on') {
                    $weekdays->push($i);
                }
            }
            $claz->which_day_1 = $weekdays->toJson();
            $claz->save();
            Session::flash('message', 'Successfully created!');
            return Redirect::route('class.index',['course_id'=>$claz->course_id]);
        }
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
        $teachers = DB::table('users')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->where('model_has_roles.role_id', 2)
                ->select('users.name', 'users.id')
                ->get();
        $class = DB::table('classmodels')->join('courses', 'courses.id', 'classmodels.course_id')->join('constants', 'courses.course_category_id', 'constants.id')->where('classmodels.id', $id)
                        ->select('courses.name as course_name', 'classmodels.id as class_id', 'constants.name', 'classmodels.start_date', 'classmodels.end_date', 'classmodels.name as class_name', 'classmodels.teacher_id', 'classmodels.which_day_1')
                        ->get()->first();
        $class->which_day_1 = collect(json_decode($class->which_day_1));
        return view('backend.class.edit')->with('class', $class)->with('teachers', $teachers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('class/edit/'.$id)->withErrors($validator);
        } else {
            $class = \App\Model\Classmodel::find($id);
            $class->name = $request->input('name');
            $class->teacher_id = $request->input('teacher_id');
            $weekdays = collect();
            for ($i = 0; $i < 7; $i++) {
                if ($request->input('' . $i) == 'on') {
                    $weekdays->push($i);
                }
            }
            $class->which_day_1 = $weekdays->toJson();
            $class->save();
            return Redirect::route('class.index',['course_id'=>$class->course_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $class = \App\Model\Classmodel::find($id);
        $class->delete();
        return route('class.index', ['course_id' => $class->course_id]);
    }

    public function divide(Request $request) {
        $course_id = $request->input('course_id');
        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');

        $course_student = DB::table('course_student')->where([
                    ['course_id', '=', $course_id],
                    ['student_id', '=', $student_id],
                ])->get();
        if ($course_student->count() == 0) {
            DB::table('course_student')->insert(
                    ['course_id' => $course_id, 'student_id' => $student_id, 'classmodel_id' => $class_id]
            );
        } else {
            DB::table('course_student')
                    ->where('id', $course_student->first()->id)
                    ->update(['classmodel_id' => $class_id]);
        }
        //if there are existing schedules, add the student into the schedule from now on 
        $schedules = DB::table('schedules')
                ->where('classmodel_id', '=', $class_id)
                ->where('date', '>=', date('Y-m-d'))
                ->get();
        // there are schedules from now
        if ($schedules->count() > 0) {
            foreach ($schedules as $schedule) {
                //check if the student is on the schedule
                if (DB::table('schedule_student')->where([['schedule_id', '=', $schedule->id], ['student_id', '=', $student_id]])->get()->count() == 0) {
                    // to create a schedule_student for the student 
                    DB::table('schedule_student')
                            ->insert(['schedule_id' => $schedule->id, 'student_id' => $student_id]);
                }
            }
        }

        Session::flash('message', 'Successfully created nerd!');
        return Redirect::to('getStudentList/' . $course_id);
    }

    public function quitClass($course_id, $student_id) {

        DB::table('course_student')
                ->where([['course_id', '=', $course_id], ['student_id', '=', $student_id]])
                // ->update(['classmodel_id' => 0 , 'deleted_at' =>date('Y-m-d h:i:s', time())]);
                ->update(['classmodel_id' => null]);

        return Redirect::to('getStudentList/' . $course_id);
    }

}
