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
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//      $users = User::all();
//      
//      foreach($users as $user){
//          $user->update(['password'=> bcrypt('1Tz56h')]);
//      }
        
      $users = DB::table('users')
              ->leftJoin('model_has_roles','model_has_roles.model_id','users.id')
              ->leftJoin('roles','roles.id','model_has_roles.role_id')
              ->select('users.id','users.name','roles.name as role')
              ->orderBy('users.created_at', 'desc')->paginate(10);
        return View::make('backend.user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('backend.user.create')->with('roles', \Spatie\Permission\Models\Role::all());
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
      $user = DB::table('users')
              ->leftJoin('model_has_roles','model_has_roles.model_id','users.id')
              ->leftJoin('roles','roles.id','model_has_roles.role_id')
              ->where('users.id',$id)
              ->select('users.id','users.name','roles.name as role','roles.id as role_id' )
              ->get()->first();
      return view('backend.user.edit')->with('user',$user)->with('roles', \Spatie\Permission\Models\Role::all());
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
        $user = User::find($id);
        $user->name = $request->input('name');
        $roles = $user->getRoleNames();
        foreach($roles as $role){
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
    public function destroy($id)
    {
        //
    }
}
