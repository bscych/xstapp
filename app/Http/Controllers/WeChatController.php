<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Overtrue\Socialite\User as SocialiteUser;

class WeChatController extends Controller {

   

    public function __construct() {
     
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve() {

        Log::info('request arrived.');
        $app = app('wechat.official_account');
        Log::info('Create $app');

        $app->server->push(function($message) {
            Log::info('---get in event--');
            if ($message['MsgType'] == 'text') {
                Log::info('detect event');
                $user_openid = $message['FromUserName'];
                Log::info($user_openid);
                $toUserName = $message['ToUserName'];
                Log::info($toUserName);
//                $user = $app->user->get($user_openid);
//                Log::info($user);
            }
        });

        Log::info('return response.');
        return $app->server->serve();
    }

}
