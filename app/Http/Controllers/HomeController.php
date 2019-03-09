<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $yx_l = 0;
        $tg1_1= 0;
        $tg1_2 = 0;
        $tg2 = 0;
        $tg3 = 0;
        
        return view('home')->with('data',$yx_l);
    }

}
