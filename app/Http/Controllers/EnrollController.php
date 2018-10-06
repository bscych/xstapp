<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Student;
use App\Model\Course;
use App\Model\Enroll;

class EnrollController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $student_id = $request->input('student_id');
        $course_id = $request->input('course_id');
        $class_id = $request->input('class_id');
        $rules = array(
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('student')
                            ->withErrors($validator);
        } else {
            $student = Student::find($student_id);
            $course = Course::find($course_id);

            if ($student != null && $course != null) {
                $enroll = new Enroll;
                $enroll->course_id = $course_id;
                $enroll->student_id = $student_id;
                $enroll->paid = $course->unit_price * $course->duration;
                $enroll->operator = Auth::id();
                $enroll->save();

                $student->balance = $student->balance - $enroll->paid;
                $student->save();
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
                            ->where('id', $course_student->id)
                            ->update(['classmodel_id' => $class_id]);
                }

                Session::flash('message', 'Successfully created nerd!');
                return Redirect::to('/getCourseList/' . $student_id);
            } else {
                return Redirect::to('/student/' . $student_id);
            }
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

}
