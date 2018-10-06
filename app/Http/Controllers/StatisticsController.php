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
                ->join('constant_values', 'constant_values.id', 'spends.name_of_account')->select('constant_values.constant_value as name_of_account', 'spends.amount', 'spends.which_day')->where('spends.finance_year', $year)->where('spends.finance_month', $month)->orderBy('spends.which_day', 'desc')
                ->get();
        $categorys = DB::table('constant_values')->select('constant_value', 'id')->where('constant_name_id', 3)->get();
        $colls = collect([]);

        foreach ($categorys as $category) {
            $data = $spends->where('name_of_account', $category->constant_value);
            $total = $data->sum('amount');
            $colls->push([$category->constant_value, $total, $category->id]);
        }

        $totalIncome = DB::table('incomes')->where('incomes.finance_year', $year)->where('incomes.finance_month', $month)->orderBy('incomes.created_at', 'desc')->get()->sum('amount');

        $totalEnroll = DB::table('enrolls')->whereYear('enrolls.created_at', $year) ->whereMonth('enrolls.created_at', $month)->orderBy('enrolls.created_at', 'desc') ->get()->sum('paid');
        $totalRemain = DB::table('students')->where('balance', '>', 0)->get()->sum('balance');

        return View::make('backend.finance.statistics.detail')
                        ->with('totalSpends', $spends)->with('spends', $colls)->with('parameters', $year . '/' . $month)->with('totalIncomes', $totalIncome)->with('totalEnroll', $totalEnroll)->with('totalRemain', $totalRemain);
    }

    public function getDetailByCategory($year, $month, $category_id) {
        $spends = DB::table('spends')
                ->join('constant_values', 'constant_values.id', 'spends.name_of_account')
                ->select('spends.id', 'spends.name', 'constant_values.constant_value as name_of_account', 'spends.amount', 'spends.which_day')
                ->where('name_of_account', $category_id)
                ->whereYear('spends.which_day', $year)
                ->whereMonth('spends.which_day', $month)
                ->orderBy('spends.which_day', 'desc')
                ->get();

        return View::make('backend.finance.statistics.spends_year_month_category')->with('spends', $spends);
    }

}
