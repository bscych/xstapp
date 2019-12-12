<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class BillController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $bills = DB::table('bills')->join('students', 'bills.student_id', 'students.id')->join('classmodels', 'classmodels.id', 'bills.class_id')->where('bills.state','<>','closed')
                        ->select('bills.id', 'students.name as student_name', 'bills.comment', 'bills.income_category', 'bills.total', 'bills.state', 'classmodels.name as class_id')->get();
        $hasGeneratedLastMonthBill = $this->hasCreatedBills(now()->subMonth()->month===1?now()->subYear()->year: now()->year, now()->subMonth()->month);
        return view('backend.finance.bill.index')->with('bills', $bills)->with('has_created_bill_for_lastMonth', $hasGeneratedLastMonthBill);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
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

    public function confirmToClose($bill_id) {
        $bill = \App\Model\Bill::find($bill_id);
        $this->saveToStudentAccount($bill);
        $this->enroll($bill);
        $bill->state = 'closed';
        $bill->save();
        return redirect()->route('bill.index');
    }

    function saveToStudentAccount($bill) {
        $student = \App\Model\Student::find($bill->student_id);
        $income = new \App\Model\Income;
        $income->amount = $bill->total;
        $income->payment_method = '银行转账' ;
        $income->name_of_account = \App\Model\Constant::where('name',$bill->income_category)->get()->first()->id;
        $income->paid_by = $bill->student_id;
        $income->comment = $bill->comment;
        $income->name = date("Y-m-d", time()) .$student->name . '，交费课程：' . $bill->income_category . '，交费金额：' . $bill->total;
        $income->finance_year = $bill->finance_year;
        $income->finance_month = $bill->finance_month;
        $income->operator = auth()->user()->id;
        $income->save();
        $student->balance = $student->balance + $income->amount;
        $student->save();
    }
    
    function enroll($bill) {
        $student = \App\Model\Student::find($bill->student_id);
        $enroll = new \App\Model\Enroll;
        $enroll->name = '(' . '扣费原因：' . $bill->income_category. '，扣费金额：' . $bill->total. ') ' . $bill->comment;
        $enroll->income_account = \App\Model\Constant::where('name',$bill->income_category)->get()->first()->id;
        $enroll->course_id =  $bill->class_id;
        $enroll->student_id =  $bill->student_id;
        $enroll->paid = $bill->total;
        $enroll->operator = auth()->user()->id;
        $enroll->save();
        $student->balance = $student->balance - $enroll->paid;
        $student->save();
    }

    public function createBillBatch($year, $month) {
        $this->hasCreatedBills($year, $month) ?: $this->generateMealBills($year, $month);
        return redirect()->route('bill.index');
    }

    /*
     * 
     */

    function hasCreatedBills($year, $month) {
        return \App\Model\Bill::where('finance_year', $year)->where('finance_month', $month)->get()->count() > 0;
    }

    /*
     * parameters:int year and int month
     * return:array with [student_id=>[course_id=>[lunch=>int,dinner=>int,snack=>int,attended=>int],course_id=>[lunch=>int,dinner=>int,snack=>int,attended=>int]] format
     */

    function sortMealData($year, $month) {
//        get schedules for the year and the month, get all schedule_student
        $datas = DB::table('schedule_student')->join('schedules', 'schedules.id', 'schedule_student.schedule_id')->join('classmodels', 'classmodels.id', 'schedules.classmodel_id')->join('courses', 'classmodels.course_id', 'courses.id')
                        ->where('schedules.date', 'like', $year . '-' . $month . '%')
                        ->select('courses.snack_fee', 'schedule_student.student_id', 'schedules.classmodel_id', 'schedule_student.lunch', 'schedule_student.dinner', 'schedule_student.attended')->get();
//        calculate lunch fee and dinner fee for each student
        $sortedData = [];
        $price = (int) \App\Model\Constant::where('name', 'price_per_meal')->get()->first()->label_name;
        foreach ($datas as $data) {
            $path = $data->student_id . '.' . $data->classmodel_id;
            $lunch_string = $path . '.lunch';
            $dinner_string = $path . '.dinner';
            $snack_string = $path . '.snack';
            $attended_string = $path . '.attended';
            if (Arr::has($sortedData, $data->student_id)) {
                if (Arr::has($sortedData, $path)) {
                    $fee_of_dinner = Arr::get($sortedData, $dinner_string) + ((int) $data->dinner) * $price;
                    $fee_of_lunch = Arr::get($sortedData, $lunch_string) + ((int) $data->lunch) * $price;
                    $fee_of_snack = Arr::get($sortedData, $snack_string) + ((int) $data->attended) * ((int) $data->snack_fee);
                    $count_of_attended = Arr::get($sortedData, $attended_string) + (int) $data->attended;
                    Arr::set($sortedData, $dinner_string, $fee_of_dinner);
                    Arr::set($sortedData, $lunch_string, $fee_of_lunch);
                    Arr::set($sortedData, $snack_string, $fee_of_snack);
                    Arr::set($sortedData, $attended_string, $count_of_attended);
                } else {
                    Arr::set($sortedData, $lunch_string, ((int) $data->lunch) * $price);
                    Arr::set($sortedData, $dinner_string, ((int) $data->dinner) * $price);
                    Arr::set($sortedData, $attended_string, (int) $data->attended);
                    Arr::set($sortedData, $snack_string, ((int) $data->attended) * ((int) $data->snack_fee));
                }
            } else {
                $fee_of_lunch = ((int) $data->lunch) * $price;
                $fee_of_dinner = ((int) $data->dinner) * $price;
                $fee_of_snack = ((int) $data->attended) * ((int) $data->snack_fee);
                $count_of_attended = (int) $data->attended;
                Arr::set($sortedData, $lunch_string, $fee_of_lunch);
                Arr::set($sortedData, $dinner_string, $fee_of_dinner);
                Arr::set($sortedData, $snack_string, $fee_of_snack);
                Arr::set($sortedData, $attended_string, $count_of_attended);
            }
        }
        return $sortedData;
    }

    function generateMealBills($year, $month) {

        $bills = collect();
        foreach ($this->sortMealData($year, $month) as $key => $value) {
            $this->formMealBill($key, $value, $year, $month);
        }
        return $bills;
    }

    function formMealBill($student_id, $arr, $year, $month) {

        foreach ($arr as $key => $value) {

            $lunch = Arr::get($value, 'lunch');
            $dinner = Arr::get($value, 'dinner');
            $snack = Arr::get($value, 'snack');
            $total_charge = $lunch + $dinner + $snack;
            if ($total_charge > 0) {
                $class = \App\Model\Classmodel::find($key);
                $bill = new \App\Model\Bill;
                $bill->class_id = $class->id;
                $bill->comment = $class->name;
                $bill->income_category = '餐费';
                $bill->student_id = $student_id;
                $bill->finance_year = $year;
                $bill->finance_month = $month;
                $bill->total = $total_charge;
                $bill->save();
            }
        }
    }

}
