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
                ->where('incomes.created_at','>', \Illuminate\Support\Carbon::now()->subMonth())
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
        if ($category == 'TG') {
            $courses = DB::table('courses')->where('courses.deleted_at', null)->where('courses.course_category_id', 12)->select('courses.name', 'courses.id')->orderBy('courses.created_at', 'desc')->get();
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', $courses)
                            ->with('incomesCategories', Constant::where('name', '学费')->get())
                            ->with('classCategory', 'TG');
        }
        //特长课要显示具体班级
        if ($category == 'TCK') {
            $courses = DB::table('classmodels')->join('courses', 'courses.id', '=', 'classmodels.course_id')->where([['courses.deleted_at', '=', null], ['courses.course_category_id', '<>', 12], ['classmodels.deleted_at', '=', null]])->select('courses.name as course_name', 'classmodels.name as class_name', 'classmodels.id')->orderBy('courses.created_at', 'desc')->get();
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', $courses)
                            ->with('incomesCategories', Constant::where('name', '学费')->get())
                            ->with('classCategory', 'TCK');
        }
        //餐费不需要关联课程
        if ($category == 'MEALFEE') {
            return View::make('backend.finance.income.create')
                            ->with('student', $student)
                            ->with('paymentMethods', $paymentMethods)
                            ->with('courses', null)
                            ->with('incomesCategories', Constant::where('name', '餐费')->get())
                            ->with('classCategory', 'MEALFEE');
        }
    }

    public function showCourseCategory() {
        $student_id = Input::get('student_id');
        return View::make('backend.finance.income.show_course_category')->with('student_id', $student_id);
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
        $classCategory = Input::get('classCategory');
        $incomeCategory = Input::get('incomeCategory');
        $how_many_left = Input::get('how_many_left');
        $rules = array(
            'amount' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('income/create?student_id=' . $student_id)
                            ->withErrors($validator);
        } else {
//            预存到学生个人账户
            $income = new Income;
            $income->amount = Input::get('amount');
            $income->payment_method = Input::get('payment_method');
            $income->name_of_account = $incomeCategory;
            $income->paid_by = $student_id;
            $income->comment = Input::get('comment');
            $income->name = date("Y-m-d", time()) . $student->name . "缴费" . $income->amount;
            $income->finance_year = Input::get('finance_year');
            $income->finance_month = Input::get('finance_month');
            $income->operator = Auth::id();
            $income->save();

            $student->balance = $student->balance + $income->amount;
            $student->save();
            //非预存操作，需要保存扣费记录

            $enroll = new Enroll;
            $enroll->name = $request->input('comment') . ' ';
            $enroll->income_account = $incomeCategory;
            $enroll->course_id = $classCategory == 'MEALFEE' ? null : $course_id;
            $enroll->student_id = $student_id;
            $enroll->paid = Input::get('amount');
            $enroll->operator = Auth::id();
            $enroll->save();

            $student->balance = $student->balance - $enroll->paid;
            $student->save();

            //托管交费
            if ($classCategory == 'TG') {
                $coure_students = DB::table('course_student')
                                ->where([
                                    ['course_id', '=', $course_id],
                                    ['student_id', '=', $student_id],
                                ])->get();
                if ($coure_students->isEmpty()) {
                    DB::table('course_student')->insert(
                            ['course_id' => $course_id, 'student_id' => $student_id]
                    );
                }
            }
            //特长课交费
            if ($classCategory == 'TCK') {
                $classModel = \App\Model\Classmodel::find($course_id);
                
                $old_how_many_left = DB::table('course_student')->where([['classmodel_id', $course_id], ['course_id',$classModel->course_id],['deleted_at',null],['student_id',$student_id]])->get()->first();
                if($old_how_many_left==null){
                     DB::table('course_student')->insert(['classmodel_id'=> $course_id, 'course_id'=>$classModel->course_id,'deleted_at'=>null,'student_id'=>$student_id,'how_many_left'=>$how_many_left]);
                }else{
                     DB::table('course_student')->where(['classmodel_id'=> $course_id, 'course_id'=>$classModel->course_id,'deleted_at'=>null,'student_id'=>$student_id])->update(['how_many_left'=>$old_how_many_left->how_many_left+$how_many_left]);
                }
               
            }

            //交餐費           
            if ($classCategory == 'MEALFEE') {
                
            }


            Session::flash('message', 'Successfully created !');
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
