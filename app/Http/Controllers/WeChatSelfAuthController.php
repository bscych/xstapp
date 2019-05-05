<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class WeChatSelfAuthController extends Controller {

    public function getEasyWechatSession() {
        // $user = session('wechat.oauth_user.default');
        $wechat_user = session('wechat.oauth_user');
        // return $user;
        return $wechat_user;
    }

    public function autoLogin() {
        Log::info('get in  selfAuthController');
        $userInfo = $this->getEasyWechatSession();

        $openId = $userInfo['id'];
        Log::info('get open ID');
        Log::info($openId);
        //查看对应的openid是否已被注册
        //如果未注册，跳转到注册
        //for testing purpose

        if ($openId == null && $openId == "") {
            Log::info('OpenId is null or empty');
            return '请在微信中打开该页面';
        } else {
            //如果已被注册，通过openid进行自动认证，
            //认证通过后重定向回原来的路由，这样就实现了自动登陆。
            $user = User::where('openid', $openId)->first();
            if ($user == null) {
                return redirect()->route('showRoleSelectionForm');
            } else {
                Auth::loginUsingId($user->id);
                return redirect()->route('wechat.home');
            }
        }
    }

    public function autoRegister(Request $request) {
        $userInfo = $this->getEasyWechatSession();

        $whichForm = $request->input("whichForm");

        if ($whichForm == "teacher") {
            $this->registerTeacher($request, $userInfo);
        } else {
            $this->registerParent($request, $userInfo);
        }

        return redirect()->route('wechat.home');
    }

    public function registerTeacher(Request $request) {
        $userInfo = $this->getEasyWechatSession();

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            Log::info('Login sucessfully');
            $user = Auth::user();
            $user->openid = $userInfo['id'];
            $user->nickname = $userInfo['nickname'];
            $user->save();
            Log::info('go to home');
            return redirect()->route('home');
        }
        Log::info('Login failed');
        return $this->showTeacherRegisterForm();
    }

    function generateCodes() {
        $students = \App\Model\Student::all();
        foreach ($students as $student) {
            $code = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);

            DB::table('register_codes')->insert(['code' => $code, 'student_id' => $student->id]);
        }
    }

    public function registerParent(Request $request) {
        $rules = array('code' => 'required|exists:register_codes',);
        $validator = Validator::make(Input::all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect()->route('showParentRegisterForm')
                            ->withErrors($validator);
        }
        //verify student is there, 
        $code = $request->input('code');
        $relationship = $request->input('relationship');
        $student_id = $this->verifyCode($code, $relationship);
        if ($student_id == null) {
            return '该验证码不存在';
        } else {
            //create a new user or find existing user
            $user = $this->getUserByOpenid();
           
            $user->hasRole('parent')?:$user->assignRole('parent');
            //log in the new user
            Auth::loginUsingId($user->id);
            //update parent_student table, setup user and student relationship
            DB::table('parent_student')->insert(['user_id' => $user->id, 'student_id' => $student_id, 'relationship' => $relationship, 'created_at' => Carbon::now()]);
            return redirect()->route('wechat.home');
        }
    }

    /*
     * verify register code 
     * if the code is validated will update relationship and delete_at fields, and return student id
     * if the code is not validated, will return null
     */

    function verifyCode($code, $relationship) {
        $students = DB::table('register_codes')
                ->join('students', 'students.id', 'register_codes.student_id')
                ->where('register_codes.deleted_at', null)
                ->where('register_codes.code', $code)
                ->select('students.id')
                ->get();
        if ($students->count() == 1) {
            DB::table('register_codes')->where('code', $code)->update(['relationship' => $relationship, 'deleted_at' => Carbon::now()]);
            return $students->first()->id;
        }
        return null;
    }

    function getUserByOpenid() {
        $userInfo = $this->getEasyWechatSession();
        $user = User::where('openid', $userInfo['id'])->first();
        if ($user == null) {
            $user = new User;
            $user->name = $userInfo['nickname'];
            $user->email = $userInfo['id'] . '@xst.com';
            $user->password = Hash::make(str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH));
            $user->openid = $userInfo['id'];
            $user->nickname = $userInfo['nickname'];
            $user->save();
        }
        return $user;
    }

    public function showRoleSelectionForm() {
        return view('api.auth.role');
    }

    public function showParentRegisterForm() {
        return view('api.auth.parentRegister');
    }

    public function showTeacherRegisterForm() {
        return view('api.auth.teacherRegister');
    }

}
