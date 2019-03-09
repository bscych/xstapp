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
use \App\Model\Student;

class StudentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $name = $request->input('name');
        //  $students = DB::table('students')
        //        ->join('userinfos','userinfos.id','=','students.userinfo_id')
        //         //->join('schools','students.school_id','=','schools.id')
        //         ->select('students.code','userinfos.id','students.comments','students.primaryschool')
        //         ->get();
        return View::make('backend.student.index')->with('students', Student::where('name', 'like', $name . '%')->paginate(15));
    }

    function indexJson() {
        return response()->json(DB::table('students')->paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View::make('backend.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required|unique:students',
            'gender' => 'required',
            'birthday' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('student/create')
                            ->withErrors($validator);
        } else {

            $student = new \App\Model\Student;
            $student->name = Input::get('name');
            $student->gender = Input::get('gender');
            $student->birthday = Input::get('birthday');
            $student->nation = Input::get('nation');
            $student->health = Input::get('health');
            $student->interest = Input::get('interest');
            $student->home_address = Input::get('home_address');
            $student->parents_info = Input::get('parents_info');
            $student->school = Input::get('school');
            $student->grade = Input::get('grade');
            $student->class_room = Input::get('class_room');
            $student->class_supervisor_name = Input::get('class_supervisor_name');
            $student->class_supervisor_phone = Input::get('class_supervisor_phone');
            $student->chinese = Input::get('chinese');
            $student->math = Input::get('math');
            $student->english = Input::get('english');
            $student->study_brief = Input::get('study_brief');
            $student->live_brief = Input::get('live_brief');
            $student->character_brief = Input::get('character_brief');
            $student->expectation = Input::get('expectation');
            $student->expect_courses = Input::get('expect_courses');

            $student->operator = Auth::id();
            $student->save();

            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('student');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $payments = DB::table('incomes')
                ->join('constants as incomeCategory','incomeCategory.id','incomes.name_of_account')
                ->select('incomes.name', 'incomes.amount','incomeCategory.name as income_name','incomes.payment_method', 'incomes.comment', 'incomes.created_at')
                ->where('incomes.paid_by', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        $enroll = DB::table('enrolls')
                ->join('courses', 'courses.id', 'enrolls.course_id')
                ->join('constants','constants.id','enrolls.income_account')
                ->select('enrolls.paid', 'constants.name as income_account','courses.name as course_name', 'enrolls.created_at')
                ->where('student_id', '=', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        $refunds = DB::table('refunds')
                ->join('constants','constants.id','refunds.name_of_account')
                ->join('courses','refunds.course_id','courses.id')
                ->select('refunds.amount','courses.name as course_name','constants.name as refund_category','refunds.created_at','refunds.comment')
                ->where('student_id','=',$id)
                ->get();
        $courses = DB::table('courses')
                ->join('course_student', 'course_student.course_id', 'courses.id')
                ->select('courses.id', 'courses.name', 'courses.start_date')
                ->where('student_id', '=', $id)
                ->where('course_student.deleted_at','=',null)
                ->get();
//        $refunds = DB::table('refunds')
//                ->join('constants');
        return View::make('backend.student.detail')
                        ->with('student', Student::find($id))
                        ->with('payments', $payments)
                        ->with('enrolls', $enroll)
                        ->with('refunds',$refunds)
                        ->with('balance', Student::find($id)->balance)
                        ->with('courses', $courses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
     return View::make('backend.student.edit')->with('student',Student::find($id));
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
            'name' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('student/'.$id.'/edit')
                            ->withErrors($validator);
        } else {

            $student = Student::find($id);
            $student->name = Input::get('name');
            $student->gender = Input::get('gender');
            $student->birthday = Input::get('birthday');
            $student->nation = Input::get('nation');
            $student->health = Input::get('health');
            $student->interest = Input::get('interest');
            $student->home_address = Input::get('home_address');
            $student->parents_info = Input::get('parents_info');
            $student->school = Input::get('school');
            $student->grade = Input::get('grade');
            $student->class_room = Input::get('class_room');
            $student->class_supervisor_name = Input::get('class_supervisor_name');
            $student->class_supervisor_phone = Input::get('class_supervisor_phone');
            $student->chinese = Input::get('chinese');
            $student->math = Input::get('math');
            $student->english = Input::get('english');
            $student->study_brief = Input::get('study_brief');
            $student->live_brief = Input::get('live_brief');
            $student->character_brief = Input::get('character_brief');
            $student->expectation = Input::get('expectation');
            $student->expect_courses = Input::get('expect_courses');

            $student->operator = Auth::id();
            $student->save();

            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('student/'.$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
      $student = Student::find($id);
      $student->delete();
      return Redirect::to('student')->with('success', 'Student has been deleted Successfully');

    }

    public function getCourseList($student_id) {
        $course_ids = DB::table('course_student')
                ->select('course_id')
                ->where('student_id', $student_id)
                ->get();
        $ids = collect([]);
        foreach ($course_ids as $id) {
            $ids->push($id->course_id);
        }
//get courses which the student has not enrolled
        $courses = DB::table('courses')
                ->join('constants', 'courses.course_category_id', 'constants.id')
                ->join('users', 'users.id', 'courses.teacher_id')
                ->select('courses.id as course_id', 'courses.name', 'constants.name as courseCategoryName', 'users.name as teacher', 'courses.duration', 'courses.unit_price')
                ->whereNotIn('courses.id', $ids)
                ->get();
        //get classes
        $classes = DB::table('classmodels')
                ->join('courses','courses.id','classmodels.course_id')
                ->join('users','users.id','classmodels.teacher_id')
                ->select('classmodels.name','classmodels.course_id','classmodels.id as classmodel_id','users.name as teacher_id')
                ->get();
        
        return View::make('backend.student.enroll')->with('courses', $courses)->with('student', Student::find($student_id))->with('classes',$classes);
    }

}
