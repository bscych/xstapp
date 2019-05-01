<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            Log::info($message);


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

    /**
     * index
     *
     * @return wechat homepage
     */
    public function index() {
        $user = Auth::user();
        if ($user->hasRole('parent')) {
          return redirect()->route('getMyKids');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * 添加菜单
     */
    public function menu_add() {
        $app = app('wechat.official_account');

        $buttons = [
            [
                'name' => '关于我们',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '品牌简介',
                        'url' => 'https://pillec.cn/app/public/brandStory',
                        'sub_button' => []
                    ],
                    [
                        'type' => 'view',
                        'name' => '教育理念',
                        'url' => 'https://pillec.cn/app/public/concept',
                        'sub_button' => []
                    ],
                    [
                        'type' => 'view',
                        'name' => '校区展示',
                        'url' => 'https://pillec.cn/app/public/show',
                        'sub_button' => []
                    ]
                ]
            ],
            [
                'name' => '课程体系',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '托管',
                        'url' => 'https://pillec.cn/app/public/trust',
                        'sub_button' => []
                    ],
                    [
                        'type' => 'view',
                        'name' => '幼小衔接',
                        'url' => 'https://pillec.cn/app/public/connect',
                        'sub_button' => []
                    ],
                    [
                        'type' => 'view',
                        'name' => '培训课程',
                        'url' => 'https://pillec.cn/app/public/training',
                        'sub_button' => []
                    ]
                ]
            ],
            [
                'type' => 'view',
                'name' => '实用工具',
                'url' => 'https://pillec.cn/app/public/index.php/api/auth/login',
                'sub_button' => []
            ]
        ];
        $app->menu->create($buttons);
    }

    /**
     * 删除菜单
     */
    public function menu_destroy() {
        $app = app('wechat.official_account');
        $menu = $app->menu;
        $menu->destroy();
    }

    /**
     * 查看微信公众号当前的菜单
     */
    public function menu_current() {
        $app = app('wechat.official_account');
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }

}
