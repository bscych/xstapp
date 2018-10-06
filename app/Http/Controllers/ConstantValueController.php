<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Model\ConstantName;
use App\Model\ConstantValue;

class ConstantValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constant_name_id = Input::get('constant_name_id');
        $constantName = ConstantName::where('id',$constant_name_id)->first();
        $constantValues = ConstantValue::where('constant_name_id',$constant_name_id)->get();
        return View::make('backend.constantValue.index')->with('models',$constantValues)->with('constantName',$constantName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('backend.constantValue.create')->with('constant_name_id',Input::get('constant_name_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'constant_value' => 'required|string|max:255'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        $constant_name_id = Input::get('constant_name_id');
        if ($validator->fails()) {
            return Redirect::to('constantValue/create')
                            ->withErrors($validator);
            
        } else {
         
            $constantValue = new ConstantValue;
            $constantValue->constant_value = Input::get('constant_value');
            $constantValue->constant_name_id = $constant_name_id;
            $constantValue->label_name = ' ';
            $constantValue->save();

            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('constantValue?constant_name_id='.$constant_name_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
