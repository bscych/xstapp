<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Model\Constant;
use App\Model\Course;
use App\Model\ClassRoom;
use App\Model\Student;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $courses = DB::table('courses')
                ->join('constants', 'courses.course_category_id', '=', 'constants.id')
                ->join('users', 'courses.teacher_id', '=', 'users.id')
                ->join('class_rooms', 'courses.classroom_id', '=', 'class_rooms.id')
                ->select('courses.id', 'courses.name', 'courses.unit_price', 'courses.duration', 'constants.name as courseCategoryName', 'users.name as teacher', 'class_rooms.name as classroom')
                ->where('courses.deleted_at', null)
                ->get();


        return View::make('backend.course.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $teachers = DB::table('teachers')
                ->join('users', 'teachers.user_id', '=', 'users.id')
                ->select('users.name as name', 'users.id as id')
                ->get();
        return View::make('backend.course.create')->with('courseCategories', Constant::where('parent_id', 2)->orderBy('created_at', 'desc')->get())->with('teachers', $teachers)->with('classrooms', ClassRoom::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required',
            'unit_price' => 'required|numeric',
            'startDate' => 'required',
            'endDate' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('course/create')
                            ->withErrors($validator);
        } else {

            $course = new Course;
            $course->name = Input::get('name');
            $course->unit = Input::get('unit');
            $course->course_category_id = Input::get('courseCategory_id');
            $course->duration = Input::get('duration');
            $course->unit_price = Input::get('unit_price');
            $course->teacher_id = Input::get('teacher_id');
            $course->classroom_id = Input::get('classroom_id');
            $course->start_date = Input::get('startDate');
            $course->end_date = Input::get('endDate');
            $frequence = Input::get('frequence');

            if ($course->course_category_id != 16 && $course->course_category_id != 17) {
                $course->which_day_1 = Input::get('whichDay1');
                $course->block1_start_time = Input::get('start1');
                $course->block1_end_time = Input::get('end1');

                if ($frequence == 2) {
                    $course->which_day_2 = Input::get('whichDay2');
                    $course->block2_start_time = Input::get('start2');
                    $course->block2_end_time = Input::get('end2');
                }
            }
            $course->save();

            $claz = new \App\Model\Classmodel;
            $claz->course_id = $course->id;
            $claz->teacher_id = $course->teacher_id;
            $claz->classroom_id = $course->classroom_id;
            $claz->start_date = $course->start_date;
            $claz->end_date = $course->end_date;
            $claz->which_day_1 = $course->which_day_1;
            $claz->block1_start_time = $course->block1_start_time;
            $claz->block1_end_time = $course->block1_end_time;
            $claz->which_day_2 = $course->which_day_2;
            $claz->block2_start_time = $course->block2_start_time;
            $claz->block2_end_time = $course->block2_end_time;
            $claz->save();

            $dates = collect([]);
            //to create schedule
            if ($course->course_category_id == 16) {
                //means it is a 托管类,will happen every working day
                // get start date and the end date
                $startdate = date_create($course->start_date);
                $enddate = date_create($course->start_date);
                date_add($enddate, date_interval_create_from_date_string("365 days"));


                while ($startdate < $enddate) {
                    $ss = date('w', strtotime($startdate->format('Y-m-d H:i:s')));
                    if (($ss != 6) && ($ss != 0)) {
                        $dates->push($startdate);
                    }
                    date_add($startdate, date_interval_create_from_date_string("1 day"));
                }
            }

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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $model = Course::find($id);

        //return view('course.edit',['model'=>$model,'courseCategories'=>CourseCategory::all()]);
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

        $course = Course::find($id);
        //delete the course
        $course->delete();
        //delete related classmodel
        DB::table('classmodels')
                ->where('course_id', $course->id)
                ->update(['deleted_at' => date("Y-m-d", time())]);

        return Redirect::to('course')->with('success', 'the Course has been deleted Successfully');
    }

    public function getStudentList($course_id) {
        $students = DB::table('course_student')
                ->join('students', 'students.id', 'course_student.student_id')
                ->select('students.id', 'students.name', 'students.gender', 'students.grade', 'students.class_room', 'course_student.classmodel_id')
                ->where('course_student.course_id', '=', $course_id)
                ->where('students.deleted_at', '=', null)
                ->where('course_student.deleted_at', '=', null)
                ->get();

        $classes = DB::table('classmodels')
                ->join('courses', 'classmodels.course_id', 'courses.id')
                ->join('class_rooms', 'classmodels.classroom_id', 'class_rooms.id')
                ->join('users', 'classmodels.teacher_id', 'users.id')
                ->select('classmodels.id', 'classmodels.name', 'class_rooms.name as classroom_name', 'courses.name as course_name', 'users.name as teacher_name')
                ->where('course_id', $course_id)
                ->get();
        return View::make('backend.course.studentList')->with('students', $students)->with('course_id', $course_id)->with('classes', $classes);
    }

    public function getClassList($param) {
        $classes = DB::table('');
        return View::make('');
    }

    public function getScheduleList($course_id) {
        $dates = collect([]);
        ////means it is a 托管类,will happen every working day
        // get start date and the end date
        $startdate = date_create('2018-3-1');
        $enddate = date_create('2018-3-1');
        date_add($enddate, date_interval_create_from_date_string("365 days"));


        while ($startdate < $enddate) {
            $nextday = date_add($startdate, date_interval_create_from_date_string("1 day"));
            $ss = date('w', strtotime($nextday->format('Y-m-d')));
            if (($ss != 6) && ($ss != 0)) {
                $dates->push(date_create($nextday->format('Y-m-d')));
            }
        }

        return View::make('backend.course.scheduleList')->with('calendar', $dates);
    }

    public function getScheduleByMonth($course_id, $month) {
        return View::make('backend.course.signIn_meal');
    }

    public function getEnrollCourse($student_id) {
//       $course_ids = DB::table('course_student')
//                ->select('course_id')
//                ->where('student_id', $student_id)
//                ->get();
//        $ids = collect([]);
//        foreach ($course_ids as $id) {
//            $ids->push($id->course_id);
//        }
//get courses which the student has not enrolled
        $courses = DB::table('courses')
                ->join('constants', 'courses.course_category_id', 'constants.id')
                ->join('users', 'users.id', 'courses.teacher_id')
                ->select('courses.id as course_id', 'courses.name', 'constants.name as courseCategoryName', 'users.name as teacher', 'courses.duration', 'courses.unit_price')
//                ->whereNotIn('courses.id', $ids)
                ->get();
        //get classes
        $classes = DB::table('classmodels')
                ->join('courses', 'courses.id', 'classmodels.course_id')
                ->join('users', 'users.id', 'classmodels.teacher_id')
                ->select('classmodels.name', 'classmodels.course_id', 'classmodels.id as classmodel_id', 'users.name as teacher_id')
                ->get();

        return View::make('backend.student.enroll')->with('courses', $courses)->with('student', Student::find($student_id))->with('classes', $classes);
    }

}
