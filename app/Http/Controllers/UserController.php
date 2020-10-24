<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;


class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//      $users = User::all();
//      
//      foreach($users as $user){
//          $user->update(['password'=> bcrypt('1Tz56h')]);
//      }

        $users = DB::table('users')
                        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
                        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
                        ->select('users.id', 'users.name', 'roles.name as role')
                        ->orderBy('users.created_at', 'desc')->paginate(10);
        return View::make('backend.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View::make('backend.user.create')->with('roles', \Spatie\Permission\Models\Role::all());
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
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('user/create')
                            ->withErrors($validator);
        } else {

            $user = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password')),
            ]);
            $user->assignRole($request->input('role'));

            Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('user');
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
        $user = DB::table('users')
                        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
                        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
                        ->where('users.id', $id)
                        ->select('users.id', 'users.name', 'roles.name as role', 'roles.id as role_id')
                        ->get()->first();
        return view('backend.user.edit')->with('user', $user)->with('roles', \Spatie\Permission\Models\Role::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::find($id);
        $user->name = $request->input('name');
        $roles = $user->getRoleNames();
        foreach ($roles as $role) {
            $user->removeRole($role);
        }
        $user->assignRole($request->input('role'));

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

    public function getMyWorkingSheet() {
        $login_user = Auth::user();
        $year = \Illuminate\Support\Carbon::now()->year;
        $month = \Illuminate\Support\Carbon::now()->month;
        $datas = collect();

        if ($login_user->hasanyrole('admin|superAdmin')) {
            $teachers = DB::table('users')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
                    ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
                    ->where('roles.id', 2)
                    ->select('users.id', 'users.name')
                    ->get();
            foreach ($teachers as $teacher) {
                $this->getTeacherCourseStatisticByID($teacher, $year, $month)===null? :$datas->push($this->getTeacherCourseStatisticByID($teacher, $year, $month));
            }
        } else {
            $datas->push($this->getTeacherCourseStatisticByID($login_user, $year, $month));
        }

        return view('backend.user.working_sheet')->with('month', $month)->with('datas', $datas)->with('year', $year);
    }

    function getTeacherCourseStatisticByID($user, $year, $month) {
        $data = collect();
        $sum_of_class = 0;
        $sum_of_student = 0;
        foreach ($this->getTCKCourseList() as $class) {
            if ($class->teacher_id === $user->id) {
                $schedules = DB::table('schedules')
                        ->where('schedules.classmodel_id', $class->id)->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)
                        ->select('schedules.id', 'schedules.date')
                        ->get();
                foreach ($schedules as $schedule) {
                    $count_of_attended = DB::table('schedule_student')->where('schedule_id', $schedule->id)->select(DB::raw('sum(attended) as count_of_attended'))->get();
                    if ($count_of_attended->first()->count_of_attended > 0) {
                        $sum_of_class++;
                        $sum_of_student += $count_of_attended->first()->count_of_attended;
                    }
                }
            }
        }
        if ($sum_of_class > 0) {
            $data->put('teacher', collect($user)->toArray());
            $data->put('sum_of_class', $sum_of_class);
            $data->put('sum_of_student', $sum_of_student);
            return $data->toArray();
        } else {
            return null;
        }
    }

    function getTCKCourseList() {
        $claz = DB::table('classmodels')->join('courses', 'classmodels.course_id', 'courses.id')->where([['courses.deleted_at', null], ['classmodels.deleted_at', null], ['courses.course_category_id', '<>', 12]])
                        ->select('classmodels.name', 'classmodels.teacher_id', 'classmodels.id')->get();
        return $claz;
    }

    function getTCKWorkingSheetByUserId($user, $year, $month) {
        $attends = DB::table('schedule_student')->join('schedules', 'schedules.id', 'schedule_student.schedule_id')->join('classmodels', 'classmodels.id', 'schedules.classmodel_id')->join('courses', 'courses.id', 'classmodels.course_id')
                ->where([['classmodels.teacher_id', '=', $user->id], ['courses.course_category_id', '<>', 12], ['courses.deleted_at', '<>', null], ['classmodels.deleted_at', '<>', null]])->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)
                ->select('schedules.date', 'classmodels.id', 'schedule_student.student_id', 'schedule_student.attended')
                ->get();
        $totalClass = 0;
        $totalStudent = 0;
        foreach ($this->getCountOfClassByUserId($user->id) as $class) {
            foreach ($this->getScheduleByClassId($class->id, $year, $month) as $schedule) {
                $countofAttend = $attends->where([['id', $class->id], ['date', $schedule->date]])->all()->sum('attended');
                if ($countofAttend > 0) {
                    $totalClass++;
                    $totalStudent = $totalStudent + $countofAttend;
                }
            }
        }
        return ['user' => $user, 'totalClass' => $totalClass, 'totalStudent' => $totalStudent];
    }

    function getCountOfClassByUserId($user_id) {
        $claz = DB::table('classmodels')->join('courses', 'courses.id', 'classmodels.course_id')
                        ->where([['classmodels.teacher_id', '=', $user_id], ['courses.course_category_id', '<>', 12], ['courses.deleted_at', '<>', null], ['classmodels.deleted_at', '<>', null]])
                        ->select('classmodels.id')->get();
        return $claz;
    }

    function getScheduleByClassId($classmodel_id, $year, $month) {
        $schedules = DB::tables('schedules')->whereYear('schedules.date', $year)->whereMonth('schedules.date', $month)->where('classmodel_id', $classmodel_id)->get();
        return $schedules;
    }

}
