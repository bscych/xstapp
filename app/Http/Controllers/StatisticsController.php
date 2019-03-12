<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
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
        return View::make('backend.finance.statistics.monthList')
                        ->with('totalIncome', DB::table('incomes')->get()->sum('amount'))
                        ->with('totalSpend', DB::table('spends')->get()->sum('amount'));
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

        return View::make('backend.finance.statistics.detail')
                        ->with('totalSpends', $spends)->with('incomes', $incomesColls)->with('spends', $colls)->with('parameters', $year . '/' . $month)->with('totalIncomes', $totalIncome)->with('totalEnroll', $totalEnroll)->with('totalRemain', $totalRemain);
    }

    public function getDetailByCategory($year, $month, $table_name, $category_id) {
        if ($table_name == 'spends') {
            $spends = DB::table('spends')
                    ->join('constants', 'constants.id', 'spends.name_of_account')
                    ->select('spends.id', 'spends.name', 'constants.name as name_of_account', 'spends.amount', 'spends.which_day')
                    ->where('name_of_account', $category_id)
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

    public function getScheduleByMonthClass($month, $class_id) {
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
        return View::make('backend.schedule.scheduleMonthList')->with('dates', $dates)->with('schedule_students', $schedule_students)->with('class_id', $class_id)->with('month', $month);
    }
    
     public function getScheduleByMonthClass_detail($month, $class_id) {
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

        $snack_fee = Course::find(Classmodel::find($class_id)->course_id)->snack_fee;

        $students = DB::table('schedule_student')
                        ->join('students', 'students.id', 'schedule_student.student_id')
                        ->select('students.id', 'students.name')
                        ->whereIn('schedule_id', $schedules)
                        ->get()->unique();

        return View::make('backend.schedule.scheduleMonthList_detail')->with('dates', $dates)->with('students', $students)->with('schedule_students', $schedule_students)->with('class_id', $class_id)->with('month', $month)->with('snack_fee', $snack_fee);
    }

}