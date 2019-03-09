<?php

namespace App\Http\Middleware;

use App\User;
use \Illuminate\Support\Facades\Auth;
use Closure;

class TransferSession {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $wechat_user = session('wechat.oauth_user.default');
        if (!Auth::check()) {
            $wechat_info = $wechat_user->original;
            $user = User::where('openid', $wechat_info['openid'])->first();
            if (is_null($user)) {
                $wechat_info = $wechat_user->original;
                $user = new User;
                $user->openid = $wechat_info['opoenid'];
                $user->nickname = $wechat_info['nickname'];
                $user->sex = $wechat_info['sex'];
                $user->city = $wechat_info['city'];
                $user->province = $wechat_info['province'];
                $user->country = $wechat_info['country'];
                $user->avatar = $wechat_info['avatar'];
                $user->password = bcrypt('123456');
                $match =[];
                $url = $request->url;
                preg_match('/\w+([1-9]\d*)/',$url,$match);
                $user->weixin_id = $match[1]??0;
                $user->recommend_id = 0;
                $user->save();
                Auth::login($user);
            }else{
                Auth::login($user);
            }
        }
        return $next($request);
    }

}
