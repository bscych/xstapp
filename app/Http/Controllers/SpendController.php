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
use App\Model\ConstantValue;

class SpendController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $spends = DB::table('spends')
                        ->join('users', 'spends.operator', '=', 'users.id')
                        ->join('constant_values as nameOfAccount', 'nameOfAccount.id', '=', 'spends.name_of_account')
                        // ->join('constant_values as paymentMethod','paymentMethod.id','=','spends.payment_method')
                        ->select('spends.id', 'spends.name', 'nameOfAccount.constant_value as name_of_account', 'spends.which_day', 'spends.amount', 'spends.payment_method', 'users.name as operator', 'spends.created_at', 'spends.comment')
                        ->orderBy('spends.which_day', 'desc')->paginate(10);
      

        return View::make('backend.finance.spend.index')->with('models', $spends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View::make('backend.finance.spend.create')->with('paymentMethods', ConstantValue::where('constant_name_id', 1)->get())->with('name_of_accounts', ConstantValue::where('constant_name_id', 3)->get());
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
            'payment_method' => 'required',
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
            $spend->payment_method = Input::get('payment_method');
            $spend->which_day = Input::get('which_day');
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
