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
                ->where('incomes.created_at', '>', \Illuminate\Support\Carbon::now()->subMonth())
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
    public function create(Request $request) {
        $student_id = Input::get('student_id');
        $category = Input::get('category');
        $student = Student::find($student_id);
        $paymentMethods = Constant::where('parent_id', 1)->get();
//       托管类的不显示班级
        if ($category == '托管课') {
            $courses = DB::table('courses')->where('courses.deleted_at', null)->where('courses.course_category_id', 12)->select('courses.name', 'courses.id')->orderBy('courses.created_at', 'desc')->get();
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', $courses)
                            ->with('incomesCategory', Constant::where('name', $category)->get()->first());
        }
        //特长课要显示具体班级
        if ($category == '特长课') {
            $courses = DB::table('classmodels')->join('courses', 'courses.id', '=', 'classmodels.course_id')->where([['courses.deleted_at', '=', null], ['courses.course_category_id', '<>', 12], ['classmodels.deleted_at', '=', null]])->select('courses.name as course_name', 'classmodels.name as class_name', 'classmodels.id')->orderBy('courses.created_at', 'desc')->get();
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', $courses)
                            ->with('incomesCategory', Constant::where('name', $category)->get()->first());
        }

//        预存保存至学生账户
        if ($category == '预存') {
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', null)
                            ->with('incomesCategory', Constant::where('name', $category)->get()->first());
        }
        //餐费，杂费，车费不需要关联课程
        else {
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', null)
                            ->with('incomesCategory', Constant::where('name', $category)->get()->first());
        }
    }

    public function showCourseCategory() {
        $student_id = Input::get('student_id');

        return View::make('backend.finance.income.show_course_category')->with('student_id', $student_id)->with('incomesCategories', Constant::where('parent_id', 4)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $student_id = Input::get('student_id');
        $student = Student::find($student_id);
        $incomeCategory = Constant::find(Input::get('incomeCategory'));
        $rules = array('amount' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('income/create?student_id=' . $student_id)
                            ->withErrors($validator);
        } else {
//            预存到学生个人账户
            $this->saveToAccount($student, $incomeCategory);
            //非预存操作，需要保存扣费记录
            if ($incomeCategory->name != '预存') {
                $this->enroll($student,$incomeCategory);
                $this->afterPay($incomeCategory);
            }
            Session::flash('message', 'Successfully created !');
            return Redirect::to('student');
        }
    }

    /*
     * 预存到学生账户
     */

    function saveToAccount($student, $incomeCategory) {
        $income = new Income;
        $income->amount = Input::get('amount');
        $income->payment_method = Input::get('payment_method');
        $income->name_of_account = Input::get('incomeCategory');
        $income->paid_by = $student->id;
        $income->comment = Input::get('comment');
        $income->name = date("Y-m-d", time()) . $student->name . '，交费课程：' . $incomeCategory->name . '，交费金额：' . $income->amount;
        $income->finance_year = Input::get('finance_year');
        $income->finance_month = Input::get('finance_month');
        $income->operator = Auth::id();
        $income->save();

        $student->balance = $student->balance + $income->amount;
        $student->save();
    }

    /*
     * 从学生账户扣费
     */

    function enroll($student, $incomeCategory) {
        $course = null;
        $course_id = null;
        $course_name = '';
        if ($incomeCategory->name === '托管课') {
            $course = \App\Model\Course::find(Input::get('course_id'));
            $course_id = $course->id;
            $course_name = $course->name;
        }
        if ($incomeCategory->name === '特长课') {
            $course = \App\Model\Classmodel::find(Input::get('course_id'));
            $course_id = $course->course_id;
            $course_name = $course->name;
        } else {
            $course_id = null;
            $course_name = $incomeCategory->name;
        }
        $enroll = new Enroll;
        $enroll->name = '('.'扣费原因：' . $course_name . '，扣费金额：' . Input::get('amount') . ') '.Input::get('comment') ;
        $enroll->income_account = $incomeCategory->id;
        $enroll->course_id = $course_id;
        $enroll->student_id = $student->id;
        $enroll->paid = Input::get('amount');
        $enroll->operator = Auth::id();
        $enroll->save();
        $student->balance = $student->balance - $enroll->paid;
        $student->save();
    }

    /*
     * 缴费后的操作
     */

    function afterPay($incomeCategory) {
        $student_id = Input::get('student_id');
        $course_id = Input::get('course_id');
        $how_many_left = Input::get('how_many_left');
        //托管交费
        if ($incomeCategory->name == '托管课') {
            $coure_students = DB::table('course_student')->where([['course_id', '=', $course_id], ['student_id', '=', $student_id],])->get();
            if ($coure_students->isEmpty()) {
                DB::table('course_student')->insert(['course_id' => $course_id, 'student_id' => $student_id]
                );
            }
        }
        //特长课交费
        if ($incomeCategory->name == '特长课') {
            $classModel = \App\Model\Classmodel::find($course_id);
            $old_how_many_left = DB::table('course_student')->where([['classmodel_id', $course_id], ['course_id', $classModel->course_id], ['deleted_at', null], ['student_id', $student_id]])->get()->first();
            if ($old_how_many_left == null) {
                DB::table('course_student')->insert(['classmodel_id' => $course_id, 'course_id' => $classModel->course_id, 'deleted_at' => null, 'student_id' => $student_id, 'how_many_left' => $how_many_left]);
            } else {
                DB::table('course_student')->where(['classmodel_id' => $course_id, 'course_id' => $classModel->course_id, 'deleted_at' => null, 'student_id' => $student_id])->update(['how_many_left' => $old_how_many_left->how_many_left + $how_many_left]);
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
