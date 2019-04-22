<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
       
       $courses = DB::table('courses')->where([['in_count', 1], ['deleted_at', null]])->get();
        $schedule_students = DB::table('schedule_student')
                ->join('schedules','schedules.id','schedule_student.schedule_id')
                ->join('classmodels','classmodels.id','schedules.classmodel_id')
                ->join('courses','courses.id','classmodels.course_id')
                ->where('schedules.date', date('Y-m-d', time()))
                ->where([['courses.in_count',1],['courses.deleted_at',null]])
                ->select('schedule_student.lunch','schedule_student.dinner','schedules.id','schedules.classmodel_id','classmodels.course_id','courses.name','schedules.date')
                ->get();
        
        return View::make('home')->with('courses', $courses)->with('schedule_students',$schedule_students);
    }

}
