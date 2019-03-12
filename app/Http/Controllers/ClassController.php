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

//        foreach (Course::all() as $course) {
//            $class = \App\Model\Classmodel::where('course_id', $course->id)->where('deleted_at',null)->first();
//
//            if ($class == null) {
//                    $claz = new \App\Model\Classmodel;
//                    $claz->course_id = $course->id;
//                    // $claz->name = $request->input('name');
//                    $claz->teacher_id = $course->teacher_id;
//                    $claz->classroom_id = $course->classroom_id;
//                    $claz->start_date = $course->start_date;
//                    $claz->end_date = $course->end_date;
//                    $claz->which_day_1 = $course->which_day_1;
//                    $claz->block1_start_time = $course->block1_start_time;
//                    $claz->block1_end_time = $course->block1_end_time;
//                    $claz->which_day_2 = $course->which_day_2;
//                    $claz->block2_start_time = $course->block2_start_time;
//                    $claz->block2_end_time = $course->block2_end_time;
//                    $claz->save();
//            }
//        }
        //$course_students = collect();
        if ($request->input('course_id') != null) {
            $classes = DB::table('classmodels')
                    ->join('courses', 'classmodels.course_id', 'courses.id')
                    ->join('class_rooms', 'classmodels.classroom_id', 'class_rooms.id')
                    ->join('users', 'classmodels.teacher_id', 'users.id')
                    ->select('classmodels.id', 'classmodels.name', 'class_rooms.name as classroom_name', 'courses.name as course_name', 'users.name as teacher_name')
                    ->where('course_id', $request->input('course_id'))
                    ->where('classmodels.deleted_at', null)
                    ->get();
        } else {
            $classes = DB::table('classmodels')
                    ->join('courses', 'classmodels.course_id', 'courses.id')
                    ->join('class_rooms', 'classmodels.classroom_id', 'class_rooms.id')
                    ->join('users', 'classmodels.teacher_id', 'users.id')
                    ->select('classmodels.id', 'classmodels.name', 'class_rooms.name as classroom_name', 'courses.name as course_name', 'users.name as teacher_name')
                    ->where('classmodels.deleted_at', null)
                    ->where('classmodels.teacher_id', Auth::id())
                    ->get();
        }
        $course_students = DB::table('course_student')->get();

        return View::make('backend.class.index')->with('classes', $classes)->with('students', $course_students)->with('course_id', $request->input('course_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $course = Course::find($request->input('course_id'));
        $teachers = DB::table('teachers')
                ->join('users', 'teachers.user_id', '=', 'users.id')
                ->select('users.name as name', 'users.id as id')
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
            $claz->classroom_id = $request->input('classroom_id');
            $claz->start_date = $course->start_date;
            $claz->end_date = $course->end_date;
            $claz->which_day_1 = $course->which_day_1;
            $claz->block1_start_time = $course->block1_start_time;
            $claz->block1_end_time = $course->block1_end_time;
            $claz->which_day_2 = $course->which_day_2;
            $claz->block2_start_time = $course->block2_start_time;
            $claz->block2_end_time = $course->block2_end_time;
            $claz->save();


            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('course');
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
                ->update(['classmodel_id' => 0]);

        return Redirect::to('getStudentList/' . $course_id);
    }

}