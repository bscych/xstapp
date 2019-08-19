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
use App\Model\Spend;
use App\Model\Constant;
use App\Model\Student;
use App\Model\Course;
use App\Model\Refund;

class SpendController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $spends = DB::table('spends')
                        ->join('users', 'spends.operator', '=', 'users.id')
                        ->join('constants as nameOfAccount', 'nameOfAccount.id', '=', 'spends.name_of_account')
                        // ->join('constant_values as paymentMethod','paymentMethod.id','=','spends.payment_method')
                        ->select('spends.id', 'spends.name', 'nameOfAccount.name as name_of_account', 'spends.which_day', 'spends.amount', 'spends.payment_method', 'users.name as operator', 'spends.created_at', 'spends.comment')
                        ->orderBy('spends.which_day', 'desc')->paginate(10);
      

        return View::make('backend.finance.spend.index')->with('models', $spends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View::make('backend.finance.spend.create')
               // ->with('paymentMethods', Constant::where('parent_id', 1)->get())
                ->with('name_of_accounts', Constant::where('parent_id', 3)->get());
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
            'name_of_account' => 'required',
            'amount' => 'required',
           // 'payment_method' => 'required',
            'finance_year' => 'required',
            'finance_month' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('spend/create')
                            ->withErrors($validator);
        } else {

            $spend = new Spend;
            $spend->name = Input::get('name');
            $spend->name_of_account = Input::get('name_of_account');
            $spend->amount = Input::get('amount');
            $spend->payment_method = Input::get('payment_method')==null?'微信':Input::get('payment_method');
            $spend->which_day = Input::get('which_day')==null?date("Y-m-d", time()):Input::get('which_day');
            $spend->finance_year = Input::get('finance_year');
            $spend->finance_month = Input::get('finance_month');
            $spend->comment = Input::get('comment');
            $spend->operator = Auth::id();
            $spend->save();

            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('spend');
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

    public function getSummary(Request $request, $id) {
        return View::make('backend.finance.spend.summary')->with('total', DB::table('spends')->select('sum(amount) as total')->get());
    }
    public function returnFee(Request $request) {
        $student_id = $request->input('student_id');
        $category_id = $request->input('category_id');
        $course_id = $request->input('course_id');
        $amount = $request->input('amount');
        $payment_method = $request->input('payment_method');
        $finance_year = $request->input('finance_year');
        $finance_month = $request->input('finance_month');
        $comment = $request->input('comment');
        
        $refund = new Refund;
        $refund->name = date("Y-m-d", time()) . Student::find($student_id)->name . "退费" . $amount;
        $refund->course_id = $course_id;
        $refund->student_id = $student_id;
        $refund->name_of_account = $category_id;
        $refund->amount = $amount;
        $refund->payment_method = $payment_method;
        $refund->finance_year = $finance_year;
        $refund->finance_month = $finance_month;
        $refund->comment = $comment;
        $refund->operator = Auth::id();
        $refund->save();
        
        if($category_id==34){//返现
            $spend = new Spend;
            $spend->name =  $refund->name;
            $spend->name_of_account = Constant::where('name','退费')->first()->id;//使用支出会计科目的退费
            $spend->amount =$refund->amount;
            $spend->payment_method =  $refund->payment_method;
            $spend->which_day = date("Y-m-d", time());
            $spend->finance_year = $refund->finance_year;
            $spend->finance_month = $refund->finance_month;
            $spend->comment = $refund->comment;
            $spend->operator = Auth::id();
            $spend->save();
            
        }else{//返回个人账户
            $balance = Student::find($student_id)->balance;
            Student::where('id',$student_id)->update(['balance'=>$balance+$amount]); 
        }
         return Redirect::to('student');
        
    }
    public function refund( $student_id) {
        $student = Student::find($student_id);
        $course_students = DB::table('course_student')
                ->where([['student_id',$student_id],['deleted_at',null]])
                ->get();
        return View::make('backend.finance.refund.create')
                ->with('student',$student)
                ->with('paymentMethods',Constant::where('parent_id', 1)->get())
                ->with('course_students',$course_students)
                ->with('courses',Course::all())
                ->with('refundCategories',Constant::where('parent_id',6)->get());
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
