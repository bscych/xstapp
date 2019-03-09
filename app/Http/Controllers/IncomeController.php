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
use App\Model\Constant;
use App\Model\Student;
use App\Model\Income;
use App\Model\Course;
use App\Model\Enroll;

class IncomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $incomes = DB::table('incomes')
                ->join('users', 'users.id', '=', 'incomes.operator')
                ->join('students', 'students.id', '=', 'incomes.paid_by')
                ->select('incomes.id', 'incomes.name', 'students.name as paid_by', 'incomes.amount', 'incomes.payment_method', 'incomes.created_at', 'incomes.comment', 'users.name as operator')
                ->orderBy('incomes.created_at', 'desc')
                ->paginate(10);
        
        return View::make('backend.finance.income.index')->with('incomes', $incomes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $student_id = Input::get('student_id');

        return View::make('backend.finance.income.create')
                ->with('student', Student::find($student_id))
                ->with('paymentMethods', Constant::where('parent_id', 1)->get())
                ->with('courses', DB::table('courses')->orderBy('courses.created_at', 'desc')->get())
                ->with('incomesCategories',Constant::where('parent_id',4)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $student_id = Input::get('student_id');
        $course_id = Input::get('course_id');
        $student = Student::find($student_id);
        $incomeCategory = Input::get('incomeCategory');
        $rules = array(
            'amount' => 'required',
            'payment_method' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('income/create?student_id=' . $student_id)
                            ->withErrors($validator);
        } else {
            $income = new Income;
            $income->amount = Input::get('amount');
            $income->payment_method = Input::get('payment_method');
            $income->name_of_account = $incomeCategory;
            $income->paid_by = $student_id;
            $income->comment = Input::get('comment');
            $income->name = date("Y-m-d", time()) . $student->name . "缴费" . $income->amount;
            $income->finance_year = date("Y", time()); 
            $income->finance_month = date("m", time());
            $income->operator = Auth::id();
            $income->save();

            $student->balance = $student->balance + $income->amount;
            $student->save();
            //非预存操作，需要保存扣费记录
            if ($incomeCategory != 31) {
                $enroll = new Enroll;
                $enroll->name =  $request->input('comment').' ';
                $enroll->income_account =  $incomeCategory;
                $enroll->course_id = $course_id;
                $enroll->student_id = $student_id;
                $enroll->paid = Input::get('amount');
                $enroll->operator = Auth::id();
                $enroll->save();

                $student->balance = $student->balance - $enroll->paid;
                $student->save();

                //预存和交学杂费不需要保存课程学生关系数据
                if ($incomeCategory==28) {
                    $coure_students = DB::table('course_student')
                                    ->where([
                                        ['course_id', '=', $course_id],
                                        ['student_id', '=', $student_id],
                                    ])->get();
                    //是否报名，如果已报名则不需要再次将数据插入关系表
                    if ($coure_students->count() == 0) {
                        DB::table('course_student')->insert(
                                ['course_id' => $course_id, 'student_id' => $student_id]
                        );
                    }
                }
            }
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
