<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $leaves = null;
        if(auth()->user()->id===1 or auth()->user()->id===3){
            $leaves = \App\Model\Leave::all();
        }else{
            $leaves = \App\Model\Leave::where('user_id', auth()->user()->id)->get();
        }
        return view('backend.leave.index')->with('leaves',$leaves );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.leave.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'from' => 'required',
        );
        $validator = validator()->make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->to(route('leave.create'))
                            ->withErrors($validator);
        } else {

            $leave = new \App\Model\Leave;
            $leave->from = $request->input('from');
            $leave->to = $request->input('to');
            $leave->user_id = auth()->user()->id;
            $leave->comment = $request->input('comment');
            $leave->save();            
            return $this->index();
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
       $leave_id = $request->input('leave_id');
       $status = $request->input('status');
       $leave = \App\Model\Leave::find($leave_id);
       $leave->status = $status;
       $leave->save();
       return $this->index();
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
