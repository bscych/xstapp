<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Model\Course;
use App\Model\Classmodel;
use Illuminate\Support\Facades\DB;
use App\Model\Constant;

class StatisticsController extends Controller {

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
        return View::make('backend.statistics.create')->with('courses', DB::table('courses')->where([['course_category_id', '=', 12], ['deleted_at', '=', null]])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $id = $request->input('course_id');
        if ($id != null) {
            $course = Course::find($id);
            $in_count = $request->input('in_count');
            $course->in_count = $request->input('in_count') == "true" ? 1 : 0;
            $course->save();
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

    public function getMonthList() {
        $income = DB::table('incomes')->where('finance_year', '>=', 2019)->where('finance_month', '>=', 11)->get()->sum('amount');
        $spend = DB::table('spends')->where('finance_year', '>=', 2019)->where('finance_month', '>=', 11)->get()->sum('amount');
        return View::make('backend.finance.statistics.monthList')
                        ->with('totalIncome', $income)
                        ->with('totalSpend', $spend);
    }

    public function detail($year, $month) {
       
        $spends = DB::table('spends')
                ->join('constants', 'constants.id', 'spends.name_of_account')
                ->select('constants.name as name_of_account', 'spends.amount', 'spends.which_day')->where('spends.finance_year', $year)->where('spends.finance_month', $month)->orderBy('spends.which_day', 'desc')
                ->get();
        $categorys = DB::table('constants')->select('name', 'id')->where('parent_id', 3)->get();
        $colls = collect([]);

        foreach ($categorys as $category) {
            $data = $spends->where('name_of_account', $category->name);
            $total = $data->sum('amount');
            $colls->push([$category->name, $total, $category->id]);
        }
        $incomeData = DB::table('incomes')
                ->join('constants', 'constants.id', 'incomes.name_of_account')
                ->select('constants.name as name_of_account', 'incomes.amount', 'incomes.created_at')->where('incomes.finance_year', $year)->where('incomes.finance_month', $month)->orderBy('incomes.created_at', 'desc')
                ->get();
        $incomesColls = collect([]);
        foreach (Constant::where('parent_id', 4)->get() as $constant) {
            $total = $incomeData->where('name_of_account', $constant->name)->sum('amount');
            $incomesColls->push([$constant->name, $total, $constant->id]);
        }

        $totalIncome = DB::table('incomes')->where('incomes.finance_year', $year)->where('incomes.finance_month', $month)->orderBy('incomes.created_at', 'desc')->get()->sum('amount');

        $totalEnroll = DB::table('enrolls')->whereYear('enrolls.created_at', $year)->whereMonth('enrolls.created_at', $month)->orderBy('enrolls.created_at', 'desc')->get()->sum('paid');
        $totalRemain = DB::table('students')->where('balance', '>', 0)->get()->sum('balance');

        $mealsByMonth = DB::table('schedule_student')->join('schedules', 'schedule_student.schedule_id', 'schedules.id')->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)->select('schedule_student.dinner', 'schedule_student.lunch');
        return View::make('backend.finance.statistics.detail')
                        ->with('totalSpends', $spends)->with('incomes', $incomesColls)->with('spends', $colls)->with('parameters', $year . '/' . $month)->with('totalIncomes', $totalIncome)->with('totalEnroll', $totalEnroll)->with('totalRemain', $totalRemain)->with('lunch', $mealsByMonth->sum('lunch'))->with('dinner', $mealsByMonth->sum('dinner'))->with('purchase', $this->getPurchase($year, $month));
    }

    public function getPurchaseDetail($year, $month) {
        $spends = DB::table('spends')
                ->join('constants', 'constants.id', 'spends.name_of_account')
                ->select('spends.id', 'spends.name', 'constants.name as name_of_account', 'spends.amount', 'spends.which_day')
//                    ->where('spends.name_of_account', (int)$category_id)
                ->where('spends.finance_year', $year)
                ->where('spends.finance_month', $month)
                ->where('spends.operator', 5)
                ->orderBy('spends.which_day', 'desc')
                ->get();
        return View::make('backend.finance.statistics.details_year_month_category')->with('spends', $spends);
    }

    public function getDetailByCategory($year, $month, $table_name, $category_id) {
        if ($table_name == 'spends') {
            $spends = DB::table('spends')
                    ->join('constants', 'constants.id', 'spends.name_of_account')
                    ->select('spends.id', 'spends.name', 'constants.name as name_of_account', 'spends.amount', 'spends.which_day')
                    ->where('spends.name_of_account', (int) $category_id)
                    ->where('spends.finance_year', $year)
                    ->where('spends.finance_month', $month)
                    ->orderBy('spends.which_day', 'desc')
                    ->get();
            return View::make('backend.finance.statistics.details_year_month_category')->with('spends', $spends);
        }
        if ($table_name == 'incomes') {
            $incomes = DB::table('incomes')
                    ->join('constants', 'constants.id', 'incomes.name_of_account')
                    ->select('incomes.id', 'incomes.name', 'constants.name as name_of_account', 'incomes.amount', 'incomes.created_at as which_day')
                    ->where('name_of_account', $category_id)
                    ->where('incomes.finance_year', $year)
                    ->where('incomes.finance_month', $month)
                    ->orderBy('incomes.created_at', 'desc')
                    ->get();
            return View::make('backend.finance.statistics.details_year_month_category')->with('spends', $incomes);
        }
    }

    function getScheduleByMonthClass($month, $class_id) {
        $dateString = date('Y') . '-' . $month . '-';
        if ($month == 0) {
            $dateString = (date('Y') - 1) . '-12';
        }
        $dates = DB::table('schedules')
                        ->select('schedules.date', 'schedules.id')
                        ->where([['classmodel_id', '=', $class_id], ['date', 'like', $dateString . '%']])->orderBy('date')->get();
        $schedules = collect();
        foreach ($dates as $schedule) {
            $schedules->push($schedule->id);
        }
        $schedule_students = DB::table('schedule_student')
                ->join('schedules', 'schedules.id', 'schedule_student.schedule_id')
                ->where([['classmodel_id', '=', $class_id], ['date', 'like', $dateString . '%']])
                ->get();
        return collect(['dates' => $dates, 'schedule_students' => $schedule_students]);
    }

    public function getScheduleStatistics(Request $request) {
        $month = $request->input('month');
        $class_id = $request->input('class_id');
        $courseCategory = DB::table('classmodels')
                        ->join('courses', 'classmodels.course_id', 'courses.id')
                        ->where('classmodels.id', $class_id)
                        ->select('courses.course_category_id')
                        ->first()->course_category_id;

        //if the class belongs to a 托管 course, then call getScheduleByMonthClass function
        if ($courseCategory == 12) {
            $data = $this->getScheduleByMonthClass($month, $class_id);
            return View::make('backend.schedule.scheduleMonthList')->with('dates', $data->pull('dates'))->with('schedule_students', $data->pull('schedule_students'))->with('class_id', $class_id)->with('month', $month);
        } else {
            //if the class belongs to a non 托管 course, then call getScheduleByWholePeriod function
            $data = $this->getScheduleByMonthClass($month, $class_id);
            return View::make('backend.schedule.tck.scheduleMonthList')->with('dates', $data->pull('dates'))->with('schedule_students', $data->pull('schedule_students'))->with('class_id', $class_id)->with('month', $month);
        }
    }

    public function getTCKStudentStatus(Request $request) {
        $month = $request->input('month');
        $class_id = $request->input('class_id');
        $courseCategory = DB::table('classmodels')
                        ->join('courses', 'classmodels.course_id', 'courses.id')
                        ->where('classmodels.id', $class_id)
                        ->select('courses.course_category_id')
                        ->first()->course_category_id;
        $data = $this->getScheduleByWholePeriod($class_id);
        return View::make('backend.schedule..tck.scheduleList')->with('students', $data['students'])->with('student_schedules', $data['student_schedules'])->with('course', $data['course']);
    }

    function getScheduleByWholePeriod($class_id) {
        $students = DB::table('course_student')
                ->join('students', 'students.id', 'course_student.student_id')
                ->where('course_student.classmodel_id', $class_id)
                ->select('students.id', 'students.name', 'course_student.how_many_left')
                ->get();
        $student_schedules = DB::table('schedule_student')
                ->join('schedules', 'schedules.id', 'schedule_student.schedule_id')
                ->where('schedules.classmodel_id', $class_id)
                ->select('schedule_student.student_id', 'schedule_student.attended', 'schedules.date')
                ->get();
        $course = DB::table('courses')
                ->join('classmodels', 'classmodels.course_id', 'courses.id')
                ->where('classmodels.id', $class_id)
                ->select('courses.name', 'courses.duration')
                ->first();

        return ['students' => $students, 'student_schedules' => $student_schedules, 'course' => $course];
    }

    public function getScheduleByMonthClass_detail(Request $request) {
        $class_id = $request->input('class_id');
        $month = $request->input('month');
        if (count(str_split($month)) < 2) {
            $month = '0' . $month;
        }
        $student_id = $request->input('student_id');
        if (now()->month === 1&&$month==='12') { 
            $dateString = now()->subYear()->year . '-' . $month . '-';            
        } else {
           $dateString = now()->year . '-' . $month . '-';
        }
        if ($month == '0') {
            $dateString = (date('Y') - 1) . '-12';
        }
        $dates = DB::table('schedules')
                        ->select('schedules.date', 'schedules.id')
                        ->where([['schedules.classmodel_id', $class_id], ['date', 'like', $dateString . '%']])->orderBy('date')->get();
        $schedules = collect();
        foreach ($dates as $schedule) {
            $schedules->push($schedule->id);
        }
        $course = Course::find(Classmodel::find($class_id)->course_id);
        $snack_fee = $course->snack_fee;
        //  $snack_fee = Course::find(Classmodel::find($class_id)->course_id)->snack_fee;
        $students = null;
        $schedule_students = null;
        if ($student_id != null and $request->input('AGENT') == 'WECHAT') {
            $students = DB::table('schedule_student')
                            ->join('students', 'students.id', 'schedule_student.student_id')
                            ->select('students.id', 'students.name')
                            ->whereIn('schedule_student.schedule_id', $schedules)
                            ->where('schedule_student.student_id', $student_id)
                            ->get()->unique();
            $schedule_students = DB::table('schedule_student')
                    ->join('schedules', 'schedules.id', 'schedule_student.schedule_id')
                    ->where([['schedule_student.student_id', '=', $student_id], ['schedules.classmodel_id', '=', $class_id], ['schedules.date', 'like', $dateString . '%']])
                    ->get();
            $lastMonth = \Illuminate\Support\Carbon::now()->subMonth()->month;
            if ($lastMonth - 10 <= 0) {
                $lastMonth = '0' . $lastMonth;
            }

            return View::make('backend.schedule.wechatStudentScheduleMonthList_detail')->with('dates', $dates)->with('students', $students)->with('schedule_students', $schedule_students)->with('class_id', $class_id)->with('month', $month)->with('snack_fee', $snack_fee)->with('lastMonth', $lastMonth)->with('student_id', $student_id);
        } else {
            $students = DB::table('schedule_student')
                            ->join('students', 'students.id', 'schedule_student.student_id')
                            ->select('students.id', 'students.name')
                            ->whereIn('schedule_id', $schedules)
                            ->get()->unique();
            $schedule_students = DB::table('schedule_student')
                    ->join('schedules', 'schedules.id', 'schedule_student.schedule_id')
                    ->where([['schedules.classmodel_id', '=', $class_id], ['schedules.date', 'like', $dateString . '%']])
                    ->get();
            if ($course->course_category_id === 12)
                return View::make('backend.schedule.scheduleMonthList_detail')->with('dates', $dates)->with('students', $students)->with('schedule_students', $schedule_students)->with('class_id', $class_id)->with('month', $month)->with('snack_fee', $snack_fee);
            else
                return View::make('backend.schedule.tck.scheduleMonthList_detail')->with('dates', $dates)->with('students', $students)->with('schedule_students', $schedule_students)->with('class_id', $class_id)->with('month', $month);
        }
    }

    public function getPurchase($year, $month) {
        return \App\Model\Spend::where([['operator', 5], ['finance_year', $year], ['finance_month', $month]])->get();
    }

}
