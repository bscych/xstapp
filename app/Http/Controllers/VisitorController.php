<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('backend.visitor.index', ['students' => \App\Model\Visitor::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.visitor.create');
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
            'gender' => 'required',
            'phone' => 'required',
        );
        $validator = validator($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to(route('visitor.create'))
                            ->withErrors($validator);
        } else {
            $visitor = new \App\Model\Visitor;
            $visitor->name = $request->input('name');
            $visitor->phone = $request->input('phone');
            $visitor->parent_name = $request->input('parent_name');
            $visitor->gender = $request->input('gender');
            $visitor->birthday = $request->input('birthday');
            $visitor->interests = $request->input('interests');
            $visitor->contact_history = json_encode(['初次到访：' . now()], JSON_UNESCAPED_UNICODE);
            $visitor->save();

            session()->flash('message', 'Successfully created !');
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

    public function addContactHistory(Request $request) {
        $visitor_id = $request->visitor_id;
        $date = $request->input('date') === null ? now()->format('Y-m-d') : $request->input('date');
        $history = $request->input('contact_history');
        $this->appendContactHistory($visitor_id, $date, $history);
        return $this->index();
    }

    private function appendContactHistory($id, $date, $history) {
        $visitor = \App\Model\Visitor::find($id);
        $contact_history = collect(json_decode($visitor->contact_history, JSON_UNESCAPED_UNICODE));
        $contact_history->push('到访日期' . $date . '  ' . $history);
        $visitor->contact_history = json_encode($contact_history->toArray(), JSON_UNESCAPED_UNICODE);
        $visitor->save();
    }

    public function convertToStudent() {
        $visitor_id = request('visitor_id');
        $visitor = \App\Model\Visitor::find($visitor_id);
        $student = new \App\Model\Student;
        $student->name = $visitor->name;
        $student->birthday = $visitor->birthday;
        $student->gender = $visitor->gender;
        $student->parents_info = \Illuminate\Support\Facades\Crypt::encryptString($visitor->parent_name . ':' . $visitor->phone);
        $student->operator = auth()->user()->id;
        $student->save();
        if ($student->id != null) {
            $this->appendContactHistory($visitor_id, now()->format('Y-m-d'),'转化为学生，学生ID'.$student->id);
        }
        return $this->index();
    }

}
