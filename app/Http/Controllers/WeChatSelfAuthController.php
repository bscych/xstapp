<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
        $openId = 'o1t8s04Nx8AkS81YUNsySVKnVGvM';


        if ($openId == null && $openId == "") {
            Log::info('OpenId is null or empty');

            return '请在微信中打开该页面';
        } else {
            //如果已被注册，通过openid进行自动认证，
            //认证通过后重定向回原来的路由，这样就实现了自动登陆。
            $user = User::where('openid', $openId)->first();

            if ($user == null) {
                Log::info('there is is no logged in user');
                return redirect()->route('showRoleSelectionForm');
            } else {
                Auth::loginUsingId($user->id);
                Log::info('login successfully and go to home');
                return redirect()->route('home');
            }
        }
    }

    public function autoRegister(Request $request) {
        //generate registerion codes

        $userInfo = $this->getEasyWechatSession();
        //根据微信信息注册用户。
//        if ($userInfo['id'] == null && $userInfo['id'] == "") {
//            return '请使用微信打开';
//        } else {
        $whichForm = $request->input("whichForm");

        if ($whichForm == "teacher") {
            $this->registerTeacher($request, $userInfo);
        } else {
            $this->registerParent($request, $userInfo);
        }
//            $userData = [
//                'password' => bcrypt('123456'),
//                'openid' => $userInfo['id'],
//                'nickname' => $userInfo['nickname'],
//                'email' => $userInfo['id'] . 'xst.com'
//            ];
//            //注意批量写入需要把相应的字段写入User中的$fillable属性数组中
//            User::create($userData);
        return redirect()->route('wechat_home');
        //}
    }

    function registerTeacher(Request $request, $userInfo) {
        Log::info('in teacher register');
        Log::info('email : ' . $request->input('email'));
        Log::info('password : ' . $request->input('password'));
        Log::info('openid :  ' . $userInfo['id']);
        Log::info('nickname:' . $userInfo['nickname']);

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
        return $this->showRegisterForm('teacher');
    }

    function generateCodes() {
        $students = \App\Model\Student::all();
        foreach ($students as $student) {
            $code = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);

            DB::table('register_codes')->insert(['code' => $code, 'student_id' => $student->id]);
        }
    }

    function registerParent(Request $request, $userInfo) {
        Log::info('in parent register');

        Log::info('openid :  ' . $userInfo['id']);
        Log::info('nickname:' . $userInfo['nickname']);

        //verify student is there, 
        $code = $request->input('code');
        $relationship = $request->input('relationship');
        $student_id = $this->verifyCode($code, $relationship);
        if ($student_id == null) {
            return '该验证码不存在';
        } else {

            //create a new user
            $user = new User;
            $user->name = $userInfo['nickname'];
            $user->email = $userInfo['id'] . '@xst.com';
            $user->password = Hash::make(str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH));
            $user->openid = $userInfo['id'];
            $user->nickname = $userInfo['nickname'];
         //   $user->create_at = Carbon::now();
            $user->save();
            //log in the new user
            Auth::loginUsingId($user->id);
            //update parent_student table, setup user and student relationship
            DB::table('parent_student')->insert(['user_id' => $user->id, 'student_id' => $student_id, 'relationship' => $relationship, 'created_at' => Carbon::now()]);
            return redirect()->route('home');
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

    public function showRoleSelectionForm() {
        return view('api.auth.role');
    }

    public function showRegisterForm($whichForm) {
        // $this->generateCodes();
        if ($whichForm == 'teacher') {
            return view('api.auth.teacherRegister');
        } else {
            return view('api.auth.parentRegister');
        }
    }
}
