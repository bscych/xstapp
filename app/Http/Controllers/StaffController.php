<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $this->transferData();

        $teachers = DB::table('teacher')
                        ->join('users', 'users.id', 'teacher.user_id')
                        ->where('teacher.deleted_at', null)
                        ->select('teacher.id', 'users.name', 'teacher.salary', 'teacher.start_at', 'teacher.deleted_at')->get();
        return view('backend.teacher.index')->with('teachers', $teachers);
    }

    private function transferData() {
        $teachers = DB::table('model_has_roles')->where('model_has_roles.role_id', '<>', 5)->get();
        foreach ($teachers as $teacher) {
            $t = new \App\Model\Teacher;
            $t->user_id = $teacher->model_id;
            $t->operator = auth()->user()->id;
            $t->save();
        }
//        return null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = DB::table('roles')->where('name', '<>', 'parent')->get();
        return view('backend.teacher.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        );
        $validator = validator()->make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->to('staff/create')
                            ->withErrors($validator);
        } else {
            $user = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password')),
            ]);
//            DB::table('model_has_roles')->insert(['role_id'=>$request->input('role'),'model_type'=>'App\User','model_id'=>$user->id]);
            $user->assignRole($request->input('role'));
            $teacher = new \App\Model\Teacher;
            $teacher->user_id = $user->id;
            $teacher->operator = auth()->user()->id;
            $teacher->start_at = $request->input('start_at');
            $teacher->salary = $request->input('salary');
            $teacher->save();
            return redirect()->to('staff');
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
        $start_at = $request->input('start_at');
        $salary = $request->input('salary');
        $teacher = \App\Model\Teacher::find($id);
        $teacher->salary = (int) $salary;
        $teacher->start_at = $start_at;
        $teacher->save();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        \App\Model\Teacher::destroy($id);
        return $this->index();
    }

}
